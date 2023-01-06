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
        Schema::create('professor_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('nome');
            $table->foreignId('tipo_user_id')->references('id')->on('tipo_users');
            $table->string('registro_professor');
            $table->date('data_nascimento');
            $table->string('whatsapp');
            $table->timestamps();

            $table->unique('user_id');
            $table->unique('registro_professor');
            $table->unique('whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professor_users');
    }
};
