<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'amoun_rest', 'payment_title_id'];
    public function customers() { return $this->hasMany(related: Customer::class); }

    public function paymentTitle() { return $this->belongsTo(PaymentTitle::class);
     }
}
