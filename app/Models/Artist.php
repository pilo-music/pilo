<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use ElasticquentTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    const SORT_LATEST = "latest";
    const SORT_BEST = "best";
    const SORT_OLDEST = "oldest";
    const SORT_SEARCH = "search";

    const DEFAULT_ITEM_COUNT = 12;
    const DEFAULT_ITEM_SORT = self::SORT_LATEST;

    protected $guarded = [
        'id'
    ];


    public function path()
    {
        return "/artist/$this->slug";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function musics()
    {
        return $this->hasMany(Music::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }


    public function tagMusics()
    {
        return $this->morphedByMany(Music::class, 'artistable');
    }

    public function tagAlbums()
    {
        return $this->morphedByMany(Album::class, 'artistable');
    }

    public function tagVideos()
    {
        return $this->morphedByMany(Video::class, 'artistable');
    }

    public function tagPlaylist()
    {
        return $this->morphedByMany(Playlist::class, 'artistable');
    }

    public function sources()
    {
        return $this->morphMany(Source::class, 'sourceable');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ]
            ],
            'analyzer' => [
                'default' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                    ],
                ],
            ],
        ],
    ];

    public function getIndexName()
    {
        return 'artists';
    }
}
