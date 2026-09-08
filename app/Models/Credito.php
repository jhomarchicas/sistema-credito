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
}