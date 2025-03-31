<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesTable extends Migration
{
    public function up()
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->decimal('monto', 15, 2);
            $table->dateTime('fecha');
            $table->text('descripcion')->nullable();

            $table->unsignedBigInteger('cuenta_bancaria_id');
            $table->unsignedBigInteger('capitulo_id')->nullable();
            $table->unsignedBigInteger('partida_id')->nullable();
            $table->unsignedBigInteger('unidad_responsable_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('solicitud_dev_id')->nullable();

            $table->timestamps();

            $table->foreign('cuenta_bancaria_id')->references('id')->on('cuenta_bancarias')->onDelete('cascade');
            $table->foreign('capitulo_id')->references('id')->on('capitulos')->onDelete('set null');
            $table->foreign('partida_id')->references('id')->on('partidas')->onDelete('set null');
            $table->foreign('unidad_responsable_id')->references('id')->on('unidad_responsables')->onDelete('set null');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            $table->foreign('solicitud_dev_id')->references('id')->on('solicitud_devs')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transacciones');
    }
}
