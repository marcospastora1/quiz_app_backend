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
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->foreignId('disciplina_id')->references('id')->on('disciplinas');
            $table->foreignId('professor_user_id')->references('id')->on('professor_users');
            $table->foreignId('quiz_status_id')->references('id')->on('quiz_status');
            $table->string('chave')->unique();
            $table->float('duracao');
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
        Schema::dropIfExists('quiz');
    }
};
