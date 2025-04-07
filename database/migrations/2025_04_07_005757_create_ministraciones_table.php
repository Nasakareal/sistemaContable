<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinistracionesTable extends Migration
{
    public function up()
    {
        Schema::create('ministraciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('fondo_id')->constrained('fondos')->onDelete('cascade');
            $table->foreignId('cuenta_bancaria_id')->constrained('cuenta_bancarias')->onDelete('cascade');
            $table->foreignId('unidad_responsable_id')->constrained('unidad_responsables')->onDelete('cascade');
            $table->foreignId('partida_id')->nullable()->constrained('partidas')->onDelete('set null');
            $table->decimal('importe', 15, 2);
            $table->string('tipo_gasto')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('periodo')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('referencia_gasto')->nullable();
            $table->string('referencia_desc_gasto')->nullable();
            $table->string('ref_fondo')->nullable();
            $table->string('ref_partida')->nullable();
            $table->string('ref_ur')->nullable();
            $table->string('ref_part')->nullable();
            $table->string('cuenta_bancaria_origen')->nullable();
            $table->string('cuenta_aplicacion')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ministraciones');
    }
}
