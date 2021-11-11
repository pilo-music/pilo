<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('artist_id');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->string('title', 50)->nullable()->index();
            $table->string('title_en', 50)->index();
            $table->string('slug')->unique();
            $table->text('image')->nullable();
            $table->string('video480');
            $table->string('video720')->nullable();
            $table->string('video1080')->nullable();
            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('play_count')->default(0);
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('search_count')->default(0);
            $table->boolean('isbest')->default(false);
            $table->tinyInteger('status')->default(\App\Models\Video::STATUS_ACTIVE);
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
        Schema::dropIfExists('videos');
    }
}
