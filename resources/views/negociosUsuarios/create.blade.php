<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            {{-- Título + descripción (Estilo Index) --}}
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Crear Asignaciones
                </h2>
                <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider font-mono">
                    [ Asignación masiva de usuarios a comercios ]
                </p>
            </div>

            {{-- Acción Volver (Estilo Botón Index) --}}
            <a href="{{ route('monitoreo.negociosUsuarios.index') }}"
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

            {{-- ================= MENSAJES DE ERROR ================= --}}
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
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Asignaciones
                            Múltiples</span>
                    </div>
                    <span class="text-xs text-gray-400">Seleccione usuarios y negocios para asignar</span>
                </div>

                <form method="POST" action="{{ route('monitoreo.negociosUsuarios.storeMultiple') }}" class="p-6"
                    id="asignacionesForm">
                    @csrf

                    {{-- Contenedor de asignaciones dinámicas --}}
                    <div id="asignaciones-container" class="space-y-4">
                        {{-- Asignación 1 (por defecto) --}}
                        <div class="asignacion-item border border-gray-200 rounded-xl overflow-hidden shadow-inner">
                            <div class="flex flex-wrap">
                                {{-- Columna izquierda: Usuario --}}
                                <div class="w-full lg:w-5/12 p-4 border-r border-gray-200 bg-white">
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Usuario <span class="text-red-500">*</span>
                                    </label>
                                    <select name="asignaciones[0][user_id]"
                                        class="select2-usuario w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                        <option value="">Buscar usuario...</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('asignaciones.0.user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} - {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('asignaciones.0.user_id')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Columna central: Negocio --}}
                                <div class="w-full lg:w-5/12 p-4 border-r border-gray-200 bg-white">
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Negocio <span class="text-red-500">*</span>
                                    </label>
                                    <select name="asignaciones[0][business_id]"
                                        class="select2-negocio w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                        <option value="">Buscar negocio...</option>
                                        @foreach ($businesses as $business)
                                            <option value="{{ $business->id }}"
                                                {{ old('asignaciones.0.business_id') == $business->id ? 'selected' : '' }}>
                                                {{ $business->nombre }} -
                                                {{ \Illuminate\Support\Str::limit($business->direccion, 40) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('asignaciones.0.business_id')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Columna derecha: Rol + acciones --}}
                                <div class="w-full lg:w-2/12 p-4 bg-gray-50/50">
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Rol <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center gap-3">
                                        <select name="asignaciones[0][role]"
                                            class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                            <option value="administrador"
                                                {{ old('asignaciones.0.role') == 'administrador' ? 'selected' : '' }}>
                                                Administrador</option>
                                            <option value="propietario"
                                                {{ old('asignaciones.0.role') == 'propietario' ? 'selected' : '' }}>
                                                Propietario</option>
                                            <option value="empleado"
                                                {{ old('asignaciones.0.role') == 'empleado' ? 'selected' : '' }}>
                                                Empleado</option>
                                        </select>
                                        <button type="button"
                                            class="remove-asignacion p-2 text-gray-400 hover:text-red-500 transition hidden"
                                            title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('asignaciones.0.role')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Botón para agregar más asignaciones --}}
                    <div class="mt-4">
                        <button type="button" id="agregar-asignacion"
                            class="inline-flex items-center gap-2 text-xs font-bold text-emerald-600 hover:text-emerald-700 uppercase tracking-widest transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            + Agregar otra asignación
                        </button>
                    </div>

                    {{-- SECCIÓN ACCIONES INFERIORES --}}
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 pt-6">

                        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Un usuario puede tener múltiples negocios
                            </span>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('monitoreo.negociosUsuarios.index') }}"
                                class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition">
                                [ Cancelar ]
                            </a>

                            <button type="submit"
                                class="text-xs font-bold text-black hover:text-emerald-600 uppercase tracking-widest transition">
                                Crear Asignaciones
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Select2 y scripts --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let asignacionCount = 1;

        // Inicializar Select2
        function initSelect2(element) {
            $(element).select2({
                width: '100%',
                placeholder: 'Buscar...',
                allowClear: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });
        }

        // Inicializar todos los selects existentes
        $(document).ready(function() {
            $('.select2-usuario, .select2-negocio').each(function() {
                initSelect2(this);
            });
        });

        // Agregar nueva asignación
        document.getElementById('agregar-asignacion').addEventListener('click', function() {
            const container = document.getElementById('asignaciones-container');
            const newIndex = asignacionCount;

            const newAsignacion = document.createElement('div');
            newAsignacion.className =
                'asignacion-item border border-gray-200 rounded-xl overflow-hidden shadow-inner mt-4';
            newAsignacion.innerHTML = `
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-5/12 p-4 border-r border-gray-200 bg-white">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Usuario <span class="text-red-500">*</span>
                        </label>
                        <select name="asignaciones[${newIndex}][user_id]" class="select2-usuario w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                            <option value="">Buscar usuario...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full lg:w-5/12 p-4 border-r border-gray-200 bg-white">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Negocio <span class="text-red-500">*</span>
                        </label>
                        <select name="asignaciones[${newIndex}][business_id]" class="select2-negocio w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                            <option value="">Buscar negocio...</option>
                            @foreach ($businesses as $business)
                                <option value="{{ $business->id }}">
                                    {{ $business->nombre }} - {{ \Illuminate\Support\Str::limit($business->direccion, 40) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full lg:w-2/12 p-4 bg-gray-50/50">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Rol <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <select name="asignaciones[${newIndex}][role]" class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                <option value="administrador">Administrador</option>
                                <option value="propietario">Propietario</option>
                                <option value="empleado" selected>Empleado</option>
                            </select>
                            <button type="button" class="remove-asignacion p-2 text-gray-400 hover:text-red-500 transition" title="Eliminar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(newAsignacion);

            // Inicializar Select2 para los nuevos selects
            $(newAsignacion).find('.select2-usuario, .select2-negocio').each(function() {
                initSelect2(this);
            });

            // Mostrar botones de eliminar en todas las asignaciones excepto la primera
            document.querySelectorAll('.remove-asignacion').forEach((btn, idx) => {
                if (idx === 0) {
                    btn.classList.add('hidden');
                } else {
                    btn.classList.remove('hidden');
                }
            });

            asignacionCount++;
        });

        // Eliminar asignación (delegación de eventos)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-asignacion')) {
                const btn = e.target.closest('.remove-asignacion');
                const asignacionItem = btn.closest('.asignacion-item');
                if (asignacionItem && document.querySelectorAll('.asignacion-item').length > 1) {
                    asignacionItem.remove();
                }
            }
        });
    </script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 40px !important;
            border-color: #e5e7eb !important;
            border-radius: 0.5rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            padding-left: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }

        .select2-container--default .select2-selection--single:hover {
            border-color: #9ca3af !important;
        }

        .select2-dropdown {
            border-color: #e5e7eb !important;
            border-radius: 0.5rem !important;
        }
    </style>
</x-app-layout>
