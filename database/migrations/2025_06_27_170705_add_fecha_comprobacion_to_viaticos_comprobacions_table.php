<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaComprobacionToViaticosComprobacionsTable extends Migration
{
    public function up()
    {
        Schema::table('viaticos_comprobacions', function (Blueprint $table) {
            $table->date('fecha_comprobacion')->nullable()->after('monto');
        });
    }

    public function down()
    {
        Schema::table('viaticos_comprobacions', function (Blueprint $table) {
            $table->dropColumn('fecha_comprobacion');
        });
    }
}
