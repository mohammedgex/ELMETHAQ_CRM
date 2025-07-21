<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'test_id',
        'score',
        'code',
        'evaluation',
        'attach',
        'notes',
    ];
    public function leads()
    {
        return $this->belongsTo(LeadsCustomers::class, 'lead_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
