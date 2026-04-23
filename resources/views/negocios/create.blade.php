<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            {{-- Título + descripción (Estilo Index) --}}
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Crear Negocio
                </h2>
                <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider font-mono">
                    [ Registro de nueva entidad local ]
                </p>
            </div>

            {{-- Acción Volver (Estilo Botón Index) --}}
            <a href="{{ route('negocios.index') }}"
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
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

            {{-- Contenedor Principal (Bordes y sombra del Index) --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                {{-- Header Interno con Icono del Index --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Editor de Negocio</span>
                    </div>
                    <span class="text-xs text-gray-400">Complete el formulario para registrar un nuevo negocio</span>
                </div>

                <form method="POST" action="{{ route('negocios.store') }}" enctype="multipart/form-data" class="p-6">
                    @csrf

                    {{-- Grilla con bordes marcados (Estilo Técnico) --}}
                    <div class="flex flex-wrap border border-gray-200 rounded-xl overflow-hidden shadow-inner">

                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="w-full lg:w-3/5 p-6 border-r border-gray-200 bg-white space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre del Negocio *</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Panadería La Estrella"
                                    class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Dirección Física *</label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}"
                                    class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Teléfono *</label>
                                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                                        class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Horarios</label>
                                    <input type="text" name="horarios" value="{{ old('horarios') }}" placeholder="Lun a Vie 9-18hs"
                                        class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                </div>
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="w-full lg:w-2/5 p-6 bg-gray-50/50 space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Identidad Visual</label>
                                <div class="border-2 border-dashed border-gray-200 p-4 bg-white text-center rounded-xl hover:border-black transition-colors group">
                                    <div class="py-2">
                                        <svg class="w-8 h-8 mx-auto text-gray-300 group-hover:text-black transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-bold mt-2">Subir Logo</p>
                                        <p class="text-[10px] text-gray-400 mt-1 uppercase">PNG, JPG (MAX 2MB)</p>
                                    </div>
                                    <input type="file" name="logo" class="hidden" id="logo-input">
                                    <label for="logo-input" class="mt-2 inline-block cursor-pointer text-[10px] bg-gray-100 px-3 py-1 rounded border border-gray-200 uppercase hover:bg-gray-200">Seleccionar archivo</label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descripción Breve</label>
                                <textarea name="descripcion" rows="3"
                                    class="w-full border-gray-200 rounded-lg p-3 text-sm focus:ring-black focus:border-black resize-none">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN ACCIONES INFERIORES --}}
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 pt-6">

                        {{-- Toggle de Estado (Estilo Badge Index) --}}
                        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <input type="checkbox" name="activo" value="1" checked
                                   class="w-5 h-5 text-black border-gray-300 rounded focus:ring-0">
                            <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Activar Negocio al guardar
                            </span>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('negocios.index') }}"
                               class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition">
                                [ Cancelar ]
                            </a>

                            <button type="submit"
                                    class="text-xs font-bold text-black hover:text-red-500 uppercase tracking-widest transition">
                                Guardar Negocio
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
