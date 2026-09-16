<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Gestión de Créditos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

<div class="min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <header class="w-full bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">

            {{-- Logo / Nombre --}}
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 6v12m3-9.5C15 7.12 13.66 6 12 6S9 7.12 9 8.5 10.34 11 12 11s3 1.12 3 2.5S13.66 16 12 16s-3-1.12-3-2.5"/>
                    </svg>
                </div>

                <div>
                    <h1 class="font-bold text-lg text-slate-900 leading-tight">
                        Gestión de Créditos
                    </h1>

                    <p class="text-xs text-slate-500">
                        Sistema administrativo
                    </p>
                </div>
            </div>

            {{-- Botón superior --}}
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5
                          rounded-lg bg-blue-600 text-sm font-semibold text-white
                          hover:bg-blue-700 shadow-sm hover:shadow-md
                          transition duration-200">

                    Dashboard

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5
                          rounded-lg border border-slate-300 bg-white
                          text-sm font-semibold text-slate-700
                          hover:bg-slate-50 hover:border-slate-400
                          transition duration-200">

                    Iniciar sesión
                </a>
            @endauth

        </div>
    </header>


    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-1 flex items-center">

        <div class="max-w-7xl mx-auto w-full px-6 lg:px-8 py-16 lg:py-20">

            <div class="grid lg:grid-cols-2 gap-14 lg:gap-20 items-center">

                {{-- LADO IZQUIERDO --}}
                <div>

                    <div class="inline-flex items-center gap-2 px-3 py-1.5
                                bg-blue-50 text-blue-700 rounded-full
                                text-sm font-medium mb-6">

                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span>

                        Plataforma de administración
                    </div>


                    <h2 class="text-4xl sm:text-5xl lg:text-6xl
                               font-bold tracking-tight text-slate-900
                               leading-[1.1]">

                        Gestiona tus créditos

                        <span class="text-blue-600">
                            de forma sencilla.
                        </span>

                    </h2>


                    <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-xl">
                        Administra clientes, créditos, cuotas y pagos desde
                        una plataforma centralizada, organizada y fácil de utilizar.
                    </p>


                    {{-- BOTÓN PRINCIPAL --}}
                    <div class="mt-9 flex flex-col sm:flex-row gap-4">

                        @auth

                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center justify-center gap-2
                                      px-7 py-3.5 rounded-xl bg-blue-600
                                      text-white font-semibold shadow-sm
                                      hover:bg-blue-700 hover:shadow-md
                                      transition duration-200">

                                Ir al Dashboard

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 5l7 7-7 7"/>

                                </svg>

                            </a>

                        @else

                            <a href="{{ route('login') }}"
                               class="inline-flex items-center justify-center gap-2
                                      px-7 py-3.5 rounded-xl bg-blue-600
                                      text-white font-semibold shadow-sm
                                      hover:bg-blue-700 hover:shadow-md
                                      transition duration-200">

                                Ingresar al sistema

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 5l7 7-7 7"/>

                                </svg>

                            </a>

                        @endauth

                    </div>


                    {{-- CARACTERÍSTICAS --}}
                    <div class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-sm text-slate-600">

                        <div class="flex items-center gap-2">

                            <svg class="w-5 h-5 text-green-500"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>

                            </svg>

                            Control de créditos
                        </div>


                        <div class="flex items-center gap-2">

                            <svg class="w-5 h-5 text-green-500"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>

                            </svg>

                            Registro de pagos
                        </div>


                        <div class="flex items-center gap-2">

                            <svg class="w-5 h-5 text-green-500"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>

                            </svg>

                            Gestión de clientes
                        </div>

                    </div>

                </div>


                {{-- LADO DERECHO --}}
                <div class="relative">

                    {{-- Fondo decorativo --}}
                    <div class="absolute -inset-6 bg-blue-100/60
                                rounded-[2.5rem] blur-3xl">
                    </div>


                    {{-- Tarjeta principal --}}
                    <div class="relative bg-white rounded-3xl
                                border border-slate-200 shadow-xl
                                shadow-slate-200/70 p-7 sm:p-9">

                        <div class="flex items-center justify-between mb-8">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Panel administrativo
                                </p>

                                <h3 class="text-xl font-bold text-slate-900 mt-1">
                                    Gestión financiera
                                </h3>

                            </div>


                            <div class="w-12 h-12 rounded-xl bg-blue-50
                                        flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M3 10h18M7 15h1m4 0h2m-9 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>

                                </svg>

                            </div>

                        </div>


                        {{-- TARJETAS --}}
                        <div class="grid grid-cols-2 gap-4">

                            {{-- Créditos --}}
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">

                                <div class="w-10 h-10 bg-blue-100 rounded-lg
                                            flex items-center justify-center mb-4">

                                    <svg class="w-5 h-5 text-blue-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M17 20h5V4H2v16h5m10 0v-6H7v6m10 0H7"/>

                                    </svg>

                                </div>

                                <p class="font-semibold text-slate-800">
                                    Créditos
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Control y seguimiento
                                </p>

                            </div>


                            {{-- Pagos --}}
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">

                                <div class="w-10 h-10 bg-green-100 rounded-lg
                                            flex items-center justify-center mb-4">

                                    <svg class="w-5 h-5 text-green-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 10v2"/>

                                    </svg>

                                </div>

                                <p class="font-semibold text-slate-800">
                                    Pagos
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Registro de cuotas
                                </p>

                            </div>


                            {{-- Clientes --}}
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">

                                <div class="w-10 h-10 bg-violet-100 rounded-lg
                                            flex items-center justify-center mb-4">

                                    <svg class="w-5 h-5 text-violet-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857"/>

                                    </svg>

                                </div>

                                <p class="font-semibold text-slate-800">
                                    Clientes
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Información centralizada
                                </p>

                            </div>


                            {{-- Reportes --}}
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">

                                <div class="w-10 h-10 bg-amber-100 rounded-lg
                                            flex items-center justify-center mb-4">

                                    <svg class="w-5 h-5 text-amber-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 17v-6m4 6V7m4 10v-3M5 20h14"/>

                                    </svg>

                                </div>

                                <p class="font-semibold text-slate-800">
                                    Reportes
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Consulta de información
                                </p>

                            </div>

                        </div>


                        {{-- Indicador --}}
                        <div class="mt-6 pt-6 border-t border-slate-100
                                    flex items-center justify-between">

                            <div class="flex items-center gap-2">

                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="absolute inline-flex h-full w-full
                                                 rounded-full bg-green-400 opacity-50">
                                    </span>

                                    <span class="relative inline-flex rounded-full
                                                 h-2.5 w-2.5 bg-green-500">
                                    </span>
                                </span>

                                <span class="text-sm text-slate-500">
                                    Sistema disponible
                                </span>

                            </div>

                            <span class="text-xs font-medium text-slate-400">
                                Gestión de Créditos
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>


    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5
                    flex flex-col sm:flex-row items-center justify-between
                    gap-2 text-sm text-slate-500">

            <p>
                © {{ date('Y') }} Sistema de Gestión de Créditos
            </p>

            <p>
                Administración segura y eficiente
            </p>

        </div>

    </footer>

</div>

</body>
</html>