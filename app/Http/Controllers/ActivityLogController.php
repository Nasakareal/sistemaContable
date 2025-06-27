<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    // Muestra listado general del historial
    public function index()
    {  
        $modulos = Activity::select('log_name')
                    ->distinct()
                    ->orderBy('log_name')
                    ->get();

        return view('admin.settings.historial.index', compact('modulos'));
    }

        public function show($log)
    {
        $actividades = Activity::where('log_name', $log)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.settings.historial.show', compact('actividades', 'log'));
    }
}
