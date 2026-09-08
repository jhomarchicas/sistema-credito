<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle del Crédito #{{ $credito->id }}</h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Datos Generales -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4">Información del Crédito</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                    <p><strong>Cliente:</strong> {{ $credito->cliente->nombres }} {{ $credito->cliente->apellidos }}</p>
                    <p><strong>Fecha Otorgado:</strong> {{ $credito->fecha_otorgamiento->format('d/m/Y') }}</p>
                    <p><strong>Fecha Vencimiento:</strong> {{ $credito->fecha_vencimiento->format('d/m/Y') }}</p>
                    <p><strong>Plazo:</strong> {{ $credito->plazo }} Meses</p>
                    <p><strong>Monto Base:</strong> ${{ number_format($credito->monto, 2) }}</p>
                    <p><strong>Tasa Interés:</strong> {{ $credito->tasa_interes }}%</p>
                    <p><strong>Total con Interés:</strong> ${{ number_format($credito->total_credito, 2) }}</p>
                    <p class="text-red-600 font-bold"><strong>Saldo Pendiente:</strong> ${{ number_format($credito->saldo, 2) }}</p>
                </div>
            </div>

            <!-- Tabla de Pagos Realizados -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4">Abonos y Pagos Registrados</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">ID Pago</th>
                                <th class="px-4 py-2 text-left">Fecha Pago</th>
                                <th class="px-4 py-2 text-left">Monto Abonado</th>
                                <th class="px-4 py-2 text-left">Referencia</th>
                                <th class="px-4 py-2 text-left">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($credito->pagos as $pago)
                                <tr>
                                    <td class="px-4 py-2 font-bold">#{{ $pago->id }}</td>
                                    <td class="px-4 py-2">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 font-bold text-green-600">${{ number_format($pago->monto, 2) }}</td>
                                    <td class="px-4 py-2">{{ $pago->referencia ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $pago->observaciones ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Aún no se han realizado abonos para este crédito.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>