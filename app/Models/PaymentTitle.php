<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentTitle extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'price'];
    public function payments()
    {
        return $this->hasMany(Payments::class);
    }
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
    public function leadCustomers()
    {
        return $this->belongsToMany(LeadsCustomers::class, 'lead_customer_payment_title');
    }
}
