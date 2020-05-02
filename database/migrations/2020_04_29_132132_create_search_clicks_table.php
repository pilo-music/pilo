<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_clicks', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("search_history_id");
            $table->foreign("search_history_id")->on("search_histories")->references("id");
            $table->string("clickable_id");
            $table->string("clickable_type");
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
        Schema::dropIfExists('search_clicks');
    }
}
