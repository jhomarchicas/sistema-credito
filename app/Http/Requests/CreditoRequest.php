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
            'cliente_id' => [
                'required',
                'exists:clientes,id',
            ],

            'fecha_otorgamiento' => [
                'required',
                'date',
            ],

            'monto' => [
                'required',
                'numeric',
                'min:1',
            ],

            'tasa_interes' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            // El plazo representa la cantidad de cuotas mensuales.
            'plazo' => [
                'required',
                'integer',
                'min:1',
            ],

            'estado' => [
                'nullable',
                'in:activo,pagado,vencido',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'cliente_id.exists' => 'El cliente seleccionado no es válido.',

            'fecha_otorgamiento.required' => 'Debe ingresar la fecha de otorgamiento.',
            'fecha_otorgamiento.date' => 'La fecha de otorgamiento no es válida.',

            'monto.required' => 'Debe ingresar el monto del crédito.',
            'monto.numeric' => 'El monto debe ser un valor numérico.',
            'monto.min' => 'El monto del crédito debe ser mayor a $0.',

            'tasa_interes.required' => 'Debe ingresar la tasa de interés.',
            'tasa_interes.numeric' => 'La tasa de interés debe ser numérica.',
            'tasa_interes.min' => 'La tasa de interés no puede ser negativa.',
            'tasa_interes.max' => 'La tasa de interés no puede superar el 100%.',

            'plazo.required' => 'Debe ingresar la cantidad de cuotas.',
            'plazo.integer' => 'La cantidad de cuotas debe ser un número entero.',
            'plazo.min' => 'El crédito debe tener al menos una cuota.',
        ];
    }
}