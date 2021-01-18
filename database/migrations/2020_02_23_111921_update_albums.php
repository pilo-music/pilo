<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAlbums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('play_count')->default(0);
            $table->unsignedInteger('music_count')->default(0);
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
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('like_count');
            $table->dropColumn('play_count');
            $table->dropColumn('music_count');
            $table->dropColumn('thumbnail');
        });
    }
}
