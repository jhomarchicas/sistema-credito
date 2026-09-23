<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Credito extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'fecha_otorgamiento',
        'monto',
        'tasa_interes',
        'plazo',
        'total_credito',
        'valor_cuota',
        'saldo',
        'fecha_vencimiento',
        'estado',
    ];

    protected $casts = [
        'fecha_otorgamiento' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
        'tasa_interes' => 'decimal:2',
        'total_credito' => 'decimal:2',
        'valor_cuota' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    /**
     * Relación: Un crédito pertenece a un cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación: Un crédito tiene muchos pagos.
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Total que el cliente ya ha pagado.
     */
    public function getTotalPagadoAttribute(): float
    {
        return (float) $this->total_credito - (float) $this->saldo;
    }

    /**
     * Monto mínimo que debe pagar actualmente.
     *
     * Si el saldo restante es menor que la cuota normal,
     * el pago mínimo será exactamente el saldo restante.
     */
    public function getPagoMinimoAttribute(): float
    {
        if ((float) $this->saldo <= 0) {
            return 0;
        }

        return min(
            (float) $this->valor_cuota,
            (float) $this->saldo
        );
    }

    /**
     * Porcentaje del crédito que ya ha sido pagado.
     */
    public function getPorcentajePagadoAttribute(): float
    {
        $total = (float) $this->total_credito;

        if ($total <= 0) {
            return 0;
        }

        $porcentaje = ($this->total_pagado / $total) * 100;

        return round(min(100, max(0, $porcentaje)), 2);
    }

    /**
     * Indica si el siguiente pago liquidará el crédito
     * pagando el mínimo requerido.
     */
    public function getEsUltimoPagoAttribute(): bool
    {
        return (float) $this->saldo > 0
            && (float) $this->saldo <= (float) $this->valor_cuota;
    }
}