<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrowsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('browses', function (Blueprint $table) {
            $table->increments("id");
            $table->string('name');
            $table->integer('type');
            $table->string('sort', 50);
            $table->tinyInteger('row_number');
            $table->tinyInteger('count');
            $table->string('value')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('browses');
    }
}
