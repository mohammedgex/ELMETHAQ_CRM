<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Company extends Model
{
    //
    use HasApiTokens, HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'password',
        'logo',
    ];

    protected $hidden = [
        'password',
    ];

    // تشفير كلمة السر تلقائياً
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // العلاقة مع العملاء
    public function leads()
    {
        return $this->hasMany(LeadsCustomers::class);
    }
}
