<nav
    x-data="{ open: false, userOpen: false }"
    class="sticky top-0 z-50 bg-white border-b border-slate-200 shadow-sm"
>
    @php
        $usuario = Auth::user();

        $puedeGestionar = $usuario->isSuperUsuario()
            || $usuario->isGestorCobros();
    @endphp

    <!-- Navegación principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- IZQUIERDA -->
            <div class="flex items-center">

                <!-- Marca -->
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 shrink-0"
                >
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-sm">
                        <i class="bi bi-wallet2 text-white text-xl"></i>
                    </div>

                    <div class="hidden lg:block leading-tight">
                        <p class="font-bold text-slate-800">
                            Gestión de Créditos
                        </p>

                        <p class="text-[11px] text-slate-500">
                            Sistema administrativo
                        </p>
                    </div>
                </a>

                <!-- Navegación escritorio -->
                <div class="hidden md:flex items-center gap-1 ml-8">

                    <!-- Dashboard -->
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                            {{ request()->routeIs('dashboard')
                                ? 'bg-indigo-50 text-indigo-700'
                                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    >
                        <i class="bi bi-grid-1x2-fill"></i>
                        Dashboard
                    </a>

                    <!-- Solo Super Usuario y Gestor de Cobros -->
                    @if($puedeGestionar)

                        <!-- Clientes -->
                        <a
                            href="{{ route('clientes.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                                {{ request()->routeIs('clientes.*')
                                    ? 'bg-indigo-50 text-indigo-700'
                                    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                        >
                            <i class="bi bi-people-fill"></i>
                            Clientes
                        </a>

                        <!-- Créditos -->
                        <a
                            href="{{ route('creditos.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                                {{ request()->routeIs('creditos.*')
                                    ? 'bg-indigo-50 text-indigo-700'
                                    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                        >
                            <i class="bi bi-cash-stack"></i>
                            Créditos
                        </a>

                        <!-- Pagos -->
                        <a
                            href="{{ route('pagos.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                                {{ request()->routeIs('pagos.*')
                                    ? 'bg-indigo-50 text-indigo-700'
                                    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                        >
                            <i class="bi bi-receipt"></i>
                            Pagos
                        </a>

                    @endif

                </div>

            </div>

            <!-- DERECHA -->
            <div class="flex items-center gap-3">

                <!-- Registrar pago -->
                @if($puedeGestionar)
                    <a
                        href="{{ route('pagos.create') }}"
                        class="hidden lg:flex items-center gap-2
                               bg-indigo-600 hover:bg-indigo-700
                               text-white px-4 py-2 rounded-lg
                               text-sm font-semibold transition shadow-sm"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Registrar pago
                    </a>
                @endif

                <!-- Usuario escritorio -->
                <div
                    class="relative hidden sm:block"
                    @click.outside="userOpen = false"
                >

                    <button
                        type="button"
                        @click="userOpen = !userOpen"
                        class="flex items-center gap-3 px-2 py-1.5 rounded-lg hover:bg-slate-100 transition"
                    >

                        <!-- Avatar -->
                        <div class="w-9 h-9 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($usuario->name, 0, 1)) }}
                        </div>

                        <!-- Usuario -->
                        <div class="hidden xl:block text-left leading-tight">

                            <p class="text-sm font-semibold text-slate-700 max-w-36 truncate">
                                {{ $usuario->name }}
                            </p>

                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $usuario->role }}
                            </p>

                        </div>

                        <i
                            class="bi bi-chevron-down text-xs text-slate-400 transition-transform"
                            :class="{ 'rotate-180': userOpen }"
                        ></i>

                    </button>

                    <!-- Dropdown -->
                    <div
                        x-cloak
                        x-show="userOpen"
                        x-transition
                        class="absolute right-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden"
                    >

                        <!-- Información del usuario -->
                        <div class="px-4 py-4 border-b border-slate-100">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="font-semibold text-sm text-slate-800 truncate">
                                        {{ $usuario->name }}
                                    </p>

                                    <p class="text-xs text-slate-500 truncate">
                                        {{ $usuario->email }}
                                    </p>

                                </div>

                            </div>

                            <!-- Rol -->
                            <div class="mt-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                    <i class="bi bi-person-badge"></i>
                                    {{ $usuario->role }}
                                </span>
                            </div>

                        </div>

                        <!-- Opciones -->
                        <div class="p-2">

                            <a
                                href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition"
                            >
                                <i class="bi bi-speedometer2 text-base"></i>
                                Dashboard
                            </a>

                            <a
                                href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition"
                            >
                                <i class="bi bi-person-circle text-base"></i>
                                Mi perfil
                            </a>

                        </div>

                        <!-- Cerrar sesión -->
                        <div class="border-t border-slate-100 p-2">

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition"
                                >
                                    <i class="bi bi-box-arrow-right text-base"></i>
                                    Cerrar sesión
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

                <!-- Botón menú móvil -->
                <button
                    type="button"
                    @click="open = !open"
                    class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 transition"
                >
                    <i
                        class="bi text-xl"
                        :class="open ? 'bi-x-lg' : 'bi-list'"
                    ></i>
                </button>

            </div>

        </div>

    </div>

    <!-- MENÚ MÓVIL -->
    <div
        x-cloak
        x-show="open"
        x-transition
        class="md:hidden border-t border-slate-200 bg-white"
    >

        <!-- Enlaces -->
        <div class="px-4 py-4 space-y-1">

            <!-- Dashboard -->
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-100' }}"
            >
                <i class="bi bi-grid-1x2-fill w-5"></i>
                Dashboard
            </a>

            @if($puedeGestionar)

                <!-- Clientes -->
                <a
                    href="{{ route('clientes.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('clientes.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    <i class="bi bi-people-fill w-5"></i>
                    Clientes
                </a>

                <!-- Créditos -->
                <a
                    href="{{ route('creditos.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('creditos.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    <i class="bi bi-cash-stack w-5"></i>
                    Créditos
                </a>

                <!-- Pagos -->
                <a
                    href="{{ route('pagos.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('pagos.*')
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    <i class="bi bi-receipt w-5"></i>
                    Pagos
                </a>

                <!-- Registrar pago -->
                <a
                    href="{{ route('pagos.create') }}"
                    class="flex items-center justify-center gap-2 mt-3
                           bg-indigo-600 hover:bg-indigo-700
                           text-white px-4 py-3 rounded-lg
                           text-sm font-bold transition"
                >
                    <i class="bi bi-plus-circle"></i>
                    Registrar Pago
                </a>

            @endif

        </div>

        <!-- Usuario móvil -->
        <div class="border-t border-slate-200 px-4 py-4">

            <div class="flex items-center gap-3 mb-4">

                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold">
                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                </div>

                <!-- Información -->
                <div class="min-w-0 flex-1">

                    <p class="font-semibold text-sm text-slate-800 truncate">
                        {{ $usuario->name }}
                    </p>

                    <p class="text-xs text-slate-500 truncate">
                        {{ $usuario->email }}
                    </p>

                    <p class="text-xs font-semibold text-indigo-600 mt-1">
                        {{ $usuario->role }}
                    </p>

                </div>

            </div>

            <div class="space-y-1">

                <!-- Perfil -->
                <a
                    href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-600 hover:bg-slate-100 transition"
                >
                    <i class="bi bi-person-circle"></i>
                    Mi perfil
                </a>

                <!-- Cerrar sesión -->
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-red-600 hover:bg-red-50 transition"
                    >
                        <i class="bi bi-box-arrow-right"></i>
                        Cerrar sesión
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>