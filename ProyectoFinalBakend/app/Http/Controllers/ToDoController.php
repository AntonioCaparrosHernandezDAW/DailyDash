<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    public function createToDo(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las tareas",
                'status'=>false
            ], 400);
        }

        //Mensajes de error
        $messages = [
            'titulo.required' => 'El título de la tarea es obligatorio',
            'titulo.max' => 'El título de tarea solo puede tener como máximo 50 carácteres',
            'fechaInicio.required'=>'La fecha de inicio de la tarea es obligatoria',
            'fechaInicio.date'=>'La fecha de inicio debe ser una fecha',
            'fechaFin.required'=>'La fecha de finalización de la tarea es obligatoria',
            'fechaFin.date'=>'La fecha de finalización debe ser una fecha',
            'fechaFin.after_or_equal'=>'La fecha de finalización no puede ser anterior a la de inicio'
        ];

        $rules=[
            "titulo" => "required|max:50",
            'fechaInicio'=>'required|date',
            'fechaFin'=>'required|date|after_or_equal:fechaInicio'
        ];

        $validator = Validator::make($request->input(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }

        $toDoCount = DB::table('todos')
            ->where('idUsuario',$user->id)
            ->count();

        if($toDoCount>=50){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Un usuario no puede tener mas de 50 tareas, por favor borra alguna",
                'status'=>false
            ], 400);
        }else if($toDoCount>=15){
            if($user->premium!=1){
                return response()->json([
                    'errorTitle' => "Error",
                    'errorText' => "El límite de tareas del usuario no premium es de 15 máximo",
                    'status'=>false
                ], 400);
            }
        }

        $titleChecker=DB::table('todos')->where('idUsuario',$user->id)->where('titulo',$request['titulo'])->first();
        if($titleChecker!=null){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Las tareas no pueden tener un título repetido",
                'status'=>false
            ], 400);
        }

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
    }

    public function listToDos(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las tareas",
                'status'=>false
            ], 400);
        }

        $toDoList = DB::table('todos')
            ->where('idUsuario',$user->id)
            ->where('visible', 1)
            ->get();

        return response()->json([
            "todos"=>$toDoList
        ]);
    }

    public function completeToDo(Request $request){ 
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first(); 

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las tareas2",
                'status'=>false
            ], 400);
        }

        DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request["titulo"])
            ->update([
                'completada'=>$request['estadoCompletado']
            ]);
    }

    public function deleteToDo(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las tareas",
                'status'=>false
            ], 400);
        }

        DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request["titulo"])
            ->update([
                'visible'=>false
            ]);
    }

    public function updateToDo(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        //Mensajes de error
        $messages = [
            'titulo.required' => 'El título de la tarea es obligatorio',
            'titulo.max' => 'El título de tarea solo puede tener como máximo 50 carácteres',
            'fechaInicio.required'=>'La fecha de inicio de la tarea es obligatoria',
            'fechaInicio.date'=>'La fecha de inicio debe ser una fecha',
            'fechaFin.required'=>'La fecha de finalización de la tarea es obligatoria',
            'fechaFin.date'=>'La fecha de finalización debe ser una fecha',
            'fechaFin.after_or_equal'=>'La fecha de finalización no puede ser anterior a la de inicio'
        ];

        $rules=[
            "titulo" => "required|max:50",
            'fechaInicio'=>'required|date',
            'fechaFin'=>'required|date|after_or_equal:fechaInicio'
        ];

        $validator = Validator::make($request->input(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las tareas",
                'status'=>false
            ], 400);
        }

        DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request["tituloOriginal"])
            ->update([
                "titulo"=>$request["titulo"],
                "prioridad"=>$request["prioridad"],
                "fechaInicio"=>$request["fechaInicio"],
                "fechaFin"=>$request["fechaFin"],
            ]);
    }

    public function getToDoCode(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las tareas",
                'status'=>false
            ], 400);
        }

        DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request['titulo'])
            ->update([
                'codigoImportar'=> bin2hex(random_bytes(20))
            ]);

        $toDo = DB::table('todos')
            ->where('idUsuario', $user->id)
            ->where('titulo', $request['titulo'])
            ->first();

        return response()->json([
            'responseTitle'=> "Código de importación:",
            'responseText'=> $toDo->codigoImportar,
            'status'=> true
        ]);
    }

    public function importToDo(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al importar la tarea",
                'status'=>false
            ], 400);
        }

        $toDo = DB::table('todos')
            ->where('codigoImportar', $request['importCode'])
            ->first();

        if(!$toDo){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al importar la tarea, por favor revise el código de importación",
                'status'=>false
            ], 400);
        }

        if($user->id == $toDo->idUsuario){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "No se puede importar una tarea propia",
                'status'=>false
            ], 400);
        }else{
            DB::table('imported_todos')
                ->insert([
                    'idUser'=>$user->id,
                    'idToDo'=>$toDo->idTarea
                ]);
        }

        return response()->json([
            'responseTitle'=> "Tarea importada:",
            'responseText'=> "La tarea ha sido importada correctamente",
            'status'=> true
        ]);
    }

    public function listImportedToDos(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al importar la tarea",
                'status'=>false
            ], 400);
        }

        $dataToImport=DB::table('imported_todos')
            ->where('idUser', $user->id)
            ->get();

        $importedToDos=[];

        foreach($dataToImport as $data){
            $todo = DB::table('todos')
                ->where('idTarea',$data->idToDo)
                ->first();

            array_push($importedToDos, $todo);
        }

        return response()->json([
            'importedToDos'=> $importedToDos
        ]);
    }
}
