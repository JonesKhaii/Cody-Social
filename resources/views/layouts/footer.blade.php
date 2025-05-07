<!-- HTML Code -->
<footer class="footer text-white">
    <div class="container">
        <div class="row">
            <!-- Giới thiệu -->
            <div class="col-md-5">
                <div class="footer-info">
                    <h4 class="footer-title">Về Cody Health</h4>
                    <p>Cody Health cung cấp các giải pháp y tế chuyên nghiệp, hỗ trợ sức khỏe toàn diện cho cộng đồng.
                    </p>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope"></i> contact@codyhealth.com</p>
                        <p><i class="fas fa-map-marker-alt"></i> 123 Đường Sức Khỏe, Quận 1, TP.HCM</p>
                        <p><i class="fas fa-phone"></i> +84 (28) 1234 5678</p>
                    </div>
                </div>
            </div>

            <!-- Links hữu ích -->
            <div class="col-md-3">
                <h4 class="footer-title">Liên kết hữu ích</h4>
                <ul class="footer-links">
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Dịch vụ</a></li>
                    <li><a href="#">Đội ngũ bác sĩ</a></li>
                    <li><a href="#">Tin tức</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>

            <!-- Mạng xã hội -->
            <div class="col-md-4">
                <h4 class="footer-title">Kết nối với chúng tôi</h4>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>

                <div class="newsletter mt-3">
                    <h5>Đăng ký nhận tin</h5>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email của bạn">
                        <div class="input-group-append">
                            <button class="btn btn-light" type="button">Đăng ký</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>© 2025 Cody Health. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><a href="#">Chính sách bảo mật</a> | <a href="#">Điều khoản sử dụng</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- CSS Code -->
<style>
    .footer {
        background-color: #1565C0;
        color: white;
        padding: 50px 0 0;
        font-size: 16px;
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0D47A1, #42A5F5);
    }

    .footer-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }

    /* .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background-color: #90CAF9;
    } */

    .footer p {
        margin-bottom: 16px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
    }

    .contact-info p {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .contact-info i {
        margin-right: 10px;
        width: 16px;
        color: #90CAF9;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 15px;
    }

    .footer-links a:before {
        content: '\f105';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        left: 0;
        color: #90CAF9;
    }

    .footer-links a:hover {
        color: white;
        padding-left: 20px;
    }

    .social-icons {
        display: flex;
        gap: 12px;
        margin-top: 10px;
    }

    .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        background-color: #90CAF9;
        color: #1565C0;
        transform: translateY(-3px);
    }

    .newsletter .input-group {
        margin-top: 10px;
        display: flex;
        flex-wrap: nowrap;
    }

    .newsletter input {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        padding: 10px 15px;
        border-radius: 4px 0 0 4px;
        flex-grow: 1;
    }

    .newsletter input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .newsletter button {
        background-color: #90CAF9;
        color: #1565C0;
        border: none;
        font-weight: 600;
        padding: 10px 15px;
        border-radius: 0 4px 4px 0;
        white-space: nowrap;
    }

    .newsletter button:hover {
        background-color: white;
    }

    .copyright {
        background-color: rgba(0, 0, 0, 0.1);
        padding: 20px 0;
        margin-top: 40px;
    }

    .copyright p {
        margin-bottom: 0;
        font-size: 14px;
    }

    .copyright a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .copyright a:hover {
        color: #90CAF9;
    }

    @media (max-width: 768px) {
        .footer {
            padding: 30px 0 0;
        }

        .footer-title {
            margin-top: 20px;
        }

        .social-icons {
            justify-content: flex-start;
        }

        .copyright .text-end {
            text-align: left !important;
            margin-top: 10px;
        }
    }
</style>
