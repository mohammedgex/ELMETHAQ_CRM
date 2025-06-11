<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    //
    protected $fillable = [
        'name',
        'address',
        'license_number',
        'logo',
        'engaz_email',
        'engaz_password',
    ];
}
