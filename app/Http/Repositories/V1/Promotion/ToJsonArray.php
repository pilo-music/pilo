<?php

namespace App\Http\Repositories\V1\Promotion;

use Illuminate\Support\Collection;

class ToJsonArray
{
    protected $promotions;

    public function __construct()
    {
        $this->promotions = collect([]);
    }

    /**
     * Set the value of promotions
     *
     * @param Collection $promotions
     * @return  self
     */
    public function setPromotions(Collection $promotions)
    {
        $this->promotions = $promotions;

        return $this;
    }

    public function build()
    {
        return $this->promotions->map(function ($item) {
            return PromotionRepo::getInstance()->toJson()->setPromotion($item)->build();
        });
    }
}
