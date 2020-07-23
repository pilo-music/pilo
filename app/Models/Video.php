<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
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

    protected $guarded = ['id'];


    public function path()
    {
        return "/video/$this->slug";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function sources()
    {
        return $this->morphMany(Source::class, 'sourceable');
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
        return 'videos';
    }
}
