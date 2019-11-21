<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ranch_id')->unsigned();
            $table->foreign('ranch_id')->references('id')->on('ranch');
            $table->bigInteger('worker_id')->unsigned();
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->date('attendance_day');
            $table->double('status', 2, 2);	
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
