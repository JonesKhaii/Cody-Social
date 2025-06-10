@extends('layouts.master')

@section('title', 'Điều khoản sử dụng')

@section('main-content')
    <div class="policy-container">
        <div class="policy-header">
            <h1>ĐIỀU KHOẢN SỬ DỤNG</h1>
            <p class="effective-date"><strong>Hiệu lực từ ngày: 01/06/2025</strong></p>
            <p class="intro">Khi sử dụng website Tôi Khoẻ, bạn đồng ý tuân thủ các điều khoản và quy định dưới đây. Vui lòng
                đọc kỹ trước khi sử dụng dịch vụ.</p>
        </div>

        <div class="policy-content">
            <section class="policy-section">
                <h2>1. GIỚI THIỆU VỀ DỊCH VỤ</h2>
                <p><strong>Tôi Khoẻ</strong> là nền tảng trực tuyến cung cấp thông tin y tế, kết nối người dùng với các bệnh
                    viện, phòng khám và bác sĩ. Chúng tôi cung cấp các dịch vụ:</p>
                <ul>
                    <li>Tìm kiếm thông tin bệnh viện, phòng khám, bác sĩ</li>
                    <li>Đặt lịch khám bệnh trực tuyến</li>
                    <li>Đọc bài viết y tế từ các bác sĩ chuyên khoa</li>
                    <li>Tương tác thông qua bình luận và đánh giá</li>
                    <li>Nhận thông báo về sức khỏe và y tế</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>2. ĐIỀU KIỆN SỬ DỤNG</h2>

                <h3>2.1 Đối với người dùng thông thường</h3>
                <ul>
                    <li>Phải từ 16 tuổi trở lên hoặc có sự đồng ý của người giám hộ</li>
                    <li>Cung cấp thông tin chính xác khi đăng ký</li>
                    <li>Chịu trách nhiệm bảo mật tài khoản và mật khẩu</li>
                    <li>Sử dụng dịch vụ cho mục đích cá nhân, phi thương mại</li>
                </ul>

                <h3>2.2 Đối với bác sĩ</h3>
                <ul>
                    <li>Phải có chứng chỉ hành nghề y khoa hợp lệ</li>
                    <li>Cung cấp đầy đủ thông tin chuyên môn để xác thực</li>
                    <li>Tuân thủ các quy định về đạo đức y khoa</li>
                    <li>Chịu trách nhiệm về tính chính xác của nội dung đăng tải</li>
                </ul>

                <h3>2.3 Đối với cơ sở y tế</h3>
                <ul>
                    <li>Phải có giấy phép hoạt động y tế hợp lệ</li>
                    <li>Cung cấp thông tin chính xác về dịch vụ và lịch hoạt động</li>
                    <li>Cam kết cung cấp dịch vụ y tế chất lượng</li>
                    <li>Tuân thủ quy định về giá cả và thanh toán</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>3. QUYỀN VÀ NGHĨA VỤ CỦA NGƯỜI DÙNG</h2>

                <h3>3.1 Quyền của người dùng</h3>
                <ul>
                    <li>Truy cập và sử dụng các tính năng công khai của website</li>
                    <li>Đặt lịch khám bệnh và hủy lịch theo quy định</li>
                    <li>Đánh giá và bình luận về dịch vụ y tế</li>
                    <li>Yêu cầu hỗ trợ kỹ thuật khi gặp sự cố</li>
                    <li>Bảo vệ thông tin cá nhân theo chính sách bảo mật</li>
                    <li>Khiếu nại khi có tranh chấp</li>
                </ul>

                <h3>3.2 Nghĩa vụ của người dùng</h3>
                <ul>
                    <li>Cung cấp thông tin chính xác và cập nhật thường xuyên</li>
                    <li>Không sử dụng website cho mục đích bất hợp pháp</li>
                    <li>Tôn trọng quyền riêng tư và thông tin của người khác</li>
                    <li>Không spam, quảng cáo trái phép</li>
                    <li>Tuân thủ các quy định về bình luận và tương tác</li>
                    <li>Thanh toán đầy đủ các dịch vụ đã sử dụng</li>
                    <li>Thông báo kịp thời khi phát hiện sai sót</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>4. QUY ĐỊNH VỀ NỘI DUNG</h2>

                <h3>4.1 Nội dung bị cấm</h3>
                <p>Nghiêm cấm đăng tải nội dung:</p>
                <ul>
                    <li>Thông tin y tế sai lệch, không có căn cứ khoa học</li>
                    <li>Quảng cáo thuốc, thực phẩm chức năng không được phép</li>
                    <li>Chửi bới, xúc phạm, phân biệt đối xử</li>
                    <li>Thông tin cá nhân của bệnh nhân không được đồng ý</li>
                    <li>Nội dung khiêu dâm, bạo lực</li>
                    <li>Vi phạm bản quyền, sở hữu trí tuệ</li>
                    <li>Lừa đảo, lôi kéo vào các hoạt động bất hợp pháp</li>
                </ul>

                <h3>4.2 Quy định về bài viết y tế</h3>
                <ul>
                    <li>Chỉ bác sĩ đã xác thực mới được đăng bài viết chuyên môn</li>
                    <li>Nội dung phải có tính giáo dục, không mang tính chẩn đoán cụ thể</li>
                    <li>Phải ghi rõ nguồn tham khảo nếu trích dẫn</li>
                    <li>Không được quảng cáo trực tiếp dịch vụ cá nhân</li>
                    <li>Tuân thủ quy định về quảng cáo y tế của Bộ Y tế</li>
                </ul>

                <h3>4.3 Quy định về bình luận</h3>
                <ul>
                    <li>Phải đăng nhập để bình luận</li>
                    <li>Nội dung phải lịch sự, tôn trọng</li>
                    <li>Không chia sẻ thông tin cá nhân trong bình luận</li>
                    <li>Không đưa ra lời khuyên y tế nếu không phải là bác sĩ</li>
                    <li>Có thể bị xóa nếu vi phạm quy định</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>5. DỊCH VỤ ĐẶT LỊCH KHÁM</h2>

                <h3>5.1 Quy trình đặt lịch</h3>
                <ul>
                    <li>Tìm kiếm bác sĩ/cơ sở y tế phù hợp</li>
                    <li>Chọn thời gian có sẵn trong lịch</li>
                    <li>Điền đầy đủ thông tin bệnh nhân</li>
                    <li>Xác nhận và thanh toán (nếu có)</li>
                    <li>Nhận thông báo xác nhận qua email/SMS</li>
                </ul>

                <h3>5.2 Chính sách hủy lịch</h3>
                <ul>
                    <li><strong>Hủy miễn phí:</strong> Trước 24 giờ</li>
                    <li><strong>Hủy có phí:</strong> Trong vòng 24 giờ (phí 50%)</li>
                    <li><strong>Không được hủy:</strong> Trong vòng 2 giờ trước lịch hẹn</li>
                    <li><strong>Trường hợp đặc biệt:</strong> Cấp cứu, thiên tai được miễn phí</li>
                </ul>

                <h3>5.3 Trách nhiệm của các bên</h3>
                <h4>Người dùng:</h4>
                <ul>
                    <li>Có mặt đúng giờ hẹn</li>
                    <li>Mang theo giấy tờ cần thiết</li>
                    <li>Thông báo kịp thời khi cần thay đổi</li>
                    <li>Thanh toán đầy đủ theo thỏa thuận</li>
                </ul>

                <h4>Bác sĩ/Cơ sở y tế:</h4>
                <ul>
                    <li>Cung cấp dịch vụ đúng chất lượng cam kết</li>
                    <li>Tôn trọng thời gian của bệnh nhân</li>
                    <li>Thông báo khi có thay đổi lịch</li>
                    <li>Bảo mật thông tin bệnh nhân</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>6. THANH TOÁN VÀ HOÀN TIỀN</h2>

                <h3>6.1 Phương thức thanh toán</h3>
                <ul>
                    <li>Thẻ tín dụng/ghi nợ nội địa và quốc tế</li>
                    <li>Ví điện tử (MoMo, ZaloPay, VNPay)</li>
                    <li>Chuyển khoản ngân hàng</li>
                    <li>Thanh toán trực tiếp tại cơ sở y tế</li>
                </ul>

                <h3>6.2 Chính sách hoàn tiền</h3>
                <ul>
                    <li><strong>Hoàn 100%:</strong> Bác sĩ hủy lịch hoặc lỗi hệ thống</li>
                    <li><strong>Hoàn 50%:</strong> Hủy lịch trong vòng 24 giờ</li>
                    <li><strong>Không hoàn:</strong> Hủy lịch trong vòng 2 giờ</li>
                    <li><strong>Thời gian hoàn tiền:</strong> 3-7 ngày làm việc</li>
                </ul>

                <h3>6.3 Tranh chấp thanh toán</h3>
                <p>Trong trường hợp có tranh chấp:</p>
                <ul>
                    <li>Liên hệ bộ phận hỗ trợ trong vòng 30 ngày</li>
                    <li>Cung cấp đầy đủ thông tin và bằng chứng</li>
                    <li>Chờ xử lý trong vòng 15 ngày làm việc</li>
                    <li>Có thể khiếu nại lên cơ quan có thẩm quyền</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>7. TRÁCH NHIỆM VÀ GIỚI HẠN</h2>

                <h3>7.1 Trách nhiệm của Tôi Khoẻ</h3>
                <ul>
                    <li>Cung cấp nền tảng kết nối ổn định và bảo mật</li>
                    <li>Xác thực thông tin bác sĩ và cơ sở y tế</li>
                    <li>Bảo vệ thông tin cá nhân của người dùng</li>
                    <li>Hỗ trợ giải quyết tranh chấp</li>
                    <li>Cập nhật và cải thiện dịch vụ liên tục</li>
                </ul>

                <h3>7.2 Giới hạn trách nhiệm</h3>
                <p>Tôi Khoẻ KHÔNG chịu trách nhiệm về:</p>
                <ul>
                    <li>Chất lượng dịch vụ y tế của bác sĩ/cơ sở y tế</li>
                    <li>Kết quả điều trị và chẩn đoán bệnh</li>
                    <li>Tranh chấp trực tiếp giữa bệnh nhân và bác sĩ</li>
                    <li>Thiệt hại do sử dụng thông tin y tế trên website</li>
                    <li>Gián đoạn dịch vụ do yếu tố bất khả kháng</li>
                    <li>Hành vi vi phạm của người dùng đối với bên thứ ba</li>
                </ul>

                <h3>7.3 Tuyên bố miễn trừ</h3>
                <ul>
                    <li>Website chỉ cung cấp thông tin tham khảo</li>
                    <li>Không thay thế cho lời khuyên của bác sĩ chuyên khoa</li>
                    <li>Người dùng tự chịu trách nhiệm về quyết định y tế</li>
                    <li>Luôn tham khảo ý kiến bác sĩ trước khi điều trị</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>8. SỞ HỮU TRÍ TUỆ</h2>

                <h3>8.1 Bản quyền của Tôi Khoẻ</h3>
                <ul>
                    <li>Tên thương hiệu, logo, thiết kế website</li>
                    <li>Mã nguồn và công nghệ phần mềm</li>
                    <li>Cơ sở dữ liệu và thuật toán</li>
                    <li>Nội dung do Tôi Khoẻ tạo ra</li>
                </ul>

                <h3>8.2 Bản quyền của người dùng</h3>
                <ul>
                    <li>Bài viết và nội dung do bác sĩ đăng tải</li>
                    <li>Bình luận và đánh giá của người dùng</li>
                    <li>Thông tin cá nhân và y tế</li>
                </ul>

                <h3>8.3 Sử dụng hợp lý</h3>
                <ul>
                    <li>Được phép trích dẫn với mục đích giáo dục</li>
                    <li>Phải ghi rõ nguồn khi sử dụng</li>
                    <li>Không được sử dụng cho mục đích thương mại</li>
                    <li>Không được sao chép toàn bộ nội dung</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>9. BẢO MẬT VÀ AN TOÀN</h2>

                <h3>9.1 Bảo mật tài khoản</h3>
                <ul>
                    <li>Tạo mật khẩu mạnh và duy nhất</li>
                    <li>Không chia sẻ thông tin đăng nhập</li>
                    <li>Đăng xuất sau khi sử dụng</li>
                    <li>Thông báo ngay khi phát hiện bất thường</li>
                    <li>Cập nhật thông tin liên hệ thường xuyên</li>
                </ul>

                <h3>9.2 An toàn thông tin y tế</h3>
                <ul>
                    <li>Chỉ chia sẻ thông tin cần thiết</li>
                    <li>Kiểm tra kỹ trước khi gửi</li>
                    <li>Không đăng thông tin nhạy cảm công khai</li>
                    <li>Yêu cầu xóa dữ liệu khi cần thiết</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>10. XỬ LÝ VI PHẠM</h2>

                <h3>10.1 Các hình thức xử lý</h3>
                <ul>
                    <li><strong>Cảnh báo:</strong> Vi phạm lần đầu, mức độ nhẹ</li>
                    <li><strong>Khóa tạm thời:</strong> Vi phạm lặp lại hoặc mức độ vừa</li>
                    <li><strong>Khóa vĩnh viễn:</strong> Vi phạm nghiêm trọng hoặc nhiều lần</li>
                    <li><strong>Xóa nội dung:</strong> Nội dung vi phạm quy định</li>
                    <li><strong>Báo cơ quan chức năng:</strong> Vi phạm pháp luật</li>
                </ul>

                <h3>10.2 Quy trình khiếu nại</h3>
                <ul>
                    <li>Gửi khiếu nại qua email: toikhoe@toikhoe.vn</li>
                    <li>Cung cấp đầy đủ thông tin và bằng chứng</li>
                    <li>Chờ phản hồi trong vòng 7 ngày làm việc</li>
                    <li>Có thể yêu cầu xem xét lại quyết định</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>11. CHẤM DỨT DỊCH VỤ</h2>

                <h3>11.1 Chấm dứt từ phía người dùng</h3>
                <ul>
                    <li>Có thể xóa tài khoản bất kỳ lúc nào</li>
                    <li>Hoàn thành các giao dịch đang diễn ra</li>
                    <li>Dữ liệu sẽ được xử lý theo chính sách bảo mật</li>
                </ul>

                <h3>11.2 Chấm dứt từ phía Tôi Khoẻ</h3>
                <ul>
                    <li>Thông báo trước 30 ngày nếu ngừng dịch vụ</li>
                    <li>Khóa tài khoản vi phạm nghiêm trọng</li>
                    <li>Hỗ trợ người dùng chuyển đổi dữ liệu</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>12. LUẬT ÁP DỤNG VÀ GIẢI QUYẾT TRANH CHẤP</h2>

                <h3>12.1 Luật áp dụng</h3>
                <p>Điều khoản này được điều chỉnh bởi pháp luật Việt Nam, bao gồm:</p>
                <ul>
                    <li>Luật Bảo vệ người tiêu dùng</li>
                    <li>Luật An toàn thông tin mạng</li>
                    <li>Luật Khám bệnh, chữa bệnh</li>
                    <li>Nghị định về bảo vệ dữ liệu cá nhân</li>
                </ul>

                <h3>12.2 Giải quyết tranh chấp</h3>
                <p>Thứ tự ưu tiên giải quyết tranh chấp:</p>
                <ol>
                    <li>Thương lượng trực tiếp giữa các bên</li>
                    <li>Hòa giải qua bộ phận hỗ trợ của Tôi Khoẻ</li>
                    <li>Trọng tài tại Trung tâm Trọng tài Quốc tế Việt Nam</li>
                    <li>Tòa án có thẩm quyền tại Hà Nội</li>
                </ol>
            </section>

            <section class="policy-section">
                <h2>13. THAY ĐỔI ĐIỀU KHOẢN</h2>
                <ul>
                    <li>Tôi Khoẻ có quyền cập nhật điều khoản khi cần thiết</li>
                    <li>Thông báo trước 30 ngày qua email và website</li>
                    <li>Người dùng có thể ngừng sử dụng nếu không đồng ý</li>
                    <li>Tiếp tục sử dụng sau thông báo = đồng ý với thay đổi</li>
                </ul>
            </section>

            <section class="policy-section">
                <h2>14. THÔNG TIN LIÊN HỆ</h2>
                <div class="contact-info">
                    <p><strong>Tổ chức:</strong> Trực thuộc côpng ty cổ phần Codyhealth </p>
                    <p><strong>Địa chỉ:</strong> Tầng 11, Toà Hoàng Huy 275 Nguyễn Trãi, Thanh Xuân Trung, Thanh Xuân, Hà
                        Nội</p>
                    <p><strong>Email hỗ trợ:</strong> toikhoe@toikhoe.vn</p>
                    <p><strong>Hotline:</strong> 1900 xxxx</p>
                    <p><strong>Thời gian hỗ trợ:</strong> Thứ 2 - Thứ 6, 8:00 - 17:00</p>
                </div>
            </section>

            <div class="policy-footer">
                <p><strong>Điều khoản này có hiệu lực từ ngày 01/06/2025 và được cập nhật lần cuối vào 01/06/2025.</strong>
                </p>
                <p><em>Bằng việc đăng ký tài khoản và sử dụng dịch vụ của chúng tôi, bạn đồng ý tuân thủ toàn bộ các điều
                        khoản trên.</em></p>
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
            background-color: #ffffff;
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
            border-left: 4px solid #e74c3c;
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

        .policy-section ol {
            margin: 10px 0 15px 20px;
            padding-left: 0;
        }

        .policy-section li {
            margin-bottom: 5px;
        }

        .policy-section ul li {
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
