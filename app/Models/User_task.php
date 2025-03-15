<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_task extends Model
{
    //
    protected $fillable = [
        'sending_user_id',
        'receiving_user_id',
        'description',
        'status',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sending_user_id');
    }

    /**
     * العلاقة مع المستخدم المستلم.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiving_user_id');
    }
}
