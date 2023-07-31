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
        Schema::create('internship_weeks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periot_id');
            $table->integer('week');
            $table->integer('day');


            $table->foreign('periot_id')->references('id')->on('internship_periots');
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
        Schema::dropIfExists('internship_weeks');
    }
};
