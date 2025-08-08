<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'card_id'];
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function leadsCustomers()
    {
        return $this->hasMany(LeadsCustomers::class);
    }
    // دالة تحسب عدد العملاء الذين تم السفر لهم فقط
    public function traveledCustomers()
    {
        return $this->hasMany(Customer::class)->where('status', 'تم السفر');
    }
}
