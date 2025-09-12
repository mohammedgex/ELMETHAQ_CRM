<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobQuestion extends Model
{
    protected $fillable = ['job_title_id', 'question', 'type', 'options', "show_in_report"];

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function answers()
    {
        return $this->hasMany(JobAnswer::class);
    }
}
