@extends('layouts.master')

@section('main-content')
    <div class="services-page">
        <!-- Banner -->
        <div class="services-banner bg-primary py-5 text-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="mb-3">Dịch vụ tại nhà</h1>
                        <p class="lead">Chúng tôi cung cấp các dịch vụ y tế chuyên nghiệp với đội ngũ nhân viên có trình độ
                            cao, giúp chăm sóc sức khỏe toàn diện cho bạn và gia đình.</p>
                    </div>
                    {{-- <div class="col-md-6 text-center">
                        <img src="{{ asset('asset/images/services-hero.svg') }}" alt="Dịch vụ y tế" class="img-fluid"
                            style="max-height: 300px;">
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Danh sách dịch vụ -->
        <div class="services-list py-5">
            <div class="container">
                <h2 class="mb-5 text-center">Các dịch vụ của chúng tôi</h2>

                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-12 mb-4">
                            <div class="card service-card border-0 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        @if ($service->image)
                                            <img src="{{ $service->image }}" class="img-fluid rounded-start h-100"
                                                alt="{{ $service->name }}" style="object-fit: cover; width: 100%;">
                                        @else
                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                                @if ($service->icon)
                                                    <img src="{{ $service->icon_url }}" alt="{{ $service->name }}"
                                                        style="height: 80px;">
                                                @else
                                                    <i class="fas fa-heartbeat fa-4x text-primary"></i>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body d-flex flex-column h-100">
                                            <h4 class="card-title">{{ $service->name }}</h4>
                                            <p class="card-text flex-grow-1">{{ Str::limit($service->description, 300) }}
                                            </p>
                                            <div class="mt-3">
                                                <a href="{{ route('services.show', $service->slug) }}"
                                                    class="btn btn-primary">Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Cam kết chất lượng -->
        <div class="quality-commitment bg-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="mb-4">Cam kết chất lượng dịch vụ</h2>
                        <p class="lead">Chúng tôi cam kết mang đến dịch vụ y tế chất lượng cao, đạt tiêu chuẩn quốc tế với
                            đội ngũ y bác sĩ giàu kinh nghiệm.</p>

                        <div class="row mt-5">
                            <div class="col-md-4">
                                <div class="commitment-item">
                                    <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                                    <h5>Đội ngũ chuyên nghiệp</h5>
                                    <p>Y bác sĩ giàu kinh nghiệm và tận tâm</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="commitment-item">
                                    <i class="fas fa-hospital fa-3x text-primary mb-3"></i>
                                    <h5>Cơ sở vật chất hiện đại</h5>
                                    <p>Trang thiết bị y tế tiên tiến</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="commitment-item">
                                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                                    <h5>Hỗ trợ 24/7</h5>
                                    <p>Luôn sẵn sàng phục vụ mọi lúc</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .service-card .rounded-start {
            border-top-left-radius: 10px !important;
            border-bottom-left-radius: 10px !important;
        }

        @media (max-width: 767.98px) {
            .service-card .rounded-start {
                border-top-left-radius: 10px !important;
                border-top-right-radius: 10px !important;
                border-bottom-left-radius: 0 !important;
            }
        }

        .commitment-item {
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .commitment-item:hover {
            transform: translateY(-5px);
        }

        .services-banner {
            background-color: #4285f4;
            background-image: linear-gradient(135deg, #4285f4 0%, #34a853 100%);
        }
    </style>
@endsection
