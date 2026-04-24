<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Rotaciones - {{ $farmacia->nombre }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Gestión de días de turno para esta farmacia
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('farmacias.rotaciones.create', $farmacia->id) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                      rounded-xl shadow hover:bg-gray-100 hover:shadow-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nueva Rotación
                </a>
                <a href="{{ route('farmacias.show', $farmacia->id) }}"
                    class="px-5 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition shadow whitespace-nowrap">
                    ← Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">

            {{-- ================= FILTROS ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <form method="GET" class="flex flex-wrap lg:flex-nowrap items-center gap-2">
                    <div class="flex-1 min-w-[180px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar por día o fecha..."
                            class="w-full h-9 px-3 rounded-lg border-gray-200
                                   text-sm text-black placeholder-gray-500
                                   focus:ring-black focus:border-black transition">
                    </div>

                    <div class="w-44 lg:w-36">
                        <select name="tipo"
                            class="w-full h-9 rounded-lg border-gray-200
                                   text-sm text-black
                                   focus:ring-black focus:border-black">
                            <option value="">Todos</option>
                            <option value="semanal" {{ request('tipo') == 'semanal' ? 'selected' : '' }}>Semanal
                            </option>
                            <option value="especifica" {{ request('tipo') == 'especifica' ? 'selected' : '' }}>Fecha
                                específica</option>
                        </select>
                    </div>

                    <div class="w-44 lg:w-36">
                        <select name="activo"
                            class="w-full h-9 rounded-lg border-gray-200
                                   text-sm text-black
                                   focus:ring-black focus:border-black">
                            <option value="">Estado</option>
                            <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>

                    <input type="date" name="fecha" value="{{ request('fecha') }}"
                        class="w-40 h-9 px-3 rounded-lg border-gray-200 text-sm">

                    <button type="submit"
                        class="h-9 px-4 inline-flex items-center justify-center
                               bg-black text-black text-sm font-medium
                               rounded-lg hover:bg-gray-800 transition">
                        Filtrar
                    </button>

                    @if (request()->anyFilled(['search', 'tipo', 'activo', 'fecha']))
                        <a href="{{ route('farmacias.rotaciones.index', $farmacia->id) }}"
                            class="text-sm text-red-500 hover:text-red-600 transition px-1">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            {{-- ================= TABLA ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Tipo</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Día /
                                    Fecha</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Semana
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Estado
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($rotaciones as $rotacion)
                                <tr class="hover:bg-gray-50 transition group">
                                    {{-- TIPO --}}
                                    <td class="px-6 py-4">
                                        @if ($rotacion->fecha_especifica)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Fecha específica
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Semanal
                                            </span>
                                        @endif
                                    </td>

                                    {{-- DÍA / FECHA --}}
                                    <td class="px-6 py-4">
                                        @if ($rotacion->fecha_especifica)
                                            <span class="text-gray-900 font-medium">
                                                {{ \Carbon\Carbon::parse($rotacion->fecha_especifica)->translatedFormat('l j \d\e F Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-900 font-medium">
                                                {{ $rotacion->dia_nombre }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- SEMANA --}}
                                    <td class="px-6 py-4">
                                        @if (!$rotacion->fecha_especifica && $rotacion->semana_mes)
                                            <span class="text-xs text-gray-500">
                                                {{ $rotacion->semana_nombre }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>

                                    {{-- ESTADO --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $rotacion->activo ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full {{ $rotacion->activo ? 'bg-green-600' : 'bg-gray-400' }}"></span>
                                            {{ $rotacion->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>

                                    {{-- ACCIONES --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('farmacias.rotaciones.edit', $rotacion->id) }}"
                                                class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
                                                title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('farmacias.rotaciones.destroy', $rotacion->id) }}"
                                                class="inline" onsubmit="event.preventDefault(); confirmDelete(this)">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    title="Eliminar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-500 font-medium">No hay rotaciones registradas</p>
                                            <p class="text-sm text-gray-400 mt-1">Comienza agregando una nueva rotación
                                            </p>
                                            <a href="{{ route('farmacias.rotaciones.create', $farmacia->id) }}"
                                                class="mt-4 inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                                + Nueva rotación
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN - CORREGIDA --}}
                @if (method_exists($rotaciones, 'links') && $rotaciones->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $rotaciones->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(form) {
            if (confirm('¿Eliminar esta rotación? Esta acción no se puede deshacer.')) {
                form.submit();
            }
        }
    </script>
</x-app-layout>
