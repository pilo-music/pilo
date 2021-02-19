<?php

namespace App\Http\Repositories\V1\Video;

use App\Models\Video;

class Find
{
    protected $count;
    protected $page;
    protected $sort;
    protected $name;
    protected $slug;
    protected $id;
    protected $toJson;


    public function __construct()
    {
        $this->count = Video::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Video::DEFAULT_ITEM_SORT;
        $this->name = null;
        $this->slug = null;
        $this->toJson = false;
        $this->id = null;
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
     * @return array|null|video
     */
    public function build()
    {
        if (isset($this->name) && !empty($this->name)) {
            /*
          *  find from name
          */
            $video = Video::searchByQuery([
                'multi_match' => [
                    'query' => $this->name,
                    "fuzziness" => "AUTO",
                    "operator" => "AND",
                    "lenient" => "true",
                    'fields' => [
                        'title_en', 'title'
                    ]
                ],
            ], null, null, $this->count, ($this->page - 1) * $this->count)->where('status', Video::STATUS_ACTIVE);

            if ($this->toJson) {
                $video = VideoRepo::getInstance()->toJsonArray()->setVideos($video)->build();
            }

            return $video;

        }

        if (isset($this->id)) {
            /**
             * find from slug
             */
            $video = Video::query()->where('status', Video::STATUS_ACTIVE)
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
            $video = Video::query()->where('status', Video::STATUS_ACTIVE)
                ->where('slug', $this->slug)->first();

            if ($this->toJson) {
                $video = VideoRepo::getInstance()->toJson()->setVideo($video)->build();
            }

            return $video;
        }
        return null;
    }


}
