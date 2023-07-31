<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_weeks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hafta_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('day');
            $table->string('title');
            $table->text('description');

            $table->foreign('hafta_id')->references('id')->on('internship_weeks');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('student_weeks');
    }
};
