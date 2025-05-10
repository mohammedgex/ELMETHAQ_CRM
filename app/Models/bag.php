<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class bag extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'leave_date',
        'transportation'
    ];

    // العلاقات:
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
