<?php

namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EloquentSearchRepository implements SearchRepository
{
    public function search(Model $model, string $query): Collection
    {
        return $model::query()
            ->where('title', 'LIKE', "%{$query}%")
            ->get();
    }
}
