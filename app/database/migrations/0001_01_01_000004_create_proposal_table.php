<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public $timestamps = false;
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
      

        
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->dateTime('data_nascimento');
            $table->float('valor_emprestimo');
            $table->longText('chave_pix');
            $table->tinyInteger('autenticado')->default(0);
            $table->tinyInteger('notificado')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
