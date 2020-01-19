<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Music extends Model implements AuditableContract
{
    use Auditable;
    use Notifiable;
    use Sluggable;

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'fullname',
            ],
        ];
    }

    public function getFullnameAttribute()
    {
        return $this->artist->name . '-' . $this->title;
    }


    public function path()
    {
        return "/music/$this->slug";
    }

    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function artists()
    {
        return $this->morphToMany(Artist::class, 'artistable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, "bookmarkable");
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagable');
    }


    public function write_tags(array $tags)
    {
        $textEncoding = 'UTF-8';
        try {
            $getID3 = new \getID3;
        } catch (\getid3_exception $e) {
        }
        $getID3->setOption(array('encoding' => $textEncoding));
        $tagwriter = new  \getid3_writetags;
        $tagwriter->filename = $this->path;
        $tagwriter->tagformats = array('id3v2.3');
        // set various options (optional)
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = $textEncoding;
        $tagwriter->remove_other_tags = true;
        $fileInfo = $getID3->analyze($this->path);
        // populate data array
        $tagData['comment'] = array();
        foreach ($tags as $tag => $value) {
            $tagData[$tag] = array($value);
        }
        if (!empty($fileInfo['comments']['picture'])) {
            $tagData['attached_picture'][0]['picturetypeid'] = 3;
            $tagData['attached_picture'][0]['description'] = 'Cover';
            $tagData['attached_picture'][0]['data'] = $fileInfo['comments']['picture'][0]['data'];
            $tagData['attached_picture'][0]['mime'] = $fileInfo['comments']['picture'][0]['image_mime'];
        }
        $tagwriter->tag_data = $tagData;
        // write tags
        $tagwriter->WriteTags();
        return array(
            'warnings' => $tagwriter->warnings,
            'errors' => $tagwriter->errors
        );
    }
}
