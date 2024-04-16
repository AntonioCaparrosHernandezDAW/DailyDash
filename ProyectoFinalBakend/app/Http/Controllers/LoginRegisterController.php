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

        return response($rememberToken);        
    }

    public function login(Request $request){
        $user = DB::table("usuarios")->where("email", $request->input("email"))->first();

        if ($user && Hash::check($request->input("password"), $user->password)) {
            return response()->json(["id" => $user->id]);
        } else {
            return response()->json(["error" => "Credenciales inválidas"], 401);
        }
    }
}