<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaOutlineVerticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_outline_vertices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_outline_header_id');
            $table->double('latitude',11,8);
            $table->float('longitude',11,8);
            $table->integer('vertex_no');
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
        Schema::dropIfExists('kelurahan_vertices');
    }
}
