<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function leads()
    {
        return $this->belongsToMany(LeadsCustomers::class, 'leads_customer_test', 'test_id', 'lead_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'test_id');
    }
}
