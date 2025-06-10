@extends('layouts.master')

@section('title', 'Chính sách bảo mật và quyền riêng tư')

@section('main-content')
    <div class="policy-container">
        <div class="policy-header">
            <h1>CHÍNH SÁCH BẢO MẬT VÀ QUYỀN RIÊNG TƯ</h1>
            <p class="effective-date"><strong>Hiệu lực từ ngày: 01/06/2025</strong></p>
            <p class="intro">Chúng tôi cam kết bảo vệ thông tin cá nhân và quyền riêng tư của người dùng một cách nghiêm túc
                và minh bạch. Chính sách này giải thích cách chúng tôi thu thập, sử dụng, lưu trữ và bảo vệ thông tin cá
                nhân của bạn khi sử dụng website của chúng tôi.</p>
        </div>

        <div class="policy-content">
            <section class="policy-section">
                <h2>1. THÔNG TIN VỀ TỔ CHỨC</h2>
                <p><strong>Tổ chức:</strong> Trực thuộc côpng ty cổ phần Codyhealth</p>
                <p><strong>Địa chỉ:</strong> Tầng 11, Toà Hoàng Huy 275 Nguyễn Trãi, Thanh Xuân Trung, Thanh Xuân, Hà Nội
                </p>
                <p><strong>Email:</strong> toikhoe@toikhoe.vn</p>
            </section>

            <section class="policy-section">
                <h2>2. MỤC ĐÍCH VÀ PHẠM VI THU THẬP THÔNG TIN</h2>

                <h3>2.1 Thông tin chúng tôi thu thập</h3>

                <h4>Đối với người dùng thông thường:</h4>
                <ul>
                    <li><strong>Thông tin đăng ký:</strong> Họ tên, email, số điện thoại, mật khẩu</li>
                    <li><strong>Thông tin tìm kiếm:</strong> Từ khóa tìm kiếm bệnh viện, phòng khám, bác sĩ</li>
                    <li><strong>Thông tin đặt lịch:</strong> Thông tin cá nhân cần thiết để đặt lịch khám bệnh</li>
                    <li><strong>Thông tin tương tác:</strong> Bình luận, phản hồi trên các bài viết</li>
                    <li><strong>Thông tin kỹ thuật:</strong> Địa chỉ IP, loại trình duyệt, thời gian truy cập</li>
                </ul>

                <h4>Đối với bác sĩ:</h4>
                <ul>
                    <li><strong>Thông tin chuyên môn:</strong> Bằng cấp, chứng chỉ hành nghề, chuyên khoa</li>
                    <li><strong>Thông tin công việc:</strong> Nơi công tác, kinh nghiệm, lịch làm việc</li>
                    <li><strong>Thông tin bài viết:</strong> Nội dung bài viết y tế đã đăng tải</li>
                </ul>

                <h3>2.2 Mục đích thu thập</h3>
                <p>Chúng tôi thu thập thông tin để:</p>
                <ul>
                    <li>Tạo và quản lý tài khoản người dùng</li>
                    <li>Cung cấp thông tin về bệnh viện, phòng khám và bác sĩ</li>
                    <li>Xử lý việc đặt lịch khám bệnh</li>
                    <li>Cho phép tương tác thông qua bình luận và phản hồi</li>
                    <li>Xác thực danh tính bác sĩ và cho phép đăng bài</li>
                    <li>Cung cấp nội dung tin tức y tế phù hợp</li>
                    <li>Cải thiện chất lượng dịch vụ và trải nghiệm người dùng</li>
                    <li>Tuân thủ các yêu cầu pháp lý</li>
                </ul>

                <h3>2.3 Cơ sở pháp lý</h3>
                <p>Việc xử lý thông tin cá nhân của chúng tôi dựa trên:</p>
                <ul>
                    <li>Sự đồng ý của người dùng khi đăng ký tài khoản</li>
                    <li>Việc thực hiện dịch vụ đặt lịch khám bệnh</li>
                    <li>Tuân thủ nghĩa vụ pháp lý trong lĩnh vực y tế</li>
                    <li>Lợi ích chính đáng trong việc cung cấp thông tin y tế</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>3. PHẠM VI SỬ DỤNG THÔNG TIN</h2>

                <h3>3.1 Sử dụng nội bộ</h3>
                <ul>
                    <li>Xử lý đăng ký, đăng nhập và quản lý tài khoản</li>
                    <li>Cung cấp kết quả tìm kiếm bệnh viện, phòng khám, bác sĩ</li>
                    <li>Xử lý việc đặt lịch khám và gửi thông báo xác nhận</li>
                    <li>Hiển thị và quản lý bình luận trên website</li>
                    <li>Xác thực và cho phép bác sĩ đăng bài viết</li>
                    <li>Gửi thông báo về bài viết mới và thông tin y tế</li>
                    <li>Cung cấp hỗ trợ kỹ thuật và khách hàng</li>
                </ul>

                <h3>3.2 Chia sẻ với bên thứ ba</h3>
                <p>Chúng tôi chỉ chia sẻ thông tin với:</p>
                <ul>
                    <li><strong>Bệnh viện và phòng khám:</strong> Thông tin liên hệ của người dùng khi có đặt lịch khám</li>
                    <li><strong>Bác sĩ:</strong> Thông tin cần thiết để xác nhận lịch hẹn và cung cấp dịch vụ y tế</li>
                    <li><strong>Nhà cung cấp dịch vụ kỹ thuật:</strong> Chỉ các thông tin cần thiết để vận hành website và
                        gửi email</li>
                    <li><strong>Cơ quan có thẩm quyền:</strong> Khi được yêu cầu theo quy định pháp luật</li>
                </ul>

                <h3>3.3 Cam kết không chia sẻ</h3>
                <p>Chúng tôi cam kết KHÔNG:</p>
                <ul>
                    <li>Bán thông tin cá nhân cho bên thứ ba</li>
                    <li>Chia sẻ thông tin y tế mà không có sự đồng ý</li>
                    <li>Sử dụng thông tin cho mục đích thương mại khác</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>4. CHÍNH SÁCH VỀ BÌNH LUẬN VÀ TƯƠNG TÁC</h2>

                <h3>4.1 Quy định bình luận</h3>
                <ul>
                    <li>Người dùng cần đăng nhập để bình luận</li>
                    <li>Mọi bình luận đều được lưu trữ và hiển thị công khai</li>
                    <li>Chúng tôi có quyền xóa bình luận vi phạm quy định</li>
                    <li>Bình luận không được chứa thông tin y tế cá nhân nhạy cảm</li>
                </ul>

                <h3>4.2 Trách nhiệm của người dùng</h3>
                <ul>
                    <li>Không chia sẻ thông tin cá nhân trong bình luận</li>
                    <li>Không đưa ra lời khuyên y tế không có căn cứ</li>
                    <li>Tôn trọng quyền riêng tư của người khác</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>5. CHÍNH SÁCH VỚI BÁC SĨ</h2>

                <h3>5.1 Xác thực danh tính</h3>
                <ul>
                    <li>Bác sĩ phải cung cấp thông tin chứng chỉ hành nghề</li>
                    <li>Chúng tôi xác minh thông tin trước khi kích hoạt quyền đăng bài</li>
                    <li>Thông tin chuyên môn có thể được hiển thị công khai</li>
                </ul>

                <h3>5.2 Nội dung bài viết</h3>
                <ul>
                    <li>Bác sĩ chịu trách nhiệm về tính chính xác của nội dung</li>
                    <li>Chúng tôi có quyền kiểm duyệt và chỉnh sửa bài viết</li>
                    <li>Bài viết phải tuân thủ các quy định về quảng cáo y tế</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>6. PHƯƠNG THỨC LIÊN HỆ</h2>

                <h3>6.1 Các hình thức liên hệ</h3>
                <p>Chúng tôi có thể liên hệ với bạn qua:</p>
                <ul>
                    <li>Email đã đăng ký</li>
                    <li>Số điện thoại (chỉ khi cần xác nhận lịch hẹn)</li>
                    <li>Thông báo trên website</li>
                    <li>Tin nhắn trong hệ thống</li>
                </ul>

                <h3>6.2 Nội dung liên hệ</h3>
                <ul>
                    <li>Xác nhận đăng ký tài khoản</li>
                    <li>Thông báo về lịch hẹn đã đặt</li>
                    <li>Bài viết y tế mới và thông tin sức khỏe</li>
                    <li>Thông báo về các thay đổi trong chính sách</li>
                    <li>Hỗ trợ kỹ thuật khi cần thiết</li>
                </ul>

                <h3>6.3 Quyền từ chối</h3>
                <p>Bạn có quyền:</p>
                <ul>
                    <li>Hủy đăng ký nhận email thông báo</li>
                    <li>Chỉ nhận thông báo về lịch hẹn</li>
                    <li>Tắt thông báo trên website</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>7. THỜI GIAN LƯU TRỮ THÔNG TIN</h2>
                <ul>
                    <li><strong>Thông tin tài khoản:</strong> Trong suốt thời gian sử dụng dịch vụ và 2 năm sau khi ngừng sử
                        dụng</li>
                    <li><strong>Thông tin đặt lịch:</strong> 5 năm theo quy định về hồ sơ y tế</li>
                    <li><strong>Bình luận và tương tác:</strong> Cho đến khi người dùng yêu cầu xóa</li>
                    <li><strong>Thông tin bác sĩ:</strong> Trong thời gian hợp tác và 3 năm sau khi kết thúc</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>8. BẢO MẬT VÀ AN TOÀN THÔNG TIN</h2>

                <h3>8.1 Các biện pháp bảo mật</h3>
                <ul>
                    <li>Mã hóa SSL cho toàn bộ website</li>
                    <li>Mã hóa mật khẩu người dùng</li>
                    <li>Kiểm soát truy cập nghiêm ngặt theo vai trò</li>
                    <li>Sao lưu dữ liệu thường xuyên</li>
                    <li>Cập nhật bảo mật định kỳ</li>
                </ul>

                <h3>8.2 Bảo mật tài khoản</h3>
                <ul>
                    <li>Xác thực 2 lớp cho tài khoản bác sĩ</li>
                    <li>Đăng xuất tự động khi không hoạt động</li>
                    <li>Thông báo khi có đăng nhập từ thiết bị lạ</li>
                    <li>Khóa tài khoản khi phát hiện hoạt động bất thường</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>9. QUYỀN CỦA NGƯỜI DÙNG</h2>

                <h3>9.1 Quyền truy cập và chỉnh sửa</h3>
                <p>Bạn có quyền:</p>
                <ul>
                    <li>Xem, chỉnh sửa thông tin cá nhân trong tài khoản</li>
                    <li>Yêu cầu cung cấp bản sao dữ liệu cá nhân</li>
                    <li>Xóa bình luận đã đăng</li>
                    <li>Hủy lịch hẹn đã đặt</li>
                    <li>Yêu cầu xóa tài khoản và dữ liệu liên quan</li>
                </ul>

                <h3>9.2 Quyền đối với bác sĩ</h3>
                <p>Bác sĩ có thêm quyền:</p>
                <ul>
                    <li>Chỉnh sửa và xóa bài viết đã đăng</li>
                    <li>Quản lý lịch làm việc</li>
                    <li>Yêu cầu ẩn thông tin chuyên môn</li>
                    <li>Ngừng hợp tác và xóa toàn bộ nội dung</li>
                </ul>

                <h3>9.3 Cách thực hiện quyền</h3>
                <p>Để thực hiện các quyền trên, bạn có thể:</p>
                <ul>
                    <li>Truy cập trang quản lý tài khoản</li>
                    <li>Liên hệ qua email: toikhoe@toikhoe.vn</li>
                    <li>Gọi điện hỗ trợ (số điện thoại hỗ trợ)</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>10. COOKIE VÀ CÔNG NGHỆ THEO DÕI</h2>

                <h3>10.1 Sử dụng Cookie</h3>
                <p>Chúng tôi sử dụng cookie để:</p>
                <ul>
                    <li>Duy trì phiên đăng nhập</li>
                    <li>Ghi nhớ tùy chọn người dùng</li>
                    <li>Phân tích lưu lượng truy cập</li>
                    <li>Cá nhân hóa nội dung</li>
                    <li>Cải thiện bảo mật website</li>
                </ul>

                <h3>10.2 Loại Cookie</h3>
                <ul>
                    <li><strong>Cookie cần thiết:</strong> Không thể tắt, cần cho hoạt động cơ bản</li>
                    <li><strong>Cookie phân tích:</strong> Giúp hiểu cách sử dụng website</li>
                    <li><strong>Cookie cá nhân hóa:</strong> Ghi nhớ sở thích người dùng</li>
                    <li><strong>Cookie tiếp thị:</strong> Hiển thị nội dung phù hợp (nếu có)</li>
                </ul>

                <h3>10.3 Quản lý Cookie</h3>
                <p>Bạn có thể quản lý cookie qua:</p>
                <ul>
                    <li>Cài đặt trình duyệt</li>
                    <li>Trang cài đặt tài khoản</li>
                    <li>Công cụ quản lý cookie trên website</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>11. VI PHẠM DỮ LIỆU</h2>
                <p>Trong trường hợp xảy ra vi phạm dữ liệu, chúng tôi sẽ:</p>
                <ul>
                    <li>Thông báo cho cơ quan có thẩm quyền trong vòng 72 giờ</li>
                    <li>Thông báo cho người dùng bị ảnh hưởng ngay lập tức</li>
                    <li>Thực hiện các biện pháp khắc phục và bảo vệ</li>
                    <li>Điều tra nguyên nhân và tăng cường bảo mật</li>
                    <li>Hỗ trợ người dùng bị ảnh hưởng</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>12. TUÂN THỬ PHÁP LUẬT</h2>
                <p>Chính sách này tuân thủ:</p>
                <ul>
                    <li>Luật An toàn thông tin mạng Việt Nam</li>
                    <li>Nghị định 13/2023/NĐ-CP về bảo vệ dữ liệu cá nhân</li>
                    <li>Luật Khám bệnh, chữa bệnh</li>
                    <li>Các quy định về quảng cáo y tế</li>
                    <li>Các tiêu chuẩn quốc tế về bảo vệ dữ liệu</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>13. THAY ĐỔI CHÍNH SÁCH</h2>

                <h3>13.1 Quyền thay đổi</h3>
                <p>Chúng tôi có quyền cập nhật chính sách để phù hợp với:</p>
                <ul>
                    <li>Thay đổi chức năng website</li>
                    <li>Yêu cầu pháp lý mới</li>
                    <li>Phản hồi của người dùng</li>
                    <li>Cải tiến bảo mật</li>
                </ul>

                <h3>13.2 Thông báo thay đổi</h3>
                <p>Khi có thay đổi quan trọng:</p>
                <ul>
                    <li>Thông báo qua email đăng ký</li>
                    <li>Đăng thông báo nổi bật trên website</li>
                    <li>Yêu cầu đồng ý lại với chính sách mới</li>
                    <li>Cung cấp 30 ngày để người dùng phản hồi</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>14. THÔNG TIN LIÊN HỆ</h2>
                <p>Mọi thắc mắc về chính sách bảo mật, vui lòng liên hệ:</p>
                <div class="contact-info">
                    <p><strong>Tổ chức:</strong> Trực thuộc côpng ty cổ phần Codyhealth</p>
                    <p><strong>Địa chỉ:</strong> Tầng 11, Toà Hoàng Huy 275 Nguyễn Trãi, Thanh Xuân Trung, Thanh Xuân, Hà
                        Nội</p>
                    <p><strong>Email:</strong> toikhoe@toikhoe.vn</p>
                    <p><strong>Thời gian hỗ trợ:</strong> Thứ 2 - Thứ 6, 8:00 - 17:00</p>
                </div>
            </section>

            <section class="policy-section">
                <h2>15. CAM KẾT CUỐI CÙNG</h2>
                <p>Chúng tôi cam kết:</p>
                <ul>
                    <li>Luôn đặt quyền riêng tư của người dùng lên hàng đầu</li>
                    <li>Minh bạch trong mọi hoạt động xử lý dữ liệu</li>
                    <li>Bảo vệ thông tin y tế với mức độ bảo mật cao nhất</li>
                    <li>Tuân thủ nghiêm ngặt các quy định pháp luật</li>
                    <li>Hỗ trợ người dùng thực hiện quyền của mình</li>
                    <li>Không ngừng cải thiện các biện pháp bảo mật</li>
                </ul>
            </section>

            <div class="policy-footer">
                <p><strong>Chính sách này có hiệu lực từ ngày 01/06/2025 và được cập nhật lần cuối vào 01/06/2025.</strong>
                </p>
                <p><em>Bằng việc sử dụng website của chúng tôi, bạn đồng ý với các điều khoản trong chính sách bảo mật
                        này.</em></p>
            </div>
        </div>
    </div>

    <style>
        .policy-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
            color: #333;
            background-color: #ffffff
        }

        .policy-header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .policy-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .effective-date {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .intro {
            font-size: 16px;
            color: #555;
            text-align: left;
        }

        .policy-content {
            margin-top: 30px;
        }

        .policy-section {
            margin-bottom: 40px;
        }

        .policy-section h2 {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
            padding-left: 15px;
        }

        .policy-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: #34495e;
            margin: 20px 0 10px 0;
        }

        .policy-section h4 {
            font-size: 14px;
            font-weight: 600;
            color: #555;
            margin: 15px 0 8px 0;
        }

        .policy-section p {
            margin-bottom: 10px;
            text-align: justify;
        }

        .policy-section ul {
            margin: 10px 0 15px 20px;
            padding-left: 0;
        }

        .policy-section li {
            margin-bottom: 5px;
            list-style-type: disc;
        }

        .contact-info {
            /* background-color: #f8f9fa; */
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .policy-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            font-size: 14px;
        }

        .policy-footer p {
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .policy-container {
                padding: 15px;
            }

            .policy-header h1 {
                font-size: 24px;
            }

            .policy-section h2 {
                font-size: 18px;
            }
        }
    </style>
@endsection
