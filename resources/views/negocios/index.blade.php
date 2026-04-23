<x-app-layout>


<x-slot name="header">
    <div class="flex items-start justify-between">

        <!-- Título + descripción (izquierda) -->
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                Negocios
            </h2>
            <p class="text-sm text-gray-400 mt-1">
                Gestión completa de comercios locales
            </p>
        </div>

        <!-- Acción (derecha) -->
        <a href="{{ route('negocios.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5
                  bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                  rounded-xl shadow hover:bg-gray-100 hover:shadow-md
                  transition">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>

            Nuevo negocio
        </a>

    </div>
</x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">

{{-- ================= FILTROS MEJORADOS ================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">

    <form method="GET" class="flex flex-wrap lg:flex-nowrap items-center gap-2">

        <!-- BUSCADOR -->
        <div class="flex-1 min-w-[180px]">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar negocios..."
                class="w-full h-9 px-3 rounded-lg border-gray-200
                       text-sm text-black placeholder-gray-500
                       focus:ring-black focus:border-black transition">
        </div>

        <!-- USUARIOS (SELECT2) -->
        <div class="w-44 lg:w-44">
            <select name="user_id"
                class="select2 w-full h-9 rounded-lg border-gray-200
                       text-sm text-black
                       focus:ring-black focus:border-black">
                <option value="">Usuarios</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
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

        <!-- BOTÓN -->
        <button type="submit"
            class="h-9 px-4 inline-flex items-center justify-center
                   bg-black text-black text-sm font-medium
                   rounded-lg hover:bg-gray-800 transition">

            Filtrar
        </button>

        <!-- LIMPIAR -->
        @if(request()->anyFilled(['search','estado','user_id']))
            <a href="{{ route('negocios.index') }}"
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
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Negocio</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Descripción</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Contacto</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Horarios</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Usuarios</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Registro</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($negocios as $negocio)
                                @php
                                    $logoPath = $negocio->logo ? 'storage/' . $negocio->logo : null;
                                    $logoExists = $negocio->logo && Storage::disk('public')->exists($negocio->logo);
                                @endphp

                                <tr class="hover:bg-gray-50 transition group">
                                    {{-- NEGOCIO con logo --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                                                @if($logoExists)
                                                    <img src="{{ asset($logoPath) }}" class="w-full h-full object-cover" alt="logo">
                                                @else
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4 21V7l8-4 8 4v14" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $negocio->nombre }}</div>
                                                <div class="text-xs text-gray-400 mt-0.5 max-w-[200px] truncate">{{ $negocio->direccion }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- DESCRIPCIÓN (agregada) --}}
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-gray-500 line-clamp-2 max-w-[200px]">
                                            {{ $negocio->descripcion ?: '—' }}
                                        </span>
                                    </td>

                                    {{-- CONTACTO mejorado --}}
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $negocio->telefono }}
                                            </div>
                                        </div>
                                    </td>

                                    {{-- HORARIOS (agregados) --}}
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-gray-500 line-clamp-2 max-w-[150px]">
                                            {{ $negocio->horarios ?: '—' }}
                                        </span>
                                    </td>

                                    {{-- USUARIOS mejorado --}}
                                    <td class="px-6 py-4">
                                        @php $users = $negocio->users; @endphp
                                        @if($users->count() === 1)
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-bold text-emerald-700">{{ substr($users->first()->name, 0, 1) }}</span>
                                                </div>
                                                <span class="text-xs text-gray-700">{{ $users->first()->name }}</span>
                                            </div>
                                        @elseif($users->count() > 1)
                                            <button onclick="openModal({{ $negocio->id }})"
                                                    class="inline-flex items-center gap-1.5 text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                                {{ $users->count() }} usuarios
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>

                                    {{-- ESTADO --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $negocio->activo ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $negocio->activo ? 'bg-green-600' : 'bg-gray-500' }}"></span>
                                            {{ $negocio->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>

                                    {{-- FECHA --}}
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-gray-500">{{ $negocio->created_at?->format('d/m/Y') }}</span>
                                    </td>

                                    {{-- ACCIONES mejoradas --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('negocios.show', $negocio) }}"
                                               class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition"
                                               title="Ver detalles">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('negocios.edit', $negocio) }}"
                                               class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
                                               title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('negocios.destroy', $negocio) }}" class="inline"
                                                  onsubmit="event.preventDefault(); confirmDelete(this)">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Eliminar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL DE USUARIOS --}}
                                <div id="modal-{{ $negocio->id }}"
                                     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                                     onclick="if(event.target === this) closeModal({{ $negocio->id }})">
                                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                                        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900">Usuarios asignados</h3>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $negocio->nombre }}</p>
                                            </div>
                                            <button onclick="closeModal({{ $negocio->id }})" class="p-2 hover:bg-gray-100 rounded-full text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-6 max-h-96 overflow-y-auto">
                                            @if($negocio->users->count())
                                                <div class="space-y-3">
                                                    @foreach($negocio->users as $user)
                                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                                                    <span class="text-xs font-bold text-emerald-700">{{ substr($user->name, 0, 1) }}</span>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                                </div>
                                                            </div>
                                                            <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-600">
                                                                {{ $user->pivot->role ?? 'miembro' }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-center text-gray-500 py-8">No hay usuarios asignados</p>
                                            @endif
                                        </div>
                                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                                            <button onclick="closeModal({{ $negocio->id }})" class="w-full px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition">
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <p class="text-gray-500 font-medium">No hay negocios registrados</p>
                                            <p class="text-sm text-gray-400 mt-1">Comienza creando el primer negocio</p>
                                            <a href="{{ route('negocios.create') }}" class="mt-4 inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                                + Crear negocio
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($negocios->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $negocios->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function openModal(id) {
            const modal = document.getElementById('modal-' + id);
            if(modal) modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById('modal-' + id);
            if(modal) modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function confirmDelete(form) {
            if(confirm('¿Eliminar este negocio? Esta acción no se puede deshacer.')) {
                form.submit();
            }
        }

        document.addEventListener('keydown', function(event) {
            if(event.key === 'Escape') {
                document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                    modal.classList.add('hidden');
                });
                document.body.style.overflow = '';
            }
        });

        $('.select2').select2({
    width: '100%',
    placeholder: 'Seleccionar...',
    allowClear: true
});
    </script>
</x-app-layout>
