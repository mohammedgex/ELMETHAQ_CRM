<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable = [
        'customer_id',
        'debit',
        'credit',
        'description',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
