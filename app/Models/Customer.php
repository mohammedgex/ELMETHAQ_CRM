<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    use HasFactory;
    protected $fillable = [
        'passport_id',
        'card_id',
        'name_ar',
        'phone',
        'mrz',
        'phone_two',
        'date_birth',
        'nationality',
        'name_en_mrz',
        'passport_issue_date',
        'marital_status',
        'license_id',
        'travel_before',
        'education',
        'visa_id',
        'notes',
        'visa_number',
        'governorates',
        'age',
        'delegate_id',
        'visa_type_id',
        'visa_peroid_id',
        'customer_group_id',
        'sponser_id',
        'evalution_id',
        'embassy_id',
        'job_id'
    ];

    public function delegate()
    {
        return $this->belongsTo(Delegate::class);
    }
    public function visaType()
    {
        return $this->belongsTo(VisaType::class);
    }
    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }
    public function sponser()
    {
        return $this->belongsTo(Sponser::class);
    }
    public function evaluation()
    {
        return $this->belongsTo(Evalution::class);
    }
    public function documentTypes()
    {
        return $this->hasMany(DocumentType::class);
    }
    public function LeadCustomer()
    {
        return $this->hasOne(LeadsCustomers::class);
    }
    public function embassy()
    {
        return $this->belongsTo(Embassy::class);
    }
    public function payments()
    {
        return $this->hasMany(related: Payments::class);
    }
    public function job()
    {
        return $this->belongsTo(JobTitle::class);
    }
}
