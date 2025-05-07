@extends ('layouts.master')
@section('title', 'Về CodyHealth - Hệ Thống Chăm Sóc Sức Khỏe Hiện Đại')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/about-us.css') }}">
@endsection

@section('main-content')
    <!-- Hero Section với Background Parallax -->
    <div class="hero-section position-relative">
        <div class="hero-bg" style="background-image: url('asset/images/banners/banner.png')"></div>
        <div class="hero-content container text-center">
            <h1 class="display-4 fw-bold mb-3 text-white">Về CodyHealth</h1>
            <p class="lead mb-4 text-white">Hệ thống chăm sóc sức khỏe hiện đại, tận tâm và chuyên nghiệp</p>
            <a href="#lien-he" class="btn btn-primary btn-lg">Đặt Lịch Khám Ngay</a>
        </div>
    </div>

    <!-- Giới thiệu với số liệu ấn tượng -->
    <div class="container mt-5">
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h2 class="section-title">Chào Mừng Đến Với CodyHealth</h2>
                <p class="section-subtitle">Nơi chăm sóc sức khỏe của bạn là ưu tiên hàng đầu của chúng tôi</p>
            </div>
        </div>

        <div class="row stats-counter">
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center">
                    <span class="counter">10+</span>
                    <p>Năm Kinh Nghiệm</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center">
                    <span class="counter">50+</span>
                    <p>Bác Sĩ Chuyên Khoa</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center">
                    <span class="counter">15,000+</span>
                    <p>Bệnh Nhân Hài Lòng</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center">
                    <span class="counter">98%</span>
                    <p>Tỷ Lệ Hài Lòng</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Giới thiệu Chi Tiết -->
    <div class="container mt-5 pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="mb-4">Chúng Tôi Là Ai?</h2>
                    <p class="lead mb-4">
                        CodyHealth là nền tảng y tế tiên tiến, được thành lập với sứ mệnh mang đến dịch vụ chăm sóc sức khỏe
                        chất lượng cao, dễ tiếp cận cho mọi người dân Việt Nam.
                    </p>
                    <p class="mb-4">
                        Với đội ngũ bác sĩ giàu kinh nghiệm, chúng tôi cam kết mang đến dịch vụ chăm sóc sức khỏe toàn diện,
                        từ khám chữa bệnh đến phòng ngừa và tư vấn sức khỏe cho mọi đối tượng, mọi lứa tuổi.
                    </p>
                    <p>
                        Tại CodyHealth, chúng tôi đặt bệnh nhân là trung tâm, luôn lắng nghe và tôn trọng nhu cầu của từng
                        cá nhân, tạo nên trải nghiệm y tế tốt nhất cho mỗi bệnh nhân.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image position-relative">
                    <img src="asset/images/posts/post1.webp" class="img-fluid rounded shadow" alt="About CodyHealth">
                    <div class="experience-badge">
                        <span>10+</span>
                        <p>Năm Kinh Nghiệm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tầm Nhìn & Sứ Mệnh -->
    <div class="vision-mission my-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="vision-box rounded p-4 shadow">
                        <div class="icon-box mb-3">
                            <i class="fas fa-eye fa-3x"></i>
                        </div>
                        <h3>Tầm Nhìn</h3>
                        <p>
                            Trở thành hệ thống chăm sóc sức khỏe hàng đầu Việt Nam, nơi mọi người dân được tiếp cận với dịch
                            vụ y tế chất lượng cao, tiên tiến và thân thiện.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mission-box rounded p-4 shadow">
                        <div class="icon-box mb-3">
                            <i class="fas fa-bullseye fa-3x"></i>
                        </div>
                        <h3>Sứ Mệnh</h3>
                        <p>
                            Mang đến giải pháp chăm sóc sức khỏe toàn diện, kết hợp y học hiện đại với công nghệ tiên tiến,
                            nhằm nâng cao chất lượng cuộc sống của mọi người dân Việt Nam.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Giá Trị Cốt Lõi -->
    <div class="container my-5">
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h2 class="section-title">Giá Trị Cốt Lõi</h2>
                <p class="section-subtitle">Những nguyên tắc định hướng mọi hoạt động của CodyHealth</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-user-md fa-3x"></i>
                    </div>
                    <h4>Chuyên Môn Cao</h4>
                    <p>
                        Đội ngũ bác sĩ giỏi, giàu kinh nghiệm trong nhiều lĩnh vực y tế, thường xuyên cập nhật kiến thức và
                        kỹ năng mới nhất.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-hand-holding-heart fa-3x"></i>
                    </div>
                    <h4>Tận Tâm</h4>
                    <p>
                        Cam kết đặt bệnh nhân làm trung tâm, lắng nghe và tôn trọng nhu cầu của từng cá nhân, chăm sóc với
                        tình yêu thương và trách nhiệm.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-hospital fa-3x"></i>
                    </div>
                    <h4>Công Nghệ Hiện Đại</h4>
                    <p>
                        Ứng dụng công nghệ y tế tiên tiến nhất, giúp chẩn đoán chính xác, điều trị hiệu quả và theo dõi sức
                        khỏe toàn diện.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-shield-alt fa-3x"></i>
                    </div>
                    <h4>An Toàn</h4>
                    <p>
                        Đảm bảo môi trường điều trị an toàn, tuân thủ nghiêm ngặt các quy trình y tế và tiêu chuẩn an toàn
                        quốc tế.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-chart-line fa-3x"></i>
                    </div>
                    <h4>Đổi Mới Liên Tục</h4>
                    <p>
                        Không ngừng cải tiến quy trình, dịch vụ và công nghệ để mang đến trải nghiệm tốt nhất cho khách
                        hàng.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h4>Hợp Tác</h4>
                    <p>
                        Xây dựng mối quan hệ hợp tác bền vững với các đối tác y tế trong nước và quốc tế để nâng cao chất
                        lượng dịch vụ.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dịch Vụ Nổi Bật -->
    <div class="featured-services my-5 py-5">
        <div class="container">
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-lg-8">
                    <h2 class="section-title">Dịch Vụ Nổi Bật</h2>
                    <p class="section-subtitle">Những dịch vụ y tế chất lượng cao tại CodyHealth</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-box rounded p-4 text-center shadow">
                        <div class="service-icon mb-3">
                            <i class="fas fa-heartbeat fa-3x"></i>
                        </div>
                        <h4>Khám Sức Khỏe Tổng Quát</h4>
                        <p>
                            Gói khám toàn diện giúp phát hiện sớm các bệnh lý và đánh giá tình trạng sức khỏe tổng thể.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-box rounded p-4 text-center shadow">
                        <div class="service-icon mb-3">
                            <i class="fas fa-stethoscope fa-3x"></i>
                        </div>
                        <h4>Tư Vấn Chuyên Khoa</h4>
                        <p>
                            Dịch vụ tư vấn với các bác sĩ chuyên khoa giàu kinh nghiệm trong nhiều lĩnh vực.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-box rounded p-4 text-center shadow">
                        <div class="service-icon mb-3">
                            <i class="fas fa-mobile-alt fa-3x"></i>
                        </div>
                        <h4>Tư Vấn Sức Khỏe Từ Xa</h4>
                        <p>
                            Giải pháp thăm khám trực tuyến, giúp bạn tiết kiệm thời gian và nhận tư vấn y tế mọi lúc, mọi
                            nơi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đội Ngũ Bác Sĩ -->
    <div class="container my-5">
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h2 class="section-title">Đội Ngũ Bác Sĩ Xuất Sắc</h2>
                <p class="section-subtitle">Những chuyên gia y tế hàng đầu tại CodyHealth</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100" alt="Dr. Anna Nguyen">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">Dr. Anna Nguyen</h5>
                        <p class="specialty mb-1">Tim Mạch</p>
                        <p class="experience mb-2"><small>10+ năm kinh nghiệm</small></p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đặt Lịch Khám</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100" alt="Dr. John Smith">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">Dr. John Smith</h5>
                        <p class="specialty mb-1">Nội Khoa</p>
                        <p class="experience mb-2"><small>15+ năm kinh nghiệm</small></p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đặt Lịch Khám</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100" alt="Dr. Mary Jane">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">Dr. Mary Jane</h5>
                        <p class="specialty mb-1">Nhi Khoa</p>
                        <p class="experience mb-2"><small>8+ năm kinh nghiệm</small></p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đặt Lịch Khám</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100" alt="Dr. David Lee">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">Dr. David Lee</h5>
                        <p class="specialty mb-1">Chấn Thương Chỉnh Hình</p>
                        <p class="experience mb-2"><small>12+ năm kinh nghiệm</small></p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đặt Lịch Khám</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="#" class="btn btn-primary">Xem Tất Cả Bác Sĩ</a>
        </div>
    </div>

    <!-- Cảm Nhận Khách Hàng -->
    <div class="testimonials my-5 py-5">
        <div class="container">
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-lg-8">
                    <h2 class="section-title">Cảm Nhận Từ Khách Hàng</h2>
                    <p class="section-subtitle">Những chia sẻ chân thành từ bệnh nhân của CodyHealth</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-box rounded p-4 shadow">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">
                            "Tôi rất hài lòng với dịch vụ tại CodyHealth. Bác sĩ tận tâm, nhân viên thân thiện và cơ sở vật
                            chất hiện đại. Tôi sẽ tiếp tục lựa chọn CodyHealth cho gia đình mình."
                        </p>
                        <div class="testimonial-author d-flex align-items-center mt-3">
                            <div class="author-avatar">
                                <img src="asset/images/users/user1.jpg" alt="Nguyễn Văn A">
                            </div>
                            <div class="author-info ml-3">
                                <h6 class="mb-0">Nguyễn Văn A</h6>
                                <p class="mb-0"><small>Bệnh nhân Tim Mạch</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-box rounded p-4 shadow">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">
                            "Dịch vụ tư vấn sức khỏe từ xa của CodyHealth rất tiện lợi. Tôi không cần di chuyển xa mà vẫn
                            được tư vấn bởi các bác sĩ chuyên môn cao. Thực sự là một giải pháp tuyệt vời!"
                        </p>
                        <div class="testimonial-author d-flex align-items-center mt-3">
                            <div class="author-avatar">
                                <img src="asset/images/users/user2.jpg" alt="Trần Thị B">
                            </div>
                            <div class="author-info ml-3">
                                <h6 class="mb-0">Trần Thị B</h6>
                                <p class="mb-0"><small>Bệnh nhân Nội Khoa</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-box rounded p-4 shadow">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text">
                            "Con tôi rất sợ đi khám bệnh, nhưng các bác sĩ tại CodyHealth đã tạo môi trường thân thiện giúp
                            cháu cảm thấy thoải mái. Đội ngũ nhi khoa tại đây thực sự hiểu tâm lý trẻ em."
                        </p>
                        <div class="testimonial-author d-flex align-items-center mt-3">
                            <div class="author-avatar">
                                <img src="asset/images/users/user3.jpg" alt="Lê Văn C">
                            </div>
                            <div class="author-info ml-3">
                                <h6 class="mb-0">Lê Văn C</h6>
                                <p class="mb-0"><small>Phụ huynh bệnh nhi</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đối Tác -->
    <div class="container my-5">
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h2 class="section-title">Đối Tác Của Chúng Tôi</h2>
                <p class="section-subtitle">Những tổ chức tin tưởng và hợp tác cùng CodyHealth</p>
            </div>
        </div>
        <div class="partners-slider">
            <div class="row">
                <div class="col-md-2 col-6 mb-4">
                    <div class="partner-logo text-center">
                        <img src="asset/images/partners/partner1.png" alt="Partner 1" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4">
                    <div class="partner-logo text-center">
                        <img src="asset/images/partners/partner2.png" alt="Partner 2" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4">
                    <div class="partner-logo text-center">
                        <img src="asset/images/partners/partner3.png" alt="Partner 3" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4">
                    <div class="partner-logo text-center">
                        <img src="asset/images/partners/partner4.png" alt="Partner 4" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4">
                    <div class="partner-logo text-center">
                        <img src="asset/images/partners/partner5.png" alt="Partner 5" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4">
                    <div class="partner-logo text-center">
                        <img src="asset/images/partners/partner6.png" alt="Partner 6" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section my-5 py-5" id="lien-he">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-3">Bạn Cần Hỗ Trợ?</h2>
                    <p class="mb-4">Hãy liên hệ với chúng tôi ngay hôm nay để được tư vấn và đặt lịch khám với các bác sĩ
                        chuyên môn.</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="#" class="btn btn-primary btn-lg mr-2">Đặt Lịch Khám</a>
                    <a href="#" class="btn btn-outline-primary btn-lg">Tư Vấn Miễn Phí</a>
                </div>
            </div>
        </div>
    </div>


@endsection
