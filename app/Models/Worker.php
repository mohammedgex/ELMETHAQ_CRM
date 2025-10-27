<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'national_id',
        'job_title',
        'phone',
        'personal_photo',
        'id_card_photo',
        'message',
    ];
}
