<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadsCustomers extends Model
{
    //
    protected $table = 'leads_customers';
    protected $fillable = [
        'name',
        'image',
        'passport_photo',
        'img_national_id_card',
        'license_photo',
        'age',
        'card_id',
        'governorate',
        'phone',
        'licence_type',
        'status',
        'test_type',
        'registration_date',
        'job_title_id',
        'delegate_id',
        'customer_id',
        'evaluation'
    ];

    /**
     * العلاقة مع جدول `job_titles` (كل `LeadsCustomer` ينتمي إلى `JobTitle`)
     */
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    /**
     * العلاقة مع جدول `delegates` (كل `LeadsCustomer` ينتمي إلى `Delegate`)
     */
    public function delegate()
    {
        return $this->belongsTo(Delegate::class, 'delegate_id');
    }

    /**
     * العلاقة مع جدول `customers` (كل `LeadsCustomer` ينتمي إلى `Customer`)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
