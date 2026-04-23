<?php

namespace App\Http\Controllers;

use App\Models\BusinessUser;
use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BusinessUser::with(['user', 'business']);

        // Filtro por búsqueda (negocio o usuario)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('business', function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('direccion', 'LIKE', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('role', $request->rol);
        }

        $relations = $query->latest()->paginate(15);

        // Para selects de filtros (si los necesitas)
        $users = User::orderBy('name')->get();
        $businesses = Business::orderBy('nombre')->get();

        return view('negociosUsuarios.index', compact('relations', 'users', 'businesses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $businesses = Business::orderBy('nombre')->get();

        return view('negociosUsuarios.create', compact('users', 'businesses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'business_id' => 'required|exists:businesses,id',
            'role' => 'required|in:administrador,propietario,empleado',
        ]);

        BusinessUser::create($request->all());

        return redirect()->route('negociosUsuarios.index')
            ->with('success', 'Asignación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessUser $negociosUsuario)
    {
        $negociosUsuario->load(['user', 'business']);

        return view('negociosUsuarios.show', compact('negociosUsuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $negociosUsuario = BusinessUser::with(['user', 'business'])->findOrFail($id);
        $users = User::orderBy('name')->get();
        $businesses = Business::orderBy('nombre')->get();

        return view('negociosUsuarios.edit', compact('negociosUsuario', 'users', 'businesses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Buscar la asignación por ID
            $negociosUsuario = BusinessUser::findOrFail($id);

            // Validar los datos
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'business_id' => 'required|exists:negocios,id',
                'role' => 'required|in:propietario,empleado,administrador',
            ], [
                'user_id.required' => 'El campo Usuario es obligatorio.',
                'user_id.exists' => 'El usuario seleccionado no existe.',
                'business_id.required' => 'El campo Negocio es obligatorio.',
                'business_id.exists' => 'El negocio seleccionado no existe.',
                'role.required' => 'El campo Rol es obligatorio.',
                'role.in' => 'El rol seleccionado no es válido.',
            ]);

            // Verificar si ya existe otra asignación con el mismo user_id y business_id
            $exists = BusinessUser::where('user_id', $request->user_id)
                ->where('business_id', $request->business_id)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['business_id' => 'Ya existe una asignación para este usuario y negocio.']);
            }

            // Actualizar la asignación
            $negociosUsuario->update([
                'user_id' => $request->user_id,
                'business_id' => $request->business_id,
                'role' => $request->role,
            ]);

            return redirect()
                ->route('monitoreo.negociosUsuarios.index')
                ->with('success', '✅ Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessUser $negociosUsuario)
    {
        $negociosUsuario->delete();

        return redirect()->route('negociosUsuarios.index')
            ->with('success', 'Asignación eliminada exitosamente.');
    }

    public function storeMultiple(Request $request)
    {
        $request->validate(
            [
                'asignaciones.*.user_id' => 'required|exists:users,id',
                'asignaciones.*.business_id' => 'required|exists:negocios,id',
                'asignaciones.*.role' => 'required|in:administrador,propietario,empleado',
            ],
            [
                'asignaciones.*.user_id.required' => 'El campo Usuario es obligatorio.',
                'asignaciones.*.user_id.exists' => 'El usuario seleccionado no existe.',
                'asignaciones.*.business_id.required' => 'El campo Negocio es obligatorio.',
                'asignaciones.*.business_id.exists' => 'El negocio seleccionado no existe.',
                'asignaciones.*.role.required' => 'El campo Rol es obligatorio.',
                'asignaciones.*.role.in' => 'El rol seleccionado no es válido. Debe ser administrador, propietario o empleado.',
            ]
        );

        try {
            foreach ($request->asignaciones as $asignacion) {
                BusinessUser::updateOrCreate(
                    [
                        'user_id' => $asignacion['user_id'],
                        'business_id' => $asignacion['business_id'],
                    ],
                    ['role' => $asignacion['role']]
                );
            }

            return redirect()->route('monitoreo.negociosUsuarios.index')
                ->with('success', count($request->asignaciones) . ' asignaciones creadas exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear las asignaciones: ' . $e->getMessage()]);
        }
    }
}
