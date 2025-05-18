@extends ('layouts.master')
@section('title', 'Về Chúng Tôi - Hệ Thống Chăm Sóc Sức Khỏe Cộng Đồng')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/about-us.css') }}">
@endsection

@section('main-content')
    <!-- Hero Section với Background Parallax -->
    <div class="hero-section position-relative">
        <div class="hero-bg" style="background-image: url('asset/images/banners/banner.png')"></div>
        <div class="hero-content container text-center">
            <h1 class="display-4 fw-bold mb-3 text-white">Về Chúng Tôi</h1>
            <p class="lead mb-4 text-white">Hệ thống chăm sóc sức khỏe cộng đồng, tận tâm và chuyên nghiệp</p>
            <a href="#lien-he" class="btn btn-primary btn-lg">Đặt Lịch Khám Ngay</a>
        </div>
    </div>

    <!-- Giới thiệu với số liệu ấn tượng -->
    <div class="container mt-5">
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h2 class="section-title">Chào Mừng Đến Với Chúng Tôi</h2>
                <p class="section-subtitle">Nơi sức khỏe cộng đồng là ưu tiên hàng đầu</p>
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
                        Chúng tôi là nền tảng y tế cộng đồng, được thành lập với sứ mệnh mang đến dịch vụ chăm sóc sức khỏe
                        chất lượng cao, dễ tiếp cận cho mọi người dân Việt Nam.
                    </p>
                    <p class="mb-4">
                        Với đội ngũ bác sĩ giàu kinh nghiệm, chúng tôi cam kết mang đến dịch vụ chăm sóc sức khỏe toàn diện,
                        từ khám chữa bệnh đến phòng ngừa và tư vấn sức khỏe cho mọi đối tượng, mọi lứa tuổi.
                    </p>
                    <p>
                        Tại trung tâm chăm sóc sức khỏe của chúng tôi, mỗi bệnh nhân là trung tâm, luôn lắng nghe và tôn
                        trọng nhu cầu của từng
                        cá nhân, tạo nên trải nghiệm y tế tốt nhất cho mỗi bệnh nhân.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image position-relative">
                    <img src="asset/images/posts/post1.webp" class="img-fluid rounded shadow" alt="About Us">
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
                            Trở thành hệ thống chăm sóc sức khỏe cộng đồng hàng đầu Việt Nam, nơi mọi người dân được tiếp
                            cận với dịch
                            vụ y tế chất lượng cao, tiên tiến và thân thiện, hướng tới sức khỏe toàn diện cho cộng đồng.
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

    <!-- Giá Trị Cốt Lõi - Nguyên Tắc T -->
    <div class="container my-5">
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h2 class="section-title">Giá Trị Cốt Lõi - Nguyên Tắc T</h2>
                <p class="section-subtitle">Hướng tới mục tiêu vì sức khỏe cộng đồng trên các nguyên tắc</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-brain fa-3x"></i>
                    </div>
                    <h4>Tài năng (Talent)</h4>
                    <p>
                        Đội ngũ y bác sĩ tài năng, giàu kinh nghiệm, tận tâm với nghề nghiệp,
                        không ngừng học hỏi và phát triển để mang lại dịch vụ y tế tốt nhất.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-clock fa-3x"></i>
                    </div>
                    <h4>Thời gian (Timely)</h4>
                    <p>
                        Thời gian là vàng - chúng tôi tối ưu hóa quy trình làm việc, đảm bảo
                        bệnh nhân được chăm sóc kịp thời và hiệu quả nhất.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-trophy fa-3x"></i>
                    </div>
                    <h4>Thành công (Triumph)</h4>
                    <p>
                        Hướng đến thành công trong việc chữa trị và phòng ngừa bệnh tật,
                        đồng hành cùng bệnh nhân trên hành trình phục hồi sức khỏe.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-balance-scale fa-3x"></i>
                    </div>
                    <h4>Trung thực (Truth)</h4>
                    <p>
                        Cam kết trung thực và minh bạch trong mọi hoạt động, từ chẩn đoán
                        đến điều trị, tạo dựng niềm tin vững chắc với bệnh nhân.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-chart-line fa-3x"></i>
                    </div>
                    <h4>Tăng trưởng (Thrive)</h4>
                    <p>
                        Không ngừng phát triển và đổi mới, ứng dụng công nghệ y tế tiên tiến
                        để nâng cao chất lượng dịch vụ chăm sóc sức khỏe.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="core-value-box h-100 rounded p-4 shadow">
                    <div class="icon-box mb-3">
                        <i class="fas fa-handshake fa-3x"></i>
                    </div>
                    <h4>Trust (Niềm tin)</h4>
                    <p>
                        Xây dựng mối quan hệ dựa trên niềm tin vững chắc với bệnh nhân và đối tác,
                        tạo nên môi trường y tế đáng tin cậy và tôn trọng.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Giá Trị Cốt Lõi Bổ Sung -->
    <div class="container my-5 pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-image position-relative">
                    <img src="asset/images/posts/post2.webp" class="img-fluid rounded shadow" alt="Our Values">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="mb-4">Những Giá Trị Cốt Lõi Khác</h2>
                    <div class="value-item mb-4">
                        <h5><i class="fas fa-heart text-primary mr-2"></i> Lòng biết ơn (Thankful)</h5>
                        <p>
                            Chúng tôi trân trọng niềm tin mà bệnh nhân đặt vào đội ngũ y bác sĩ,
                            và luôn biết ơn vì được phục vụ cộng đồng mỗi ngày.
                        </p>
                    </div>
                    <div class="value-item mb-4">
                        <h5><i class="fas fa-lightbulb text-primary mr-2"></i> Sự thật (True)</h5>
                        <p>
                            Cam kết mang đến giá trị thực, không phóng đại hay hứa hẹn quá mức,
                            luôn đặt lợi ích sức khỏe của bệnh nhân lên hàng đầu.
                        </p>
                    </div>
                    <div class="value-item mb-4">
                        <h5><i class="fas fa-dove text-primary mr-2"></i> Bình yên (Tranquility)</h5>
                        <p>
                            Tạo môi trường y tế an toàn, thân thiện giúp bệnh nhân cảm thấy bình yên
                            và thoải mái trong suốt quá trình khám chữa bệnh.
                        </p>
                    </div>
                    <div class="value-item">
                        <h5><i class="fas fa-wind text-primary mr-2"></i> Linh động (Transform)</h5>
                        <p>
                            Linh hoạt trong cách tiếp cận và giải quyết vấn đề, thích ứng với
                            những thay đổi và thách thức để đáp ứng tốt nhất nhu cầu của bệnh nhân.
                        </p>
                    </div>
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
                    <p class="section-subtitle">Những dịch vụ y tế chất lượng cao vì sức khỏe cộng đồng</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-box rounded p-4 text-center shadow">
                        <div class="service-icon mb-3">
                            <i class="fas fa-heartbeat fa-3x"></i>
                        </div>
                        <h4>Khám Sức Khỏe Toàn Diện</h4>
                        <p>
                            Gói khám toàn diện theo nguyên tắc T giúp phát hiện sớm các bệnh lý và đánh giá tình trạng sức
                            khỏe tổng thể.
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
                            Dịch vụ tư vấn với các bác sĩ chuyên khoa giàu kinh nghiệm, áp dụng nguyên tắc thời gian và tài
                            năng.
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
                <p class="section-subtitle">Những chuyên gia y tế tài năng và tận tâm</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100"
                            alt="Bác sĩ chuyên khoa Tim Mạch">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">TS. BS. Nguyễn Văn A</h5>
                        <p class="specialty mb-1">Tim Mạch</p>
                        <p class="experience mb-2"><small>10+ năm kinh nghiệm</small></p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đặt Lịch Khám</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100" alt="Bác sĩ chuyên khoa Nội">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">PGS. TS. Trần Văn B</h5>
                        <p class="specialty mb-1">Nội Khoa</p>
                        <p class="experience mb-2"><small>15+ năm kinh nghiệm</small></p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đặt Lịch Khám</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100" alt="Bác sĩ chuyên khoa Nhi">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">TS. BS. Lê Thị C</h5>
                        <p class="specialty mb-1">Nhi Khoa</p>
                        <p class="experience mb-2"><small>8+ năm kinh nghiệm</small></p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đặt Lịch Khám</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="doctor-card overflow-hidden rounded shadow">
                    <div class="doctor-image">
                        <img src="asset/images/users/doctor1.jpeg" class="img-fluid w-100"
                            alt="Bác sĩ chuyên khoa Chỉnh Hình">
                        <div class="doctor-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="doctor-info p-3 text-center">
                        <h5 class="mb-1">BS. CKI. Hoàng Văn D</h5>
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

    <!-- Tác Động Cộng Đồng -->
    <div class="impact-section my-5 py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-lg-8">
                    <h2 class="section-title">Tác Động Đến Cộng Đồng</h2>
                    <p class="section-subtitle">Những đóng góp của chúng tôi cho sức khỏe cộng đồng</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="impact-box h-100 rounded p-4 shadow">
                        <div class="row">
                            <div class="col-md-4 mb-md-0 mb-3">
                                <img src="asset/images/impact/impact1.jpg" class="img-fluid rounded"
                                    alt="Chương trình khám bệnh miễn phí">
                            </div>
                            <div class="col-md-8">
                                <h4>Chương Trình Khám Bệnh Miễn Phí</h4>
                                <p>Thực hiện hơn 50 chương trình khám bệnh miễn phí tại các vùng nông thôn, miền núi, giúp
                                    hơn 10,000 người dân tiếp cận dịch vụ y tế chất lượng.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="impact-box h-100 rounded p-4 shadow">
                        <div class="row">
                            <div class="col-md-4 mb-md-0 mb-3">
                                <img src="asset/images/impact/impact2.jpg" class="img-fluid rounded"
                                    alt="Giáo dục sức khỏe cộng đồng">
                            </div>
                            <div class="col-md-8">
                                <h4>Giáo Dục Sức Khỏe Cộng Đồng</h4>
                                <p>Tổ chức hơn 100 buổi tuyên truyền, giáo dục sức khỏe tại các trường học, khu dân cư, nâng
                                    cao nhận thức về phòng ngừa bệnh tật.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="impact-box h-100 rounded p-4 shadow">
                        <div class="row">
                            <div class="col-md-4 mb-md-0 mb-3">
                                <img src="asset/images/impact/impact3.jpg" class="img-fluid rounded"
                                    alt="Đào tạo nhân lực y tế">
                            </div>
                            <div class="col-md-8">
                                <h4>Đào Tạo Nhân Lực Y Tế</h4>
                                <p>Đào tạo và nâng cao trình độ cho hơn 200 cán bộ y tế tại các trạm y tế xã, phường, góp
                                    phần nâng cao chất lượng y tế cơ sở.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="impact-box h-100 rounded p-4 shadow">
                        <div class="row">
                            <div class="col-md-4 mb-md-0 mb-3">
                                <img src="asset/images/impact/impact4.jpg" class="img-fluid rounded"
                                    alt="Nghiên cứu y học">
                            </div>
                            <div class="col-md-8">
                                <h4>Nghiên Cứu Y Học</h4>
                                <p>Thực hiện nhiều đề tài nghiên cứu về các bệnh phổ biến tại Việt Nam, đóng góp vào sự phát
                                    triển của y học trong nước và quốc tế.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cảm Nhận Khách Hàng -->
    <div class="testimonials my-5 py-5">
        <div class="container">
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-lg-8">
                    <h2 class="section-title">Cảm Nhận Từ Bệnh Nhân</h2>
                    <p class="section-subtitle">Những chia sẻ chân thành từ bệnh nhân của chúng tôi</p>
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
                            "Tôi rất hài lòng với dịch vụ tại đây. Bác sĩ tận tâm, nhân viên thân thiện và cơ sở vật
                            chất hiện đại. Đặc biệt là phương châm 'Thời gian là vàng' đã giúp tôi tiết kiệm thời gian chờ
                            đợi."
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
                            "Dịch vụ tư vấn sức khỏe từ xa rất tiện lợi. Tôi không cần di chuyển xa mà vẫn
                            được tư vấn bởi các bác sĩ chuyên môn cao. Đội ngũ y bác sĩ luôn trung thực trong việc tư vấn
                            điều trị."
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
                            "Con tôi rất sợ đi khám bệnh, nhưng các bác sĩ đã tạo môi trường bình yên giúp
                            cháu cảm thấy thoải mái. Đội ngũ nhi khoa thực sự hiểu tâm lý trẻ em và rất tận tâm."
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
                <p class="section-subtitle">Những tổ chức tin tưởng và hợp tác cùng chúng tôi</p>
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

    <!-- Cam Kết Với Nguyên Tắc T -->
    <div class="commitment-section my-5 py-5"
        style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('asset/images/banners/banner2.jpg'); background-size: cover; background-position: center; color: white;">
        <div class="container">
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-lg-8">
                    <h2 class="section-title text-white">Cam Kết Của Chúng Tôi</h2>
                    <p class="section-subtitle text-white-50">Thực hiện nguyên tắc T trong mọi hoạt động</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="commitment-item d-flex">
                        <div class="commitment-icon mr-4">
                            <i class="fas fa-check-circle fa-3x text-primary"></i>
                        </div>
                        <div class="commitment-content">
                            <h4 class="commitment-title mb-3">Tài Năng & Trung Thực</h4>
                            <p>Chúng tôi cam kết xây dựng đội ngũ y bác sĩ tài năng, luôn trung thực trong chẩn đoán và điều
                                trị, đặt lợi ích sức khỏe của bệnh nhân lên hàng đầu.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="commitment-item d-flex">
                        <div class="commitment-icon mr-4">
                            <i class="fas fa-check-circle fa-3x text-primary"></i>
                        </div>
                        <div class="commitment-content">
                            <h4 class="commitment-title mb-3">Thời Gian & Thành Công</h4>
                            <p>Chúng tôi tối ưu hóa thời gian cho bệnh nhân, đồng thời cam kết mang đến thành công trong
                                điều trị, giúp bệnh nhân nhanh chóng phục hồi sức khỏe.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="commitment-item d-flex">
                        <div class="commitment-icon mr-4">
                            <i class="fas fa-check-circle fa-3x text-primary"></i>
                        </div>
                        <div class="commitment-content">
                            <h4 class="commitment-title mb-3">Tăng Trưởng & Giá Trị Thực</h4>
                            <p>Chúng tôi không ngừng đổi mới và phát triển, cam kết mang đến những giá trị thực cho cộng
                                đồng, góp phần nâng cao chất lượng cuộc sống.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="commitment-item d-flex">
                        <div class="commitment-icon mr-4">
                            <i class="fas fa-check-circle fa-3x text-primary"></i>
                        </div>
                        <div class="commitment-content">
                            <h4 class="commitment-title mb-3">Trust & Tranquility</h4>
                            <p>Chúng tôi xây dựng niềm tin vững chắc với bệnh nhân, đồng thời tạo môi trường y tế bình yên,
                                giúp bệnh nhân cảm thấy an tâm trong suốt quá trình điều trị.</p>
                        </div>
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
                        chuyên môn. Chúng tôi cam kết thực hiện nguyên tắc T trong mọi dịch vụ.</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="#" class="btn btn-primary btn-lg mr-2">Đặt Lịch Khám</a>
                    <a href="#" class="btn btn-outline-primary btn-lg">Tư Vấn Miễn Phí</a>
                </div>
            </div>
        </div>
    </div>

@endsection
