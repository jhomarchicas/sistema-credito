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
            ->paginate(10)
            ->withQueryString();

        return view('creditos.index', compact(
            'creditos',
            'estado',
            'search'
        ));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('creditos.create', compact('clientes'));
    }

    public function store(CreditoRequest $request)
    {
        $monto = round((float) $request->input('monto'), 2);
        $tasa = (float) $request->input('tasa_interes');
        $cantidadCuotas = (int) $request->input('plazo');

        $fechaOtorgamiento = Carbon::parse(
            $request->input('fecha_otorgamiento')
        );

        /*
        |--------------------------------------------------------------------------
        | Cálculo del crédito
        |--------------------------------------------------------------------------
        */

        $interesMonto = round(
            $monto * ($tasa / 100),
            2
        );

        $totalCredito = round(
            $monto + $interesMonto,
            2
        );

        /*
         * Valor normal de cada cuota.
         *
         * El último pago no depende estrictamente de este valor.
         * Si existe una diferencia por redondeo, se cobrará únicamente
         * el saldo restante.
         */
        $valorCuota = round(
            $totalCredito / $cantidadCuotas,
            2
        );

        /*
         * Al crear el crédito, el saldo pendiente es igual
         * al total del crédito.
         */
        $saldo = $totalCredito;

        /*
         * Cada cuota representa un mes.
         *
         * Ejemplo:
         * 12 cuotas = vencimiento dentro de 12 meses.
         */
        $fechaVencimiento = $fechaOtorgamiento
            ->copy()
            ->addMonthsNoOverflow($cantidadCuotas);

        Credito::create([
            'cliente_id' => $request->input('cliente_id'),
            'fecha_otorgamiento' => $fechaOtorgamiento,
            'monto' => $monto,
            'tasa_interes' => $tasa,
            'plazo' => $cantidadCuotas,
            'total_credito' => $totalCredito,
            'valor_cuota' => $valorCuota,
            'saldo' => $saldo,
            'fecha_vencimiento' => $fechaVencimiento,
            'estado' => 'activo',
        ]);

        return redirect()
            ->route('creditos.index')
            ->with(
                'success',
                'Crédito otorgado y registrado exitosamente.'
            );
    }

    public function show(Credito $credito)
    {
        $credito->load([
            'cliente',
            'pagos' => function ($query) {
                $query->orderBy('fecha_pago')
                    ->orderBy('id');
            }
        ]);

        return view('creditos.show', compact('credito'));
    }
}