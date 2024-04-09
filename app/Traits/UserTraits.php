<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\WEBMaestro;


use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use Mail;
use PDO;


trait UserTraits
{
	private function envio_correo_confirmacion() {

        $listaproveedoress          =   User::where('email_confirmacion','=',0)
        								->where('rol_id','=','1CIX00000019')
                                        ->get();


        foreach($listaproveedoress as $item){

            $token                  =   substr($item->id, -8);
            // correos from(de)
            $emailfrom          =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            // correos principales y  copias
            $email              =   $item->email;
            $array      =  Array(
                'PR'                =>  $item,
                'token'             =>  $token,
            );
            Mail::send('emails.confirmacion', $array, function($message) use ($emailfrom,$email)
            {
                $message->from($emailfrom->correoprincipal, 'Induamerica registro proveedores');
                $message->to($email);
                $message->subject('Confirmación de registro');

            });

            $pedido                         	=   User::where('id','=',$item->id)->first();
            $pedido->email_confirmacion       	=   1;
            $pedido->save();

        }



	}
}