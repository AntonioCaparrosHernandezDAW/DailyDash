<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    //Devuelve los datos relevantes para identificar al usuario que corresponde al token recibido
    public function getUserByToken(Request $request){
        //Recoge al usuario
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        //Devuelve error si el usuario no existe
        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar al usuario",
                'status'=>false
            ], 400);
        }

        return response()->json([
            "userId"=>$user->id,
            "username"=>$user->username
        ]);
    }

    //Recoge la imagen almacenada en storage/app/profilePictures y las devuelve al cliente en un formato que pueda tratar como es un "blob"
    public function getProfilePicture(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();
    
        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar al usuario",
                'status'=>false
            ], 400);
        }
    
        $profilePictureLocation = 'profilePictures/'.$user->id.'.png';
    
        if (!Storage::exists($profilePictureLocation)) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "La foto de perfil no existe",
                'status' => false
            ], 400);
        }
    
        $profilePictureLocation = storage_path('app/' . $profilePictureLocation);
    
        $file = File::get($profilePictureLocation);
    
        $response = Response::make($file, 200);
    
        return $response;
    }

    //Cambia el nombre de usuario del usuario que corresponde al token recibido
    public function changeUsername(Request $request){
         //Mensajes de error
         $messages = [
            'newUsername.required' => 'El nuevo nombre de cuenta es obligatorio',
            'newUsername.max' => 'El nombre de cuenta es demasiado largo',
            'newUsername.unique' => 'El nombre de cuenta ya existe'
        ];

        //Reglas de validación
        $rules=[
            "newUsername" => "required|max:15|unique:usuarios,username",
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
        
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if(!$user){
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "Ha ocurrido un error al cargar al usuario",
                'status'=>false
            ], 400);

        }else{
            //Modifica el nombre de usuario
            DB::table('usuarios')
                ->where('remember_token',$request['userToken'])
                ->update([
                    'username' => $request['newUsername']
                ]);
            

            return response()->json([
                'responseTitle'=> "Nombre de cuenta modificado",
                'responseText'=> "El nombre de la cuenta ha sido modificado correctamente",
                'status'=> true
            ]);      
        }
    }

    //Cambia la contraseña del usuario que corresponde al token recibido
    public function changePassword(Request $request){
        //Mensajes de error
        $messages = [
            'newPassword.required' => 'La contraseña es obligatoria',
            'newPassword.max' => 'La contraseña no puede superar los 20 carácteres',
            'newPassword.confirmed' => 'Las nuevas contraseñas no coinciden',
            'newPassword.regex' => 'La contraseña no puede tener menos de 9 carácteres',
        ];

        //Reglas de validación
        $rules=[
            "newPassword" => [
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

        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if (Hash::check($request["oldPassword"], $user->password)) {
            DB::table('usuarios')
                ->where('remember_token',$request['userToken'])
                ->update([
                    'password'=>Hash::make($request['newPassword'])
                ]);

            return response()->json([
                'responseTitle'=> "Contraseña modificada",
                'responseText'=> "La contraseña ha sido modificada correctamente",
                'status'=> true
            ]); 
        }else{
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => "La contraseña antigua no es correcta",
                'status'=>false
            ], 400);
        }
    }

    //Genera un código asociado al usuario que vaya a comprar la versión premium
    public function createPaymentToken(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        $paymentToken = bin2hex(random_bytes(30));

        DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->update([
                    'token_pago'=>$paymentToken
                ]); 

        return response()->json([
            'token'=>$paymentToken
        ]);
    }

    //Comprueba el token previamente creado por "createPaymentToken"(Esto se hace así porque a esta funcion solo se puede acceder una vez se confierme el pago exitoso)
    public function checkPaymentToken(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        return response()->json([
            'resultado'=>$user->token_pago == $request['paymentToken']
        ]);
    }

    //Otorga al usuario el atributo premium
    public function grantPremiumToUser(Request $request){
        DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->update([
                'premium'=>1
            ]); 
    }

    //Recoge la imagen nueva introducida por el usuario y guarda los datos en la carpeta storage con un nombre asociado a el
    public function changeProfilePicture(Request $request){
        //Mensajes de error
        $messages = [
            'profilePic.required' => 'Debes subir un archivo',
            'profilePic.image' => 'Debes subir una imagen'
        ];

        //Reglas de validación
        $rules=[
            "profilePic"=>'required|image'
        ];

        //Validaciones
        $validator = Validator::make($request->all(), $rules, $messages);   //Hay que hacer $request->all() porque sino no coge los archivos
        if ($validator->fails()) {
            return response()->json([
                'errorTitle' => "Error",
                'errorText' => $validator->errors()->first(),
                'status'=>false
            ], 400);
        }

        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        //Guarda en storage con su id como nombre
        $filename = $user->id.'.png';
        Storage::putFileAs('profilePictures', $request->file('profilePic'), $filename);

        return response()->json([
            'responseTitle'=> "Foto de perfil modificada",
            'responseText'=> "La foto de perfil ha sido modificada correctamente",
            'status'=> true
        ]); 
    }
}
