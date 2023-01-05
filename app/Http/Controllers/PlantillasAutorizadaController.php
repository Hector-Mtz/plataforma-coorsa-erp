<?php

namespace App\Http\Controllers;

use App\Models\PlantillasAutorizada;
use App\Models\puesto;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PlantillasAutorizadaController extends Controller
{
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc']
        ]);



        //Get catologos
        $puestos = puesto::select('puestos.id', 'puestos.name');

        if (request()->has('search')) {

            $search = '%' . str(request('search'))->replace('%', '\\%') . '%';
            $puestos->where('puestos.name', 'like', $search);
        }

        if (request()->has('field')) {
            $puestos->orderBy(request('field'), request('direction'));
        } else {
            $puestos->orderBy('puestos.name', 'asc');
        }

        $ubicaciones = Ubicacion::select('ubicaciones.id', 'ubicaciones.name')
            ->with([
                'plantillasAutorizadas' => function ($query) {
                    $query->select('plantillas_autorizadas.*')
                        ->selectRaw('count(users.id) as cantidad_activa')
                        ->leftJoin('cecos', 'plantillas_autorizadas.ubicacione_id', '=', 'cecos.ubicacione_id')
                        ->leftJoin('empleados_puestos', function ($join) {
                            $join->on('cecos.id', '=', 'empleados_puestos.departamento_id')
                                ->on('plantillas_autorizadas.puesto_id', '=', 'empleados_puestos.puesto_id')
                                ->on('empleados_puestos.activo', '=', DB::raw(1));
                        })
                        ->leftJoin('users', function ($join) {
                            $join->on('empleados_puestos.empleado_id', '=', 'users.id')
                                ->on('users.activo', '=', DB::raw(1));
                        })
                        ->groupBy('plantillas_autorizadas.id');
                }
            ])->orderBy('ubicaciones.id', 'asc');

        return Inertia::render('PlantillasAutorizadas/PlantillasAutorizadasIndex', [
            'puestos' => fn () => $puestos->get(),
            'ubicaciones' => fn () => $ubicaciones->get(),
            'filters' => fn () => request()->all(['search', 'field', 'direction'])
        ]);
    }

    public function store(Request $request)
    {
        $validated =  $request->validate([
            'puesto_id' =>  ['required', 'exists:puestos,id'],
            'ubicacione_id' => ['required', 'exists:ubicaciones,id'],
            'cantidad' => ['required', 'numeric', 'min:0'],
        ]);
        //me aseguro de no doplicar registros en el mismo puesto y ubicacion
        $plantillasAutorizada =  PlantillasAutorizada::updateOrCreate([
            'puesto_id' =>   $validated['puesto_id'],
            'ubicacione_id' =>  $validated['ubicacione_id'],
        ], [
            'cantidad' =>   $validated['cantidad'],
        ]);
        return redirect()->back();
    }


    public function update(Request $request, PlantillasAutorizada $plantillasAutorizada)
    {
        $validated =  $request->validate([
            'cantidad' => ['required', 'numeric', 'min:0'],
        ]);

        $plantillasAutorizada->update($validated);

        return redirect()->back();
        return response()->json([
            'message' => 'updated'
        ]);
    }
}
