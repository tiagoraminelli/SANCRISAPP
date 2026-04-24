<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            {{-- Título + descripción (Estilo Index) --}}
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Crear Farmacia
                </h2>
                <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider font-mono">
                    [ Registro de nueva farmacia de turno ]
                </p>
            </div>

            {{-- Acción Volver (Estilo Botón Index) --}}
            <a href="{{ route('farmacias.index') }}"
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
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Datos de la
                            Farmacia</span>
                    </div>
                    <span class="text-xs text-gray-400">Complete el formulario para registrar una nueva farmacia</span>
                </div>

                <form method="POST" action="{{ route('farmacias.store') }}" enctype="multipart/form-data"
                    class="p-6">
                    @csrf

                    {{-- Grilla con bordes marcados --}}
                    <div class="flex flex-wrap border border-gray-200 rounded-xl overflow-hidden shadow-inner">

                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="w-full lg:w-3/5 p-6 border-r border-gray-200 bg-white space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Nombre de la Farmacia <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}"
                                    placeholder="Ej: Farmacia Central"
                                    class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                @error('nombre')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Dirección <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}"
                                    placeholder="Calle y número"
                                    class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                @error('direccion')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Teléfono <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                                        placeholder="351 123-4567"
                                        class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                    @error('telefono')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Horario
                                    </label>
                                    <div class="flex gap-2 items-center">
                                        <input type="time" name="horario_apertura"
                                            value="{{ old('horario_apertura') }}"
                                            class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                        <span class="text-gray-400">-</span>
                                        <input type="time" name="horario_cierre" value="{{ old('horario_cierre') }}"
                                            class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                    </div>
                                    @error('horario_apertura')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                    @error('horario_cierre')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Latitud
                                    </label>
                                    <input type="text" name="latitud" value="{{ old('latitud') }}"
                                        placeholder="-31.5375"
                                        class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                    @error('latitud')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        Longitud
                                    </label>
                                    <input type="text" name="longitud" value="{{ old('longitud') }}"
                                        placeholder="-68.5367"
                                        class="w-full h-10 px-3 rounded-lg border-gray-200 text-sm focus:ring-black focus:border-black transition">
                                    @error('longitud')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="w-full lg:w-2/5 p-6 bg-gray-50/50 space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Identidad Visual
                                </label>
                                <div
                                    class="border-2 border-dashed border-gray-200 p-4 bg-white text-center rounded-xl hover:border-black transition-colors group">
                                    <div class="py-2">
                                        <svg class="w-8 h-8 mx-auto text-gray-300 group-hover:text-black transition"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-bold mt-2">Subir Logo</p>
                                        <p class="text-[10px] text-gray-400 mt-1 uppercase">PNG, JPG (MAX 2MB)</p>
                                    </div>
                                    <input type="file" name="logo" class="hidden" id="logo-input">
                                    <label for="logo-input"
                                        class="mt-2 inline-block cursor-pointer text-[10px] bg-gray-100 px-3 py-1 rounded border border-gray-200 uppercase hover:bg-gray-200">Seleccionar
                                        archivo</label>
                                </div>
                                @error('logo')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Descripción
                                </label>
                                <textarea name="descripcion" rows="4"
                                    class="w-full border-gray-200 rounded-lg p-3 text-sm focus:ring-black focus:border-black resize-none"
                                    placeholder="Información adicional sobre la farmacia...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN ACCIONES INFERIORES --}}
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 pt-6">

                        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <input type="checkbox" name="activo" value="1" checked
                                class="w-5 h-5 text-black border-gray-300 rounded focus:ring-0">
                            <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Activar farmacia al guardar
                            </span>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('farmacias.index') }}"
                                class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition">
                                [ Cancelar ]
                            </a>

                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-black text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Guardar Farmacia
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
