<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixFkPartidaViaticoToComprobaciones extends Migration
{
    public function up()
    {
        Schema::table('partida_viatico', function (Blueprint $table) {
            $table->dropForeign('partida_viatico_viatico_id_foreign');
        });

        Schema::table('partida_viatico', function (Blueprint $table) {
            if (Schema::hasColumn('partida_viatico', 'viatico_id')) {
                $table->renameColumn('viatico_id', 'viaticos_comprobacion_id');
            }
            $table->foreign('viaticos_comprobacion_id')
                  ->references('id')
                  ->on('viaticos_comprobacions')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('partida_viatico', function (Blueprint $table) {
            $table->dropForeign(['viaticos_comprobacion_id']);
        });

        Schema::table('partida_viatico', function (Blueprint $table) {
            if (Schema::hasColumn('partida_viatico', 'viaticos_comprobacion_id')) {
                $table->renameColumn('viaticos_comprobacion_id', 'viatico_id');
            }
            $table->foreign('viatico_id')
                  ->references('id')
                  ->on('viaticos')
                  ->onDelete('cascade');
        });
    }
}
