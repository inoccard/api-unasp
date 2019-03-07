<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->string('endereco',200);
            $table->string('bairro',100);
            $table->string('cidade',100);
            $table->string('celular',15);
            $table->string('email',100)->unique();
        /*    $table->dateTime('datanascimento');
            $table->string('sexo',1);
            $table->string('email',100)->unique();
            $table->string('cpf',13);
            $table->string('rg',14);
            $table->string('rne',14);
            $table->string('certnascimento',50);
            $table->string('docmilitar',50);
            $table->boolean('matriculado'); */
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
        Schema::dropIfExists('alunos');
    }
}
