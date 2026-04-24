<?php

namespace App\Http\Controllers;

use App\Models\FarmaciaTurno;
use App\Models\FarmaciaRotacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FarmaciaTurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FarmaciaTurno::query();

        // Filtro por búsqueda (nombre o dirección)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('direccion', 'LIKE', "%{$search}%")
                    ->orWhere('telefono', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por estado (activo/inactivo)
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado);
        }

        // Filtro por turno hoy
        if ($request->filled('turno_hoy')) {
            $hoy = now();
            $diaSemana = $hoy->dayOfWeekIso;
            $semanaMes = ceil($hoy->day / 7);

            $query->whereHas('rotaciones', function ($q) use ($diaSemana, $semanaMes, $hoy) {
                $q->where('activo', true)
                    ->where(function ($sq) use ($diaSemana, $semanaMes, $hoy) {
                        $sq->where('dia_semana', $diaSemana)
                            ->where(function ($ssq) use ($semanaMes) {
                                $ssq->whereNull('semana_mes')
                                    ->orWhere('semana_mes', $semanaMes);
                            })
                            ->orWhere('fecha_especifica', $hoy->toDateString());
                    });
            });
        }

        $farmacias = $query->latest()->paginate(15);

        return view('farmacias.index', compact('farmacias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('farmacias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'direccion' => 'required|string',
                'telefono' => 'required|string|max:20',
                'latitud' => 'nullable|numeric|between:-90,90',
                'longitud' => 'nullable|numeric|between:-180,180',
                'horario_apertura' => 'nullable|date_format:H:i',
                'horario_cierre' => 'nullable|date_format:H:i|after:horario_apertura',
                'descripcion' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'activo' => 'nullable|boolean',
            ], [
                'nombre.required' => 'El nombre de la farmacia es obligatorio.',
                'direccion.required' => 'La dirección es obligatoria.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'horario_cierre.after' => 'El horario de cierre debe ser posterior al de apertura.',
                'logo.image' => 'El archivo debe ser una imagen.',
                'logo.max' => 'La imagen no debe superar los 2MB.',
            ]);

            // Subir logo si existe
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('farmacias', 'public');
            }

            $farmacia = FarmaciaTurno::create([
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'horario_apertura' => $request->horario_apertura,
                'horario_cierre' => $request->horario_cierre,
                'descripcion' => $request->descripcion,
                'logo' => $logoPath,
                'activo' => $request->has('activo') ? 1 : 0,
            ]);

            return redirect()
                ->route('farmacias.index')
                ->with('success', 'Farmacia creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la farmacia: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */


    public function show($id)
    {
        $farmacia = FarmaciaTurno::with('rotaciones')->findOrFail($id);

        // Mapeo manual de días y meses en español
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        // Obtener mes y año actual
        $mesActual = now()->month;
        $anioActual = now()->year;

        $diasTurno = [];
        foreach ($farmacia->rotaciones as $rotacion) {
            if ($rotacion->fecha_especifica) {
                $timestamp = strtotime($rotacion->fecha_especifica);
                $mesFecha = date('n', $timestamp);
                $anioFecha = date('Y', $timestamp);

                // Solo incluir fechas del mes y año actual
                if ($mesFecha == $mesActual && $anioFecha == $anioActual) {
                    $numeroDia = date('j', $timestamp);
                    $nombreDia = $dias[date('w', $timestamp)];
                    $nombreMes = $meses[$mesFecha - 1];
                    $anio = date('Y', $timestamp);

                    $diasTurno[] = [
                        'fecha' => $rotacion->fecha_especifica,
                        'texto' => "$nombreDia $numeroDia de $nombreMes $anio",
                    ];
                }
            }
        }

        $diasTurno = collect($diasTurno)->sortBy('fecha');

        return view('farmacias.show', compact('farmacia', 'diasTurno', 'mesActual', 'anioActual'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $farmacia = FarmaciaTurno::findOrFail($id);
        $dias = FarmaciaRotacion::DIAS;
        $semanas = FarmaciaRotacion::SEMANAS;

        return view('farmacias.edit', compact('farmacia', 'dias', 'semanas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $farmacia = FarmaciaTurno::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'direccion' => 'required|string',
                'telefono' => 'required|string|max:20',
                'latitud' => 'nullable|numeric|between:-90,90',
                'longitud' => 'nullable|numeric|between:-180,180',
                'horario_apertura' => 'nullable|date_format:H:i',
                'horario_cierre' => 'nullable|date_format:H:i|after:horario_apertura',
                'descripcion' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'activo' => 'nullable|boolean',
            ], [
                'nombre.required' => 'El nombre de la farmacia es obligatorio.',
                'direccion.required' => 'La dirección es obligatoria.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'horario_cierre.after' => 'El horario de cierre debe ser posterior al de apertura.',
                'logo.image' => 'El archivo debe ser una imagen.',
                'logo.max' => 'La imagen no debe superar los 2MB.',
            ]);

            $updateData = [
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'horario_apertura' => $request->horario_apertura,
                'horario_cierre' => $request->horario_cierre,
                'descripcion' => $request->descripcion,
                'activo' => $request->has('activo') ? 1 : 0,
            ];

            // Subir nuevo logo si existe
            if ($request->hasFile('logo')) {
                // Eliminar logo anterior si existe
                if ($farmacia->logo && Storage::disk('public')->exists($farmacia->logo)) {
                    Storage::disk('public')->delete($farmacia->logo);
                }

                // Guardar nuevo logo
                $updateData['logo'] = $request->file('logo')->store('farmacias', 'public');
            }

            $farmacia->update($updateData);

            return redirect()
                ->route('farmacias.index')
                ->with('success', ' Farmacia actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la farmacia: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $farmacia = FarmaciaTurno::findOrFail($id);
            $farmacia->delete();

            return redirect()
                ->route('farmacias.index')
                ->with('success', '✅ Farmacia eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Error al eliminar la farmacia: ' . $e->getMessage()]);
        }
    }

    /**
     * Store rotation rules for a pharmacy.
     */
    public function storeRotacion(Request $request, $id)
    {
        try {
            $farmacia = FarmaciaTurno::findOrFail($id);

            $request->validate([
                'dia_semana' => 'required|integer|between:1,7',
                'semana_mes' => 'nullable|integer|between:1,4',
                'fecha_especifica' => 'nullable|date',
            ], [
                'dia_semana.required' => 'El día de la semana es obligatorio.',
                'dia_semana.between' => 'El día de la semana no es válido.',
                'semana_mes.between' => 'La semana del mes no es válida.',
                'fecha_especifica.date' => 'La fecha específica no es válida.',
            ]);

            // Verificar si ya existe una rotación similar
            $exists = FarmaciaRotacion::where('farmacia_id', $id)
                ->where('dia_semana', $request->dia_semana)
                ->where(function ($q) use ($request) {
                    if ($request->filled('semana_mes')) {
                        $q->where('semana_mes', $request->semana_mes);
                    } else {
                        $q->whereNull('semana_mes');
                    }
                })
                ->where('activo', true)
                ->exists();

            if ($exists) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'Ya existe una rotación configurada para este día.']);
            }

            FarmaciaRotacion::create([
                'farmacia_id' => $id,
                'dia_semana' => $request->dia_semana,
                'semana_mes' => $request->semana_mes,
                'fecha_especifica' => $request->fecha_especifica,
                'activo' => true,
            ]);

            return redirect()
                ->route('farmacias.edit', $id)
                ->with('success', '✅ Rotación agregada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Error al agregar la rotación: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove a rotation rule.
     */
    public function destroyRotacion($id)
    {
        try {
            $rotacion = FarmaciaRotacion::findOrFail($id);
            $farmaciaId = $rotacion->farmacia_id;
            $rotacion->delete();

            return redirect()
                ->route('farmacias.edit', $farmaciaId)
                ->with('success', '✅ Rotación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Error al eliminar la rotación: ' . $e->getMessage()]);
        }
    }

    /**
     * Get pharmacy on duty today (for API/widget).
     */
    public function turnoHoy()
    {
        $hoy = now();
        $diaSemana = $hoy->dayOfWeekIso;
        $semanaMes = ceil($hoy->day / 7);

        $farmacia = FarmaciaTurno::where('activo', true)
            ->whereHas('rotaciones', function ($q) use ($diaSemana, $semanaMes, $hoy) {
                $q->where('activo', true)
                    ->where(function ($sq) use ($diaSemana, $semanaMes, $hoy) {
                        $sq->where('dia_semana', $diaSemana)
                            ->where(function ($ssq) use ($semanaMes) {
                                $ssq->whereNull('semana_mes')
                                    ->orWhere('semana_mes', $semanaMes);
                            })
                            ->orWhere('fecha_especifica', $hoy->toDateString());
                    });
            })
            ->first();

        return response()->json([
            'success' => true,
            'data' => $farmacia,
            'fecha' => $hoy->toDateString(),
            'dia' => $hoy->locale('es')->dayName,
        ]);
    }

    /**
     * Get turnos for a specific month (for calendar)
     */
}
