<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMessages extends Model
{
    protected $guarded = ['id'];

    public const TYPE_ERROR = 1;
    public const TYPE_WARNING = 2;
    public const TYPE_INFO = 3;
    public const TYPE_SUCCESS = 4;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
