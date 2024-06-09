<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function createNote(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las notas",
                'status'=>false
            ], 400);
        }

        //Mensajes de error
        $messages = [
            'noteTitle.required' => 'El titulo de la nota es obligatorio',
            'noteText.required' => 'El texto de la nota es obligatorio',
        ];

        if($user->premium != 1){
            $rules=[
                "noteTitle" => "required|max:15",
                "noteText" => "required|max:100",
            ];

            $messages['noteTitle.max'] = 'El título máximo para usuarios no premium es de 15 caracteres';
            $messages['noteText.max'] = 'El texto máximo para usuarios no premium es de 100 caracteres';
        }else{
            $rules=[
                "noteTitle" => "required|max:50",
                "noteText" => "required|max:1000",
            ];

            $messages['noteTitle.max'] = 'El título máximo para usuarios no premium es de 50 caracteres';
            $messages['noteText.max'] = 'El texto máximo para usuarios no premium es de 1000 caracteres';
        }

        //Validaciones
        $validator = Validator::make($request->input(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }

        DB::table('notes')->insert([
            'idUser'=>$user->id,
            'title'=>$request['noteTitle'],
            'text'=>$request['noteText'],
            'date'=>Carbon::now(),
        ]);
    }

    public function listNotes(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las notas",
                'status'=>false
            ], 400);
        }

        $notesList = DB::table('notes')
            ->where('idUser',$user->id)
            ->where('visible', 1)
            ->get();

        return response()->json([
            "notes"=>$notesList
        ]);
    }

    public function updateNote(Request $request){
        $note = DB::table('notes')
            ->where('idNote', $request['idNote'])
            ->first();

        if(!$note){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al localizar la nota, por favor vuelva a intentarlo",
                'status'=>false
            ], 400);
        }

        $user = DB::table('usuarios')
            ->where('id',$note->idUser)
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar las notas",
                'status'=>false
            ], 400);
        }

        //Mensajes de error
        $messages = [
            'noteTitle.required' => 'El titulo de la nota es obligatorio',
            'noteText.required' => 'El texto de la nota es obligatorio',
        ];

        if($user->premium != 1){
            $rules=[
                "noteTitle" => "required|max:15",
                "noteText" => "required|max:100",
            ];

            $messages['noteTitle.max'] = 'El título máximo para usuarios no premium es de 15 caracteres';
            $messages['noteText.max'] = 'El texto máximo para usuarios no premium es de 100 caracteres';
        }else{
            $rules=[
                "noteTitle" => "required|max:50",
                "noteText" => "required|max:1000",
            ];

            $messages['noteTitle.max'] = 'El título máximo para usuarios no premium es de 50 caracteres';
            $messages['noteText.max'] = 'El texto máximo para usuarios no premium es de 1000 caracteres';
        }

        //Validaciones
        $validator = Validator::make($request->input(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }
        
        $updated = DB::table('notes')
            ->where('idNote', $request['idNote'])
            ->update([
                'title' => $request['noteTitle'],
                'text' => $request['noteText']
            ]);

        if (!$updated) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al actualizar la nota",
                'status'=>false
            ], 400);
        }
    }

    public function deleteNote(Request $request){
        $note = DB::table('notes')
            ->where('idNote', $request['idNote'])
            ->first();

        if(!$note){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al localizar la nota, por favor vuelva a intentarlo",
                'status'=>false
            ], 400);
        }

        $updated = DB::table('notes')
            ->where('idNote', $request['idNote'])
            ->update([
                'visible'=>false
            ]);

        if (!$updated) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al actualizar la nota",
                'status'=>false
            ], 400);
        }
    }
}