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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('userUID')->nullable(); //tc
            $table->string('userFullName')->nullable(); //tc + isim-soyisim + okul_no
            $table->string('userFirstName')->nullable(); //name
            $table->string('userLastName')->nullable();  //surname
            $table->string('userEMailAddress')->nullable(); //email
            $table->string('userLogonName')->nullable();
            $table->string('userOfficeLocation')->nullable();  //okudugu bolum nerede vs.
            $table->string('userTitle')->nullable();   //lisans-yüksek lisans vs öğrencisi
            $table->string('userTelephoneNumber')->nullable(); //telefon numarası
            $table->string('userGender')->nullable();  //cinsiyet
            $table->string('userDescription')->nullable(); //lisans acıklaması
            $table->string('userLogonNamePreWindows2000')->nullable();
            $table->string('userDistinguishedName')->nullable();
            $table->tinyInteger('user_type')->nullable()->comment('0:Öğrenci 1:Akademisyen');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
