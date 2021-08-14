<?php

namespace App\Http\Repositories\V1\Promotion;

use App\Models\Promotion;

class Find
{
    protected $id;
    protected $slug;
    protected $type;
    protected $toJson;

    public function __construct()
    {
        $this->id = null;
        $this->slug = null;
        $this->type = null;
        $this->toJson = false;
    }

    /**
     * @param null $id
     * @return Find
     */
    public function setId($id): Find
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param null $slug
     * @return Find
     */
    public function setSlug($slug): Find
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param null $type
     * @return Find
     */
    public function setType($type): Find
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param mixed $toJson
     * @return Find
     */
    public function setToJson($toJson = true): Find
    {
        $this->toJson = $toJson;
        return $this;
    }


    public function build()
    {
        if (isset($this->id)) {
            $promotion = Promotion::query()->where('id', $this->id);
        } elseif (isset($this->slug)) {
            $promotion = Promotion::query()->where('slug', $this->slug);
        } else {
            return null;
        }

        $promotion  = $promotion->where('status', Promotion::STATUS_ACTIVE);

        if (isset($this->type)) {
            $promotion = $promotion->where('type', $this->type);
        }

        $promotion = $promotion->first();

        if ($this->toJson) {
            $promotion = PromotionRepo::getInstance()->toJson()->setPromotion($promotion)->build();
        }

        return $promotion;
    }
}
