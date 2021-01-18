<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusFieldToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->tinyInteger('status')->default(\App\Models\Artist::STATUS_ACTIVE);
        });
        Schema::table('musics', function (Blueprint $table) {
            $table->tinyInteger('status')->default(\App\Models\Music::STATUS_ACTIVE);
        });
        Schema::table('albums', function (Blueprint $table) {
            $table->tinyInteger('status')->default(\App\Models\Album::STATUS_ACTIVE);
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->tinyInteger('status')->default(\App\Models\Video::STATUS_ACTIVE);
        });
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->tinyInteger('status')->default(\App\Models\Playlist::STATUS_ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('musics', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('playlists', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->dropColumn('status');
        });
    }
}
