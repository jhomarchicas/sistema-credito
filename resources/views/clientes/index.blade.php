<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Módulo de Clientes</h2>
            <a href="{{ route('clientes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded">
                + Nuevo Cliente
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
                <form method="GET" action="{{ route('clientes.index') }}" class="mb-6 flex gap-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre, apellido o documento..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium">Buscar</button>
                    @if($search)
                        <a href="{{ route('clientes.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">Limpiar</a>
                    @endif
                </form>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Documento</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Nombre Completo</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Teléfono</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Estado</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($clientes as $cliente)
                                <tr>
                                    <td class="px-4 py-3 font-semibold">{{ $cliente->documento_identidad }}</td>
                                    <td class="px-4 py-3">{{ $cliente->nombres }} {{ $cliente->apellidos }}</td>
                                    <td class="px-4 py-3">{{ $cliente->telefono ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $cliente->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($cliente->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-2">
                                        <a href="{{ route('clientes.show', $cliente) }}" class="text-blue-600 hover:text-blue-900 font-medium">Historial</a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar</a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline" onsubmit="return confirm('¿Desactivar cliente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Desactivar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">No se encontraron clientes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $clientes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>