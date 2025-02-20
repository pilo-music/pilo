<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $guarded = ['id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
