<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 print:hidden">

            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Comprobante de Pago #{{ $pago->id }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Crédito #{{ $pago->credito_id }}
                </p>
            </div>

            <div class="flex gap-2">

                <a
                    href="{{ route('pagos.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm py-2 px-4 rounded-md"
                >
                    Volver
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="bg-gray-800 hover:bg-black text-white text-sm py-2 px-4 rounded-md"
                >
                    Imprimir Recibo
                </button>

            </div>
        </div>
    </x-slot>

    <div class="py-12 print:py-0">

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 print:px-0">

            <div
                id="recibo"
                class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 print:shadow-none print:border-none print:rounded-none"
            >

                <!-- Encabezado -->
                <div class="text-center border-b border-gray-200 pb-5 mb-6">

                    <h1 class="text-2xl font-bold text-gray-800">
                        SISTEMA DE CRÉDITOS
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Recibo Oficial de Pago / Abono
                    </p>

                    <div class="mt-3">
                        <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-bold">
                            Recibo #{{ $pago->id }}
                        </span>
                    </div>

                </div>

                <!-- Cliente -->
                <div class="mb-6">

                    <h3 class="text-xs uppercase tracking-wide font-bold text-gray-500 mb-3">
                        Información del Cliente
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between gap-4 border-b border-gray-100 pb-2">
                            <span class="text-gray-500">
                                Cliente
                            </span>

                            <span class="font-bold text-gray-800 text-right">
                                {{ $pago->credito->cliente->nombres }}
                                {{ $pago->credito->cliente->apellidos }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4 border-b border-gray-100 pb-2">
                            <span class="text-gray-500">
                                Documento de Identidad
                            </span>

                            <span class="font-bold text-gray-800">
                                {{ $pago->credito->cliente->documento_identidad }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4 border-b border-gray-100 pb-2">
                            <span class="text-gray-500">
                                Crédito Asociado
                            </span>

                            <span class="font-bold text-gray-800">
                                #{{ $pago->credito_id }}
                            </span>
                        </div>

                    </div>

                </div>

                <!-- Pago -->
                <div class="mb-6">

                    <h3 class="text-xs uppercase tracking-wide font-bold text-gray-500 mb-3">
                        Información del Pago
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between gap-4 border-b border-gray-100 pb-2">
                            <span class="text-gray-500">
                                Fecha del Pago
                            </span>

                            <span class="font-bold text-gray-800">
                                {{ $pago->fecha_pago->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4 border-b border-gray-100 pb-2">
                            <span class="text-gray-500">
                                Referencia
                            </span>

                            <span class="font-bold text-gray-800">
                                {{ $pago->referencia ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4 border-b border-gray-100 pb-2">
                            <span class="text-gray-500">
                                Cuota Establecida
                            </span>

                            <span class="font-bold text-gray-800">
                                ${{ number_format($pago->credito->valor_cuota, 2) }}
                            </span>
                        </div>

                    </div>

                </div>

                <!-- Monto -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">

                    <div class="flex justify-between items-center gap-4">

                        <div>
                            <p class="text-sm font-bold text-gray-700">
                                Monto Abonado
                            </p>

                            @if($pago->monto > $pago->credito->valor_cuota)
                                <p class="text-xs text-gray-500 mt-1">
                                    Abono superior a la cuota establecida
                                </p>
                            @endif
                        </div>

                        <p class="text-2xl font-bold text-green-600">
                            ${{ number_format($pago->monto, 2) }}
                        </p>

                    </div>

                    <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between gap-4">

                        <span class="text-sm text-gray-500">
                            Saldo restante después de este pago
                        </span>

                        <span class="text-sm font-bold {{ ($pago->saldo_restante ?? $pago->credito->saldo) <= 0 ? 'text-green-600' : 'text-gray-800' }}">
                            ${{ number_format(
                                $pago->saldo_restante ?? $pago->credito->saldo,
                                2
                            ) }}
                        </span>

                    </div>

                </div>

                @if(($pago->saldo_restante ?? null) !== null && $pago->saldo_restante <= 0)

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-center">

                        <p class="font-bold text-green-700">
                            Crédito liquidado
                        </p>

                        <p class="text-xs text-green-600 mt-1">
                            Este pago canceló completamente el saldo pendiente del crédito.
                        </p>

                    </div>

                @endif

                <!-- Observaciones -->
                @if($pago->observaciones)

                    <div class="mb-8">

                        <h3 class="text-xs uppercase tracking-wide font-bold text-gray-500 mb-2">
                            Observaciones
                        </h3>

                        <div class="bg-gray-50 rounded-md p-3 text-sm text-gray-700">
                            {{ $pago->observaciones }}
                        </div>

                    </div>

                @endif

                <!-- Firmas -->
                <div class="mt-16 pt-8">

                    <div class="grid grid-cols-2 gap-12 text-center text-xs text-gray-500">

                        <div>
                            <div class="border-b border-gray-400 mb-2"></div>

                            <p>
                                Firma Gestor de Cobros
                            </p>
                        </div>

                        <div>
                            <div class="border-b border-gray-400 mb-2"></div>

                            <p>
                                Firma del Cliente
                            </p>
                        </div>

                    </div>

                </div>

                <!-- Pie -->
                <div class="mt-10 pt-4 border-t border-gray-100 text-center">

                    <p class="text-xs text-gray-400">
                        Comprobante correspondiente al pago
                        #{{ $pago->id }}
                        del crédito
                        #{{ $pago->credito_id }}.
                    </p>

                </div>

            </div>

        </div>
    </div>

    <style>
        @media print {

            body {
                background: white !important;
            }

            nav,
            aside,
            header,
            .print\:hidden {
                display: none !important;
            }

            #recibo {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 20px;
            }

            @page {
                margin: 12mm;
            }
        }
    </style>

</x-app-layout>