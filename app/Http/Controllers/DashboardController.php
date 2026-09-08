<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cliente = null;

        // Si el usuario es de tipo cliente, cargamos sus créditos y pagos asociados
        if ($user->isCliente() && $user->cliente_id) {
            $cliente = $user->cliente()->with(['creditos.pagos'])->first();
        }

        return view('dashboard', compact('cliente'));
    }
}