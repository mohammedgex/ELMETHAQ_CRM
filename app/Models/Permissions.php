<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permissions extends Model
{
    //
    use HasFactory;

    protected $fillable = ['permission', 'user_id'];

    /**
     * العلاقة: الصلاحية تخص مستخدم معين
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
