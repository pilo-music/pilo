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
     * @throws \Exception
     */
    public function definition()
    {
        $title = $this->faker->text(5);
        return [
            'name' => $title,
            'name_en' => $title,
            'slug' => generate_slug($title),
            'image' => $this->faker->imageUrl(300, 300),
            'isbest' => $this->faker->numberBetween(0, 2),
            'music_count' => random_int(0, 100),
            'album_count' => random_int(0, 100),
            'followers_count' => random_int(0, 100),
            'playlist_count' => random_int(0, 100),
            'video_count' => random_int(0, 100),
            'header_image' => $this->faker->imageUrl(300, 300),
            'thumbnail' => $this->faker->imageUrl(300, 300),
        ];
    }
}
