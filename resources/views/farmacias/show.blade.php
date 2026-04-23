<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    {{ $farmacia->nombre }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Detalle de farmacia de turno
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('farmacias.edit', $farmacia->id) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                      rounded-xl shadow hover:bg-gray-100 hover:shadow-md transition">
                    Editar
                </a>

                <a href="{{ route('farmacias.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                      rounded-xl shadow hover:bg-gray-100 hover:shadow-md transition">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 space-y-6">

            {{-- TARJETA DE INFORMACIÓN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Información de la farmacia</h3>
                            <p class="text-xs text-gray-500">Datos generales del comercio</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-start gap-6">
                        <div
                            class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if ($farmacia->logo_url)
                                <img src="{{ $farmacia->logo_url }}" class="w-full h-full object-cover" alt="logo">
                            @else
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $farmacia->nombre }}</h2>
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $farmacia->activo ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $farmacia->activo ? 'bg-green-600' : 'bg-gray-500' }}"></span>
                                    {{ $farmacia->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $farmacia->direccion ?? 'Sin dirección' }}</p>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $farmacia->telefono ?? 'No informado' }}</span>
                                </div>
                                @if ($farmacia->horario_apertura && $farmacia->horario_cierre)
                                    <div class="flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-gray-700">
                                            {{ \Carbon\Carbon::parse($farmacia->horario_apertura)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($farmacia->horario_cierre)->format('H:i') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($farmacia->descripcion)
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $farmacia->descripcion }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- DÍAS DE TURNO --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Días de turno</h3>
                            <p class="text-xs text-gray-500">Fechas en que esta farmacia está de turno</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if ($diasTurno->count())
                        <div class="space-y-3">
                            @foreach ($diasTurno as $item)
                                <div
                                    class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-emerald-50 transition group">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 transition">
                                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 capitalize">{{ $item['texto'] }}</p>
                                            <p class="text-xs text-gray-500">Día de turno completo</p>
                                        </div>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Turno
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">No hay días de turno registrados</p>
                            <p class="text-sm text-gray-400 mt-1">Esta farmacia no tiene fechas de turno asignadas</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
