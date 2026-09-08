<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\Cliente;
use App\Http\Requests\CreditoRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreditoController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->input('estado');
        $search = $request->input('search');

        $creditos = Credito::with('cliente')
            ->when($estado, function ($query, $estado) {
                $query->where('estado', $estado);
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('cliente', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%")
                      ->orWhere('documento_identidad', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('creditos.index', compact('creditos', 'estado', 'search'));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')->get();
        return view('creditos.create', compact('clientes'));
    }

    public function store(CreditoRequest $request)
    {
        // Castear explícitamente las entradas a tipos numéricos
        $monto = (float) $request->input('monto');
        $tasa = (float) $request->input('tasa_interes');
        $plazo = (int) $request->input('plazo'); // Debe ser entero para Carbon

        $fechaOtorgamiento = Carbon::parse($request->input('fecha_otorgamiento'));

        // Cálculos de Negocio
        $interesMonto = $monto * ($tasa / 100);
        $totalCredito = $monto + $interesMonto;
        $saldo = $totalCredito;

        // Ahora $plazo es un int y Carbon lo procesará correctamente
        $fechaVencimiento = $fechaOtorgamiento->copy()->addMonths($plazo);

        Credito::create([
            'cliente_id' => $request->input('cliente_id'),
            'fecha_otorgamiento' => $fechaOtorgamiento,
            'monto' => $monto,
            'tasa_interes' => $tasa,
            'plazo' => $plazo,
            'total_credito' => $totalCredito,
            'saldo' => $saldo,
            'fecha_vencimiento' => $fechaVencimiento,
            'estado' => 'activo',
        ]);

        return redirect()->route('creditos.index')
            ->with('success', 'Crédito otorgado y registrado exitosamente.');
    }

    public function show(Credito $credito)
    {
        $credito->load(['cliente', 'pagos']);
        return view('creditos.show', compact('credito'));
    }
}