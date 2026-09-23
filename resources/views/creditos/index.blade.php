<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Créditos
            </h2>

            <a
                href="{{ route('creditos.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded"
            >
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
                <form
                    method="GET"
                    action="{{ route('creditos.index') }}"
                    class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4"
                >
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Buscar por cliente o documento..."
                        class="border-gray-300 rounded-md shadow-sm text-sm"
                    >

                    <select
                        name="estado"
                        class="border-gray-300 rounded-md shadow-sm text-sm"
                    >
                        <option value="">
                            -- Todos los estados --
                        </option>

                        <option
                            value="activo"
                            {{ $estado === 'activo' ? 'selected' : '' }}
                        >
                            Activo
                        </option>

                        <option
                            value="pagado"
                            {{ $estado === 'pagado' ? 'selected' : '' }}
                        >
                            Pagado
                        </option>

                        <option
                            value="vencido"
                            {{ $estado === 'vencido' ? 'selected' : '' }}
                        >
                            Vencido
                        </option>
                    </select>

                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-md text-sm font-medium w-full"
                        >
                            Filtrar
                        </button>

                        <a
                            href="{{ route('creditos.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium text-center"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    ID
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Cliente
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Total
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Cuotas
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Valor Cuota
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Saldo
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Vencimiento
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Estado
                                </th>

                                <th class="px-4 py-3 text-right">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse($creditos as $credito)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3 font-bold">
                                        #{{ $credito->id }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-800">
                                            {{ $credito->cliente->nombres }}
                                            {{ $credito->cliente->apellidos }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $credito->cliente->documento_identidad }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        ${{ number_format($credito->total_credito, 2) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="font-medium">
                                            {{ $credito->plazo }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        ${{ number_format($credito->valor_cuota, 2) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if($credito->saldo > 0)
                                            <span class="font-bold text-red-600">
                                                ${{ number_format($credito->saldo, 2) }}
                                            </span>
                                        @else
                                            <span class="font-bold text-green-600">
                                                $0.00
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $credito->fecha_vencimiento->format('d/m/Y') }}
                                    </td>

                                    <td class="px-4 py-3">

                                        @if($credito->estado === 'pagado')

                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                Pagado
                                            </span>

                                        @elseif($credito->estado === 'vencido')

                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                Vencido
                                            </span>

                                        @else

                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                Activo
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-4 py-3">

                                        <div class="flex justify-end items-center gap-3">

                                            <a
                                                href="{{ route('creditos.show', $credito) }}"
                                                class="text-blue-600 hover:text-blue-900 font-medium"
                                            >
                                                Detalles
                                            </a>

                                            @if(
                                                $credito->estado !== 'pagado'
                                                && $credito->saldo > 0
                                            )

                                                <a
                                                    href="{{ route('pagos.create', ['credito_id' => $credito->id]) }}"
                                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md text-xs font-bold whitespace-nowrap"
                                                >
                                                    Registrar pago
                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="9"
                                        class="px-4 py-8 text-center text-gray-500"
                                    >
                                        No hay registros de créditos.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $creditos->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>