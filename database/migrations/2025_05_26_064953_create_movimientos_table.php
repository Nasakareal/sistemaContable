<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('origen');
            $table->date('fecha')->nullable();
            $table->string('descripcion')->nullable();
            $table->decimal('monto', 15, 2)->default(0);
            $table->unsignedBigInteger('requisicion_id')->nullable();
            $table->unsignedBigInteger('nomina_id')->nullable();
            $table->unsignedBigInteger('cuenta_bancaria_id')->nullable();
            $table->string('tipo')->nullable();
            $table->string('referencia')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->index(['origen', 'requisicion_id', 'nomina_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
}
