<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Doctor;
use App\Models\DoctorService;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function specialty()
    {
        if (!Session::has('booking.doctor_id')) {
            return redirect()->route('home')->with('error', 'Vui lòng chọn bác sĩ trước.');
        }

        $doctorId = Session::get('booking.doctor_id');
        $doctor = Doctor::with(['specializations:id,name'])->findOrFail($doctorId);
        $specialties = $doctor->specializations->pluck('name', 'id');

        Session::put('booking.back_to', ['route' => 'booking.start', 'params' => ['doctor_id' => $doctorId]]);

        return view('appointment.specialty', compact('specialties', 'doctor'));
    }

    public function getServicesBySpecialization($specializationId)
    {
        $doctorId = Session::get('booking.doctor_id');

        $services = DoctorService::query()
            ->select([
                'doctor_services.service_id',
                'doctor_services.price',
                'services.name',
            ])
            ->join('services', 'services.id', '=', 'doctor_services.service_id')
            ->where('doctor_services.doctor_id', $doctorId)
            ->where('services.specialization_id', $specializationId)
            ->orderBy('services.name')
            ->get();

        return response()->json($services);
    }

    public function appointmentType(Request $request)
    {
        $request->validate([
            'specialization_id' => 'required|exists:specializations,id',
            'service_id' => 'required|exists:services,id',
            // 'consultation_type' => 'required|in:Online,Ofline,At Home',
        ]);

        Session::put('booking.specialization_id', $request->specialization_id);
        Session::put('booking.service_id', $request->service_id);
        // Session::put('booking.consultation_type', $request->consultation_type);

        $doctorId = Session::get('booking.doctor_id');
        $doctor = Doctor::with(['specializations:id,name'])->findOrFail($doctorId);

        return view('appointment.appointment-type', compact('doctor'));
    }

    public function datetime()
    {
        if (!Session::has('booking.doctor_id')) {
            return redirect()->route('home')->with('error', 'Vui lòng chọn bác sĩ trước.');
        }

        $doctorId = Session::get('booking.doctor_id');
        $doctor = Doctor::findOrFail($doctorId);

        Session::put('booking.back_to', ['route' => 'booking.appointmentType', 'params' => []]);

        $bookedAppointments = DB::table('appointments')
            ->where('doctor_id', $doctorId)
            ->whereDate('date', '>=', now())
            ->whereDate('date', '<=', now()->addYear())
            ->get()
            ->groupBy(function ($item) {
                return $item->date;
            });

        $doctorTimeSlots = DB::table('doctor_time_slots')
            ->join('time_slots', 'doctor_time_slots.time_slot_id', '=', 'time_slots.id')
            ->where('doctor_time_slots.doctor_id', $doctorId)
            ->select('doctor_time_slots.day_of_week', 'time_slots.*')
            ->get()
            ->groupBy('day_of_week');

        $days = [];

        for ($i = 0; $i < 365; $i++) {
            $date = now()->addDays($i);
            $dateStr = $date->toDateString();
            $dow = $date->dayOfWeek;

            $slots = $doctorTimeSlots[$dow] ?? collect();
            $processedSlots = [];

            foreach ($slots as $slot) {
                $isBooked = false;
                if (isset($bookedAppointments[$dateStr])) {
                    $isBooked = $bookedAppointments[$dateStr]
                        ->where('time', $slot->start_time)
                        ->count() > 0;
                }

                $processedSlots[] = [
                    'id' => $slot->id,
                    'label' => $slot->label,
                    'is_booked' => $isBooked,
                    'part' => match (true) {
                        $slot->start_time < '12:00:00' => 'morning',
                        $slot->start_time < '18:00:00' => 'afternoon',
                        default => 'evening',
                    }
                ];
            }

            $days[] = [
                'date' => $dateStr,
                'weekday' => $date->isoFormat('dddd'),
                'slots' => $processedSlots
            ];
        }

        return view('appointment.datetime', compact('doctor', 'days'));
    }


    public function info(Request $request)
    {
        // Lưu ngày giờ đã chọn
        Session::put('booking.datetime', [
            'date' => $request->selected_date,
            'time' => $request->selected_time,
        ]);

        Session::put('booking.back_to', ['route' => 'booking.datetime', 'params' => []]);

        $doctorId = Session::get('booking.doctor_id');
        $doctor = Doctor::with('specializations')->findOrFail($doctorId);
        $user = auth()->user();

        $patientInfo = [
            'is_for_self' => true,
            'name' => $user?->name,
            'email' => $user?->email,
            'phone' => $user?->phone,
        ];

        Session::put('booking.patient', $patientInfo);

        return view('appointment.information', compact('doctor', 'user', 'patientInfo'));
    }



    public function confirm(Request $request)
    {
        $isForSelf = $request->input('is_for_self') === '1';

        if ($isForSelf && Auth::check()) {
            $patientInfo = [
                'is_for_self' => true,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ];
        } else {
            $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
            ]);

            $patientInfo = [
                'is_for_self' => false,
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ];
        }

        Session::put('booking.patient', $patientInfo);

        $doctor = Doctor::with('specializations')->findOrFail(Session::get('booking.doctor_id'));
        $datetime = Session::get('booking.datetime');
        $specializationId = Session::get('booking.specialization_id');

        // Tạo cuộc hẹn vào DB
        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'specialization_id' => $specializationId,
            'user_id' => Auth::id(),
            'date' => $datetime['date'],
            'time' => $datetime['time'],
            'status' => 'Chờ duyệt',
            'approval_status' => 'Chờ duyệt',
            'consultation_type' => Session::get('booking.consultation_type'),
            'notes' => 'Đặt bởi ' . ($isForSelf ? 'chính người dùng' : 'người dùng cho người thân') .
                ' - Thông tin: ' . $patientInfo['name'] . ' / ' . $patientInfo['phone'],
        ]);

        return view('appointment.confirmation', compact('appointment', 'doctor', 'patientInfo'));
    }

    public function start(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id'
        ]);

        Session::put('booking.doctor_id', $request->doctor_id);
        Session::put('booking.back_to', ['route' => 'home', 'params' => []]);

        return redirect()->route('booking.specialty');
    }


    public function appointmentTypeGet()
    {
        if (!Session::has('booking.doctor_id')) {
            return redirect()->route('home')->with('error', 'Vui lòng chọn bác sĩ trước.');
        }

        $doctorId = Session::get('booking.doctor_id');
        $doctor = Doctor::with(['specializations:id,name'])->findOrFail($doctorId);

        return view('appointment.appointment-type', compact('doctor'));
    }
}
