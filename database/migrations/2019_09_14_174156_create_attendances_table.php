<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('students_masters_id');
            $table->unsignedInteger('lectures_id');
            $table->timestamps();

            $table->foreign('students_masters_id')
            ->references('id')
            ->on('students_masters')
            ->onDelete('cascade');

            $table->foreign('lectures_id')
            ->references('id')
            ->on('lectures')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
