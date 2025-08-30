<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $fillable = [
        'description',
        'date',
        'customer_id',
        'user_id',
        'lead_id',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function lead()
    {
        return $this->belongsTo(LeadsCustomers::class);
    }
}
