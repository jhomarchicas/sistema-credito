<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Otorgar Nuevo Crédito
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form
                    action="{{ route('creditos.store') }}"
                    method="POST"
                    class="space-y-6"
                    id="creditoForm"
                >
                    @csrf

                    <!-- Cliente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Seleccionar Cliente *
                        </label>

                        <select
                            name="cliente_id"
                            required
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                        >
                            <option value="">
                                -- Seleccione un cliente activo --
                            </option>

                            @foreach($clientes as $cliente)
                                <option
                                    value="{{ $cliente->id }}"
                                    {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}
                                >
                                    {{ $cliente->documento_identidad }}
                                    -
                                    {{ $cliente->nombres }}
                                    {{ $cliente->apellidos }}
                                </option>
                            @endforeach
                        </select>

                        @error('cliente_id')
                            <span class="text-red-500 text-xs">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Datos del crédito -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Monto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Monto del Crédito ($) *
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="1"
                                name="monto"
                                id="monto"
                                value="{{ old('monto') }}"
                                required
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                            >

                            @error('monto')
                                <span class="text-red-500 text-xs">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Interés -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tasa de Interés (%) *
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                name="tasa_interes"
                                id="tasa_interes"
                                value="{{ old('tasa_interes', 10) }}"
                                required
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                            >

                            @error('tasa_interes')
                                <span class="text-red-500 text-xs">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Cantidad de cuotas -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Cantidad de Cuotas *
                            </label>

                            <input
                                type="number"
                                min="1"
                                step="1"
                                name="plazo"
                                id="plazo"
                                value="{{ old('plazo', 12) }}"
                                required
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                            >

                            <p class="mt-1 text-xs text-gray-500">
                                Cada cuota corresponde a un período mensual.
                            </p>

                            @error('plazo')
                                <span class="text-red-500 text-xs">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Fecha -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Fecha de Otorgamiento *
                            </label>

                            <input
                                type="date"
                                name="fecha_otorgamiento"
                                value="{{ old('fecha_otorgamiento', date('Y-m-d')) }}"
                                required
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm"
                            >

                            @error('fecha_otorgamiento')
                                <span class="text-red-500 text-xs">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>

                    <!-- Resumen -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">

                        <h3 class="text-sm font-bold text-gray-800 mb-4">
                            Resumen del Crédito
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                            <div>
                                <p class="text-xs text-gray-500">
                                    Monto solicitado
                                </p>

                                <p
                                    id="resumenMonto"
                                    class="font-bold text-gray-800"
                                >
                                    $0.00
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    Interés
                                </p>

                                <p
                                    id="resumenInteres"
                                    class="font-bold text-gray-800"
                                >
                                    $0.00
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    Total a pagar
                                </p>

                                <p
                                    id="resumenTotal"
                                    class="font-bold text-gray-800"
                                >
                                    $0.00
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    Cuotas
                                </p>

                                <p
                                    id="resumenCuotas"
                                    class="font-bold text-gray-800"
                                >
                                    0
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    Cuota aproximada
                                </p>

                                <p
                                    id="resumenValorCuota"
                                    class="font-bold text-indigo-600 text-lg"
                                >
                                    $0.00
                                </p>
                            </div>

                        </div>

                        <p class="mt-4 text-xs text-gray-500">
                            La última cuota puede variar algunos centavos debido
                            al redondeo del valor de las cuotas.
                        </p>

                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-2 pt-2">

                        <a
                            href="{{ route('creditos.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-bold"
                        >
                            Generar Crédito
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const montoInput = document.getElementById('monto');
            const tasaInput = document.getElementById('tasa_interes');
            const plazoInput = document.getElementById('plazo');

            const resumenMonto = document.getElementById('resumenMonto');
            const resumenInteres = document.getElementById('resumenInteres');
            const resumenTotal = document.getElementById('resumenTotal');
            const resumenCuotas = document.getElementById('resumenCuotas');
            const resumenValorCuota = document.getElementById('resumenValorCuota');

            function dinero(valor) {
                return '$' + valor.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function calcularCredito() {

                const monto = parseFloat(montoInput.value) || 0;
                const tasa = parseFloat(tasaInput.value) || 0;
                const cuotas = parseInt(plazoInput.value) || 0;

                const interes = monto * (tasa / 100);
                const total = monto + interes;

                let valorCuota = 0;

                if (cuotas > 0) {
                    valorCuota = total / cuotas;
                }

                resumenMonto.textContent = dinero(monto);
                resumenInteres.textContent = dinero(interes);
                resumenTotal.textContent = dinero(total);
                resumenCuotas.textContent = cuotas;
                resumenValorCuota.textContent = dinero(valorCuota);
            }

            montoInput.addEventListener('input', calcularCredito);
            tasaInput.addEventListener('input', calcularCredito);
            plazoInput.addEventListener('input', calcularCredito);

            calcularCredito();
        });
    </script>

</x-app-layout>