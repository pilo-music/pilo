<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;

    const SENDER_ADMIN = 1;
    const SENDER_USER = 2;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
