<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            {{-- Título + descripción --}}
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Editar Rotación - {{ $farmacia->nombre }}
                </h2>
                <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider font-mono">
                    [ Modificación de día de turno ]
                </p>
            </div>

            {{-- Acción Volver --}}
            <a href="{{ route('farmacias.rotaciones.index', $farmacia->id) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                      rounded-xl shadow hover:bg-gray-100 transition font-mono">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-mono">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">

            {{-- Mensajes de error --}}
            @if ($errors->any())
                <div class="mb-6 bg-white border border-red-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-red-50 border-b border-red-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-red-800">Errores de validación</h4>
                            <p class="text-xs text-red-600">Por favor, corrige los siguientes errores:</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2 text-sm text-red-700">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Contenedor Principal --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                {{-- Header Interno --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Editar
                            Rotación</span>
                    </div>
                    <span class="text-xs text-gray-400">Modifique la configuración del día de turno</span>
                </div>

                <form method="POST" action="{{ route('farmacias.rotaciones.update', $rotacion->id) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap border border-gray-200 rounded-xl overflow-hidden shadow-inner">

                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="w-full lg:w-1/2 p-6 border-r border-gray-200 bg-white space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Tipo de Rotación <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="tipo_rotacion" value="semanal"
                                            {{ is_null($rotacion->fecha_especifica) ? 'checked' : '' }}
                                            class="w-4 h-4 text-black border-gray-300 focus:ring-0">
                                        <span class="text-sm text-gray-700">Semanal</span>
                                        <span class="text-xs text-gray-400 ml-2">(Se repite todas las semanas)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="tipo_rotacion" value="especifica"
                                            {{ !is_null($rotacion->fecha_especifica) ? 'checked' : '' }}
                                            class="w-4 h-4 text-black border-gray-300 focus:ring-0">
                                        <span class="text-sm text-gray-700">Fecha específica</span>
                                        <span class="text-xs text-gray-400 ml-2">(Día puntual ej. feriado)</span>
                                    </label>
                                </div>
                                @error('tipo_rotacion')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="w-full lg:w-1/2 p-6 bg-gray-50/50 space-y-5">

                            {{-- Campos para rotación semanal --}}
                            <div id="semanal_fields"
                                style="{{ is_null($rotacion->fecha_especifica) ? 'display: block;' : 'display: none;' }}">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Día de la semana <span class="text-red-500">*</span>
                                </label>
                                <select name="dia_semana"
                                    class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                    <option value="">Seleccionar día</option>
                                    @foreach ($dias as $num => $nombre)
                                        <option value="{{ $num }}"
                                            {{ old('dia_semana', $rotacion->dia_semana) == $num ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dia_semana')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror

                                <div class="mt-4">
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Semana del mes
                                    </label>
                                    <select name="semana_mes"
                                        class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                        <option value="">Todas las semanas</option>
                                        @foreach ($semanas as $num => $nombre)
                                            <option value="{{ $num }}"
                                                {{ old('semana_mes', $rotacion->semana_mes) == $num ? 'selected' : '' }}>
                                                {{ $nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-[10px] text-gray-400 mt-1">Seleccione una semana específica o deje en
                                        blanco para todas</p>
                                    @error('semana_mes')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Campos para fecha específica --}}
                            <div id="especifica_fields"
                                style="{{ !is_null($rotacion->fecha_especifica) ? 'display: block;' : 'display: none;' }}">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Fecha específica <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_especifica"
                                    value="{{ old('fecha_especifica', $rotacion->fecha_especifica ? \Carbon\Carbon::parse($rotacion->fecha_especifica)->format('Y-m-d') : '') }}"
                                    class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                <p class="text-[10px] text-gray-400 mt-1">Seleccione una fecha puntual (ej. feriado, día
                                    especial)</p>
                                @error('fecha_especifica')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN ACCIONES INFERIORES --}}
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 pt-6">

                        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <input type="checkbox" name="activo" value="1"
                                {{ old('activo', $rotacion->activo) ? 'checked' : '' }}
                                class="w-5 h-5 text-black border-gray-300 rounded focus:ring-0">
                            <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Rotación activa
                            </span>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('farmacias.rotaciones.index', $farmacia->id) }}"
                                class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition">
                                [ Cancelar ]
                            </a>

                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-black text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Actualizar Rotación
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoRotacionRadios = document.querySelectorAll('input[name="tipo_rotacion"]');
            const semanalFields = document.getElementById('semanal_fields');
            const especificaFields = document.getElementById('especifica_fields');

            function toggleFields() {
                const selected = document.querySelector('input[name="tipo_rotacion"]:checked').value;
                if (selected === 'semanal') {
                    semanalFields.style.display = 'block';
                    especificaFields.style.display = 'none';
                } else {
                    semanalFields.style.display = 'none';
                    especificaFields.style.display = 'block';
                }
            }

            tipoRotacionRadios.forEach(radio => {
                radio.addEventListener('change', toggleFields);
            });
        });
    </script>
</x-app-layout>
