<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Taakeb extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'company_id',
        'lead_id',
        'visa_image',
        'issued_number',
        'sponsor_id_number',
        'sponsor_name',
        'sponsor_address',
        'sponsor_phone',
        'consulate',
        'purpose',
        'follow_up_date',
    ];

    /**
     * العلاقة مع الشركة (Company)
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * العلاقة مع العميل (Customer)
     */
    public function lead()
    {
        return $this->belongsTo(LeadsCustomers::class);
    }
}
