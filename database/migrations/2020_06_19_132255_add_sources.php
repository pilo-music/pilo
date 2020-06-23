<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->string('source_id')->nullable();
        });

        Schema::table('musics', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->string('source_id')->nullable();
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->string('source_id')->nullable();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->string('source_id')->nullable();
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->string('source_id')->nullable();
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
            $table->dropColumn('source');
            $table->dropColumn('source_id');
        });

        Schema::table('musics', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('source_id');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('source_id');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('source_id');
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('source_id');
        });
    }
}
