<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiaryController extends Controller
{
    //Comprueba si el usuario introducido en el día seleccionado tiene datos en el diario y los devuelve, o devuelve una cadena vacía en caso negativo
    public function getDiaryEntry(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        $diaryEntry = DB::table('diary')
            ->where('idUser', $user->id)
            ->where('date', $request['date'])
            ->value('text');

        if ($diaryEntry) {
            return response()->json([
                'text' => $diaryEntry
            ]);
        } else {
            return response()->json([
                'text' => ''
            ]);
        }
    }

    //Comprueba las limitaciones de un usuario premium/no premium y actualiza el registro del diario de el usuario seleccionado en el día establecido por el nuevo texto
    public function updateDiaryEntry(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if($user->premium != 1){
            $rules=[
                "text" => "max:500",
            ];

            $messages = [
                'text.max'=>'El texto máximo para usuarios no premium es de 500 caracteres'
            ];
        }else{
            $rules=[
                "text" => "max:3000",
            ];

            $messages = [
                'text.max'=>'El texto máximo para usuarios no premium es de 3000 caracteres'
            ];
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

        $existingEntry = DB::table('diary')
            ->where('idUser', $user->id)
            ->where('date', $request['date']) 
            ->first();

        if ($existingEntry) {
            DB::table('diary')
                ->where('idUser', $user->id)
                ->where('date', $request['date'])
                ->update(['text' => $request['text']]);
        } else {
             DB::table('diary')->insert([
                'idUser' => $user->id,
                'date' => $request['date'], 
                'text' => $request['text'],
            ]);
        }
    }
}
