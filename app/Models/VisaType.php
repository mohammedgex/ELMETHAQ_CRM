<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaType extends Model
{
    use HasFactory;
    protected $fillable = ['count', 'outgoing_number', 'registration_number', 'visa_peroid', 'sponser_id', 'embassy_id'];
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
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
}
