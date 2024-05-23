<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiaryController extends Controller
{
    public function updateDiaryEntry(Request $request){
        $idUser = $request['idUser'] ?? null;
        $date = $request['date'] ?? null;
        $text = $request['text'] ?? null;

        if (!$idUser || !$date || !$text) {
        return response()->json(['message' => 'Faltan datos requeridos en la solicitud.']/*, 400*/);
        }

        $existingEntry = DB::table('diary')
            ->where('idUser', $idUser)
            ->where('date', $date) 
            ->first();

        if ($existingEntry) {
            DB::table('diary')
                ->where('idUser', $idUser)
                ->where('date', $date)
                ->update(['text' => $text]);

            return response()->json(['message' => 'Entrada de diario actualizada correctamente.'], 200);
        } else {
            DB::table('diary')->insert([
                'idUser' => $idUser,
                'date' => $date, 
                'text' => $text,
            ]);

            return response()->json(['message' => 'Nueva entrada de diario creada correctamente.'], 200);
        }
    }

    public function getDiaryEntry(Request $request){
        $jsonData = $request->json()->all();

        // Validar y obtener datos del JSON
        $idUser = $jsonData['idUser'] ?? null;
        $date = $jsonData['date'] ?? null;

        // Verificar si los datos necesarios están presentes
        if (!$idUser || !$date) {
            return response()->json(['error' => 'Faltan datos requeridos en la solicitud.'], 400);
        }

        // Buscar texto en la tabla diary para el usuario y la fecha especificados
        $diaryEntry = DB::table('diary')
            ->where('idUser', $idUser)
            ->whereDate('date', $date)
            ->value('text');

        if ($diaryEntry) {
            return response()->json(['text' => $diaryEntry], 200);
        } else {
            return response()->json(['text' => ''], 200); // Devuelve un texto vacío si no se encuentra nada
        }
    }
}
