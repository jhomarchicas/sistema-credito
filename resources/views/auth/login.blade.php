<x-guest-layout>

    <div
        x-data="{ showPassword: false }"
        class="w-full"
    >

        <!-- Volver al inicio -->
        <div class="mb-6">
            <a
                href="{{ url('/') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition"
            >
                <i class="bi bi-arrow-left"></i>
                Volver al inicio
            </a>
        </div>

        <!-- Encabezado -->
        <div class="text-center mb-8">

            <div class="mx-auto w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 mb-5">
                <i class="bi bi-wallet2 text-white text-3xl"></i>
            </div>

            <h1 class="text-2xl font-bold text-slate-800">
                Bienvenido
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                Ingresa tus credenciales para acceder al sistema
            </p>

        </div>

        <!-- Estado de sesión -->
        <x-auth-session-status
            class="mb-5"
            :status="session('status')"
        />

        <!-- Formulario -->
        <form
            method="POST"
            action="{{ route('login') }}"
            class="space-y-5"
        >
            @csrf

            <!-- Correo electrónico -->
            <div>

                <label
                    for="email"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Correo electrónico
                </label>

                <div class="relative">

                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="bi bi-envelope text-slate-400"></i>
                    </div>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="correo@ejemplo.com"
                        class="block w-full rounded-xl border-slate-300 pl-10 pr-4 py-3 text-sm text-slate-800
                               placeholder:text-slate-400
                               focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>

                @error('email')
                    <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Contraseña -->
            <div>

                <div class="flex items-center justify-between mb-2">

                    <label
                        for="password"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Contraseña
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition"
                        >
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                </div>

                <div class="relative">

                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="bi bi-lock text-slate-400"></i>
                    </div>

                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Ingresa tu contraseña"
                        class="block w-full rounded-xl border-slate-300 pl-10 pr-12 py-3 text-sm text-slate-800
                               placeholder:text-slate-400
                               focus:border-indigo-500 focus:ring-indigo-500"
                    >

                    <!-- Mostrar / ocultar contraseña -->
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 transition"
                        tabindex="-1"
                    >
                        <i
                            class="bi text-lg"
                            :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"
                        ></i>
                    </button>

                </div>

                @error('password')
                    <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Mantener sesión -->
            <div class="flex items-center">

                <label
                    for="remember_me"
                    class="inline-flex items-center cursor-pointer"
                >
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-slate-300 text-indigo-600 shadow-sm
                               focus:ring-indigo-500 focus:ring-offset-0"
                    >

                    <span class="ml-2 text-sm text-slate-600">
                        Mantener sesión iniciada
                    </span>
                </label>

            </div>

            <!-- Iniciar sesión -->
            <button
                type="submit"
                class="w-full flex items-center justify-center gap-2
                       bg-indigo-600 hover:bg-indigo-700
                       text-white font-bold text-sm
                       py-3 px-4 rounded-xl
                       shadow-sm shadow-indigo-200
                       transition duration-200"
            >
                <i class="bi bi-box-arrow-in-right text-lg"></i>
                Iniciar sesión
            </button>

        </form>

        <!-- Separador -->
        <div class="relative my-7">

            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>

            <div class="relative flex justify-center">
                <span class="bg-white px-3 text-xs text-slate-400">
                    Acceso seguro
                </span>
            </div>

        </div>

        <!-- Pie -->
        <div class="text-center">

            <div class="flex items-center justify-center gap-2 text-xs text-slate-400">
                <i class="bi bi-shield-check"></i>

                <span>
                    Sistema de Gestión de Créditos
                </span>
            </div>

        </div>

    </div>

</x-guest-layout>