<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponser extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'city'];
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function visas()
    {
        return $this->hasMany(VisaType::class);
    }
}
