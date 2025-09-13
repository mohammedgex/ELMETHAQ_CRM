<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class LeadsCustomers extends Model
{
    //
    use Notifiable;
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
        'phone_verified_at',
        'passport_photo',
        'passport_numder',
        'img_national_id_card',
        'img_national_id_card_back',
        'license_photo',
        'age',
        'date_of_birth',
        'card_id',
        'evaluation',
        'licence_type',
        'status',
        'test_type',
        'registration_date',
        'delegate_id',
        'customer_id',
        'fcm_token',
    ];

    protected $dates = [
        'phone_verified_at',
        'registration_date',
        'date_of_birth',
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
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
    public function tests()
    {
        return $this->belongsToMany(Test::class, 'leads_customer_test', 'lead_id', 'test_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'lead_id');
    }
    public function taakebs()
    {
        return $this->hasMany(Taakeb::class);
    }

    public function answers()
    {
        return $this->hasMany(JobAnswer::class, 'lead_id');
    }
    public function historis()
    {
        # code...
        return $this->hasMany(History::class, 'lead_id');
    }
}
