<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Comment extends Model  implements AuditableContract
{
    use Auditable;
    protected $guarded = ['id','status'];

    const STATUS_DEACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setCommentAttribute($value)
    {
        $this->attributes['comment'] = str_replace(PHP_EOL , "<br>" , $value);
    }
}
