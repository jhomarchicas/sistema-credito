<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Módulo de Créditos</h2>
            <a href="{{ route('creditos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded">
                + Otorgar Nuevo Crédito
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
                <!-- Filtros -->
                <form method="GET" action="{{ route('creditos.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por cliente o documento..." class="border-gray-300 rounded-md shadow-sm text-sm">
                    
                    <select name="estado" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">-- Todos los estados --</option>
                        <option value="activo" {{ $estado === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="pagado" {{ $estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="vencido" {{ $estado === 'vencido' ? 'selected' : '' }}>Vencido</option>
                    </select>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium w-full">Filtrar</button>
                        <a href="{{ route('creditos.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium text-center">Limpiar</a>
                    </div>
                </form>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Monto Solicitado</th>
                                <th class="px-4 py-3 text-left">Total c/ Interés</th>
                                <th class="px-4 py-3 text-left">Saldo Pendiente</th>
                                <th class="px-4 py-3 text-left">Vencimiento</th>
                                <th class="px-4 py-3 text-left">Estado</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($creditos as $credito)
                                <tr>
                                    <td class="px-4 py-3 font-bold">#{{ $credito->id }}</td>
                                    <td class="px-4 py-3">{{ $credito->cliente->nombres }} {{ $credito->cliente->apellidos }}</td>
                                    <td class="px-4 py-3">${{ number_format($credito->monto, 2) }}</td>
                                    <td class="px-4 py-3">${{ number_format($credito->total_credito, 2) }}</td>
                                    <td class="px-4 py-3 font-bold text-red-600">${{ number_format($credito->saldo, 2) }}</td>
                                    <td class="px-4 py-3">{{ $credito->fecha_vencimiento->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $credito->estado === 'pagado' ? 'bg-green-100 text-green-800' : ($credito->estado === 'vencido' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($credito->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('creditos.show', $credito) }}" class="text-blue-600 hover:text-blue-900 font-medium">Detalles</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">No hay registros de créditos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $creditos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>