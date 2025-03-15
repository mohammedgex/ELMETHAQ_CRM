<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class VisaProfessions extends Model
{
    use HasFactory;
    protected $fillable = ['job', 'visa_type_id', 'profession_count'];
    public function visa_type()
    {
        return $this->belongsTo(VisaType::class);
    }
}
