<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'visa_type_id',
    ];
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function visaType()
    {
        return $this->belongsTo(VisaType::class);
    }
    public function visaProfession()
    {
        return $this->hasOne(VisaProfessions::class);
    }
}