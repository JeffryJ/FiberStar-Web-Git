<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateCoveragePassThroughTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coverage_pass_through_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pass_through_type');
            $table->timestamps();
        });

        DB::table('coverage_pass_through_types')->insert(
            [
                ['pass_through_type' => 'Terrestrial','created_at'=>Carbon::now()->toDateTimeString(),'updated_at'=>Carbon::now()->toDateTimeString()],
                ['pass_through_type' => 'Submarine','created_at'=>Carbon::now()->toDateTimeString(),'updated_at'=>Carbon::now()->toDateTimeString()],
                ['pass_through_type' => 'Hybrid','created_at'=>Carbon::now()->toDateTimeString(),'updated_at'=>Carbon::now()->toDateTimeString()]
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coverage_pass_through_types');
    }
}
