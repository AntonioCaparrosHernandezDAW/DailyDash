<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NoteController extends Controller
{
    public function createNote(Request $request){
        DB::table('notes')->insert([
            'idUser'=>$request['idUser'],
            'title'=>$request['noteTitle'],
            'text'=>$request['noteText'],
            'date'=>Carbon::now(),
        ]);

        return response()->json([
            'status'=>'nota creada Correctamente'
        ]);
    }
}
