<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detalle del Crédito #{{ $credito->id }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $credito->cliente->nombres }} {{ $credito->cliente->apellidos }}
                </p>
            </div>

            @if($credito->estado !== 'pagado' && $credito->saldo > 0)
                <a
                    href="{{ route('pagos.create', ['credito_id' => $credito->id]) }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded-md"
                >
                    + Registrar Pago
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Resumen principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Total del Crédito
                    </p>

                    <p class="text-2xl font-bold text-gray-800 mt-1">
                        ${{ number_format($credito->total_credito, 2) }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Monto base:
                        ${{ number_format($credito->monto, 2) }}
                    </p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Total Pagado
                    </p>

                    <p class="text-2xl font-bold text-green-600 mt-1">
                        ${{ number_format($credito->total_pagado, 2) }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ number_format($credito->porcentaje_pagado, 2) }}%
                        del crédito
                    </p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Saldo Pendiente
                    </p>

                    <p class="text-2xl font-bold {{ $credito->saldo > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                        ${{ number_format($credito->saldo, 2) }}
                    </p>

                    @if($credito->saldo <= 0)
                        <p class="text-xs text-green-600 mt-1 font-medium">
                            Crédito completamente pagado
                        </p>
                    @else
                        <p class="text-xs text-gray-500 mt-1">
                            Pendiente por cancelar
                        </p>
                    @endif
                </div>

                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Cuota Establecida
                    </p>

                    <p class="text-2xl font-bold text-indigo-600 mt-1">
                        ${{ number_format($credito->valor_cuota, 2) }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Plan de {{ $credito->plazo }} cuotas
                    </p>
                </div>

            </div>

            <!-- Progreso -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">

                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Progreso del Crédito
                        </h3>

                        <p class="text-sm text-gray-500">
                            Avance según el monto total pagado.
                        </p>
                    </div>

                    <span class="font-bold text-gray-800">
                        {{ number_format($credito->porcentaje_pagado, 2) }}%
                    </span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div
                        class="bg-green-500 h-3 rounded-full"
                        style="width: {{ min(100, $credito->porcentaje_pagado) }}%"
                    ></div>
                </div>

                <div class="flex justify-between mt-2 text-xs text-gray-500">
                    <span>
                        Pagado:
                        ${{ number_format($credito->total_pagado, 2) }}
                    </span>

                    <span>
                        Total:
                        ${{ number_format($credito->total_credito, 2) }}
                    </span>
                </div>

            </div>

            <!-- Información -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Datos generales -->
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100">

                    <h3 class="text-lg font-bold text-gray-800 mb-5">
                        Información del Crédito
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 text-sm">

                        <div>
                            <p class="text-xs text-gray-500">
                                Cliente
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $credito->cliente->nombres }}
                                {{ $credito->cliente->apellidos }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Documento
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $credito->cliente->documento_identidad }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Fecha de Otorgamiento
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Fecha de Vencimiento
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $credito->fecha_vencimiento->format('d/m/Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Monto Base
                            </p>

                            <p class="font-semibold text-gray-800">
                                ${{ number_format($credito->monto, 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Tasa de Interés
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ number_format($credito->tasa_interes, 2) }}%
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Cantidad de Cuotas
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $credito->plazo }} cuotas
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Estado
                            </p>

                            @if($credito->estado === 'pagado')
                                <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Pagado
                                </span>
                            @elseif($credito->estado === 'vencido')
                                <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                    Vencido
                                </span>
                            @else
                                <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    Activo
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- Próximo pago -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">

                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        Próximo Pago
                    </h3>

                    @if($credito->saldo <= 0)

                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="font-bold text-green-700">
                                Crédito pagado
                            </p>

                            <p class="text-sm text-green-600 mt-1">
                                El cliente no posee saldo pendiente en este crédito.
                            </p>
                        </div>

                    @else

                        @if($credito->es_ultimo_pago)

                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <p class="text-xs text-green-600 uppercase font-bold">
                                    Pago Final
                                </p>

                                <p class="text-2xl font-bold text-green-700 mt-1">
                                    ${{ number_format($credito->pago_minimo, 2) }}
                                </p>

                                <p class="text-xs text-green-600 mt-2">
                                    Este pago liquidará completamente el crédito.
                                </p>
                            </div>

                        @else

                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-4">
                                <p class="text-xs text-indigo-600 uppercase font-bold">
                                    Pago mínimo
                                </p>

                                <p class="text-2xl font-bold text-indigo-700 mt-1">
                                    ${{ number_format($credito->pago_minimo, 2) }}
                                </p>

                                <p class="text-xs text-indigo-600 mt-2">
                                    El cliente puede realizar un pago mayor para reducir su saldo.
                                </p>
                            </div>

                        @endif

                        <div class="space-y-2 text-sm">

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Cuota normal
                                </span>

                                <span class="font-semibold">
                                    ${{ number_format($credito->valor_cuota, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Saldo actual
                                </span>

                                <span class="font-semibold">
                                    ${{ number_format($credito->saldo, 2) }}
                                </span>
                            </div>

                        </div>

                        <a
                            href="{{ route('pagos.create', ['credito_id' => $credito->id]) }}"
                            class="block text-center mt-5 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md text-sm font-bold"
                        >
                            Registrar Pago
                        </a>

                    @endif

                </div>

            </div>

            <!-- Historial -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">

                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Historial de Pagos
                        </h3>

                        <p class="text-sm text-gray-500">
                            Abonos registrados para este crédito.
                        </p>
                    </div>

                    <span class="text-sm font-medium text-gray-500">
                        {{ $credito->pagos->count() }}
                        {{ $credito->pagos->count() === 1 ? 'pago' : 'pagos' }}
                    </span>
                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 text-sm">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    Pago
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Fecha
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Monto
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Referencia
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Observaciones
                                </th>

                                <th class="px-4 py-3 text-right">
                                    Comprobante
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse($credito->pagos as $pago)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3 font-bold">
                                        #{{ $pago->id }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $pago->fecha_pago->format('d/m/Y') }}
                                    </td>

                                    <td class="px-4 py-3 font-bold text-green-600">
                                        ${{ number_format($pago->monto, 2) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $pago->referencia ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $pago->observaciones ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <a
                                            href="{{ route('pagos.show', $pago) }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium"
                                        >
                                            Ver recibo
                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="6"
                                        class="px-4 py-8 text-center text-gray-500"
                                    >
                                        Aún no se han registrado pagos para este crédito.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>

                </div>

            </div>

            <!-- Volver -->
            <div>
                <a
                    href="{{ route('creditos.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 font-medium"
                >
                    ← Volver a créditos
                </a>
            </div>

        </div>
    </div>
</x-app-layout>