<?php

namespace App\Helpers;

use App\Notifications\CustomNotification;

class NotificationHelper
{
    /**
     * Gửi thông báo đến người dùng
     *
     * @param mixed $user Người nhận thông báo
     * @param string $type Loại thông báo (appointment, message, profile, etc.)
     * @param string $message Nội dung thông báo
     * @param string|null $link Đường dẫn khi click vào thông báo
     * @param array|null $additionalData Dữ liệu bổ sung
     * @return void
     */
    public static function send($user, $type, $message, $link = null, $additionalData = null)
    {
        if (!$user) return;

        $data = [
            'type' => $type,
            'message' => $message,
            'link' => $link,
            'additional_data' => $additionalData
        ];

        $user->notify(new CustomNotification($data));
    }
}
