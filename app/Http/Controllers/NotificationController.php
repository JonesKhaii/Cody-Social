<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    // Lấy thông báo chưa đọc cho user/doctor
    public function fetchUnread()
    {
        // Thêm log để debug
        Log::info('Attempting to fetch notifications');

        // Kiểm tra xác thực hiện tại
        $guardName = $this->getCurrentGuard();
        Log::info('Current guard: ' . $guardName);

        $user = $this->getAuthenticatedUser();
        if (!$user) {
            Log::warning('No authenticated user found');
            return response()->json(['notifications' => [], 'unread_count' => 0]);
        }

        Log::info('User found: ' . $user->id . ' (' . get_class($user) . ')');

        $notifications = $user->unreadNotifications;

        Log::info('Notifications count: ' . $notifications->count());

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $notifications->count()
        ]);
    }

    // Đánh dấu tất cả là đã đọc
    public function markAllAsRead()
    {
        Log::info('Attempting to mark all notifications as read');

        $user = $this->getAuthenticatedUser();
        if ($user) {
            $user->unreadNotifications->markAsRead();
            Log::info('All notifications marked as read for user: ' . $user->id);
        } else {
            Log::warning('No authenticated user found for marking all read');
        }

        return response()->json([
            'success' => true,
            'message' => 'Tất cả thông báo đã được đánh dấu là đã đọc.'
        ]);
    }

    // Xác định người dùng hiện tại (doctor hoặc user)
    private function getAuthenticatedUser()
    {
        if (auth()->guard('doctor')->check()) {
            return auth()->guard('doctor')->user();
        } elseif (auth()->guard('web')->check()) {
            return auth()->guard('web')->user();
        }

        return null;
    }

    // Xác định guard hiện tại đang được sử dụng
    private function getCurrentGuard()
    {
        if (auth()->guard('doctor')->check()) {
            return 'doctor';
        } elseif (auth()->guard('web')->check()) {
            return 'web';
        }

        return 'none';
    }

    public function markAsRead($id)
    {
        Log::info('Attempting to mark notification as read: ' . $id);

        $user = $this->getAuthenticatedUser();
        if ($user) {
            $notification = $user->notifications->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                Log::info('Notification marked as read: ' . $id);
            } else {
                Log::warning('Notification not found: ' . $id);
            }
        } else {
            Log::warning('No authenticated user found for marking notification read');
        }

        return response()->json([
            'success' => true,
            'message' => 'Thông báo đã được đánh dấu là đã đọc.'
        ]);
    }
}
