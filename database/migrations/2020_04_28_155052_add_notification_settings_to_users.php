<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationSettingsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('global_notification')->default(true);
            $table->boolean('music_notification')->default(true);
            $table->boolean('album_notification')->default(true);
            $table->boolean('video_notification')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('global_notification');
            $table->dropColumn('music_notification');
            $table->dropColumn('album_notification');
            $table->dropColumn('video_notification');
        });
    }
}
