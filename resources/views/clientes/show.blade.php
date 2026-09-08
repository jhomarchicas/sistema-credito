<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Historial de Créditos: {{ $cliente->nombres }} {{ $cliente->apellidos }}</h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Datos del Cliente -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
                <h3 class="text-lg font-bold mb-2">Ficha del Cliente</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                    <p><strong>Documento:</strong> {{ $cliente->documento_identidad }}</p>
                    <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'N/A' }}</p>
                    <p><strong>Correo:</strong> {{ $cliente->correo ?? 'N/A' }}</p>
                    <p class="col-span-3"><strong>Dirección:</strong> {{ $cliente->direccion ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Listado Histórico -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4">Créditos Otorgados</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">ID Crédito</th>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Monto Solicitado</th>
                                <th class="px-4 py-2 text-left">Total con Interés</th>
                                <th class="px-4 py-2 text-left">Saldo Pendiente</th>
                                <th class="px-4 py-2 text-left">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($cliente->creditos as $credito)
                                <tr>
                                    <td class="px-4 py-2 font-bold">#{{ $credito->id }}</td>
                                    <td class="px-4 py-2">{{ $credito->fecha_otorgamiento->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">${{ number_format($credito->monto, 2) }}</td>
                                    <td class="px-4 py-2">${{ number_format($credito->total_credito, 2) }}</td>
                                    <td class="px-4 py-2 font-bold text-red-600">${{ number_format($credito->saldo, 2) }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $credito->estado === 'pagado' ? 'bg-green-100 text-green-800' : ($credito->estado === 'vencido' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($credito->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">Este cliente no posee créditos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>