<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    SanCrisApp
                </h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-white/10 text-emerald-300 rounded-full text-[11px] font-medium">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                        Portal Ciudadano
                    </span>
                    <span class="text-xs text-gray-400">•</span>
                    <span class="text-xs text-gray-400">Bienvenido, {{ auth()->user()->name }}</span>
                </div>
            </div>

            {{-- Selector de rol visual --}}
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400">Vista:</span>
                <div class="flex bg-white/10 rounded-lg p-1">
                    <button class="px-3 py-1 text-xs font-bold rounded-md bg-white text-gray-900 shadow-sm">Ciudadano</button>
                    <button class="px-3 py-1 text-xs font-bold text-gray-300 hover:text-white">Admin</button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">

            {{-- ================= HERO / BIENVENIDA ================= --}}
            <div class="relative bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                {{-- Banda decorativa con colores de la ciudad --}}
                <div class="h-2 flex">
                    <div class="w-1/3 bg-emerald-600"></div>
                    <div class="w-1/3 bg-white"></div>
                    <div class="w-1/3 bg-red-600"></div>
                </div>
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                                San Cristóbal
                            </h1>
                            <p class="text-gray-500 mt-2 max-w-2xl">
                                Información útil al alcance de tu mano. Farmacias de turno, horarios de colectivos,
                                comercios locales y servicios esenciales.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-emerald-600">24</div>
                                <div class="text-xs text-gray-400">NEGOCIOS</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-600">8</div>
                                <div class="text-xs text-gray-400">FARMACIAS</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-700">12</div>
                                <div class="text-xs text-gray-400">SERVICIOS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= SERVICIOS DE EMERGENCIA (DESTACADO) ================= --}}
            <div class="bg-red-50 rounded-2xl p-5 border border-red-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Emergencias</h3>
                            <p class="text-sm text-gray-600">En caso de emergencia, comunícate al:</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-red-600">911</div>
                            <div class="text-[10px] text-gray-500 uppercase">Policía</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-red-600">107</div>
                            <div class="text-[10px] text-gray-500 uppercase">Emergencias Médicas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-red-600">100</div>
                            <div class="text-[10px] text-gray-500 uppercase">Bomberos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-gray-700">103</div>
                            <div class="text-[10px] text-gray-500 uppercase">Defensa Civil</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= FARMACIA DE TURNO (DESTACADO) ================= --}}
            <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Farmacia de Turno</h3>
                            <p class="text-sm text-gray-600">Atención las 24 horas</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="text-xl font-bold text-emerald-700">Farmacia Central</div>
                        <div class="text-xs text-gray-500">Av. San Martín 123 | Tel: 351 123-4567</div>
                        <div class="text-xs text-emerald-600 mt-1">🟢 Abierta ahora</div>
                    </div>
                </div>
            </div>

            {{-- ================= GRID DE SERVICIOS ================= --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Servicios Públicos</h3>
                    <a href="#" class="text-xs text-emerald-600 hover:underline">Ver todos →</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Colectivo --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Línea 5 - Centro</h4>
                                <p class="text-xs text-gray-500">05:00 a 23:00</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">Recorre todo el centro de la ciudad</p>
                    </div>
                    {{-- Colectivo 2 --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Línea 8 - Hospital</h4>
                                <p class="text-xs text-gray-500">06:00 a 22:00</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">Conexión directa al hospital municipal</p>
                    </div>
                    {{-- Taxi --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Radio Taxi San Cristóbal</h4>
                                <p class="text-xs text-gray-500">24 horas</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">📞 351 444-5555</p>
                    </div>
                    {{-- Remis --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Remis del Centro</h4>
                                <p class="text-xs text-gray-500">06:00 a 02:00</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">📞 351 666-7777</p>
                    </div>
                </div>
            </div>

            {{-- ================= NEGOCIOS DESTACADOS ================= --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Negocios Destacados</h3>
                    <a href="#" class="text-xs text-emerald-600 hover:underline">Ver todos →</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    {{-- Card Negocio 1 --}}
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition group">
                        <div class="h-1 flex">
                            <div class="w-1/3 bg-emerald-600"></div>
                            <div class="w-1/3 bg-white"></div>
                            <div class="w-1/3 bg-red-600"></div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 text-sm uppercase">Panadería La Estrella</h4>
                            <p class="text-xs text-gray-500 mt-1">Av. Trabajadores Ferroviarios 450</p>
                            <p class="text-xs text-gray-600 mt-2 line-clamp-2">Las mejores facturas y pan artesanal de San Cristóbal</p>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-xs text-emerald-600 font-medium">📞 0842-1001</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Activo</span>
                            </div>
                        </div>
                    </div>
                    {{-- Card Negocio 2 --}}
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition group">
                        <div class="h-1 flex">
                            <div class="w-1/3 bg-emerald-600"></div>
                            <div class="w-1/3 bg-white"></div>
                            <div class="w-1/3 bg-red-600"></div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 text-sm uppercase">Ferretería El Ferroviario</h4>
                            <p class="text-xs text-gray-500 mt-1">Belgrano 890</p>
                            <p class="text-xs text-gray-600 mt-2 line-clamp-2">Herramientas, pinturas y materiales de construcción</p>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-xs text-emerald-600 font-medium">📞 351 123-4567</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Activo</span>
                            </div>
                        </div>
                    </div>
                    {{-- Card Negocio 3 --}}
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition group">
                        <div class="h-1 flex">
                            <div class="w-1/3 bg-emerald-600"></div>
                            <div class="w-1/3 bg-white"></div>
                            <div class="w-1/3 bg-red-600"></div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 text-sm uppercase">Restobar El Encuentro</h4>
                            <p class="text-xs text-gray-500 mt-1">Pueyrredón 890</p>
                            <p class="text-xs text-gray-600 mt-2 line-clamp-2">Especialidad en minutas, pizzas y cervezas artesanales</p>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-xs text-emerald-600 font-medium">📞 3408-429999</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Activo</span>
                            </div>
                        </div>
                    </div>
                    {{-- Card Negocio 4 --}}
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition group">
                        <div class="h-1 flex">
                            <div class="w-1/3 bg-emerald-600"></div>
                            <div class="w-1/3 bg-white"></div>
                            <div class="w-1/3 bg-red-600"></div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 text-sm uppercase">Librería El Estudio</h4>
                            <p class="text-xs text-gray-500 mt-1">San Martín 567</p>
                            <p class="text-xs text-gray-600 mt-2 line-clamp-2">Artículos de librería, útiles escolares y oficina</p>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-xs text-emerald-600 font-medium">📞 351 987-6543</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">Inactivo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TELÉFONOS ÚTILES ================= --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">Teléfonos Útiles</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div class="text-center">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            </div>
                            <div class="text-xs font-bold text-gray-900">Hospital</div>
                            <div class="text-xs text-gray-500">351 444-1111</div>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="text-xs font-bold text-gray-900">Municipalidad</div>
                            <div class="text-xs text-gray-500">351 444-2222</div>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="text-xs font-bold text-gray-900">Defensa Civil</div>
                            <div class="text-xs text-gray-500">351 444-3333</div>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="text-xs font-bold text-gray-900">Tránsito</div>
                            <div class="text-xs text-gray-500">351 444-4444</div>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="text-xs font-bold text-gray-900">Atención al Vecino</div>
                            <div class="text-xs text-gray-500">0800-888-0000</div>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="text-xs font-bold text-gray-900">Protección Civil</div>
                            <div class="text-xs text-gray-500">351 444-5555</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= MAPA (placeholder) ================= --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900">Mapa de la Ciudad</h3>
                    <span class="text-xs text-gray-400">Negocios y servicios cercanos</span>
                </div>
                <div class="p-6">
                    <div class="bg-gray-100 rounded-xl h-64 flex items-center justify-center border border-gray-200">
                        <div class="text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <p class="text-sm text-gray-400">Mapa interactivo</p>
                            <p class="text-xs text-gray-300 mt-1">Ubicación de negocios y farmacias</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center py-6">
                <p class="text-xs text-gray-400 uppercase tracking-widest">
                    [ SanCrisApp | Portal Ciudadano de San Cristóbal ]
                </p>
                <div class="flex justify-center gap-2 mt-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span class="w-2 h-2 rounded-full bg-white border border-gray-300"></span>
                    <span class="w-2 h-2 rounded-full bg-red-600"></span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
