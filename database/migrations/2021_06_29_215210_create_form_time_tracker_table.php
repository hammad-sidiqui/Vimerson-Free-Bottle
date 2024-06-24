<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTimeTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_time_tracker', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedInteger('step_one_time')->nullable();
            $table->unsignedInteger('step_two_time')->nullable();
            $table->unsignedInteger('step_three_time')->nullable();
            $table->unsignedInteger('step_four_time')->nullable();
            $table->unsignedTinyInteger('e_status')->nullable()->default(0);

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
        Schema::dropIfExists('form_time_tracker');
    }
}
