<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUserByToken(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        return response()->json([
            "userId"=>$user->id,
            "username"=>$user->username
        ]);
    }

    public function changeUsername(Request $request){
        $request->validate([
            'newUsername' => 'required|string|max:255|unique:usuarios,username',
        ]);
        
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if($user){
            DB::table('usuarios')
                ->where('remember_token',$request['userToken'])
                ->update([
                    'username' => $request['newUsername']
                ]);
            

                /*
            if ($user->username === $request['newUsername']) {
                return response()->json(['response' => 'Nombre de usuario modificado correctamente']);
            } else {
            }*/
            return response()->json(['response' => 'Ha ocurrido un error al modificar el nombre del usuario']);

        }else{
            return response()->json([
                'response'=>"Usuario no encontrado"
            ]);
        }
    }

    public function changePassword(Request $request){
        //Como luego se comprueba si la password nueva es ideantica a la comprobación no hace falta comprobar tambien la confirmación
        $request->validate([
            'newPassword' => 'required|string|max:255',
        ]);

        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        if (Hash::check($request["oldPassword"], $user->password)) {
            if($request['newPassword']==$request['confirmedPassword']){
                DB::table('usuarios')
                    ->where('remember_token',$request['userToken'])
                    ->update([
                        'password'=>Hash::make($request['newPassword'])
                    ]);

                return response()->json([
                    'response'=>"La contraseña ha sido cambiada correctamente"
                ]);
            }else{
                return response()->json([
                    'response'=>"La contraseña nueva no concuerda con su confirmación"
                ]);
            }
        }else{
            return response()->json([
                'response'=>"La contraseña anterior es incorrecta"
            ]);
        }
    }

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

    public function checkPaymentToken(Request $request){
        $user = DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->first();

        return response()->json([
            'resultado'=>$user->token_pago == $request['paymentToken'],
            //'tokenIntroducido'=>$request['paymentToken'],
            //'tokenReal'=>$user->token_pago
        ]);
    }

    public function grantPremiumToUser(Request $request){
        DB::table('usuarios')
            ->where('remember_token',$request['userToken'])
            ->update([
                    'premium'=>1
                ]); 
    }
}
