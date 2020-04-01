<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArtists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->unsignedInteger('music_count')->default(0);
            $table->unsignedInteger('album_count')->default(0);
            $table->unsignedInteger('followers_count')->default(0);
            $table->unsignedInteger('playlist_count')->default(0);
            $table->unsignedInteger('video_count')->default(0);
            $table->string('header_image')->nullable();
            $table->string('thumbnail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musics', function (Blueprint $table) {
            $table->dropColumn('music_count');
            $table->dropColumn('album_count');
            $table->dropColumn('followers_count');
            $table->dropColumn('playlist_count');
            $table->dropColumn('header_image');
            $table->dropColumn('thumbnail');
        });
    }
}
