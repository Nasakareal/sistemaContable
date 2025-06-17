<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViaticosTable extends Migration
{
    public function up()
    {
        Schema::create('viaticos', function (Blueprint $table) {
            $table->id();

            // Referencia a empleado desde otra base de datos, sin foreign key
            $table->unsignedBigInteger('empleado_id'); 

            // Fondos y cuentas bancarias locales, sí llevan foreign
            $table->foreignId('fondo_id')->constrained()->onDelete('restrict');
            $table->foreignId('cuenta_bancaria_id')->constrained()->onDelete('restrict');

            // Fecha en la que se entregó el viático
            $table->date('fecha_entrega');

            // Monto total entregado
            $table->decimal('importe_total', 12, 2);

            // Estado del viático
            $table->enum('estatus', ['PENDIENTE', 'COMPROBADO', 'PARCIAL', 'CANCELADO'])->default('PENDIENTE');

            // Campo adicional para notas u observaciones
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('viaticos');
    }
}
