<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaType extends Model
{
    use HasFactory;
    protected $fillable = ['count', 'outgoing_number', 'registration_number', 'visa_peroid', 'sponser_id', 'embassy_id', 'porpose', 'name', 'issuing_visa'];
    public function visa_professions()
    {
        return $this->hasMany(VisaProfessions::class);
    }
    public function sponser()
    {
        return $this->belongsTo(Sponser::class);
    }
    public function embassy()
    {
        return $this->belongsTo(Embassy::class);
    }
    public function customerGroups()
    {
        return $this->hasMany(CustomerGroup::class);
    }
    public function getOutgoingCustomersCountAttribute()
    {
        return $this->customerGroups->sum(function ($group) {
            return $group->customers->count();
        });
    }
    public function outgoingCustomers()
    {
        return $this->hasMany(Customer::class)->where('status', 'تم السفر');
    }
}
