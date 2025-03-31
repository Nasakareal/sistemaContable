<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuentaBancaria;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function json()
    {
        $cuentas = CuentaBancaria::select('nombre', 'saldo')->get();
        return response()->json($cuentas);
    }
}
