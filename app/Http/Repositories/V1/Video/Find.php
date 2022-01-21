<?php

namespace App\Http\Repositories\V1\Video;

use App\Models\Video;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class Find
{
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
        $this->columns = ["*"];
        $this->count = Video::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Video::DEFAULT_ITEM_SORT;
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
     * @return array|null|Collection
     */
    public function build()
    {
        if (isset($this->name) && !empty($this->name)) {
            /**
             * find from name
             */
            $video = Search::new()
                ->add(Video::class, ['title', 'title_en'])
                ->paginate($this->count, 'page', $this->page)
                ->get($this->name);

            if ($this->toJson) {
                $video = VideoRepo::getInstance()->toJsonArray()->setVideos($video)->build();
            }

            return $video;
        }

        if (isset($this->id)) {
            /**
             * find from slug
             */
            $video = Video::query()->select($this->columns)->where('status', Video::STATUS_ACTIVE)
                ->where('id', $this->id)->first();

            if ($this->toJson) {
                $video = VideoRepo::getInstance()->toJson()->setVideo($video)->build();
            }
            return $video;
        }

        /**
         * find from slug
         */
        if (isset($this->slug) && $this->slug != "") {
            $video = Video::query()->select($this->columns)->where('status', Video::STATUS_ACTIVE)
                ->where('slug', $this->slug)->first();

            if ($this->toJson) {
                $video = VideoRepo::getInstance()->toJson()->setVideo($video)->build();
            }

            return $video;
        }
        return null;
    }
}
