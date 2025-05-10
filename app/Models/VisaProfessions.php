<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class VisaProfessions extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_title',
        'job',
        'profession_count',
        'customer_group_id',
        'visa_type_id',
    ];
    public function visa_type()
    {
        return $this->belongsTo(VisaType::class);
    }
    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }
}
