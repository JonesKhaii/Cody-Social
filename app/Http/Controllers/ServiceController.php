<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các dịch vụ
     */
    public function index()
    {
        $services = Service::active()->orderBy('name')->get();
        return view('pages.inhome-services.index', compact('services'));
    }

    /**
     * Hiển thị chi tiết một dịch vụ
     */
    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Lấy các dịch vụ liên quan, nhưng không lấy dữ liệu bác sĩ
        $relatedServices = Service::where('id', '!=', $service->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('pages.inhome-services.service-detail', compact('service', 'relatedServices'));
    }
}
