<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Album::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $title = $this->faker->unique()->name;
        return [
            'title' => $title,
            'title_en' => $title,
            'slug' => generate_slug($title),
            'image' => $this->faker->imageUrl(300, 300),
            'isbest' => random_int(0, 2),
            'like_count' => random_int(0, 100),
            'play_count' => random_int(0, 100),
            'music_count' => random_int(0, 100),
            'thumbnail' => $this->faker->imageUrl(300, 300),
        ];
    }
}
