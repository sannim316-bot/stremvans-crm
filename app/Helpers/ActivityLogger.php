<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log($action, $module, $description)
    {
        ActivityLog::create([

            'user_id' => auth()->id(),

            'action' => $action,

            'module' => $module,

            'description' => $description,

            'ip_address' => request()->ip()

        ]);
    }
}