<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            {{-- Título + descripción (Estilo Index) --}}
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Editar Asignación
                </h2>
                <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider font-mono">
                    [ Modificación de asignación de usuario a comercio ]
                </p>
            </div>

            {{-- Acción Volver (Estilo Botón Index) --}}
            <a href="{{ route('monitoreo.negociosUsuarios.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                      rounded-xl shadow hover:bg-gray-100 transition font-mono">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-mono">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">

            {{-- Contenedor Principal --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                {{-- Header Interno --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Editar Asignación</span>
                    </div>
                    <span class="text-xs text-gray-400">Modifique la asignación de usuario a negocio</span>
                </div>

                <form method="POST" action="{{ route('monitoreo.negociosUsuarios.update', $negociosUsuario) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" value="{{ $negociosUsuario->id }}">

                    {{-- Grilla con bordes marcados (Estilo Técnico) --}}
                    <div class="flex flex-wrap border border-gray-200 rounded-xl overflow-hidden shadow-inner">


                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="w-full lg:w-1/2 p-6 border-r border-gray-200 bg-white space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Usuario <span class="text-red-500">*</span>
                                </label>
                                <select name="user_id"
                                        class="select2-usuario w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                    <option value="">Seleccionar usuario</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $negociosUsuario->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Negocio <span class="text-red-500">*</span>
                                </label>
                                <select name="business_id"
                                        class="select2-negocio w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                    <option value="">Seleccionar negocio</option>
                                    @foreach($businesses as $business)
                                        <option value="{{ $business->id }}" {{ old('business_id', $negociosUsuario->business_id) == $business->id ? 'selected' : '' }}>
                                            {{ $business->nombre }} - {{ \Illuminate\Support\Str::limit($business->direccion, 40) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('business_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="w-full lg:w-1/2 p-6 bg-gray-50/50 space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Rol <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="role" value="administrador" {{ old('role', $negociosUsuario->role) == 'administrador' ? 'checked' : '' }}
                                               class="w-4 h-4 text-black border-gray-300 focus:ring-0">
                                        <span class="text-sm text-gray-700">Administrador</span>
                                        <span class="text-xs text-gray-400 ml-2">(Control total del negocio)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="role" value="propietario" {{ old('role', $negociosUsuario->role) == 'propietario' ? 'checked' : '' }}
                                               class="w-4 h-4 text-black border-gray-300 focus:ring-0">
                                        <span class="text-sm text-gray-700">Propietario</span>
                                        <span class="text-xs text-gray-400 ml-2">(Dueño del negocio)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="role" value="empleado" {{ old('role', $negociosUsuario->role) == 'empleado' ? 'checked' : '' }}
                                               class="w-4 h-4 text-black border-gray-300 focus:ring-0">
                                        <span class="text-sm text-gray-700">Empleado</span>
                                        <span class="text-xs text-gray-400 ml-2">(Acceso limitado)</span>
                                    </label>
                                </div>
                                @error('business_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN ACCIONES INFERIORES --}}
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 pt-6">

                        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-black text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Actualizar Asignación
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
        // Inicializar Select2
        $(document).ready(function() {
            $('.select2-usuario, .select2-negocio').each(function() {
                $(this).select2({
                    width: '100%',
                    placeholder: 'Buscar...',
                    allowClear: true,
                    language: {
                        noResults: function() {
                            return "No se encontraron resultados";
                        }
                    }
                });
            });
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
