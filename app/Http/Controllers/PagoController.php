<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Credito;
use App\Http\Requests\PagoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PagoController extends Controller
{
    /**
     * Mostrar listado de pagos.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pagos = Pago::with(['credito.cliente'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('credito.cliente', function ($clienteQuery) use ($search) {
                        $clienteQuery
                            ->where('nombres', 'like', "%{$search}%")
                            ->orWhere('apellidos', 'like', "%{$search}%")
                            ->orWhere('documento_identidad', 'like', "%{$search}%");
                    })
                    ->orWhere('referencia', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pagos.index', compact(
            'pagos',
            'search'
        ));
    }

    /**
     * Mostrar formulario para registrar un pago.
     */
    public function create(Request $request)
    {
        $credito_id = $request->input('credito_id');

        $creditos = Credito::with('cliente')
            ->whereIn('estado', ['activo', 'vencido'])
            ->where('saldo', '>', 0)
            ->orderBy('fecha_vencimiento')
            ->get();

        return view('pagos.create', compact(
            'creditos',
            'credito_id'
        ));
    }

    /**
     * Registrar un nuevo pago.
     */
    public function store(PagoRequest $request)
    {
        $montoAbono = round(
            (float) $request->input('monto'),
            2
        );

        DB::transaction(function () use ($request, $montoAbono) {

            /*
             * Bloqueamos el crédito mientras se procesa el pago
             * para evitar que dos pagos simultáneos modifiquen
             * el mismo saldo.
             */
            $credito = Credito::whereKey(
                $request->input('credito_id')
            )
                ->lockForUpdate()
                ->firstOrFail();

            $saldoActual = round(
                (float) $credito->saldo,
                2
            );

            $valorCuota = round(
                (float) $credito->valor_cuota,
                2
            );

            /*
             * No permitir pagos sobre créditos
             * completamente cancelados.
             */
            if (
                $credito->estado === 'pagado' ||
                $saldoActual <= 0
            ) {
                throw ValidationException::withMessages([
                    'credito_id' =>
                        'Este crédito ya se encuentra completamente pagado.',
                ]);
            }

            /*
             * El pago mínimo será:
             *
             * - La cuota normal, mientras el saldo sea mayor.
             * - El saldo exacto, cuando sea la última cuota.
             *
             * Ejemplo:
             *
             * Cuota = $91.67
             * Saldo = $800
             * Mínimo = $91.67
             *
             * Cuota = $91.67
             * Saldo = $65.34
             * Mínimo = $65.34
             */
            $pagoMinimo = round(
                min($valorCuota, $saldoActual),
                2
            );

            /*
             * No permitir pagos menores al mínimo.
             */
            if ($montoAbono < $pagoMinimo) {
                throw ValidationException::withMessages([
                    'monto' =>
                        'El pago mínimo requerido es de $'
                        . number_format($pagoMinimo, 2)
                        . '.',
                ]);
            }

            /*
             * Nunca permitir pagar más del saldo.
             */
            if ($montoAbono > $saldoActual) {
                throw ValidationException::withMessages([
                    'monto' =>
                        'El monto del pago ($'
                        . number_format($montoAbono, 2)
                        . ') no puede ser mayor al saldo pendiente ($'
                        . number_format($saldoActual, 2)
                        . ').',
                ]);
            }

            /*
             * Calcular el saldo que quedará después
             * de realizar el pago.
             */
            $nuevoSaldo = round(
                $saldoActual - $montoAbono,
                2
            );

            /*
             * Protección adicional contra pequeños
             * valores negativos causados por redondeo.
             */
            $nuevoSaldo = max(0, $nuevoSaldo);

            /*
             * Registrar el pago.
             *
             * saldo_restante guarda el saldo histórico
             * que quedó exactamente después de este pago.
             */
            Pago::create([
                'credito_id' => $credito->id,
                'fecha_pago' => $request->input('fecha_pago'),
                'monto' => $montoAbono,
                'saldo_restante' => $nuevoSaldo,
                'referencia' => $request->input('referencia'),
                'observaciones' => $request->input('observaciones'),
            ]);

            /*
             * Actualizar saldo del crédito.
             */
            $credito->saldo = $nuevoSaldo;

            /*
             * Si ya no existe saldo pendiente,
             * marcar automáticamente como pagado.
             */
            if ($nuevoSaldo <= 0) {
                $credito->saldo = 0;
                $credito->estado = 'pagado';
            }

            $credito->save();
        });

        return redirect()
            ->route('pagos.index')
            ->with(
                'success',
                'Pago registrado correctamente y saldo actualizado.'
            );
    }

    /**
     * Mostrar comprobante de un pago.
     */
    public function show(Pago $pago)
    {
        $pago->load([
            'credito.cliente'
        ]);

        return view('pagos.show', compact('pago'));
    }
}