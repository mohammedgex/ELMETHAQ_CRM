<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTitle extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
    public function payments() { return $this->hasMany(Payments::class); }
}
