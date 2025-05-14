@extends('layouts.master')

@section('main-content')
    <div class="health-tools-page py-4">
        <div class="container">
            <h1 class="mb-4">Công cụ sức khỏe</h1>
            <p class="lead mb-5">Các công cụ miễn phí giúp bạn theo dõi, đánh giá và cải thiện sức khỏe mỗi ngày.</p>

            <div class="row mb-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Chỉ số cơ thể</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('tools.bmi') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-calculator text-primary me-2"></i> Tính chỉ số BMI
                                </a>
                                <a href="{{ route('tools.body-fat') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-percentage text-primary me-2"></i> Tính tỷ lệ mỡ cơ thể
                                </a>
                                <a href="{{ route('tools.bmr') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-fire text-primary me-2"></i> Tính BMR và TDEE
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Sức khỏe tim mạch</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('tools.blood-pressure') }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-stethoscope text-danger me-2"></i> Đánh giá huyết áp
                                </a>
                                <a href="{{ route('tools.heart-rate-zones') }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-running text-danger me-2"></i> Vùng nhịp tim tập luyện
                                </a>
                                <a href="{{ route('tools.heart-risk') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-chart-line text-danger me-2"></i> Nguy cơ tim mạch
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Dinh dưỡng</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('tools.calorie-needs') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-utensils text-success me-2"></i> Tính nhu cầu calo
                                </a>
                                <a href="{{ route('tools.water-intake') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-tint text-success me-2"></i> Lượng nước cần uống
                                </a>
                                <a href="{{ route('tools.macro-calculator') }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-chart-pie text-success me-2"></i> Tính Macros
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Công cụ chuyên khoa</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('tools.pregnancy-calculator') }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-baby text-info me-2"></i> Tính ngày dự sinh
                                </a>
                                <a href="{{ route('tools.diabetes-risk') }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-syringe text-info me-2"></i> Đánh giá nguy cơ tiểu đường
                                </a>
                                <a href="{{ route('tools.sleep-calculator') }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-bed text-info me-2"></i> Tính thời gian ngủ tối ưu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-light rounded p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4>Theo dõi sức khỏe của bạn</h4>
                        <p class="mb-md-0">Các công cụ sức khỏe giúp bạn nhận biết sớm các yếu tố nguy cơ và cải thiện lối
                            sống. Hãy sử dụng thường xuyên để nắm rõ tình trạng sức khỏe của mình.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('tools.bmi') }}" class="btn btn-primary">Bắt đầu ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 0.75rem 0;
        }

        .list-group-item:first-child {
            border-top: none;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection
