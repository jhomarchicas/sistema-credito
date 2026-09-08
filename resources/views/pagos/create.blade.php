<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Nuevo Abono / Pago</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('pagos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Seleccionar Crédito Pendiente *</label>
                        <select name="credito_id" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">-- Seleccione un crédito activo/vencido --</option>
                            @foreach($creditos as $c)
                                <option value="{{ $c->id }}" {{ (old('credito_id', $credito_id) == $c->id) ? 'selected' : '' }}>
                                    Crédito #{{ $c->id }} - {{ $c->cliente->nombres }} {{ $c->cliente->apellidos }} (Saldo Pendiente: ${{ number_format($c->saldo, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('credito_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monto a Abonar ($) *</label>
                            <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('monto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Pago *</label>
                            <input type="date" name="fecha_pago" value="{{ old('fecha_pago', date('Y-m-d')) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('fecha_pago') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">N° de Referencia / Comprobante (Opcional)</label>
                        <input type="text" name="referencia" value="{{ old('referencia') }}" placeholder="Ej: Depósito #123456" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                        @error('referencia') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Observaciones (Opcional)</label>
                        <textarea name="observaciones" rows="2" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('pagos.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-bold">Procesar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>