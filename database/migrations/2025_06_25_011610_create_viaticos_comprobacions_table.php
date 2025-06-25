<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViaticosComprobacionsTable extends Migration
{
    public function up()
    {
        Schema::create('viaticos_comprobacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viatico_id')->constrained('viaticos')->onDelete('cascade');
            $table->string('cuenta_contable');
            $table->text('descripcion')->nullable();
            $table->decimal('monto', 12, 2);
            $table->enum('tipo', ['GASTO', 'REINTEGRO', 'ADICIONAL']);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('viaticos_comprobacions');
    }
}
