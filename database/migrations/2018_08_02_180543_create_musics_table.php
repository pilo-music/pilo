<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('artist_id');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->unsignedInteger('album_id')->nullable();
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
            $table->string('title', 191)->nullable()->index();
            $table->string('title_en', 191)->index();
            $table->string('slug')->unique();
            $table->text('image');
            $table->string('thumbnail')->nullable();
            $table->text('text')->nullable();
            $table->string('link128');
            $table->string('link320')->nullable();
            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('play_count')->default(0);
            $table->unsignedBigInteger('search_count')->default(0);
            $table->boolean('isbest')->default(false);
            $table->string('time', 15)->default('00:00');
            $table->tinyInteger('status')->default(\App\Models\Music::STATUS_ACTIVE);
            $table->timestamp('stored_at')->nullable();
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
        Schema::dropIfExists('musics');
    }
}
