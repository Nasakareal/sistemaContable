<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesPresupuestalesTable extends Migration
{
    public function up()
    {
        Schema::create('asignaciones_presupuestales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fondo_id')->constrained('fondos')->onDelete('cascade');
            $table->foreignId('cuenta_bancaria_id')->nullable()->constrained('cuenta_bancarias')->onDelete('set null');
            $table->foreignId('unidad_responsable_id')->constrained('unidad_responsables')->onDelete('cascade');
            $table->foreignId('partida_id')->nullable()->constrained('partidas')->onDelete('set null');

            $table->decimal('monto', 15, 2);
            $table->string('periodo')->nullable();
            $table->text('justificacion')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asignaciones_presupuestales');
    }
}
