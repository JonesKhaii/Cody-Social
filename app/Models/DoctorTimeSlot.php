<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTimeSlot extends Model
{
    protected $table = 'doctor_time_slots';

    protected $fillable = [
        'doctor_id',
        'time_slot_id',
        'date',
        'is_booked',
    ];

    protected $casts = [
        'date' => 'date',
        'is_booked' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
