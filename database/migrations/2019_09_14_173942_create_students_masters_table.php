<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
                ->reference('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('batch',25);
            $table->string('division',25);
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
        Schema::dropIfExists('students_masters');
    }
}
