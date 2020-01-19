<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const TYPE_CONTACTUS = 1;
    const TYPE_TECHNICAL = 2;
    const TYPE_COMMENT = 3;

    const SENDER_ADMIN = 1;
    const SENDER_USER = 2;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
