<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 191)->nullable()->index();
            $table->string('name_en', 191)->index();
            $table->string('slug')->unique();
            $table->text('image');
            $table->string('header_image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('music_count')->default(0);
            $table->unsignedInteger('album_count')->default(0);
            $table->unsignedInteger('followers_count')->default(0);
            $table->unsignedInteger('playlist_count')->default(0);
            $table->unsignedInteger('video_count')->default(0);
            $table->unsignedBigInteger('search_count')->default(0);
            $table->boolean("isbest")->default(false);
            $table->tinyInteger('status')->default(\App\Models\Artist::STATUS_ACTIVE);
            $table->timestamp('stored_at')->nullable();
            $table->timestamps();
        });

        Schema::create('artistables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('artist_id');
            $table->bigInteger('artistable_id');
            $table->string('artistable_type');
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
        Schema::dropIfExists('artists');
        Schema::dropIfExists('artistables');
    }
}
