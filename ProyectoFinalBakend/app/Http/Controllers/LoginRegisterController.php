<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RememberPasswordCodeEmail;

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

        //Generar username
        $userCount = DB::table('usuarios')->count();
        $username = 'Usuario' . ($userCount + 1);

        // DDBB insert
        DB::table("usuarios")->insert([
            "username"=> $username,
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
        $user = DB::table("usuarios")
        ->where("email", $request["email"])
        ->first();

        if(!$user){
            return response()->json([
                'error'=>"El usuario no ha sido encontrado"
            ]);
        }

        if (Hash::check($request["password"], $user->password)) {
            return response()->json([
                "user" => $user->email,
                "token" => $user->remember_token
            ]);       
        } else {
            return response()->json(
                ["error" => "Credenciales inválidas"]
            );
        }
    }

    public function sendEmailToRemember(Request $request){
        //Comprobar email

        $token_password= bin2hex(random_bytes(30));

        $user = DB::table("usuarios")
        ->where("email", $request["email"])
        ->update([
            'token_password'=>$token_password
        ]);

        Mail::to('antonioclasedaw@gmail.com')->send(new RememberPasswordCodeEmail($token_password));
        return response()->json([
            "resultado" => "ok"
        ]);
    }

    public function changePasswordWithCode(Request $request){
        $user = DB::table("usuarios")
        ->where("email", $request["email"])
        ->first();

        if($user->token_password == $request['code']){
            $user = DB::table("usuarios")
                ->where("email", $request["email"])
                ->update([
                    'password'=> Hash::make($request['newPassword'])
                ]);

            return response()->json([
                "resultado" => "Contraseña actualizada correctamente"
            ]);
        }else{
            return response()->json([
                "resultado" => "Error al cambiar la contraseña"
            ]);
        }
    }
}
