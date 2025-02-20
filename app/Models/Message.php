<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public const TYPE_TEXT = 1;
    public const TYPE_IMAGE = 2;

    public const SENDER_ADMIN = 1;
    public const SENDER_USER = 2;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
