<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("title")->index();
            $table->string("slug")->unique();
            $table->string("image")->nullable();
            $table->string("image_one")->nullable();
            $table->string("image_two")->nullable();
            $table->string("image_three")->nullable();
            $table->string("image_four")->nullable();
            $table->unsignedInteger('music_count')->default(0);
            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('play_count')->default(0);
            $table->unsignedBigInteger('search_count')->default(0);
            $table->tinyInteger('status')->default(\App\Models\Playlist::STATUS_ACTIVE);
            $table->timestamp('stored_at')->nullable();
            $table->timestamps();
        });
        Schema::create('playlistables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedBigInteger('playlistable_id');
            $table->string('playlistable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlists');
        Schema::dropIfExists('playlistables');
    }
}
