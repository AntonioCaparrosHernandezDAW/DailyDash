<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToDoController extends Controller
{
    public function createToDo(Request $request){
        //Hacer que no se pueda repetir el titulo de la tarea para ese usuario
        /*$request->validate([
            'titulo' => 'required|string|max:255|unique:todos,titulo',
        ]);*/

        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        DB::table('todos')
        ->insert([
            "idUsuario"=>$user->id,
            "usuariosAsociados"=>null,
            "titulo"=>$request['titulo'],
            "prioridad"=>$request['prioridad'],
            "fechaInicio"=>$request['fechaInicio'],
            "fechaFin"=>$request['fechaFin'],
            "completada"=> 0
        ]);

        return response()->json([
            'message'=>'Tarea creada correctamente'
        ]);
    }

    public function listToDos(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['token'])
            ->first();

        $toDoList = DB::table('todos')
            ->where('idUsuario',$user->id)
            ->get();

        return response()->json([
            "todos"=>$toDoList
        ]);
    }

    public function completeToDo(Request $request){ 
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first(); 

        DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request["titulo"])
            ->update([
                'completada'=>$request['estadoCompletado']
            ]);

        return response()->json([
            "response"=>"Exito en la modificación de la tarea"
        ]);
    }

    public function deleteToDo(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request["titulo"])
            ->delete();
            
        return response()->json([
            "response"=>"Exito al borrar la tarea"
        ]);
    }

    public function updateToDo(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request["titulo"])
            ->update([
                "titulo"=>$request["valoresEditados"]["titulo"],
                "prioridad"=>$request["valoresEditados"]["prioridad"],
                "fechaInicio"=>$request["valoresEditados"]["fechaInicio"],
                "fechaFin"=>$request["valoresEditados"]["fechaFin"],
            ]);
            
        return response()->json([
            "response"=>"Exito al editar la tarea"
        ]);
    }
}
