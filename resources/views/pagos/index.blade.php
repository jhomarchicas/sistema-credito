
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Módulo de Pagos
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Historial de abonos y pagos realizados.
                </p>
            </div>

            <a href="{{ route('pagos.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded-md text-center">
                + Registrar Abono
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Pagos registrados
                    </p>

                    <p class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $pagos->total() }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $search ? 'Resultados de la búsqueda' : 'Total de registros' }}
                    </p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Recaudación de esta página
                    </p>

                    <p class="text-2xl font-bold text-green-600 mt-1">
                        ${{ number_format($pagos->sum('monto'), 2) }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Suma de los pagos visibles en el listado.
                    </p>
                </div>

            </div>

            <!-- Listado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Buscador -->
                <form method="GET"
                      action="{{ route('pagos.index') }}"
                      class="mb-6 flex flex-col sm:flex-row gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Buscar por cliente, documento o referencia..."
                        class="border-gray-300 rounded-md shadow-sm text-sm w-full sm:flex-1"
                    >

                    <button type="submit"
                            class="bg-gray-800 hover:bg-black text-white px-5 py-2 rounded-md text-sm font-medium">
                        Buscar
                    </button>

                    <a href="{{ route('pagos.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-md text-sm font-medium text-center">
                        Limpiar
                    </a>

                </form>

                <!-- Tabla -->
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 text-sm">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">ID Pago</th>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Crédito</th>
                                <th class="px-4 py-3 text-left">Fecha</th>
                                <th class="px-4 py-3 text-left">Monto Abonado</th>
                                <th class="px-4 py-3 text-left">Cuota Normal</th>
                                <th class="px-4 py-3 text-left">Referencia</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse($pagos as $pago)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3 font-bold text-gray-800">
                                        #{{ $pago->id }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <p class="font-medium text-gray-800">
                                            {{ $pago->credito->cliente->nombres }}
                                            {{ $pago->credito->cliente->apellidos }}
                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $pago->credito->cliente->documento_identidad }}
                                        </p>
                                    </td>

                                    <td class="px-4 py-3">
                                        <a href="{{ route('creditos.show', $pago->credito) }}"
                                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            #{{ $pago->credito_id }}
                                        </a>
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $pago->fecha_pago->format('d/m/Y') }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="font-bold text-green-600">
                                            ${{ number_format($pago->monto, 2) }}
                                        </span>

                                        @if($pago->monto > $pago->credito->valor_cuota)
                                            <p class="text-xs text-indigo-600 mt-1">
                                                Abono superior a la cuota
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        ${{ number_format($pago->credito->valor_cuota, 2) }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $pago->referencia ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('pagos.show', $pago) }}"
                                           class="inline-flex items-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3 py-2 rounded-md text-xs font-bold whitespace-nowrap">
                                            Ver recibo
                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8"
                                        class="px-4 py-10 text-center text-gray-500">
                                        No se encontraron registros de pagos.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>

                </div>

                <!-- Paginación -->
                <div class="mt-5">
                    {{ $pagos->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
