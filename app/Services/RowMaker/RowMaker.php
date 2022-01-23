<?php

namespace App\Services\RowMaker;

class RowMaker
{
    public function __construct(
        public string  $title,
        public Types   $type,
        public int     $count,
        public array   $items,
        public ?string $link = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'type' => $this->type,
            'count' => $this->count,
            'items' => $this->items,
            'link' => $this->link,
        ];
    }
}
