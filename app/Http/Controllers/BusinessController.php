<?php

namespace App\Http\Controllers;

use App\Models\Business;

use Illuminate\Http\Request;


class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Business::query();

        // =========================
        // SOLO NEGOCIOS DEL USUARIO LOGUEADO
        // =========================
        $query->whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });

        // =========================
        // BÚSQUEDA GENERAL
        // =========================
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('direccion', 'LIKE', "%{$search}%")
                    ->orWhere('telefono', 'LIKE', "%{$search}%");
            });
        }

        // =========================
        // FILTRO ESTADO
        // =========================
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado);
        }

        // =========================
        // ADMIN VE TODO (OPCIONAL)
        // =========================
        if ($user && $user->role === 'administrador') {
            $query = Business::query(); // override si admin
        }

        $negocios = $query->latest()->paginate(12);

        // usuarios para select2 (solo si admin)
        $users = \App\Models\User::orderBy('name')->get();

        return view('negocios.index', compact('negocios', 'users'));
    }

    public function create()
    {
        return view('negocios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'direccion' => 'required',
            'telefono' => 'required',
        ]);

        $business = Business::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        // Vincular usuario como OWNER
        $business->users()->attach(auth()->id(), [
            'role' => 'owner'
        ]);

        return redirect()->route('negocio.index');
    }

    public function show(Business $negocio)
    {
        // Verifica que el usuario pertenece al negocio
        if (!$negocio->users->contains(auth()->id())) {
            abort(403);
        }

        return view('negocios.show', compact('negocio'));
    }

    public function edit(Business $negocio)
    {
        if (!$negocio->users->contains(auth()->id())) {
            abort(403);
        }

        return view('negocios.edit', compact('negocio'));
    }

    public function update(Request $request, Business $negocio)
    {
        if (!$negocio->users->contains(auth()->id())) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|max:255',
            'direccion' => 'required',
            'telefono' => 'required',
        ]);

        $negocio->update($request->only([
            'nombre',
            'direccion',
            'telefono'
        ]));

        return redirect()->route('negocio.index');
    }

    public function destroy(Business $negocio)
    {
        if (!$negocio->users->contains(auth()->id())) {
            abort(403);
        }

        $negocio->delete();

        return redirect()->route('negocio.index');
    }
}
