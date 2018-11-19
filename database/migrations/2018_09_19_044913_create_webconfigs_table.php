<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webconfigs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo_image_link');
            $table->string('company_name');
            $table->string('address',500);
            $table->string('customer_care_image_link');
            $table->string('phone');
            $table->string('fax');
            $table->string('contact_email');
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
        Schema::dropIfExists('webconfigs');
    }
}
