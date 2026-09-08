<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Principal - Sistema de Créditos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Tarjeta de Bienvenida Modernizada -->
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl p-6 transition-all">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 tracking-tight">¡Bienvenido(a), {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-500 mt-1">Resumen general y accesos rápidos a tu cuenta.</p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <div class="flex items-center gap-2">
                            <!-- Icono Correo -->
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium text-gray-700">{{ Auth::user()->email }}</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <div class="flex items-center gap-2">
                            <!-- Icono Rol -->
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos a Módulos (Super Usuario y Gestor) -->
            @if(Auth::user()->isSuperUsuario() || Auth::user()->isGestorCobros())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Módulo Clientes -->
                    <div class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-100 transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <!-- Icono Usuarios -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Módulo Clientes</h4>
                            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Registro, consulta, búsqueda e historial de clientes.</p>
                        </div>
                        <a href="{{ route('clientes.index') }}" class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 text-white text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-blue-700 active:bg-blue-800 transition shadow-sm">
                            <span>Gestionar Clientes</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <!-- Módulo Créditos -->
                    <div class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-100 transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <!-- Icono Tarjeta de Crédito -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Módulo Créditos</h4>
                            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Otorgamiento, cálculo de intereses y estados de crédito.</p>
                        </div>
                        <a href="{{ route('creditos.index') }}" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 text-white text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-emerald-700 active:bg-emerald-800 transition shadow-sm">
                            <span>Gestionar Créditos</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <!-- Módulo Pagos -->
                    <div class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-100 transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <!-- Icono Billetes / Pagos -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Módulo Pagos</h4>
                            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Registro de abonos, control de saldos y comprobantes.</p>
                        </div>
                        <a href="{{ route('pagos.index') }}" class="w-full inline-flex items-center justify-center gap-2 bg-purple-600 text-white text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-purple-700 active:bg-purple-800 transition shadow-sm">
                            <span>Gestionar Pagos</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                </div>
            @endif

            <!-- Vista para Clientes -->

            @if(Auth::user()->isCliente())
                <div class="space-y-6">
                    <!-- Encabezado de la sección -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">Estado de mis Créditos</h4>
                        </div>
                        <p class="text-gray-500 text-sm ml-10">Consulta aquí el resumen general de tus créditos y abonos realizados.</p>
                    </div>
            
                    @if($cliente && $cliente->creditos->count() > 0)
                        <!-- Listado de Créditos -->
                        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl p-6">
                            <h5 class="text-md font-bold text-gray-800 mb-4">Créditos Registrados</h5>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left">N° Crédito</th>
                                            <th class="px-4 py-3 text-left">Monto Solicitado</th>
                                            <th class="px-4 py-3 text-left">Total c/ Interés</th>
                                            <th class="px-4 py-3 text-left">Saldo Pendiente</th>
                                            <th class="px-4 py-3 text-left">Fecha Vencimiento</th>
                                            <th class="px-4 py-3 text-left">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($cliente->creditos as $credito)
                                            <tr>
                                                <td class="px-4 py-3 font-bold">#{{ $credito->id }}</td>
                                                <td class="px-4 py-3">${{ number_format($credito->monto, 2) }}</td>
                                                <td class="px-4 py-3">${{ number_format($credito->total_credito, 2) }}</td>
                                                <td class="px-4 py-3 font-bold text-red-600">${{ number_format($credito->saldo, 2) }}</td>
                                                <td class="px-4 py-3">{{ $credito->fecha_vencimiento->format('d/m/Y') }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2.5 py-1 text-xs rounded-full font-semibold {{ $credito->estado === 'pagado' ? 'bg-green-100 text-green-800' : ($credito->estado === 'vencido' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                        {{ ucfirst($credito->estado) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
            
                        <!-- Histórico de Abonos / Pagos -->
                        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl p-6">
                            <h5 class="text-md font-bold text-gray-800 mb-4">Histórico de Mis Abonos</h5>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left">N° Pago</th>
                                            <th class="px-4 py-3 text-left">N° Crédito</th>
                                            <th class="px-4 py-3 text-left">Fecha Pago</th>
                                            <th class="px-4 py-3 text-left">Monto Abonado</th>
                                            <th class="px-4 py-3 text-left">Referencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @php $tienePagos = false; @endphp
                                        @foreach($cliente->creditos as $credito)
                                            @foreach($credito->pagos as $pago)
                                                @php $tienePagos = true; @endphp
                                                <tr>
                                                    <td class="px-4 py-3 font-bold">#{{ $pago->id }}</td>
                                                    <td class="px-4 py-3">#{{ $credito->id }}</td>
                                                    <td class="px-4 py-3">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                                    <td class="px-4 py-3 font-bold text-green-600">${{ number_format($pago->monto, 2) }}</td>
                                                    <td class="px-4 py-3">{{ $pago->referencia ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
            
                                        @if(!$tienePagos)
                                            <tr>
                                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">Aún no se han registrado abonos a tus créditos.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center text-gray-500">
                            Actualmente no tienes créditos registrados en el sistema.
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>