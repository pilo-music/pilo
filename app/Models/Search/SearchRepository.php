<?php

namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SearchRepository
{
    public function search(Model $model, string $query): Collection;
}
