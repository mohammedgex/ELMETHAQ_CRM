<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'type',
        'name',
        'phone',
        'email',
        'details',
        'status',
        'status_notes',
        'status_updated_at',
        'assigned_to',
        'priority'
    ];

    protected $casts = [
        'details' => 'array',
        'status_updated_at' => 'datetime',
    ];

    // العلاقة مع المستخدم (إذا كان هناك نظام مستخدمين)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // دالة لتحديث الحالة
    public function updateStatus($status, $notes = null)
    {
        $this->update([
            'status' => $status,
            'status_notes' => $notes,
            'status_updated_at' => now(),
        ]);
    }

    // دالة للحصول على لون الحالة
    public function getStatusColor()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'in_progress' => 'info',
            'under_review' => 'primary',
            'approved' => 'success',
            'completed' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }

    // دالة للحصول على نص الحالة بالعربية
    public function getStatusText()
    {
        return match ($this->status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد المعالجة',
            'under_review' => 'قيد المراجعة',
            'approved' => 'موافق عليه',
            'completed' => 'مكتمل',
            'rejected' => 'مرفوض',
            'cancelled' => 'ملغي',
            default => 'غير محدد'
        };
    }

    // دالة للحصول على أولوية النص
    public function getPriorityText()
    {
        return match ($this->priority) {
            1 => 'عادي',
            2 => 'مهم',
            3 => 'عاجل',
            default => 'غير محدد'
        };
    }

    // دالة للحصول على لون الأولوية
    public function getPriorityColor()
    {
        return match ($this->priority) {
            1 => 'secondary',
            2 => 'warning',
            3 => 'danger',
            default => 'secondary'
        };
    }
}
