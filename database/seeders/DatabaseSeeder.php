<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Music;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = User::factory()->create();

//        User::factory()->create([
//            'email' => 'mobin@gmail.com',
//            'password' => bcrypt('123456'),
//            'level' => 'admin'
//        ]);


        $artist = Artist::factory()->create([
            'user_id' => $user->id
        ]);

        $album = Album::factory()->create([
            'user_id' => $user->id,
            'artist_id' => $artist->id
        ]);

        $musics = Music::factory()->count(100)->create([
            'user_id' => $user->id,
            'artist_id' => $artist->id,
            'album_id' => $album->id
        ]);
    }
}
