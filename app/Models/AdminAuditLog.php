<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAuditLog extends Model
{
    use HasFactory;

    protected $table = 'admin_audit_log';

    protected $fillable = [
        'admin_id',
        'action',
        'details',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
