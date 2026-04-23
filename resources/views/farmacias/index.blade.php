<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <!-- Título + descripción (izquierda) -->
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Farmacias de Turno
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Gestión de farmacias y rotación de turnos
                </p>
            </div>

            <!-- Acción (derecha) -->
            <a href="{{ route('farmacias.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                      rounded-xl shadow hover:bg-gray-100 hover:shadow-md transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nueva Farmacia
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">

            {{-- ================= FILTROS ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <form method="GET" class="flex flex-wrap lg:flex-nowrap items-center gap-2">
                    <!-- BUSCADOR -->
                    <div class="flex-1 min-w-[180px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar farmacia..."
                            class="w-full h-9 px-3 rounded-lg border-gray-200
                                   text-sm text-black placeholder-gray-500
                                   focus:ring-black focus:border-black transition">
                    </div>

                    <!-- ESTADO -->
                    <div class="w-44 lg:w-36">
                        <select name="estado"
                            class="w-full h-9 rounded-lg border-gray-200
                                   text-sm text-black
                                   focus:ring-black focus:border-black">
                            <option value="">Estado</option>
                            <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>

                    <!-- TURNO HOY -->
                    <div class="w-44 lg:w-36">
                        <select name="turno_hoy"
                            class="w-full h-9 rounded-lg border-gray-200
                                   text-sm text-black
                                   focus:ring-black focus:border-black">
                            <option value="">Turno hoy</option>
                            <option value="1" {{ request('turno_hoy') == '1' ? 'selected' : '' }}>De turno hoy
                            </option>
                            <option value="0" {{ request('turno_hoy') == '0' ? 'selected' : '' }}>Sin turno hoy
                            </option>
                        </select>
                    </div>

                    <!-- BOTÓN -->
                    <button type="submit"
                        class="h-9 px-4 inline-flex items-center justify-center
                               bg-black text-white text-sm font-medium
                               rounded-lg hover:bg-gray-800 transition">
                        Filtrar
                    </button>

                    <!-- LIMPIAR -->
                    @if (request()->anyFilled(['search', 'estado', 'turno_hoy']))
                        <a href="{{ route('farmacias.index') }}"
                            class="text-sm text-red-500 hover:text-red-600 transition px-1">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            {{-- ================= TABLA COMPLETA ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Farmacia
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Contacto
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Horario
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Turno hoy
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Rotación
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Estado
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Registro
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($farmacias as $farmacia)
                                @php
                                    $logoPath = $farmacia->logo ? 'storage/' . $farmacia->logo : null;
                                    $logoExists = $farmacia->logo && Storage::disk('public')->exists($farmacia->logo);
                                    $turnoHoy = $farmacia->estaDeTurnoHoy();
                                @endphp

                                <tr class="hover:bg-gray-50 transition group">
                                    {{-- FARMACIA con logo --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                                                @if ($logoExists)
                                                    <img src="{{ asset($logoPath) }}" class="w-full h-full object-cover"
                                                        alt="logo">
                                                @else
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $farmacia->nombre }}</div>
                                                <div class="text-xs text-gray-400 mt-0.5 max-w-[200px] truncate">
                                                    {{ $farmacia->direccion }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- CONTACTO --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $farmacia->telefono }}
                                        </div>
                                    </td>

                                    {{-- HORARIO --}}
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-gray-500">
                                            @if ($farmacia->horario_apertura && $farmacia->horario_cierre)
                                                {{ \Carbon\Carbon::parse($farmacia->horario_apertura)->format('H:i') }}
                                                - {{ \Carbon\Carbon::parse($farmacia->horario_cierre)->format('H:i') }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>

                                    {{-- TURNO HOY --}}
                                    <td class="px-6 py-4">
                                        @if ($turnoHoy)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                De turno
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                Sin turno
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ROTACIÓN --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $rotaciones = $farmacia->rotaciones()->where('activo', true)->get();
                                        @endphp
                                        @if ($rotaciones->count() > 0)
                                            <button onclick="openRotacionModal({{ $farmacia->id }})"
                                                class="inline-flex items-center gap-1.5 text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                                {{ $rotaciones->count() }} reglas
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400">Sin configuración</span>
                                        @endif
                                    </td>

                                    {{-- ESTADO --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $farmacia->activo ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full {{ $farmacia->activo ? 'bg-green-600' : 'bg-gray-500' }}"></span>
                                            {{ $farmacia->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>

                                    {{-- FECHA --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-xs text-gray-500">{{ $farmacia->created_at?->format('d/m/Y') }}</span>
                                    </td>

                                    {{-- ACCIONES --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('farmacias.show', $farmacia->id) }}"
                                                class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition"
                                                title="Ver detalles">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('farmacias.edit', $farmacia->id) }}"
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
                                                action="{{ route('farmacias.destroy', $farmacia->id) }}"
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

                                {{-- MODAL DE ROTACIÓN --}}
                                <div id="modal-rotacion-{{ $farmacia->id }}"
                                    class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                                    onclick="if(event.target === this) closeRotacionModal({{ $farmacia->id }})">
                                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                                        <div
                                            class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900">Reglas de rotación</h3>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $farmacia->nombre }}</p>
                                            </div>
                                            <button onclick="closeRotacionModal({{ $farmacia->id }})"
                                                class="p-2 hover:bg-gray-100 rounded-full text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-6 max-h-96 overflow-y-auto">
                                            @if ($farmacia->rotaciones->count())
                                                <div class="space-y-2">
                                                    @foreach ($farmacia->rotaciones as $rotacion)
                                                        <div
                                                            class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-900">
                                                                    {{ $rotacion->dia_nombre }}
                                                                </p>
                                                                @if ($rotacion->semana_mes)
                                                                    <p class="text-xs text-gray-500">
                                                                        {{ $rotacion->semana_nombre }}</p>
                                                                @endif
                                                                @if ($rotacion->fecha_especifica)
                                                                    <p class="text-xs text-gray-500">
                                                                        {{ $rotacion->fecha_especifica->format('d/m/Y') }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('farmacias.destroyRotacion', $rotacion->id) }}"
                                                                onsubmit="event.preventDefault(); confirmDeleteRotacion(this)">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="p-1 text-gray-400 hover:text-red-600 transition"
                                                                    title="Eliminar regla">
                                                                    <svg class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-center text-gray-500 py-8">No hay reglas de rotación
                                                    configuradas</p>
                                            @endif
                                        </div>
                                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                                            <button onclick="closeRotacionModal({{ $farmacia->id }})"
                                                class="w-full px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition">
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <p class="text-gray-500 font-medium">No hay farmacias registradas</p>
                                            <p class="text-sm text-gray-400 mt-1">Comienza creando la primera farmacia
                                            </p>
                                            <a href="{{ route('farmacias.create') }}"
                                                class="mt-4 inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                                + Nueva farmacia
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($farmacias->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $farmacias->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(form) {
            if (confirm('¿Eliminar esta farmacia? Esta acción no se puede deshacer.')) {
                form.submit();
            }
        }

        function confirmDeleteRotacion(form) {
            if (confirm('¿Eliminar esta regla de rotación?')) {
                form.submit();
            }
        }

        function openRotacionModal(id) {
            const modal = document.getElementById('modal-rotacion-' + id);
            if (modal) modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRotacionModal(id) {
            const modal = document.getElementById('modal-rotacion-' + id);
            if (modal) modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('[id^="modal-rotacion-"]').forEach(modal => {
                    modal.classList.add('hidden');
                });
                document.body.style.overflow = '';
            }
        });
    </script>
</x-app-layout>
