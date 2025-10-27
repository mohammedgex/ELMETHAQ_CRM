<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'phone',
    'email',
    'country',
    'visa_type',
    'travel_date',
    'passport_number',
    'passport_expiry',
    'nationality',
    'message',
  ];

  protected $casts = [
    'travel_date' => 'date',
    'passport_expiry' => 'date',
  ];
}
