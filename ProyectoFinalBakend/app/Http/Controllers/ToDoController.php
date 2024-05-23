<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToDoController extends Controller
{
    public function createToDo(Request $post){
        DB::table('todos')
        ->insert([
            "idUsuario"=>$request['userId'],
            "usuariosAsociados"=>null,
            "titulo"=>$request['titulo'],
            "prioridad"=>$request['prioridad'],
            "fechaInicio"=>$request['fechaInicio'],
            "fechaFin"=>$request['fechaFin'],
        ]);

        return response()->json([
            'message'=>'Tarea creada correctamente'
        ]);
    }
}
