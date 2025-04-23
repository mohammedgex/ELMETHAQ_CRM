<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class LeadsCustomers extends Model
{
    //
    use HasFactory, HasApiTokens;
    protected $table = 'leads_customers';


    protected $fillable = [
        'name',
        'image',
        'governorate',
        'phone',
        'phone_two',
        'job_title_id',
        'have_you_ever_traveled_before?',
        'password',
        'passport_photo',
        'img_national_id_card',
        'img_national_id_card_back',
        'license_photo',
        'age',
        'card_id',
        'evaluation',
        'licence_type',
        'status',
        'test_type',
        'registration_date',
        'delegate_id',
        'customer_id',
        'phone_verified_at', // 👈 أضف السطر ده هنا
    ];

    protected $hidden = [
        'password',
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
