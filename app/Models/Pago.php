<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'credito_id',
        'fecha_pago',
        'monto',
        'referencia',
        'observaciones',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
    ];

    /**
     * Relación: Un pago pertenece a un crédito.
     */
    public function credito(): BelongsTo
    {
        return $this->belongsTo(Credito::class);
    }
}