<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{

    use Notifiable;
    use HasFactory;
    protected $fillable = [
        'image',
        'name_ar',
        'card_id',
        'phone',
        'governorate',
        'governorate_live',
        'age',
        'status',
        'license_type',
        'license_expire_date',
        'license_status',
        'phone_two',
        'e_visa_number',
        'medical_examination',
        'finger_print_examination',
        'virus_examination',
        'engaz_request',
        'nationality',
        'marital_status',
        'education',
        'notes',
        'mrz',
        'name_en_mrz',
        'passport_id',
        'date_birth',
        'passport_expire_date',
        'gender',
        'issue_place',
        'travel_before',
        'delegate_id',
        'job_title_id',
        'customer_group_id',
        'sponser_id',
        'visa_type_id',
        'evaluation_id',
        'experience_years',
        'experience',
        'mrz_image',
        'visa_number',
        'visa_issuance_date',
        'visa_expiry_date',
        'passport_issuance_date',
        'archived_at',
        'fcm_token',
        "hospital_address"
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
        return $this->belongsTo(Evaluation::class);
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
        return $this->hasMany(Payments::class);
    }
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    public function blackList()
    {
        return $this->hasOne(BlackList::class);
    }
    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }
}
