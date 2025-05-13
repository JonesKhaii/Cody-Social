<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index(Request $request)
    {

        $query = Clinic::query();

        // Lọc theo loại
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Lọc theo địa chỉ
        if ($request->filled('address')) {
            $query->where('address', 'like', "%{$request->address}%");
        }

        // Sắp xếp theo tên
        $query->orderBy('name', 'asc');

        // Phân trang
        $clinics = $query->paginate(10);

        return view('pages.clinics-list', compact('clinics'));
    }

    public function show($slug)
    {

        $clinic = Clinic::where('slug', $slug)->firstOrFail();

        return view('pages.clinic-detail', compact('clinic'));
    }
}
