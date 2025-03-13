<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaProfessions extends Model
{
    use HasFactory;
    protected $fillable = ['peroid', 'customer_id'];
    public function customers() { return $this->hasMany(Customer::class); }
}
