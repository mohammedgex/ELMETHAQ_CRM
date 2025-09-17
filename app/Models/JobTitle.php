<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    //
    use HasFactory;
    protected $fillable = ['title', 'show_in_app'];
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function leadsCustomers()
    {
        return $this->hasMany(LeadsCustomers::class, 'job_title_id');
    }
    public function questions()
    {
        return $this->hasMany(JobQuestion::class);
    }
}
