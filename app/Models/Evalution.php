<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evalution extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
