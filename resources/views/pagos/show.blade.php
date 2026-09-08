<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Comprobante de Pago #{{ $pago->id }}</h2>
            <button onclick="window.print()" class="bg-gray-800 hover:bg-black text-white text-sm py-2 px-4 rounded">
                🖨️ Imprimir Recibo
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow border border-gray-200">
            <!-- Encabezado Recibo -->
            <div class="text-center border-b pb-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800">SISTEMA DE CRÉDITOS</h1>
                <p class="text-sm text-gray-500">Recibo Oficial de Pago / Abono</p>
                <p class="text-xs text-gray-400 mt-1">Fecha Emisión: {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Detalles del Pago -->
            <div class="space-y-4 text-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Cliente:</span>
                    <span class="font-bold text-gray-800">{{ $pago->credito->cliente->nombres }} {{ $pago->credito->cliente->apellidos }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Documento Identidad:</span>
                    <span class="font-bold text-gray-800">{{ $pago->credito->cliente->documento_identidad }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Crédito Asociado:</span>
                    <span class="font-bold text-gray-800">#{{ $pago->credito_id }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Fecha del Pago:</span>
                    <span class="font-bold text-gray-800">{{ $pago->fecha_pago->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Referencia:</span>
                    <span class="font-bold text-gray-800">{{ $pago->referencia ?? 'N/A' }}</span>
                </div>

                <!-- Resumen de Montos -->
                <div class="bg-gray-50 p-4 rounded-lg my-4 space-y-2">
                    <div class="flex justify-between text-base">
                        <span class="font-bold text-gray-700">Monto Abonado:</span>
                        <span class="font-bold text-green-600 text-lg">${{ number_format($pago->monto, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 border-t pt-2">
                        <span>Saldo Restante del Crédito:</span>
                        <span class="font-bold text-gray-700">${{ number_format($pago->credito->saldo, 2) }}</span>
                    </div>
                </div>

                @if($pago->observaciones)
                    <div class="text-xs text-gray-500">
                        <strong>Observaciones:</strong> {{ $pago->observaciones }}
                    </div>
                @endif
            </div>

            <!-- Firma -->
            <div class="mt-12 pt-8 border-t flex justify-around text-center text-xs text-gray-500">
                <div>
                    <div class="w-40 border-b border-gray-400 mb-1"></div>
                    <p>Firma Gestor de Cobros</p>
                </div>
                <div>
                    <div class="w-40 border-b border-gray-400 mb-1"></div>
                    <p>Firma del Cliente</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>