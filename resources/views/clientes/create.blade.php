<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Nuevo Cliente</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombres *</label>
                            <input type="text" name="nombres" value="{{ old('nombres') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('nombres') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellidos *</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('apellidos') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Documento de Identidad *</label>
                            <input type="text" name="documento_identidad" value="{{ old('documento_identidad') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            @error('documento_identidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <input type="email" name="correo" value="{{ old('correo') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado *</label>
                            <select name="estado" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <textarea name="direccion" rows="3" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">{{ old('direccion') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('clientes.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-bold">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>