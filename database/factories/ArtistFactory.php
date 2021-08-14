<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'name_en' => $this->faker->name,
            'slug' => $this->faker->text(10),
            'image' => $this->faker->imageUrl(300, 300),
            'isbest' => $this->faker->numberBetween(0, 2),
            'music_count' => $this->faker->numberBetween(0, 100),
            'album_count' => $this->faker->numberBetween(0, 100),
            'followers_count' => $this->faker->numberBetween(0, 100),
            'playlist_count' => $this->faker->numberBetween(0, 100),
            'video_count' => $this->faker->numberBetween(0, 100),
            'header_image' => $this->faker->imageUrl(300, 300),
            'thumbnail' => $this->faker->imageUrl(300, 300),
        ];
    }
}
