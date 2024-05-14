<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validaciones
        $credentials = $request->validate([
            "email" => "required|email|unique:usuarios",
            "password" => "required|confirmed",
        ]);

        // Generar token único
        $rememberToken = Str::random(60);

        // DDBB insert
        DB::table("usuarios")->insert([
            "email" => $request['email'],
            "password" => Hash::make($request['password']),
            "remember_token" => $rememberToken,
        ]);

        $prueba = DB::table("usuarios")->where('remember_token', $rememberToken)->first();

        return response()->json([
            'token'=>$rememberToken,
            'prueba'=>$prueba
        ]);    
    }

    public function login(Request $request){
        $user = DB::table("usuarios")->where("email", $request->input("email"))->first();

        if ($user && Hash::check($request->input("password"), $user->password)) {
            return response()->json([
                "user" => $user->email,
                "token" => $user->remember_token
            ]);       
        } else {
            return response()->json(["error" => "Credenciales inválidas"], 401);
        }
    }
}
