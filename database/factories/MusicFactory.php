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
            'text' => $this->faker->text(100),
            'link128' => $this->faker->url(),
            'link320' => $this->faker->url(),
            'isbest' => random_int(0, 2),
            'time' => $this->faker->time("i:s"),
            'like_count' => random_int(0, 100),
            'play_count' => random_int(0, 100),
            'thumbnail' => $this->faker->imageUrl(300, 300),
        ];
    }
}
