<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMessages extends Model
{
    protected $guarded = ['id'];

    const TYPE_ERROR = 1;
    const TYPE_WARNING = 2;
    const TYPE_INFO = 3;
    const TYPE_SUCCESS = 4;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
