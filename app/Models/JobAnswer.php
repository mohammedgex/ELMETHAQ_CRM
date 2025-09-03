<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobAnswer extends Model
{
    protected $fillable = ['job_question_id', 'lead_id', 'answer'];

    public function question()
    {
        return $this->belongsTo(JobQuestion::class);
    }

    public function lead()
    {
        return $this->belongsTo(LeadsCustomers::class); // أو User
    }
}
