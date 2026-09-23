<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nuevo Abono / Pago
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form
                    action="{{ route('pagos.store') }}"
                    method="POST"
                    class="space-y-6"
                    id="pagoForm"
                >
                    @csrf

                    <!-- Crédito -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Seleccionar Crédito Pendiente *
                        </label>

                        <select
                            name="credito_id"
                            id="credito_id"
                            required
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                        >
                            <option value="">
                                -- Seleccione un crédito activo/vencido --
                            </option>

                            @foreach($creditos as $c)
                                <option
                                    value="{{ $c->id }}"
                                    data-cliente="{{ $c->cliente->nombres }} {{ $c->cliente->apellidos }}"
                                    data-saldo="{{ (float) $c->saldo }}"
                                    data-cuota="{{ (float) $c->valor_cuota }}"
                                    data-minimo="{{ (float) $c->pago_minimo }}"
                                    data-final="{{ $c->es_ultimo_pago ? '1' : '0' }}"
                                    {{ old('credito_id', $credito_id) == $c->id ? 'selected' : '' }}
                                >
                                    Crédito #{{ $c->id }}
                                    -
                                    {{ $c->cliente->nombres }}
                                    {{ $c->cliente->apellidos }}
                                    -
                                    Saldo: ${{ number_format($c->saldo, 2) }}
                                </option>
                            @endforeach
                        </select>

                        @error('credito_id')
                            <span class="text-red-500 text-xs">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Información del crédito -->
                    <div
                        id="infoCredito"
                        class="hidden border border-gray-200 rounded-lg overflow-hidden"
                    >
                        <div class="bg-gray-50 px-5 py-4 border-b border-gray-200">
                            <p class="text-xs text-gray-500 uppercase font-bold">
                                Crédito seleccionado
                            </p>

                            <p
                                id="clienteCredito"
                                class="font-bold text-gray-800 mt-1"
                            >
                                -
                            </p>
                        </div>

                        <div class="p-5">

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                                <!-- Saldo -->
                                <div>
                                    <p class="text-xs text-gray-500">
                                        Saldo pendiente
                                    </p>

                                    <p
                                        id="saldoCredito"
                                        class="text-xl font-bold text-red-600 mt-1"
                                    >
                                        $0.00
                                    </p>
                                </div>

                                <!-- Cuota -->
                                <div>
                                    <p class="text-xs text-gray-500">
                                        Cuota establecida
                                    </p>

                                    <p
                                        id="cuotaCredito"
                                        class="text-xl font-bold text-gray-800 mt-1"
                                    >
                                        $0.00
                                    </p>
                                </div>

                                <!-- Mínimo -->
                                <div>
                                    <p
                                        id="tituloMinimo"
                                        class="text-xs text-gray-500"
                                    >
                                        Pago mínimo
                                    </p>

                                    <p
                                        id="minimoCredito"
                                        class="text-xl font-bold text-indigo-600 mt-1"
                                    >
                                        $0.00
                                    </p>
                                </div>

                            </div>

                            <!-- Mensaje normal -->
                            <div
                                id="mensajeNormal"
                                class="mt-5 bg-indigo-50 border border-indigo-200 rounded-md p-3 text-sm text-indigo-700"
                            >
                                Puede realizar un pago mayor a la cuota para reducir
                                el saldo del crédito más rápidamente.
                            </div>

                            <!-- Mensaje pago final -->
                            <div
                                id="mensajeFinal"
                                class="hidden mt-5 bg-green-50 border border-green-200 rounded-md p-3"
                            >
                                <p class="text-sm font-bold text-green-700">
                                    Pago final
                                </p>

                                <p class="text-xs text-green-600 mt-1">
                                    El saldo pendiente es menor o igual a la cuota
                                    normal. Debe pagar exactamente el saldo restante
                                    para liquidar el crédito.
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Pago -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Monto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Monto a Pagar ($) *
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="monto"
                                id="monto"
                                value="{{ old('monto') }}"
                                required
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                            >

                            <p
                                id="ayudaMonto"
                                class="mt-1 text-xs text-gray-500"
                            >
                                Seleccione primero un crédito.
                            </p>

                            @error('monto')
                                <span class="block text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Fecha -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Fecha de Pago *
                            </label>

                            <input
                                type="date"
                                name="fecha_pago"
                                value="{{ old('fecha_pago', date('Y-m-d')) }}"
                                required
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                            >

                            @error('fecha_pago')
                                <span class="text-red-500 text-xs">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>

                    <!-- Referencia -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            N° de Referencia / Comprobante
                            <span class="text-gray-400">(Opcional)</span>
                        </label>

                        <input
                            type="text"
                            name="referencia"
                            value="{{ old('referencia') }}"
                            placeholder="Ej: Depósito #123456"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                        >

                        @error('referencia')
                            <span class="text-red-500 text-xs">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Observaciones
                            <span class="text-gray-400">(Opcional)</span>
                        </label>

                        <textarea
                            name="observaciones"
                            rows="3"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                        >{{ old('observaciones') }}</textarea>

                        @error('observaciones')
                            <span class="text-red-500 text-xs">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-2 pt-2">

                        <a
                            href="{{ route('pagos.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-bold"
                        >
                            Procesar Pago
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const creditoSelect = document.getElementById('credito_id');
            const montoInput = document.getElementById('monto');

            const infoCredito = document.getElementById('infoCredito');

            const clienteCredito = document.getElementById('clienteCredito');
            const saldoCredito = document.getElementById('saldoCredito');
            const cuotaCredito = document.getElementById('cuotaCredito');
            const minimoCredito = document.getElementById('minimoCredito');

            const tituloMinimo = document.getElementById('tituloMinimo');

            const mensajeNormal = document.getElementById('mensajeNormal');
            const mensajeFinal = document.getElementById('mensajeFinal');

            const ayudaMonto = document.getElementById('ayudaMonto');

            function dinero(valor) {
                return '$' + valor.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function actualizarCredito() {

                const opcion = creditoSelect.options[
                    creditoSelect.selectedIndex
                ];

                if (!opcion || !opcion.value) {

                    infoCredito.classList.add('hidden');

                    montoInput.removeAttribute('min');
                    montoInput.removeAttribute('max');

                    ayudaMonto.textContent =
                        'Seleccione primero un crédito.';

                    return;
                }

                const cliente = opcion.dataset.cliente;

                const saldo =
                    parseFloat(opcion.dataset.saldo) || 0;

                const cuota =
                    parseFloat(opcion.dataset.cuota) || 0;

                const minimo =
                    parseFloat(opcion.dataset.minimo) || 0;

                const esFinal =
                    opcion.dataset.final === '1';

                infoCredito.classList.remove('hidden');

                clienteCredito.textContent = cliente;

                saldoCredito.textContent = dinero(saldo);

                cuotaCredito.textContent = dinero(cuota);

                minimoCredito.textContent = dinero(minimo);

                /*
                 * Límites visuales del input.
                 *
                 * El backend vuelve a comprobarlos,
                 * por lo que no dependemos del navegador.
                 */
                montoInput.min = minimo.toFixed(2);
                montoInput.max = saldo.toFixed(2);

                if (esFinal) {

                    tituloMinimo.textContent =
                        'Pago final requerido';

                    mensajeNormal.classList.add('hidden');
                    mensajeFinal.classList.remove('hidden');

                    ayudaMonto.textContent =
                        'Debe pagar exactamente '
                        + dinero(saldo)
                        + ' para liquidar el crédito.';

                    /*
                     * En el último pago colocamos automáticamente
                     * el saldo exacto.
                     */
                    montoInput.value = saldo.toFixed(2);

                    /*
                     * Como el último pago debe ser exacto,
                     * establecemos mínimo y máximo al mismo valor.
                     */
                    montoInput.min = saldo.toFixed(2);
                    montoInput.max = saldo.toFixed(2);

                } else {

                    tituloMinimo.textContent =
                        'Pago mínimo';

                    mensajeNormal.classList.remove('hidden');
                    mensajeFinal.classList.add('hidden');

                    ayudaMonto.textContent =
                        'Pago mínimo: '
                        + dinero(minimo)
                        + '. Puede pagar hasta '
                        + dinero(saldo)
                        + '.';

                    /*
                     * Si cambia de un crédito final a otro normal,
                     * limpiamos el monto para evitar conservar
                     * el valor del crédito anterior.
                     */
                    if (
                        montoInput.value &&
                        parseFloat(montoInput.value) > saldo
                    ) {
                        montoInput.value = '';
                    }
                }
            }

            creditoSelect.addEventListener(
                'change',
                actualizarCredito
            );

            actualizarCredito();

        });
    </script>

</x-app-layout>