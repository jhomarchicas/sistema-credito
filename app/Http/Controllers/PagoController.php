<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Credito;
use App\Http\Requests\PagoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pagos = Pago::with(['credito.cliente'])
            ->when($search, function ($query, $search) {
                $query->whereHas('credito.cliente', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%")
                      ->orWhere('documento_identidad', 'like', "%{$search}%");
                })->orWhere('referencia', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('pagos.index', compact('pagos', 'search'));
    }

    public function create(Request $request)
    {
        $credito_id = $request->input('credito_id');
        
        // Obtener solo créditos activos o vencidos (que tengan saldo)
        $creditos = Credito::with('cliente')
            ->whereIn('estado', ['activo', 'vencido'])
            ->where('saldo', '>', 0)
            ->get();

        return view('pagos.create', compact('creditos', 'credito_id'));
    }

    public function store(PagoRequest $request)
    {
        $montoAbono = (float) $request->input('monto');
        $credito = Credito::findOrFail($request->input('credito_id'));

        // Validar que el abono no supere el saldo actual
        if ($montoAbono > $credito->saldo) {
            return back()->withInput()->withErrors([
                'monto' => 'El monto del pago ($' . number_format($montoAbono, 2) . ') no puede ser mayor al saldo pendiente ($' . number_format($credito->saldo, 2) . ').'
            ]);
        }

        DB::transaction(function () use ($request, $montoAbono, $credito) {
            // 1. Registrar el pago
            $pago = Pago::create([
                'credito_id' => $credito->id,
                'fecha_pago' => $request->input('fecha_pago'),
                'monto' => $montoAbono,
                'referencia' => $request->input('referencia'),
                'observaciones' => $request->input('observaciones'),
            ]);

            // 2. Descontar del saldo del crédito
            $nuevoSaldo = $credito->saldo - $montoAbono;
            $credito->saldo = $nuevoSaldo;

            // 3. Cambiar estado si se saldó la deuda por completo
            if ($nuevoSaldo <= 0) {
                $credito->estado = 'pagado';
            }

            $credito->save();
        });

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente y saldo actualizado.');
    }

    public function show(Pago $pago)
    {
        $pago->load(['credito.cliente']);
        return view('pagos.show', compact('pago'));
    }
}