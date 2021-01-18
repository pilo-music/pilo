<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_histories', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("user_id")->nullable();
            $table->foreign("user_id")->on("users")->references("id");
            $table->string("historyable_id");
            $table->string("historyable_type");
            $table->string("ip")->nullable();
            $table->string("agent")->nullable();
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
        Schema::dropIfExists('play_histories');
    }
}
