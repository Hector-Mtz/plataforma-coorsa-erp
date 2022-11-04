<?php

namespace App\Http\Controllers;

use App\Models\DireccionEstado;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    //
    public function formularioEmpleado () 
    {
        $direccionEstado = DireccionEstado::select('id', 'nombre', 'activo')->where('activo', 1)->get();
        return response()->json([
            /*'departamentos' => $departamentos,
            'escolaridades' => $escolaridades,
            'bancos' => $bancos,
            'tiposContratos' => $tiposContratos,
            'tiposSangres' => $catTiposSangres,
            'estadosCiviles' =>  $estadosCiviles,
            'motivosBajas' =>  $motivosBajas,*/
            'estadosDireccion' => $direccionEstado
        ]);
    }
}
