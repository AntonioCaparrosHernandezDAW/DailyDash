<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RememberPasswordCodeEmail;
use Illuminate\Support\Facades\Validator;

class LoginRegisterController extends Controller
{
    //Da de alta al usuario en la base de datos
    public function registerUser(Request $request){
        //Mensajes de error
        $messages = [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida',
            'email.unique' => 'El correo electrónico ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.max' => 'La contraseña no puede superar los 20 carácteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe tener al menos 9 caracteres'
        ];

        //Reglas de validación
        $rules=[
            "email" => "required|email|unique:usuarios",
            "password" => [
                "required",
                "max:20",
                "confirmed",
                "regex:/^.{9,}$/"
            ]
        ];

        //Validaciones
        $validator = Validator::make($request->input(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }

        // Generar token único
        $rememberToken = Str::random(50);

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

        return response()->json([
            'responseTitle'=> "Registro correcto",
            'responseText'=> "Usuario registrado correctamente",
            'status'=> true
        ]);    
    }

    //Verifica al usuario que intenta acceder a la aplicación
    public function logUser(Request $request){
        $user = DB::table("usuarios")
            ->where("email", $request["email"])
            ->first();

        if(!$user || !Hash::check($request["password"], $user->password)){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al iniciar sesión, revise el correo y la contraseña",
                'status'=>false
            ], 400);
        }

        return response()->json([
            'responseTitle'=> "Login correcto",
            'responseText'=> "Usuario logeado correctamente. Redirigiendo...",
            'status'=> true,
            "user" => $user->email,
            "token" => $user->remember_token
        ]);       
    }

    //Envia un correo electrónico con un código al remitente
    public function sendEmailToRemember(Request $request){
        //Mensajes de error
        $messages = [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida',
        ];

        //Reglas de validación
        $rules=[
            "email" => "required|email"
        ];

        $validator = Validator::make($request->input(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }

        $token_password= bin2hex(random_bytes(20));

        $user = DB::table("usuarios")
            ->where("email", $request["email"])
            ->update([
                'token_password'=>$token_password
            ]);

        Mail::to($request['email'])->send(new RememberPasswordCodeEmail($token_password));

        return response()->json([
            'responseTitle'=> "Correo enviado",
            'responseText'=> "Revise su dirección de correo e introduzca el código",
            'status'=> true
        ]);
    }

    //Cambia la contraseña si el código introducido es el correcto
    public function changePasswordWithCode(Request $request){
        //Mensajes de error
        $messages = [
            'newPassword.required' => 'La contraseña es obligatoria',
            'newPassword.regex' => 'La contraseña debe tener al menos 9 caracteres'
        ];

        //Reglas de validación
        $rules=[
            "newPassword" => [
                "required",
                "regex:/^.{9,}$/"
            ]
        ];

        //Validaciones
        $validator = Validator::make($request->input(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }

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
                    'responseTitle'=> "Contraseña actualizada",
                    'responseText'=> "La contraseña ha sido cambiada satisfactóriamente",
                    'status'=> true
                ]);
        }else{
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "El código no coincide con el solicitado",
                'status'=>false
            ], 400);
        }
    }
}
