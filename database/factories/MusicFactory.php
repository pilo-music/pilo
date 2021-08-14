<?php

namespace Database\Factories;

use App\Models\Music;
use Illuminate\Database\Eloquent\Factories\Factory;

class MusicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Music::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(5),
            'title_en' => $this->faker->text(5),
            'slug' => $this->faker->text(5),
            'image' => $this->faker->imageUrl(300, 300),
            'text' => $this->faker->text(100),
            'link128' => $this->faker->url(),
            'link320' => $this->faker->url(),
            'isbest' => $this->faker->numberBetween(0, 2),
            'time' => $this->faker->time("i:s"),
            'like_count' => $this->faker->numberBetween(0, 100),
            'play_count' => $this->faker->numberBetween(0, 100),
            'thumbnail' => $this->faker->imageUrl(300, 300),
        ];
    }
}
