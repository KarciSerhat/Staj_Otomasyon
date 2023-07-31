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
        Schema::create('week_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_week_id');
            $table->string('image');

            $table->foreign('student_week_id')->references('id')->on('student_weeks');
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
        Schema::dropIfExists('week_images');
    }
};
