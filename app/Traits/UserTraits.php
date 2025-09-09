<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\WEBMaestro;
use App\Modelos\FeDocumento;
use App\Modelos\VMergeOC;
use App\Modelos\STDTrabajador;
use App\Modelos\LqgLiquidacionGasto;




use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use Mail;
use PDO;
use App\Traits\WhatsappTraits;

trait UserTraits
{
    use WhatsappTraits;

    private function envio_correo_apcli() {

        $listadocumentos          =   FeDocumento::where('ind_email_clap','=',0)->where('COD_ESTADO','<>','ETM0000000000006')
                                      ->get();

        foreach($listadocumentos as $item){

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $usuario                =   User::where('id','=',$item->usuario_pa)->first();
            $correocc               =   $usuario->email;

            if($item->TXT_PROCEDENCIA = 'ADM'){
                $trabajador         =   STDTrabajador::where('COD_TRAB','=',$usuario->usuarioosiris_id)->first();
                if($trabajador->TXT_CORREO_ELECTRONICO == ''){
                    $correocc               =   'jose.neciosup@induamerica.com.pe';
                }else{
                    $correocc               =   $trabajador->TXT_CORREO_ELECTRONICO;
                }
            }
            //dd($usuario);
            $oc                     =   VMergeOC::where('COD_ORDEN','=',$item->ID_DOCUMENTO)
                                        ->select(DB::raw('COD_ORDEN,COD_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL'))
                                        ->groupBy('COD_ORDEN')
                                        ->groupBy('FEC_ORDEN')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')
                                        ->groupBy('TXT_EMPR_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO')
                                        ->groupBy('COD_EMPR')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')->first();

            // correos principales y  copias
            //$email                  =   $item->email;
            $array                  =   Array(
                'item'                =>  $item,
                'oc'                  =>  $oc,
            );

            //whatsaap para uc
            //$mensaje            =   'COMPROBANTE : '.$item->ID_DOCUMENTO.'%0D%0A'.'Estado : '.$item->TXT_ESTADO.'%0D%0A';
            //$this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');

            Mail::send('emails.cli', $array, function($message) use ($emailfrom,$item,$correocc)
            {
                $message->from($emailfrom->correoprincipal, 'Induamerica estado de la orden de compra '.$item->ID_DOCUMENTO .'('.$item->TXT_ESTADO.')');
                $message->to($correocc);
                $message->subject('Orden de Compra '.$item->TXT_ESTADO);
            });

            $pedido                             =   FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)->first();
            $pedido->ind_email_clap               =   1;
            $pedido->save();

        }
        print_r("Se envio correctamente el correo proveedor");
    }




    private function envio_correo_co() {

        $listadocumentos          =   FeDocumento::where('ind_email_ap','=',0)->where('COD_ESTADO','<>','ETM0000000000006')
                                      ->get();

        foreach($listadocumentos as $item){

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00030')->first();

            $oc                     =   VMergeOC::where('COD_ORDEN','=',$item->ID_DOCUMENTO)
                                        ->select(DB::raw('COD_ORDEN,COD_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL'))
                                        ->groupBy('COD_ORDEN')
                                        ->groupBy('FEC_ORDEN')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')
                                        ->groupBy('TXT_EMPR_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO')
                                        ->groupBy('COD_EMPR')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')->first();

            // correos principales y  copias
            //$email                  =   $item->email;
            $array                  =   Array(
                'item'                =>  $item,
                'oc'                  =>  $oc,
            );


            Mail::send('emails.ap', $array, function($message) use ($emailfrom,$item,$email)
            {
                $message->from($emailfrom->correoprincipal, 'MERGE - Orden de Compra '.$item->ID_DOCUMENTO .'('.$item->TXT_ESTADO.')');
                $message->to($email->correoprincipal);
                $message->subject('Orden de Compra '.$item->TXT_ESTADO);
            });

            $pedido                             =   FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)->first();
            $pedido->ind_email_ap               =   1;
            $pedido->save();

        }
        print("Se envio correctamente el correo Contabilidad");
    }



    private function envio_correo_baja() {

        $listadocumentos          =   FeDocumento::where('ind_email_ba','=',0)->where('COD_ESTADO','=','ETM0000000000006')
                                      ->get();


        foreach($listadocumentos as $item){

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $usuario                =   User::where('id','=',$item->usuario_pa)->first();

            $correocc               =   $usuario->email;

            if($item->TXT_PROCEDENCIA = 'ADM'){
                $trabajador         =   STDTrabajador::where('COD_TRAB','=',$usuario->usuarioosiris_id)->first();
                if($trabajador->TXT_CORREO_ELECTRONICO == ''){
                    $correocc               =   'jose.neciosup@induamerica.com.pe';
                }else{
                    $correocc               =   $trabajador->TXT_CORREO_ELECTRONICO;
                }
            }
            
        //dd($usuario);

            $oc                     =   VMergeOC::where('COD_ORDEN','=',$item->ID_DOCUMENTO)
                                        ->select(DB::raw('COD_ORDEN,COD_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL'))
                                        ->groupBy('COD_ORDEN')
                                        ->groupBy('FEC_ORDEN')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')
                                        ->groupBy('TXT_EMPR_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO')
                                        ->groupBy('COD_EMPR')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')->first();

            // correos principales y  copias
            //$email                  =   $item->email;
            $array                  =   Array(
                'item'                =>  $item,
                'oc'                  =>  $oc,
            );


            Mail::send('emails.baja', $array, function($message) use ($emailfrom,$item,$correocc)
            {
                $message->from($emailfrom->correoprincipal, 'MERGE - Orden de Compra '.$item->ID_DOCUMENTO .'(RECHAZO)');
                $message->to($correocc);
                $message->subject('Orden de Compra Rechazado');
            });

            $pedido                             =   FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)->first();
            $pedido->ind_email_ba               =   1;
            $pedido->save();

        }
        print("Se envio correctamente de BAJA");
    }



    private function envio_correo_adm() {

        $listadocumentos          =   FeDocumento::where('ind_email_adm','=',0)->where('COD_ESTADO','<>','ETM0000000000006')
                                      ->get();

        foreach($listadocumentos as $item){

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();

            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00031')->first();
            //dd($email);

            $oc                     =   VMergeOC::where('COD_ORDEN','=',$item->ID_DOCUMENTO)
                                        ->select(DB::raw('COD_ORDEN,COD_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL'))
                                        ->groupBy('COD_ORDEN')
                                        ->groupBy('FEC_ORDEN')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')
                                        ->groupBy('TXT_EMPR_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO')
                                        ->groupBy('COD_EMPR')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')->first();

            // correos principales y  copias
            //$email                  =   $item->email;
            $array                  =   Array(
                'item'                =>  $item,
                'oc'                  =>  $oc,
            );


            Mail::send('emails.adm', $array, function($message) use ($emailfrom,$item,$email)
            {
                $message->from($emailfrom->correoprincipal, 'MERGE - Orden de Compra '.$item->ID_DOCUMENTO .'('.$item->TXT_ESTADO.')');
                $message->to($email->correoprincipal);
                $message->subject('Orden de Compra '.$item->TXT_ESTADO);
            });

            $pedido                             =   FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)->first();
            $pedido->ind_email_adm              =   1;
            $pedido->save();

        }
        print_r("Se envio correctamente el correo Adminstracion");
    }

    private function envio_correo_tesoreria_lq() {

        $listaliquidaciones          =   LqgLiquidacionGasto::where('COD_ESTADO', 'ETM0000000000005')
                                        //->where('ID_DOCUMENTO','=','LIQG00000329')
                                        ->where(function($query) {
                                            $query->whereNull('IND_CORREO')
                                                  ->orWhere('IND_CORREO', 0);
                                        })
                                        //->where('ARENDIR_ID','<>','')
                                        ->where(function($query) {
                                            $query->whereNotNull('COD_OSIRIS')
                                                  ->where('COD_OSIRIS', '<>', '');
                                        })
                                        ->get();

        foreach($listaliquidaciones as $item){

            $documentoCtble         =   DB::table('CMP.DOCUMENTO_CTBLE')
                                        ->where('COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                        ->where('COD_DOCUMENTO_CTBLE', $item->COD_OSIRIS)
                                        ->first();
                                        
            if(count($documentoCtble)>0){

                $valeRendir             =   DB::table('WEB.VALE_RENDIR')
                                            ->where('ID', $item->ARENDIR_ID)
                                            ->first();


                $documentos = DB::table('CMP.DOCUMENTO_CTBLE')
                    ->select([
                        'COD_DOCUMENTO_CTBLE',
                        'NRO_SERIE',
                        'NRO_DOC',
                        'FEC_EMISION',
                        'TXT_EMPR_EMISOR',
                        'TXT_CATEGORIA_TIPO_DOC',
                        'CAN_TOTAL'
                    ])
                    ->whereIn('COD_DOCUMENTO_CTBLE', function($query) use($documentoCtble) {
                        $query->select('COD_TABLA_ASOC')
                              ->from('CMP.REFERENCIA_ASOC')
                              ->where('COD_TABLA', $documentoCtble->COD_DOCUMENTO_CTBLE);
                    })
                    ->where('COD_ESTADO', 1)
                    ->get();

                $vale_doc               =   '';
                $monto_vale             =   0;


                $autorizacion           =   array();
                $COD_AUTORIZACION       =   '';
                if(count($valeRendir)>0){

                    $autorizacion       =   DB::table('TES.AUTORIZACION')
                                            ->where('COD_AUTORIZACION', $valeRendir->ID_OSIRIS)
                                            ->first();

                    //dd($autorizacion);
                    if(count($autorizacion)>0){
                        $vale_doc               =   $autorizacion->TXT_SERIE.'-'.$autorizacion->TXT_NUMERO;
                        $monto_vale             =   $autorizacion->CAN_TOTAL;
                        $COD_AUTORIZACION       =   $autorizacion->COD_AUTORIZACION;
                    }
                }

                $termino                =   'REEMBOLSO';
                $montotermino           =   $documentoCtble->CAN_TOTAL;

                if(count($autorizacion)>0){
                    $montotermino           =   $autorizacion->CAN_TOTAL-$documentoCtble->CAN_TOTAL;
                    if($autorizacion->CAN_TOTAL >  $documentoCtble->CAN_TOTAL){
                        $termino                =   'DEVOLUCION';
                    }
                }

                $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
                $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00037')->first();
                $array                  =   Array(
                    'item'                =>  $item,
                    'oc'                  =>  $documentoCtble,
                    'documentos'          =>  $documentos,
                    'COD_AUTORIZACION'    =>  $COD_AUTORIZACION,
                    'documentos'          =>  $documentos,
                    'documentos'          =>  $documentos,
                    'valeRendir'          =>  $valeRendir,
                    'vale_doc'            =>  $vale_doc,
                    'autorizacion'        =>  $autorizacion,
                    'termino'             =>  $termino,
                    'montotermino'        =>  $montotermino,
                    'monto_vale'          =>  $monto_vale
                );

                Mail::send('emails.tesorerialg', $array, function($message) use ($emailfrom,$item,$email,$documentoCtble)
                {
                    $emailcopias        = explode(",", $email->correocopia);
                    $message->from($emailfrom->correoprincipal, 'LIQUIDACION '.$item->ID_DOCUMENTO);
                    //$message->to('jorge.saldana@induamerica.com.pe');
                    $message->to($email->correoprincipal)->cc($emailcopias);
                    $message->subject('APLICACION DE VALE CON LIQUIDACION '.$documentoCtble->NRO_SERIE.'-'.$documentoCtble->NRO_DOC);
                });

                $pedido                             =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->first();
                $pedido->IND_CORREO                 =   1;
                $pedido->save();
            }                            
        }
        print_r("Se envio correctamente el correo Adminstracion");
    }



    private function envio_correo_uc() {

        $listadocumentos          =   FeDocumento::where('ind_email_uc','=',0)->where('COD_ESTADO','<>','ETM0000000000006')
                                      ->get();

        foreach($listadocumentos as $item){

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();

            //$usuario                =   User::where('id','=',$item->COD_CONTACTO)->first();
            $usuario                =   STDTrabajador::where('COD_TRAB','=',$item->COD_CONTACTO)->first();

            //dd($usuario);

            $oc                     =   VMergeOC::where('COD_ORDEN','=',$item->ID_DOCUMENTO)
                                        ->select(DB::raw('COD_ORDEN,COD_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL'))
                                        ->groupBy('COD_ORDEN')
                                        ->groupBy('FEC_ORDEN')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')
                                        ->groupBy('TXT_EMPR_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO_CLIENTE')
                                        ->groupBy('NRO_DOCUMENTO')
                                        ->groupBy('COD_EMPR')
                                        ->groupBy('TXT_CATEGORIA_MONEDA')->first();

            // correos principales y  copias
            //$email                  =   $item->email;
            $array                  =   Array(
                'item'                =>  $item,
                'oc'                  =>  $oc,
            );

            Mail::send('emails.uc', $array, function($message) use ($emailfrom,$item,$usuario)
            {
                $message->from($emailfrom->correoprincipal, 'MERGE - Orden de Compra '.$item->ID_DOCUMENTO .'('.$item->TXT_ESTADO.')');
                $message->to($usuario->TXT_CORREO_ELECTRONICO);
                $message->subject('Orden de Compra '.$item->TXT_ESTADO);
            });

            $pedido                             =   FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)->first();
            $pedido->ind_email_uc               =   1;
            $pedido->save();

        }
        print_r("Se envio correctamente el correo UC");
    }

	private function envio_correo_confirmacion() {

        $listaproveedoress          =   User::where('email_confirmacion','=',0)
        								->where('rol_id','=','1CIX00000024')
                                        ->get();




        foreach($listaproveedoress as $item){

            $token                  =   substr($item->id, -8);
            // correos from(de)
            $emailfrom          =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            // correos principales y  copias
            $email              =   $item->email;

            if(1==0){
                $url                =   "http://localhost:8080/merge/activar-registro/".Hashids::encode($token);
            }else{
                $url                =   "https://merge.grupoinduamerica.com/merge/activar-registro/".Hashids::encode($token);
            }  

            $array      =  Array(
                'PR'                =>  $item,
                'token'             =>  $token,
                'url'               =>  $url,
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

        print_r("Se envio correctamente el correo CONFIRMACION");

	}






}