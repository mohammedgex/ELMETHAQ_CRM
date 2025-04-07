<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'block',
        'reason',
    ];

    /**
     * علاقة الـ BlackList بالـ Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
