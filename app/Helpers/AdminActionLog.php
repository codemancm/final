<?php

namespace App\Helpers;

use App\Models\AdminAuditLog;
use Illuminate\Support\Facades\Auth;

class AdminActionLog
{
    public static function log($action, $details = null)
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            AdminAuditLog::create([
                'admin_id' => Auth::id(),
                'action' => $action,
                'details' => $details,
            ]);
        }
    }
}
