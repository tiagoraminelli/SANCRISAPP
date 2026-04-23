<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <!-- Título + descripción (izquierda) -->
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Usuarios por Negocio
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Gestión de asignaciones de usuarios a comercios
                </p>
            </div>

            <!-- Acción (derecha)-->
           <a href="{{ route('monitoreo.negociosUsuarios.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-white text-gray-900 text-xs font-semibold uppercase tracking-widest
                      rounded-xl shadow hover:bg-gray-100 hover:shadow-md
                      transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nueva Asignación
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">


         {{-- ================= MENSAJES DE ÉXITO ================= --}}
@if(session('success'))
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-50 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm text-gray-700">{{ session('success') }}</p>
        </div>
    </div>
@endif

{{-- ================= MENSAJES DE ERROR ================= --}}
@if($errors->any())
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">Se encontraron errores:</p>
                <ul class="mt-1 list-disc list-inside text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

            {{-- ================= FILTROS ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <form method="GET" class="flex flex-wrap lg:flex-nowrap items-center gap-2">
                    <!-- BUSCADOR -->
                    <div class="flex-1 min-w-[180px]">
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar negocio o usuario..."
                            class="w-full h-9 px-3 rounded-lg border-gray-200
                                   text-sm text-black placeholder-gray-500
                                   focus:ring-black focus:border-black transition">
                    </div>

                    <!-- ROL -->
                    <div class="w-44 lg:w-36">
                        <select name="rol"
                            class="w-full h-9 rounded-lg border-gray-200
                                   text-sm text-black
                                   focus:ring-black focus:border-black">
                            <option value="">Todos los roles</option>
                            <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="owner" {{ request('rol') == 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="member" {{ request('rol') == 'member' ? 'selected' : '' }}>Member</option>
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
                    @if(request()->anyFilled(['search', 'rol']))
                        <a href="{{ route('negociosUsuarios.index') }}"
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
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Usuario</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Rol</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Asignación</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($relations as $relation)
                                <tr class="hover:bg-gray-50 transition group">
                                    {{-- NEGOCIO --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                                                @php
                                                    $logoExists = $relation->business->logo && Storage::disk('public')->exists($relation->business->logo);
                                                @endphp
                                                @if($logoExists)
                                                    <img src="{{ asset('storage/' . $relation->business->logo) }}"
                                                         class="w-full h-full object-cover"
                                                         alt="logo">
                                                @else
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4 21V7l8-4 8 4v14" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $relation->business->nombre }}</div>
                                                <div class="text-xs text-gray-400 mt-0.5 max-w-[200px] truncate">{{ $relation->business->direccion }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- USUARIO --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-bold text-emerald-700">{{ substr($relation->user->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $relation->user->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $relation->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

{{-- ROL --}}
<td class="px-6 py-4">
    @php
        $roleValue = $relation->role ?? 'empleado';

        $displayName = match($roleValue) {
            'propietario' => 'Propietario',
            'administrador' => 'Administrador',
            'empleado' => 'Empleado',
            default => ucfirst($roleValue),
        };

        $colorClass = match($roleValue) {
            'propietario' => 'bg-emerald-100 text-emerald-700',
            'administrador' => 'bg-purple-100 text-purple-700',
            'empleado' => 'bg-gray-100 text-gray-600',
            default => 'bg-gray-100 text-gray-600',
        };

        $dotClass = match($roleValue) {
            'propietario' => 'bg-emerald-600',
            'administrador' => 'bg-purple-600',
            'empleado' => 'bg-gray-500',
            default => 'bg-gray-500',
        };
    @endphp
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
        {{ $displayName }}
    </span>
</td>
                                    {{-- FECHA ASIGNACIÓN --}}
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-gray-500">{{ $relation->created_at?->format('d/m/Y H:i') }}</span>
                                    </td>

                                    {{-- ACCIONES --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-1">
                                            <a href="#" class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition" title="Ver detalles">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('monitoreo.negociosUsuarios.edit', $relation->id) }}" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('monitoreo.negociosUsuarios.destroy', $relation->id) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this)">
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
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <p class="text-gray-500 font-medium">No hay asignaciones registradas</p>
                                            <p class="text-sm text-gray-400 mt-1">Comienza asignando usuarios a negocios</p>
                                            <a href="#" class="mt-4 inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                                + Nueva asignación
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                @if($relations->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $relations->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(form) {
            if(confirm('¿Eliminar esta asignación? Esta acción no se puede deshacer.')) {
                form.submit();
            }
        }
    </script>
</x-app-layout>
