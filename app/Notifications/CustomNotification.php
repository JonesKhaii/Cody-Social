<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;

class CustomNotification extends BaseNotification
{
    use Queueable;

    protected $data;

    /**
     * Khởi tạo thông báo với dữ liệu động.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Xác định kênh gửi thông báo.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Dữ liệu sẽ lưu vào database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->data['type'],
            'message' => $this->data['message'],
            'link' => $this->data['link'] ?? null,
            'additional_data' => $this->data['additional_data'] ?? null
        ];
    }
}
