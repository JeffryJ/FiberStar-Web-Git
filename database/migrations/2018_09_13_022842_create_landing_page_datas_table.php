<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingPageDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /**
         * TODO: Change multiple image to single image, here, controller and view
         */

        Schema::create('landing_page_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('background_image_link');
            $table->string('who_we_are',3000);
            $table->string('benefit1_title');
            $table->string('benefit1_description',1000);
            $table->string('benefit1_image_link');
            $table->string('benefit2_title');
            $table->string('benefit2_description',1000);
            $table->string('benefit2_image_link');
            $table->string('benefit3_title');
            $table->string('benefit3_description',1000);
            $table->string('benefit3_image_link');
            $table->string('benefit4_title');
            $table->string('benefit4_description',1000);
            $table->string('benefit4_image_link');
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
        Schema::dropIfExists('landing_page_datas');
    }
}
