<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'credito_id' => ['required', 'exists:creditos,id'],
            'fecha_pago' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'referencia' => ['nullable', 'string', 'max:100'],
            'observaciones' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'credito_id.required' => 'Debe seleccionar un crédito.',
            'credito_id.exists' => 'El crédito seleccionado no existe.',

            'fecha_pago.required' => 'Debe ingresar la fecha del pago.',
            'fecha_pago.date' => 'La fecha del pago no es válida.',

            'monto.required' => 'Debe ingresar el monto a pagar.',
            'monto.numeric' => 'El monto debe ser un valor numérico.',
            'monto.min' => 'El monto del pago debe ser mayor a $0.',

            'referencia.max' =>
                'La referencia no puede superar los 100 caracteres.',

            'observaciones.max' =>
                'Las observaciones no pueden superar los 255 caracteres.',
        ];
    }
}