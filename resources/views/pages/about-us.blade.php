@extends ('layouts.master')
@section('title', 'Trang Chủ')
@section('main-content')
    <div class="hero-section">
        <h1>Về CodyHealth</h1>
        <p>Hệ thống chăm sóc sức khỏe hiện đại, tận tâm và chuyên nghiệp</p>
    </div>

    <!-- About Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="about-content">
                    <h2>Chúng Tôi Là Ai?</h2>
                    <p>
                        CodyHealth là nền tảng y tế tiên tiến, cung cấp các
                        dịch vụ chăm sóc sức khỏe chất lượng cao với đội ngũ
                        bác sĩ hàng đầu. Chúng tôi cam kết mang đến dịch vụ
                        tốt nhất cho mọi bệnh nhân.
                    </p>
                    <p>
                        Với công nghệ tiên tiến, CodyHealth giúp bệnh nhân
                        dễ dàng đặt lịch khám, theo dõi tình trạng sức khỏe
                        và nhận tư vấn từ chuyên gia y tế.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <img
                    src="asset/images/posts/post1.webp"
                    class="img-fluid rounded"
                    alt="About CodyHealth" />
            </div>
        </div>
    </div>

    <!-- Core Values -->
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Giá Trị Cốt Lõi</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="icon-box">
                    <i class="fas fa-user-md"></i>
                    <h5>Chuyên Môn Cao</h5>
                    <p>
                        Đội ngũ bác sĩ giỏi, giàu kinh nghiệm trong nhiều
                        lĩnh vực y tế.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="icon-box">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h5>Tận Tâm</h5>
                    <p>
                        Cam kết chăm sóc bệnh nhân với tình yêu thương và
                        trách nhiệm.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="icon-box">
                    <i class="fas fa-hospital"></i>
                    <h5>Công Nghệ Hiện Đại</h5>
                    <p>
                        Ứng dụng công nghệ tiên tiến giúp theo dõi sức khỏe
                        tốt hơn.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Team -->
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Đội Ngũ Bác Sĩ</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="team-member">
                    <img
                        src="asset/images/users/doctor1.jpeg"
                        alt="Dr. Anna Nguyen" />
                    <h6>Dr. Anna Nguyen</h6>
                    <p>Tim Mạch</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="team-member">
                    <img
                        src="asset/images/users/doctor1.jpeg"
                        alt="Dr. John Smith" />
                    <h6>Dr. John Smith</h6>
                    <p>Nội Khoa</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="team-member">
                    <img
                        src="asset/images/users/doctor1.jpeg"
                        alt="Dr. Mary Jane" />
                    <h6>Dr. Mary Jane</h6>
                    <p>Nhi Khoa</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="team-member">
                    <img
                        src="asset/images/users/doctor1.jpeg"
                        alt="Dr. David Lee" />
                    <h6>Dr. David Lee</h6>
                    <p>Chấn Thương Chỉnh Hình</p>
                </div>
            </div>
        </div>
    </div>
@endsection
