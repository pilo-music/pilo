<?php

namespace App\Http\Repositories\V1\Music;

use App\Models\Music;
use App\Services\Search\Search;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Find
{
    private Search $search;
    protected $columns;
    protected $count;
    protected $page;
    protected $sort;
    protected $name;
    protected $slug;
    protected $id;
    protected $toJson;


    public function __construct()
    {
        $this->search = new Search();
        $this->columns = ["*"];
        $this->count = Music::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Music::DEFAULT_ITEM_SORT;
        $this->name = null;
        $this->slug = null;
        $this->id = null;
        $this->toJson = false;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set the value of count
     *
     * @param $count
     * @return  self
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Set the value of page
     *
     * @param $page
     * @return  self
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Set the value of sort
     *
     * @param $sort
     * @return  self
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Set the value of name
     *
     * @param $name
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of slug
     *
     * @param $slug
     * @return  self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }


    /**
     * Set the value of toJson
     *
     * @param bool $toJson
     * @return  self
     */
    public function setToJson(bool $toJson = true)
    {
        $this->toJson = $toJson;

        return $this;
    }

    /**
     * @param mixed $id
     * @return Find
     */
    public function setId($id): Find
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Builder|Collection|Model|object|null
     */
    public function build()
    {
        if (isset($this->name) && !empty($this->name)) {
            $items = $this->search->search(Search::INDEX_MUSIC, $this->name, $this->page, $this->count);
            $idList = collect($items)->pluck("id")->toArray();
            $musics = Music::query()->select($this->columns)->where('status', Music::STATUS_ACTIVE)
                ->whereIn('id', $idList)->get();

            if ($this->toJson) {
                $musics = MusicRepo::getInstance()->toJsonArray()->setMusics($musics)->build();
            }

            return $musics;
        }

        if (isset($this->id)) {
            /**
             * find from slug
             */
            $music = Music::query()->select($this->columns)->where('status', Music::STATUS_ACTIVE)
                ->where('id', $this->id)->first();

            if ($this->toJson) {
                $music = MusicRepo::getInstance()->toJson()->setMusic($music)->build();
            }
            return $music;
        }

        if (isset($this->slug) && $this->slug != "") {
            $music = Music::query()->select($this->columns)->where('status', Music::STATUS_ACTIVE)
                ->where('slug', $this->slug)->first();

            if ($this->toJson) {
                $music = MusicRepo::getInstance()->toJson()->setMusic($music)->build();
            }

            return $music;
        }
        return null;
    }


}
