<?php

namespace App\Http\Controllers;

use App\Models\FarmaciaTurno;
use App\Models\FarmaciaRotacion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FarmaciaRotacionController extends Controller
{
    /**
     * Display a listing of the rotations for a pharmacy.
     */
    public function index($farmacia_id)
    {
        $farmacia = FarmaciaTurno::findOrFail($farmacia_id);

        $query = FarmaciaRotacion::where('farmacia_id', $farmacia_id);

        // Filtro de búsqueda mejorado
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where(function ($q) use ($search) {
                // Buscar por día de la semana (nombre)
                $diaEncontrado = null;
                foreach (FarmaciaRotacion::DIAS as $num => $nombre) {
                    if (stripos($nombre, $search) !== false || stripos(substr($nombre, 0, 3), $search) !== false) {
                        $diaEncontrado = $num;
                        break;
                    }
                }

                if ($diaEncontrado) {
                    $q->orWhere('dia_semana', $diaEncontrado);
                }

                // Buscar por fecha específica en formato Y-m-d, d/m, d/m/Y
                $fechaParsed = null;
                // Formato d/m/Y
                if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $search, $matches)) {
                    $fechaParsed = "{$matches[3]}-{$matches[2]}-{$matches[1]}";
                }
                // Formato d/m
                elseif (preg_match('/^(\d{1,2})\/(\d{1,2})$/', $search, $matches)) {
                    $fechaParsed = "%-{$matches[2]}-{$matches[1]}";
                    $q->orWhere('fecha_especifica', 'LIKE', $fechaParsed);
                }
                // Formato Y-m-d
                elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $search)) {
                    $fechaParsed = $search;
                    $q->orWhere('fecha_especifica', $fechaParsed);
                }

                if ($fechaParsed && strpos($fechaParsed, '%-') !== 0) {
                    $q->orWhere('fecha_especifica', $fechaParsed);
                }

                // Buscar por mes (enero, febrero, etc.)
                $meses = [
                    'enero' => 1,
                    'febrero' => 2,
                    'marzo' => 3,
                    'abril' => 4,
                    'mayo' => 5,
                    'junio' => 6,
                    'julio' => 7,
                    'agosto' => 8,
                    'septiembre' => 9,
                    'octubre' => 10,
                    'noviembre' => 11,
                    'diciembre' => 12
                ];

                foreach ($meses as $mesNombre => $mesNum) {
                    if (stripos($search, $mesNombre) !== false) {
                        $q->orWhere('fecha_especifica', 'LIKE', "%-{$mesNum}-%");
                        break;
                    }
                }

                // Búsqueda por texto plano
                $q->orWhere('dia_semana', 'LIKE', "%{$search}%")
                    ->orWhere('fecha_especifica', 'LIKE', "%{$search}%");
            });
        }

        if (request()->filled('fecha')) {
            $query->whereDate('fecha_especifica', request()->fecha);
        }

        // Filtros adicionales
        if (request()->filled('tipo')) {
            if (request()->tipo == 'semanal') {
                $query->whereNull('fecha_especifica');
            } elseif (request()->tipo == 'especifica') {
                $query->whereNotNull('fecha_especifica');
            }
        }

        if (request()->filled('activo')) {
            $query->where('activo', request()->activo);
        }

        $rotaciones = $query->orderByRaw('CASE WHEN fecha_especifica IS NOT NULL THEN 1 ELSE 0 END')
            ->orderBy('dia_semana')
            ->orderBy('fecha_especifica')
            ->paginate(15);

        return view('farmacias.rotaciones.index', compact('farmacia', 'rotaciones'));
    }


    /**
     * Show the form for creating a new rotation.
     */
    public function create($farmacia_id)
    {
        $farmacia = FarmaciaTurno::findOrFail($farmacia_id);

        return view('farmacias.rotaciones.create', compact('farmacia'));
    }

    /**
     * Store multiple rotations in storage.
     */
    public function store(Request $request, $farmacia_id)
    {
        try {
            $farmacia = FarmaciaTurno::findOrFail($farmacia_id);

            // Validación para múltiples fechas
            $request->validate([
                'fechas' => 'required|array|min:1',
                'fechas.*' => 'required|date',
                'activo' => 'nullable|boolean',
            ], [
                'fechas.required' => 'Debe seleccionar al menos una fecha.',
                'fechas.*.required' => 'La fecha es obligatoria.',
                'fechas.*.date' => 'La fecha no es válida.',
            ]);

            $creadas = 0;
            $duplicadas = 0;
            $fechasExistentes = [];

            foreach ($request->fechas as $fecha) {
                // Verificar si ya existe una rotación con esta fecha
                $exists = FarmaciaRotacion::where('farmacia_id', $farmacia_id)
                    ->where('fecha_especifica', $fecha)
                    ->exists();

                if ($exists) {
                    $duplicadas++;
                    $fechasExistentes[] = Carbon::parse($fecha)->format('d/m/Y');
                    continue;
                }

                // Crear nueva rotación
                FarmaciaRotacion::create([
                    'farmacia_id' => $farmacia_id,
                    'fecha_especifica' => $fecha,
                    'dia_semana' => null,
                    'semana_mes' => null,
                    'activo' => $request->has('activo'),
                ]);
                $creadas++;
            }

            // Mensaje de resultado
            if ($creadas == 0 && $duplicadas > 0) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['error' => 'Las siguientes fechas ya existen como rotación: ' . implode(', ', $fechasExistentes)]);
            }

            $mensaje = '';
            if ($creadas > 0) {
                $mensaje .= " $creadas rotación(es) creada(s) exitosamente.";
            }
            if ($duplicadas > 0) {
                $mensaje .= "  $duplicadas fecha(s) ya existían: " . implode(', ', $fechasExistentes);
            }

            return redirect()
                ->route('farmacias.rotaciones.index', $farmacia_id)
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear las rotaciones: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing a rotation.
     */
    public function edit($id)
    {
        $rotacion = FarmaciaRotacion::findOrFail($id);
        $farmacia = $rotacion->farmacia;
        $dias = FarmaciaRotacion::DIAS;
        $semanas = FarmaciaRotacion::SEMANAS;

        return view('farmacias.rotaciones.edit', compact('rotacion', 'farmacia', 'dias', 'semanas'));
    }

    /**
     * Update the specified rotation in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $rotacion = FarmaciaRotacion::findOrFail($id);
            $farmacia_id = $rotacion->farmacia_id;

            $request->validate([
                'tipo_rotacion' => 'required|in:semanal,especifica',
                'dia_semana' => 'required_if:tipo_rotacion,semanal|nullable|integer|between:1,7',
                'semana_mes' => 'nullable|integer|between:1,4',
                'fecha_especifica' => 'required_if:tipo_rotacion,especifica|nullable|date|after_or_equal:today',
                'activo' => 'nullable|boolean',
            ], [
                'tipo_rotacion.required' => 'Debe seleccionar un tipo de rotación.',
                'dia_semana.required_if' => 'Debe seleccionar un día de la semana.',
                'dia_semana.between' => 'El día de la semana no es válido.',
                'fecha_especifica.required_if' => 'Debe seleccionar una fecha específica.',
                'fecha_especifica.date' => 'La fecha no es válida.',
                'fecha_especifica.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            ]);

            if ($request->tipo_rotacion == 'semanal') {
                // Verificar duplicado excluyendo el actual
                $exists = FarmaciaRotacion::where('farmacia_id', $farmacia_id)
                    ->where('id', '!=', $id)
                    ->where('dia_semana', $request->dia_semana)
                    ->where(function ($q) use ($request) {
                        if ($request->filled('semana_mes')) {
                            $q->where('semana_mes', $request->semana_mes);
                        } else {
                            $q->whereNull('semana_mes');
                        }
                    })
                    ->whereNull('fecha_especifica')
                    ->exists();

                if ($exists) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['error' => 'Ya existe otra rotación semanal configurada para este día.']);
                }

                $rotacion->update([
                    'dia_semana' => $request->dia_semana,
                    'semana_mes' => $request->semana_mes,
                    'fecha_especifica' => null,
                    'activo' => $request->has('activo'),
                ]);
            } else {
                // Tipo específico
                $exists = FarmaciaRotacion::where('farmacia_id', $farmacia_id)
                    ->where('id', '!=', $id)
                    ->where('fecha_especifica', $request->fecha_especifica)
                    ->exists();

                if ($exists) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['error' => 'Ya existe otra rotación configurada para esta fecha.']);
                }

                $rotacion->update([
                    'dia_semana' => null,
                    'semana_mes' => null,
                    'fecha_especifica' => $request->fecha_especifica,
                    'activo' => $request->has('activo'),
                ]);
            }

            return redirect()
                ->route('farmacias.show', $farmacia_id)
                ->with('success', '✅ Rotación actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la rotación: ' . $e->getMessage()]);
        }
    }



    /**
     * Remove the specified rotation from storage.
     */
    public function destroy($id)
    {
        try {
            $rotacion = FarmaciaRotacion::findOrFail($id);
            $farmacia_id = $rotacion->farmacia_id;
            $rotacion->delete();

            return redirect()
                ->route('farmacias.show', $farmacia_id)
                ->with('success', '✅ Rotación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Error al eliminar la rotación: ' . $e->getMessage()]);
        }
    }
}
