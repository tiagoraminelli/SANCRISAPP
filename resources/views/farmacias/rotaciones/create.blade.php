<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Nueva Rotación - {{ $farmacia->nombre }}
                </h2>
                <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider font-mono">
                    [ Asignación masiva de días de turno ]
                </p>
            </div>

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
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

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

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Configuración de
                            Rotación</span>
                    </div>
                    <span class="text-xs text-gray-400">Seleccione fechas específicas para turno</span>
                </div>

                <form method="POST" action="{{ route('farmacias.rotaciones.store', $farmacia->id) }}" class="p-6">
                    @csrf

                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-inner">
                        <div class="w-full p-6 bg-white space-y-5">

                            {{-- Tipo de rotación (fijo en fecha específica) --}}
                            <input type="hidden" name="tipo_rotacion" value="especifica">

                            {{-- Contenedor de fechas dinámicas --}}
                            <div id="fechas-container" class="space-y-3">
                                <div class="fecha-item flex items-center gap-3">
                                    <div class="flex-1">
                                        <label
                                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                                            Fecha <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" name="fechas[]"
                                            class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition"
                                            value="{{ old('fechas.0') }}">
                                    </div>
                                    <button type="button"
                                        class="remove-fecha mt-5 p-2 text-gray-400 hover:text-red-500 transition hidden"
                                        title="Eliminar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Botón para agregar más fechas --}}
                            <div class="mt-2">
                                <button type="button" id="agregar-fecha"
                                    class="inline-flex items-center gap-2 text-xs font-bold text-emerald-600 hover:text-emerald-700 uppercase tracking-widest transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    + Agregar otra fecha
                                </button>
                            </div>

                            @error('fechas.*')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Activar rotación --}}
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <input type="checkbox" name="activo" value="1" {{ old('activo', 1) ? 'checked' : '' }}
                                class="w-5 h-5 text-black border-gray-300 rounded focus:ring-0">
                            <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Activar rotación al guardar
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
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Guardar Rotaciones
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let fechaCount = 1;
            const container = document.getElementById('fechas-container');

            // Agregar nueva fecha
            document.getElementById('agregar-fecha').addEventListener('click', function() {
                const newIndex = fechaCount;
                const newItem = document.createElement('div');
                newItem.className = 'fecha-item flex items-center gap-3';
                newItem.innerHTML = `
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                            Fecha <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fechas[${newIndex}]"
                            class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                    </div>
                    <button type="button" class="remove-fecha mt-5 p-2 text-gray-400 hover:text-red-500 transition" title="Eliminar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                `;
                container.appendChild(newItem);
                fechaCount++;

                // Actualizar visibilidad de botones eliminar
                toggleRemoveButtons();
            });

            // Eliminar fecha (delegación de eventos)
            container.addEventListener('click', function(e) {
                if (e.target.closest('.remove-fecha')) {
                    const btn = e.target.closest('.remove-fecha');
                    const fechaItem = btn.closest('.fecha-item');
                    if (document.querySelectorAll('.fecha-item').length > 1) {
                        fechaItem.remove();
                        toggleRemoveButtons();
                    }
                }
            });

            function toggleRemoveButtons() {
                const items = document.querySelectorAll('.fecha-item');
                items.forEach((item, idx) => {
                    const removeBtn = item.querySelector('.remove-fecha');
                    if (idx === 0) {
                        removeBtn.classList.add('hidden');
                    } else {
                        removeBtn.classList.remove('hidden');
                    }
                });
            }

            toggleRemoveButtons();
        });
    </script>
</x-app-layout>
