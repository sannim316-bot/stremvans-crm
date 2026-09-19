<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    public static function send($title, $message, $type = 'info', $userId = null)
    {
        Notification::create([

            'user_id' => $userId,

            'title' => $title,

            'message' => $message,

            'type' => $type,

            'is_read' => false

        ]);
    }

    public static function sendToAdmins($title, $message, $type = 'info')
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::send($title, $message, $type, $admin->id);
        }
    }
}