$(document).ready(function () {
    // Kích hoạt từ nút trong header
    $("#open-ai-advisor").click(function (e) {
        e.preventDefault();
        $("#ai-chatbot-container").show();
        $("#ai-chatbot-trigger").hide();
        console.log("Đã nhấp vào nút tư vấn sức khỏe AI");
        scrollToBottom();
    });

    // Hiển thị/ẩn chatbot
    $("#ai-chatbot-trigger").click(function () {
        $("#ai-chatbot-container").show();
        $(this).hide();
        scrollToBottom();
    });

    // Ẩn chatbot khi nhấn nút đóng
    $("#close-chatbot").click(function () {
        $("#ai-chatbot-container").hide();
        $("#ai-chatbot-trigger").show();
    });

    // Thu nhỏ chatbot khi nhấn nút thu nhỏ
    $("#minimize-chatbot").click(function () {
        $("#ai-chatbot-container").hide();
        $("#ai-chatbot-trigger").show();
    });

    // Gửi tin nhắn khi nhấn nút gửi
    $("#ai-send-message").click(sendMessage);

    // Gửi tin nhắn khi nhấn Enter (không phải Shift+Enter)
    $("#ai-user-input").keydown(function (e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Xử lý nút cuộn xuống
    $("#ai-scroll-bottom").click(function () {
        scrollToBottom();
    });

    // Kiểm tra vị trí cuộn để hiển thị/ẩn nút cuộn xuống
    $("#ai-chatbot-messages").scroll(function () {
        const messagesContainer = document.getElementById("ai-chatbot-messages");
        const scrollPosition = messagesContainer.scrollTop + messagesContainer.clientHeight;
        const scrollHeight = messagesContainer.scrollHeight;

        // Nếu người dùng không ở dưới cùng, hiển thị nút cuộn xuống
        if (scrollHeight - scrollPosition > 50) {
            $("#ai-scroll-bottom").css("display", "flex");
        } else {
            $("#ai-scroll-bottom").css("display", "none");
        }
    });

    // Giới hạn số lượng tin nhắn để tránh tràn bộ nhớ
    function limitMessages() {
        const maxMessages = 50; // Số lượng tin nhắn tối đa muốn giữ lại
        const messages = $("#ai-chatbot-messages .ai-message");

        if (messages.length > maxMessages) {
            // Xóa các tin nhắn cũ nếu vượt quá giới hạn
            messages.slice(0, messages.length - maxMessages).remove();
        }
    }

    // Hàm cuộn xuống cuối cùng
    function scrollToBottom() {
        const messagesContainer = document.getElementById("ai-chatbot-messages");

        // Đảm bảo DOM đã được cập nhật
        setTimeout(function () {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            // Ẩn nút cuộn xuống khi đã ở dưới cùng
            $("#ai-scroll-bottom").css("display", "none");
        }, 100);
    }

    // Tự động điều chỉnh chiều cao của textarea
    function initAutoResizeTextarea() {
        const textarea = document.getElementById('ai-user-input');

        // Đặt chiều cao ban đầu
        textarea.style.height = '40px';

        // Xử lý sự kiện input
        textarea.addEventListener('input', function () {
            // Đặt lại chiều cao về auto để tính toán chiều cao thực tế
            this.style.height = 'auto';

            // Giới hạn chiều cao tối đa
            const maxHeight = 120;

            // Đặt chiều cao mới dựa trên nội dung
            const newHeight = Math.min(this.scrollHeight, maxHeight);
            this.style.height = newHeight + 'px';

            // Điều chỉnh overflow dựa trên chiều cao
            if (this.scrollHeight > maxHeight) {
                this.style.overflowY = 'auto';
            } else {
                this.style.overflowY = 'hidden';
            }
        });

        // Xử lý khi xóa nội dung
        textarea.addEventListener('keyup', function () {
            if (this.value === '') {
                this.style.height = '40px';
                this.style.overflowY = 'hidden';
            }
        });
    }

    // Khởi tạo tính năng tự điều chỉnh kích thước
    initAutoResizeTextarea();

    // Hàm gửi tin nhắn
    function sendMessage() {
        const userInput = $("#ai-user-input").val().trim();

        if (!userInput) return;

        // Giới hạn số lượng tin nhắn
        limitMessages();

        // Hiển thị tin nhắn của người dùng
        $("#ai-chatbot-messages").append(`
            <div class="ai-message ai-user-message">
                ${userInput}
            </div>
        `);

        // Xóa input và reset chiều cao
        $("#ai-user-input").val("");
        document.getElementById('ai-user-input').style.height = '40px';
        document.getElementById('ai-user-input').style.overflowY = 'hidden';

        // Cuộn xuống cuối cùng
        scrollToBottom();

        // Hiển thị trạng thái đang nhập
        $("#ai-chatbot-messages").append(`
            <div class="ai-typing" id="ai-typing-indicator">
                <div class="ai-typing-dot"></div>
                <div class="ai-typing-dot"></div>
                <div class="ai-typing-dot"></div>
            </div>
        `);

        // Cuộn xuống cuối cùng
        scrollToBottom();

        // Gọi API chatbot
        $.ajax({
            url: '/api/ai-chatbot',
            method: 'POST',
            data: {
                message: userInput,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Xóa hiệu ứng đang nhập
                $("#ai-typing-indicator").remove();

                // Hiển thị phản hồi từ bot
                $("#ai-chatbot-messages").append(`
                    <div class="ai-message ai-bot-message">
                        ${response.message}
                    </div>
                `);

                // Cuộn xuống cuối cùng
                scrollToBottom();
            },
            error: function () {
                // Xóa hiệu ứng đang nhập
                $("#ai-typing-indicator").remove();

                // Hiển thị thông báo lỗi
                $("#ai-chatbot-messages").append(`
                    <div class="ai-message ai-bot-message">
                        Xin lỗi, đã xảy ra lỗi khi xử lý yêu cầu của bạn. Vui lòng thử lại sau.
                    </div>
                `);

                // Cuộn xuống cuối cùng
                scrollToBottom();
            }
        });
    }

    // Cập nhật cuộn khi cửa sổ thay đổi kích thước
    $(window).resize(function () {
        scrollToBottom();
    });

    // Khởi tạo cuộn ban đầu
    scrollToBottom();
});