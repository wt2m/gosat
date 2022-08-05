<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConsultaCredito extends Migration
{
    public function up()
    {

        Schema::create('consulta_credito', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('instituicao');
            $table->string('modalidade');
            $table->double('valorAPagar');
            $table->double('valorSolicitado');
            $table->integer('qntParcelas');
            $table->double('taxaJuros');
            $table->string('cpf');
            $table->timestamps();
            $table->softDeletes();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('consulta_credito');
    }
}
