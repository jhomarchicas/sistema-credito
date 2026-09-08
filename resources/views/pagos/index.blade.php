<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Módulo de Pagos</h2>
            <a href="{{ route('pagos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded">
                + Registrar Abono
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Buscador -->
                <form method="GET" action="{{ route('pagos.index') }}" class="mb-6 flex gap-4">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por cliente, documento o referencia..." class="border-gray-300 rounded-md shadow-sm text-sm w-full md:w-1/3">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Buscar</button>
                    <a href="{{ route('pagos.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm">Limpiar</a>
                </form>

                <!-- Tabla de Pagos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">ID Pago</th>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Crédito #</th>
                                <th class="px-4 py-3 text-left">Fecha de Pago</th>
                                <th class="px-4 py-3 text-left">Monto Abonado</th>
                                <th class="px-4 py-3 text-left">Referencia</th>
                                <th class="px-4 py-3 text-right">Comprobante</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($pagos as $pago)
                                <tr>
                                    <td class="px-4 py-3 font-bold">#{{ $pago->id }}</td>
                                    <td class="px-4 py-3">{{ $pago->credito->cliente->nombres }} {{ $pago->credito->cliente->apellidos }}</td>
                                    <td class="px-4 py-3">#{{ $pago->credito_id }}</td>
                                    <td class="px-4 py-3">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 font-bold text-green-600">${{ number_format($pago->monto, 2) }}</td>
                                    <td class="px-4 py-3">{{ $pago->referencia ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('pagos.show', $pago) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Ver Recibo</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay registro de abonos o pagos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pagos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>