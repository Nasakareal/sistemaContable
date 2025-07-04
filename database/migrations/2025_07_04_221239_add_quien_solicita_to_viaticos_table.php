<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuienSolicitaToViaticosTable extends Migration
{
    public function up()
    {
        Schema::table('viaticos', function (Blueprint $table) {
            $table->enum('quien_solicita', [
                'UR RECTORIA',
                'UR DELEGACION ADMINISTRATIVA',
                'UR DIRECCION ACADEMICA PAS'
            ])->nullable()->after('empleado_id');
        });
    }

    public function down()
    {
        Schema::table('viaticos', function (Blueprint $table) {
            $table->dropColumn('quien_solicita');
        });
    }
}
