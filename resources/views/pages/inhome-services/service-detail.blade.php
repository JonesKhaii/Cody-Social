@extends('layouts.master')

@section('main-content')
    <div class="service-detail-page">
        <!-- Breadcrumbs -->
        <div class="bg-light py-3">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('services') }}">Dịch vụ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $service->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Service Header -->
        <div class="service-header py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="mb-3">{{ $service->name }}</h1>
                        <p class="lead">{{ $service->description }}</p>
                        <a href="#book-service" class="btn btn-primary btn-lg mt-3">
                            <i class="fas fa-calendar-check me-2"></i>Đặt lịch ngay
                        </a>
                    </div>
                    <div class="col-lg-6">
                        @if ($service->image)
                            <img src="{{ $service->image }}" alt="{{ $service->name }}" class="img-fluid rounded shadow">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded p-5 shadow"
                                style="height: 300px;">
                                @if ($service->icon)
                                    <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" style="height: 120px;">
                                @else
                                    <i class="fas fa-heartbeat fa-5x text-primary"></i>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <div class="service-details bg-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="mb-4">Chi tiết dịch vụ</h2>

                                <div class="service-content">
                                    <!-- Đây là nội dung chi tiết dịch vụ -->
                                    @if ($service->content)
                                        {!! $service->content !!}
                                    @else
                                        <!-- Nội dung mặc định cho từng loại dịch vụ -->
                                        @if ($service->slug == 'ho-tro-cham-soc-tai-nha')
                                            <h4>Dịch vụ chăm sóc tại nhà của chúng tôi bao gồm:</h4>
                                            <ul class="service-features">
                                                <li>Chăm sóc vết thương, thay băng, chăm sóc ống thông</li>
                                                <li>Theo dõi các chỉ số sức khỏe như huyết áp, đường huyết</li>
                                                <li>Hỗ trợ dùng thuốc theo đơn của bác sĩ</li>
                                                <li>Chăm sóc vệ sinh cá nhân hàng ngày</li>
                                                <li>Hỗ trợ tập vật lý trị liệu, phục hồi chức năng</li>
                                                <li>Tư vấn dinh dưỡng và chế độ ăn phù hợp</li>
                                            </ul>

                                            <h4 class="mt-4">Đội ngũ chăm sóc</h4>
                                            <p>Đội ngũ điều dưỡng và nhân viên y tế của chúng tôi đều được đào tạo chuyên
                                                nghiệp, có nhiều năm kinh nghiệm và được cấp chứng chỉ hành nghề. Họ không
                                                chỉ có kỹ năng chuyên môn cao mà còn có thái độ phục vụ tận tâm, chu đáo.
                                            </p>

                                            <h4 class="mt-4">Thời gian phục vụ</h4>
                                            <p>Dịch vụ chăm sóc tại nhà của chúng tôi hoạt động 24/7, sẵn sàng đáp ứng mọi
                                                nhu cầu của bạn và gia đình.</p>
                                        @else
                                            <!-- Nội dung mặc định cho các dịch vụ khác -->
                                            <p>Dịch vụ {{ $service->name }} của chúng tôi được thiết kế để đáp ứng nhu cầu
                                                chăm sóc sức khỏe toàn diện của bạn và gia đình. Với đội ngũ y bác sĩ giàu
                                                kinh nghiệm và tận tâm, chúng tôi cam kết mang đến dịch vụ chất lượng cao,
                                                đảm bảo an toàn và hiệu quả.</p>

                                            <h4 class="mt-4">Lợi ích của dịch vụ</h4>
                                            <ul class="service-features">
                                                <li>Dịch vụ chuyên nghiệp, đạt chuẩn y tế</li>
                                                <li>Tiết kiệm thời gian và chi phí đi lại</li>
                                                <li>Được chăm sóc trong môi trường quen thuộc</li>
                                                <li>Đội ngũ y tế giàu kinh nghiệm</li>
                                                <li>Linh hoạt thời gian theo nhu cầu</li>
                                                <li>Giám sát và báo cáo tình trạng thường xuyên</li>
                                            </ul>

                                            <h4 class="mt-4">Quy trình thực hiện</h4>
                                            <ol>
                                                <li>Tiếp nhận thông tin và đánh giá nhu cầu</li>
                                                <li>Tư vấn gói dịch vụ phù hợp</li>
                                                <li>Xây dựng kế hoạch chi tiết</li>
                                                <li>Triển khai dịch vụ</li>
                                                <li>Báo cáo và đánh giá hiệu quả</li>
                                            </ol>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin thêm về dịch vụ -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="mb-4">Quy trình thực hiện</h3>

                                <div class="row">
                                    <div class="col-md-4 mb-md-0 mb-3">
                                        <div class="process-step text-center">
                                            <div
                                                class="process-icon rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3 text-white">
                                                <span>1</span>
                                            </div>
                                            <h5>Đăng ký dịch vụ</h5>
                                            <p class="text-muted small">Điền thông tin và nhu cầu chăm sóc của bạn</p>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-md-0 mb-3">
                                        <div class="process-step text-center">
                                            <div
                                                class="process-icon rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3 text-white">
                                                <span>2</span>
                                            </div>
                                            <h5>Tư vấn chi tiết</h5>
                                            <p class="text-muted small">Chuyên viên của chúng tôi sẽ liên hệ và tư vấn gói
                                                dịch vụ phù hợp</p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="process-step text-center">
                                            <div
                                                class="process-icon rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3 text-white">
                                                <span>3</span>
                                            </div>
                                            <h5>Triển khai dịch vụ</h5>
                                            <p class="text-muted small">Nhân viên y tế sẽ đến tận nơi để thực hiện dịch vụ
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="mb-4">Câu hỏi thường gặp</h3>

                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item mb-3 border-0">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="false" aria-controls="collapseOne">
                                                Chi phí dịch vụ {{ $service->name }} là bao nhiêu?
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Chi phí dịch vụ phụ thuộc vào nhu cầu cụ thể và thời gian sử dụng dịch vụ.
                                                Vui lòng liên hệ với chúng tôi để được tư vấn chi tiết và nhận báo giá phù
                                                hợp nhất.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item mb-3 border-0">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Làm thế nào để đặt lịch sử dụng dịch vụ?
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Bạn có thể đặt lịch thông qua website của chúng tôi, gọi điện trực tiếp hoặc
                                                đến trực tiếp cơ sở của chúng tôi. Sau khi nhận thông tin, chúng tôi sẽ liên
                                                hệ lại để xác nhận và sắp xếp lịch phù hợp.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                Dịch vụ có được bảo hiểm y tế chi trả không?
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Một số dịch vụ của chúng tôi có thể được bảo hiểm y tế chi trả tùy thuộc vào
                                                loại bảo hiểm của bạn. Vui lòng liên hệ với chúng tôi và cung cấp thông tin
                                                bảo hiểm để chúng tôi kiểm tra khả năng chi trả.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-lg-0 mt-4">
                        <!-- Đặt lịch -->
                        <div class="card mb-4 border-0 shadow-sm" id="book-service">
                            <div class="card-body p-4">
                                <h3 class="mb-3">Đặt lịch dịch vụ</h3>
                                <form>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Ngày hẹn</label>
                                        <input type="date" class="form-control" id="date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <textarea class="form-control" id="note" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Gửi yêu cầu</button>
                                </form>
                            </div>
                        </div>

                        <!-- Dịch vụ liên quan -->
                        @if (isset($relatedServices) && $relatedServices->count() > 0)
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="mb-3">Dịch vụ liên quan</h3>
                                    <div class="related-services">
                                        @foreach ($relatedServices as $relatedService)
                                            <div class="related-service-item mb-3">
                                                <a href="{{ route('services.show', $relatedService->slug) }}"
                                                    class="d-flex align-items-center text-decoration-none">
                                                    @if ($relatedService->icon)
                                                        <img src="{{ $relatedService->icon_url }}"
                                                            alt="{{ $relatedService->name }}" class="me-3"
                                                            style="width: 40px; height: 40px;">
                                                    @else
                                                        <i class="fas fa-heartbeat fa-2x text-primary me-3"></i>
                                                    @endif
                                                    <span>{{ $relatedService->name }}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Thông tin liên hệ -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="mb-3">Thông tin liên hệ</h3>
                                <ul class="list-unstyled contact-info">
                                    <li class="d-flex mb-3">
                                        <i class="fas fa-phone-alt text-primary me-3 mt-1"></i>
                                        <div>
                                            <p class="mb-0">Hotline:</p>
                                            <a href="tel:0983 691 895" class="text-decoration-none font-weight-bold">0983
                                                691 895</a>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-3">
                                        <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                                        <div>
                                            <p class="mb-0">Email:</p>
                                            <a href="mailto:codyhealth2023@gmail.com"
                                                class="text-decoration-none">codyhealth2023@gmail.com</a>
                                        </div>
                                    </li>
                                    <li class="d-flex">
                                        <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                        <div>
                                            <p class="mb-0">Địa chỉ:</p>
                                            <p class="mb-0">LK2B, licogi 13 164 Khuất Duy Tiến, Nhân Chính, Thanh Xuân,
                                                Hà Nội.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Thẻ testimonial -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="mb-3">Phản hồi từ khách hàng</h3>
                                <div class="testimonial-item bg-light rounded p-3">
                                    <div class="testimonial-content">
                                        <i class="fas fa-quote-left text-primary me-2"></i>
                                        <p class="mb-3">Tôi rất hài lòng với dịch vụ chăm sóc tại nhà. Nhân viên y tế
                                            chuyên nghiệp và tận tâm giúp mẹ tôi phục hồi nhanh chóng sau ca phẫu thuật.</p>
                                    </div>
                                    <div class="testimonial-author d-flex align-items-center">
                                        <div class="author-avatar me-3">
                                            <img src="https://via.placeholder.com/40" alt="Nguyễn Văn A"
                                                class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Nguyễn Văn A</h6>
                                            <p class="text-muted small mb-0">Khách hàng tại Hà Nội</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA section -->
        <div class="cta-section py-5 text-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="mb-3">Bạn cần tư vấn thêm về dịch vụ {{ $service->name }}?</h2>
                        <p class="lead mb-4">Đội ngũ chuyên gia của chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="tel:0983 691 895" class="btn btn-light btn-lg">
                                <i class="fas fa-phone-alt me-2"></i>Gọi ngay
                            </a>
                            <a href="#book-service" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-calendar-alt me-2"></i>Đặt lịch
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .service-features li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
        }

        .service-features li:before {
            content: "\f00c";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #4285f4;
            position: absolute;
            left: 0;
            top: 2px;
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(66, 133, 244, 0.1);
            color: #4285f4;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(66, 133, 244, 0.25);
        }

        .related-service-item {
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .related-service-item:hover {
            background-color: rgba(66, 133, 244, 0.05);
        }

        .related-service-item a {
            color: #333;
        }

        .related-service-item a:hover {
            color: #4285f4;
        }

        .process-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
            font-weight: bold;
        }

        .author-avatar img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .testimonial-item {
            transition: transform 0.3s ease;
        }

        .testimonial-item:hover {
            transform: translateY(-3px);
        }

        .cta-section {
            margin-bottom: 50px;
            background-color: #1565c0;
        }
    </style>
@endsection
