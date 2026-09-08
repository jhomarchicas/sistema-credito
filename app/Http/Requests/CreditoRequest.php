<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'fecha_otorgamiento' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:1'],
            'tasa_interes' => ['required', 'numeric', 'min:0', 'max:100'],
            'plazo' => ['required', 'integer', 'min:1'], // Plazo en meses
            'estado' => ['nullable', 'in:activo,pagado,vencido'],
        ];
    }
}