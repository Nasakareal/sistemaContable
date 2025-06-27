<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidaTransaccionTable extends Migration
{
    public function up()
    {
        Schema::create('partida_transaccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaccion_id')->constrained('transacciones')->onDelete('cascade');
            $table->foreignId('partida_id')->constrained('partidas')->onDelete('restrict');
            $table->decimal('monto', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partida_transaccion');
    }
}
