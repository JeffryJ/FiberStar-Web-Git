<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->integer('invite_as_role_id');
            $table->string('confirmation_token');
            $table->integer('invited_by');
            $table->boolean('user_registered')->default(false);
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
        Schema::dropIfExists('register_invitations');
    }
}
