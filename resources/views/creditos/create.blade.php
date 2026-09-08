<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Otorgar Nuevo Crédito</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('creditos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Seleccionar Cliente *</label>
                        <select name="cliente_id" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">-- Seleccione un cliente activo --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->documento_identidad }} - {{ $cliente->nombres }} {{ $cliente->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monto del Crédito ($) *</label>
                            <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('monto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tasa de Interés (%) *</label>
                            <input type="number" step="0.01" name="tasa_interes" value="{{ old('tasa_interes', 10) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('tasa_interes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Plazo (Meses) *</label>
                            <input type="number" name="plazo" value="{{ old('plazo', 12) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('plazo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Otorgamiento *</label>
                            <input type="date" name="fecha_otorgamiento" value="{{ old('fecha_otorgamiento', date('Y-m-d')) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('fecha_otorgamiento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('creditos.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-bold">Generar Crédito</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>