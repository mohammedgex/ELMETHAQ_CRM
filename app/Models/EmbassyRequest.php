<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmbassyRequest extends Model
{
  use HasFactory;
  protected $fillable = [
    'type',
    'fullname',
    'country_code1',
    'mobile',
    'whatsapp',
    'email',
    'address',
    'city',
    'call_time'
  ];
}
