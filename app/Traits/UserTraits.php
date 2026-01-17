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
use App\Modelos\VMergeDocumento;
use App\Modelos\VMergeOP;
use App\Modelos\CMPOrden;

use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use Mail;
use PDO;
use App\Traits\WhatsappTraits;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

trait UserTraits
{
    use WhatsappTraits;

    private function eliminacion_vales_arendir() {

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.CULMINAR_VALE');
        $stmt->execute();

    }


    private function envio_correo_reparacion_levantada() {

        $listaliquidaciones     =   FeDocumento::where('IND_CORREO_REPARABLE', '1')
                                    ->get();

        foreach($listaliquidaciones as $item){
    
                $larchivos              =   DB::table('CMP.DOC_ASOCIAR_COMPRA')
                                            ->where('COD_ORDEN', 'IICHCL0000012784')
                                            ->where('TXT_ASIGNADO', 'ARCHIVO_VIRTUAL')
                                            ->get();
                $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
                $email                  =   'facturacion.iacm@induamerica.com.pe';
                if($item->COD_EMPR == 'IACHEM0000010394'){
                    $email                  =   'facturacion.iain@induamerica.com.pe';
                }


                $array                  =   Array(
                    'item'                =>  $item,
                    'larchivos'           =>  $larchivos
                );
                $subjectcorreo = 'SE SUBSANO LA REPARACION DEL DOCUMENTO // '.$item->ID_DOCUMENTO.' // '.$item->OPERACION;

                Mail::send('emails.reparable', $array, function($message) use ($emailfrom,$item,$subjectcorreo,$email)
                {
                    $message->from($emailfrom->correoprincipal, 'ORDEN COMPRA '.$item->ID_DOCUMENTO);
                    $message->to($email)->cc('jorge.saldana@induamerica.com.pe');
                    $message->subject($subjectcorreo);
                });

                FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                            ->update(
                                    [
                                        'IND_CORREO_REPARABLE'=>'2'
                                    ]);                      
        }
        print_r("Se envio correctamente el correo Adminstracion");
    }





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

        $listaliquidaciones          =      LqgLiquidacionGasto::where('COD_ESTADO', 'ETM0000000000005')
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
            $correotrabajdor         =    '';
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

                $subjectcorreo = 'APLICACIÓN DE REEMBOLSO '.$documentoCtble->NRO_SERIE.'-'.$documentoCtble->NRO_DOC;
                if(count($valeRendir)>0){
                    $subjectcorreo = 'APLICACION DE VALE CON LIQUIDACION '.$documentoCtble->NRO_SERIE.'-'.$documentoCtble->NRO_DOC;
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
                if($item->COD_CENTRO == 'CEN0000000000004'){ //rioja
                    $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00038')->first();
                }else{
                    if($item->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                        $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00039')->first();
                    }else{
                        if($item->COD_CENTRO == 'CEN0000000000002'){ //bellavista
                            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00040')->first();
                        }
                    }
                }

                //TRANSFERENCIA Y REEMBOLSO
                if($item->ARENDIR == 'REEMBOLSO' && $item->COD_CATEGORIA_TIPOPAGO == 'MPC0000000000002'){
                    $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00037')->first();
                }

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

                $user = DB::table('users')->where('id', $item->USUARIO_CREA)->first();
                $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('COD_TRAB','=',$user->usuarioosiris_id)->first();
                //correo de trabajadores
                $correotrabajador         =    '';
                if(count($trabajadorcorreo)>0){
                    if ($trabajadorcorreo->emailcorp !== null) {
                        $correotrabajador = $trabajadorcorreo->emailcorp;
                    }
                }

                Mail::send('emails.tesorerialg', $array, function($message) use ($emailfrom,$item,$email,$documentoCtble,$subjectcorreo,$correotrabajador)
                {

                    if($correotrabajador ==''){
                        $emailcopias        = explode(",", $email->correocopia);  
                    }else{
                        $emailcopias        = explode(",", $email->correocopia); 
                        $emailcopias[]      = $correotrabajador; // Agrega al final del array
                    }
                    $message->from($emailfrom->correoprincipal, 'LIQUIDACION '.$item->ID_DOCUMENTO);
                    //$message->to('jorge.saldana@induamerica.com.pe');
                    $message->to($email->correoprincipal)->cc($emailcopias);
                    $message->subject($subjectcorreo);
                });

                $pedido                             =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->first();
                $pedido->IND_CORREO                 =   1;
                $pedido->save();
            }                            
        }
        print_r("Se envio correctamente el correo Adminstracion");
    }

    private function envio_correo_jefeacopiodic() {

        $listadocumentos          =   FeDocumento::where('OPERACION','=','DOCUMENTO_INTERNO_COMPRA')
                                      ->where('COD_ESTADO','=','ETM0000000000012')
                                      ->where('IND_EMAIL_JEFE_ACOPIO','=',0)
                                      ->get();


        foreach($listadocumentos as $item){

            $ordencompra         =      VMergeDocumento::leftJoin('FE_REF_ASOC', function ($leftJoin){
                                            $leftJoin->on('FE_REF_ASOC.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                                ->where('FE_REF_ASOC.COD_ESTADO', '=', '1');
                                        })
                                        ->leftJoin('FE_DOCUMENTO', function ($leftJoin){
                                            $leftJoin->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                                ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                        })                                                
                                        ->WHERE('FE_REF_ASOC.LOTE','=',$item->ID_DOCUMENTO)                                                                                                
                                        ->WHERE('VMERGEDOCUMENTOS.COD_ESTADO','=','1')                                                
                                        ->orderBy('VMERGEDOCUMENTOS.FEC_EMISION','ASC')
                                        ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                            FEC_EMISION,
                                                            TXT_CATEGORIA_MONEDA,
                                                            TXT_EMPR_EMISOR,
                                                            COD_USUARIO_CREA_AUD,
                                                            CAN_TOTAL,
                                                            NRO_SERIE,
                                                            NRO_DOC,
                                                            FE_REF_ASOC.LOTE AS LOTE_DOC,                                                                    
                                                            FE_DOCUMENTO.ID_DOCUMENTO,
                                                            VMERGEDOCUMENTOS.COD_CENTRO,
                                                            VMERGEDOCUMENTOS.COD_ESTADO,
                                                            FE_DOCUMENTO.TXT_ESTADO,
                                                            FE_REF_ASOC.TOTAL_MERGE
                                                        '))
                                        ->first();

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00041')->first();
            if($ordencompra->COD_CENTRO == 'CEN0000000000004'){ //rioja
                $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00041')->first();
            }else{
                if($ordencompra->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                    $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00041')->first();
                }else{
                    if($ordencompra->COD_CENTRO == 'CEN0000000000002'){ //bellavista
                        $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00041')->first();
                    }
                }
            }
            $subjectcorreo = "DOCUMENTO INTERNO COMPRA (".$item->ID_DOCUMENTO.")";

            $array  =        [
                                    'ordencompra'       => $ordencompra,
                                    'estado'            => 'POR APROBAR JEFE DE ACOPIO',
                             ];

            Mail::send('emails.emaildocumentointernocompragenerado', $array, function($message) use ($emailfrom,$item,$email,$subjectcorreo)
            {
                $emailcopias        = explode(",", $email->correocopia);  
                $message->from($emailfrom->correoprincipal, 'DOCUMENTO INTERNO COMPRA JEFE ACOPIO ('.$item->ID_DOCUMENTO.')');
                $message->to($email->correoprincipal)->cc($emailcopias);
                $message->subject($subjectcorreo);
            });

            FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                        ->update(
                                [
                                    'IND_EMAIL_JEFE_ACOPIO'=>'1'
                                ]);  

        }

        print_r("Se envio correctamente el correo jefe de acopio");
    }


    private function envio_correo_admindic() {

        $listadocumentos          =   FeDocumento::where('OPERACION','=','DOCUMENTO_INTERNO_COMPRA')
                                      ->where('COD_ESTADO','=','ETM0000000000004')
                                      ->where('IND_EMAIL_ADMINISTRACION_ACOPIO','=',0)
                                      ->get();


        foreach($listadocumentos as $item){

            $ordencompra         =      VMergeDocumento::leftJoin('FE_REF_ASOC', function ($leftJoin){
                                            $leftJoin->on('FE_REF_ASOC.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                                ->where('FE_REF_ASOC.COD_ESTADO', '=', '1');
                                        })
                                        ->leftJoin('FE_DOCUMENTO', function ($leftJoin){
                                            $leftJoin->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                                ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                        })                                                
                                        ->WHERE('FE_REF_ASOC.LOTE','=',$item->ID_DOCUMENTO)                                                                                                
                                        ->WHERE('VMERGEDOCUMENTOS.COD_ESTADO','=','1')                                                
                                        ->orderBy('VMERGEDOCUMENTOS.FEC_EMISION','ASC')
                                        ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                            FEC_EMISION,
                                                            TXT_CATEGORIA_MONEDA,
                                                            TXT_EMPR_EMISOR,
                                                            COD_USUARIO_CREA_AUD,
                                                            CAN_TOTAL,
                                                            NRO_SERIE,
                                                            NRO_DOC,
                                                            FE_REF_ASOC.LOTE AS LOTE_DOC,                                                                    
                                                            FE_DOCUMENTO.ID_DOCUMENTO,
                                                            VMERGEDOCUMENTOS.COD_CENTRO,
                                                            VMERGEDOCUMENTOS.COD_ESTADO,
                                                            FE_DOCUMENTO.TXT_ESTADO,
                                                            FE_REF_ASOC.TOTAL_MERGE
                                                        '))
                                        ->first();

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00043')->first();
            if($ordencompra->COD_CENTRO == 'CEN0000000000004'){ //rioja
                $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00043')->first();
            }else{
                if($ordencompra->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                    $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00043')->first();
                }else{
                    if($ordencompra->COD_CENTRO == 'CEN0000000000002'){ //bellavista
                        $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00043')->first();
                    }
                }
            }
            $subjectcorreo = "DOCUMENTO INTERNO COMPRA (".$item->ID_DOCUMENTO.")";

            $array  =        [
                                    'ordencompra'       => $ordencompra,
                                    'estado'            => 'POR APROBAR ADMINISTRACION',
                             ];

            Mail::send('emails.emaildocumentointernocompragenerado', $array, function($message) use ($emailfrom,$item,$email,$subjectcorreo)
            {
                $emailcopias        = explode(",", $email->correocopia);  
                $message->from($emailfrom->correoprincipal, 'DOCUMENTO INTERNO COMPRA ADMINISTRACION ('.$item->ID_DOCUMENTO.')');
                $message->to($email->correoprincipal)->cc($emailcopias);
                $message->subject($subjectcorreo);
            });

            FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                        ->update(
                                [
                                    'IND_EMAIL_ADMINISTRACION_ACOPIO'=>'1'
                                ]);  

        }

        print_r("Se envio correctamente el correo administracion");
    }

    private function envio_correo_adminlqc() {

        $listadocumentos          =   FeDocumento::where('OPERACION','=','LIQUIDACION_COMPRA_ANTICIPO')
                                      ->where('COD_ESTADO','=','ETM0000000000004')
                                      ->where('IND_EMAIL_ADMINISTRACION_ACOPIO','=',0)
                                      ->get();

        foreach($listadocumentos as $item){

            $ordenpago              =      VMergeOP::where('COD_ESTADO','=','1')
                                                ->where('COD_AUTORIZACION','=',$item->ID_DOCUMENTO)
                                                ->first();

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00044')->first();
            if($ordenpago->COD_CENTRO == 'CEN0000000000004'){ //rioja
                $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00044')->first();
            }else{
                if($ordenpago->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                    $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00044')->first();
                }else{
                    if($ordenpago->COD_CENTRO == 'CEN0000000000002'){ //bellavista
                        $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00044')->first();
                    }
                }
            }
            $subjectcorreo = "LIQUIDACION DE COMPRA ANTICIPO (".$item->ID_DOCUMENTO.")";
            $array  =        [
                                    'ordenpago'       => $ordenpago,
                                    'estado'            => 'POR APROBAR ADMINISTRACION',
                             ];

            Mail::send('emails.emailliquidacioncompraanticipogenerado', $array, function($message) use ($emailfrom,$item,$email,$subjectcorreo)
            {
                $emailcopias        = explode(",", $email->correocopia);  
                $message->from($emailfrom->correoprincipal, 'LIQUIDACION DE COMPRA ANTICIPO ADMINISTRACION ('.$item->ID_DOCUMENTO.')');
                $message->to($email->correoprincipal)->cc($emailcopias);
                $message->subject($subjectcorreo);
            });

            FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                        ->update(
                                [
                                    'IND_EMAIL_ADMINISTRACION_ACOPIO'=>'1'
                                ]);  

        }

        print_r("Se envio correctamente el correo administracion");
    }


    private function envio_correo_aprobado() {

        $listadocumentos          =   FeDocumento::where('COD_ESTADO','=','ETM0000000000005')
                                      ->where('IND_EMAIL_APROBADO','=',0)
                                      //->where('ID_DOCUMENTO','=','IILMCR0000033070')
                                      ->get();

        foreach($listadocumentos as $item){

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00046')->first();
            $fe_historial           =   DB::table('FE_DOCUMENTO_HISTORIAL')
                                        ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
                                        ->where('TIPO', 'like', '%APROBADO POR%')
                                        ->where('TIPO','<>','APROBADO POR ADMINISTRACION')
                                        ->orderBy('FECHA', 'desc')
                                        ->get();
            $subjectcorreo          =   "COMPRA APROBADA ".$item->ID_DOCUMENTO." (".$item->OPERACION.")";

            //correo de trabajadores
            $correotrabajador         =    '';
            foreach($fe_historial as $item3){
                    $user = DB::table('users')->where('id', $item3->USUARIO_ID)->first();
                    $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $user->usuarioosiris_id)->first();

                    $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('dni','=',$trabajador->NRO_DOCUMENTO)->first();
                    if(count($trabajadorcorreo)>0){
                        if ($trabajadorcorreo->emailcorp !== null) {
                            $correotrabajador = $correotrabajador.$trabajadorcorreo->emailcorp.',';
                        }
                    }
            }


            $usuario_solicita = '';
            $usuario_autoriza = '';
            $usuario_aprueba = '';

            if($item->OPERACION == 'ORDEN_COMPRA'){

                $ordencompra            =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();




                $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $ordencompra->COD_TRABAJADOR_SOLICITA)->first();
                $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('dni','=',$trabajador->NRO_DOCUMENTO)->first();
                if(count($trabajadorcorreo)>0){

                    if($trabajador->COD_TRAB != 'ISTR000000000033'){

                        $usuario_solicita = $trabajadorcorreo->apellidopaterno.' '.$trabajadorcorreo->apellidomaterno.' '.$trabajadorcorreo->nombres;
                        if ($trabajadorcorreo->emailcorp !== null) {
                            $correotrabajador = $correotrabajador.$trabajadorcorreo->emailcorp.',';
                        }

                    }


                }


                $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $ordencompra->COD_TRABAJADOR_ENCARGADO)->first();
                $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('dni','=',$trabajador->NRO_DOCUMENTO)->first();
                if(count($trabajadorcorreo)>0){

                    if($trabajador->COD_TRAB != 'ISTR000000000033'){
                        $usuario_autoriza = $trabajadorcorreo->apellidopaterno.' '.$trabajadorcorreo->apellidomaterno.' '.$trabajadorcorreo->nombres;
                        if ($trabajadorcorreo->emailcorp !== null) {
                            $correotrabajador = $correotrabajador.$trabajadorcorreo->emailcorp.',';
                        }
                    }

                }

                $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $ordencompra->COD_TRABAJADOR_COMISIONISTA)->first();
                $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('dni','=',$trabajador->NRO_DOCUMENTO)->first();
                if(count($trabajadorcorreo)>0){
                    if($trabajador->COD_TRAB != 'ISTR000000000033'){
                        $usuario_aprueba = $trabajadorcorreo->apellidopaterno.' '.$trabajadorcorreo->apellidomaterno.' '.$trabajadorcorreo->nombres;
                        if ($trabajadorcorreo->emailcorp !== null) {
                            $correotrabajador = $correotrabajador.$trabajadorcorreo->emailcorp.',';
                        }
                    }
                }


            }


            // 1. Eliminar espacios en blanco al inicio y final
            $correotrabajador = trim($correotrabajador);
            
            // 2. Eliminar coma final si existe
            $correotrabajador = rtrim($correotrabajador, ',');
            
            // 3. Convertir a array
            $correotrabajador = explode(',', $correotrabajador);
            
            // 4. Limpiar cada correo (eliminar espacios)
            $correotrabajador = array_map('trim', $correotrabajador);
            
            // 5. Eliminar elementos vacíos
            $correotrabajador = array_filter($correotrabajador);
            
            // 6. Eliminar duplicados manteniendo el orden
            $correotrabajador = array_unique($correotrabajador);
            $correosLimpios = implode(',', $correotrabajador);

            $array  =        [
                                    'item'       => $item,
                                    'fe_historial'     => $fe_historial,
                                    'usuario_solicita'     => $usuario_solicita,
                                    'usuario_autoriza'     => $usuario_autoriza,
                                    'usuario_aprueba'     => $usuario_aprueba,
                             ];


            Mail::send('emails.emailcompraaprobado', $array, function($message) use ($emailfrom,$item,$email,$subjectcorreo,$correosLimpios)
            {


                if($correosLimpios ==''){
                    $emailcopias        = explode(",", $email->correocopia);  
                }else{
                    $emailcopias        = explode(",", $email->correocopia.','.$correosLimpios); 
                }

                $message->from($emailfrom->correoprincipal, 'COMPRA APROBADA ('.$item->ID_DOCUMENTO.')');
                $message->to($email->correoprincipal)->cc($emailcopias);
                $message->subject($subjectcorreo);
            });

            FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                        ->update(
                                [
                                    'IND_EMAIL_APROBADO'=>'1'
                                ]);  

        }

        print_r("Se envio correctamente el correo administracion");
    }

    private function crear_excel_aporbado_admin() {

        $ayer = Carbon::yesterday()->format('Y-m-d');

        $listadocumentos =  FeDocumento::leftJoin('CMP.ORDEN', 'CMP.ORDEN.COD_ORDEN', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                            ->leftJoin('users', 'users.id', '=', 'FE_DOCUMENTO.usuario_uc')
                            ->leftJoin('STD.TRABAJADOR', 'STD.TRABAJADOR.COD_TRAB', '=', 'CMP.ORDEN.COD_TRABAJADOR_ENCARGADO')
                            ->leftJoin('users as uconta', 'uconta.id', '=', 'FE_DOCUMENTO.usuario_pr')
                            ->leftJoin('users as uadmin', 'uadmin.id', '=', 'FE_DOCUMENTO.usuario_ap')
                            ->select('FE_DOCUMENTO.*','CMP.ORDEN.*','users.*','STD.TRABAJADOR.*','uconta.nombre as nombreconta','uadmin.nombre as nombreadmin')
                            //->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                            ->where(function($q) {
                                $q->whereNull('IND_EMAIL_APROBADO_ADMIN')
                                  ->orWhere('IND_EMAIL_APROBADO_ADMIN', 0);
                            })
                            ->whereDate('fecha_ap', $ayer)
                            ->orderBy('fecha_ap','asc')
                            ->get();

        if(count($listadocumentos)>0){

            $fecha_actual = date("Y-m-d");
            $titulo = 'Compras-Aprobadas-(' . $ayer . ')';

            // 1. Guardar LOCALMENTE primero (esto siempre funciona)
            $rutaLocal = storage_path('app/excel_temp/');

            // Crear carpeta temporal si no existe
            if (!file_exists($rutaLocal)) {
                mkdir($rutaLocal, 0777, true);
            }

            // Generar Excel localmente
            Excel::create($titulo, function($excel) use ($listadocumentos, $titulo) {
                $excel->sheet('OC', function($sheet) use ($listadocumentos, $titulo) {
                    $sheet->loadView('excel.listacomprasaprobadas')
                          ->with('listadocumentos', $listadocumentos)
                          ->with('titulo', $titulo);
                });
            })->store('xls', $rutaLocal);

            // Ruta completa del archivo local
            $archivoLocal = $rutaLocal . $titulo . '.xls';

            // 2. Intentar copiar a la red
            $rutaRed = '\\\\10.1.50.2\\comprobantes\\EXCELOC\\';

            $nombre_archivo     =   $titulo . '_' . date('His') . '.xls';

            $archivoRed = $rutaRed . $nombre_archivo; // Agregar hora para evitar duplicados

            // Intentar copiar de diferentes maneras
            $copiado = false;

            // Método 1: copy() nativo de PHP
            if (copy($archivoLocal, $archivoRed)) {
                $copiado = true;
                echo "✅ Archivo copiado exitosamente usando copy()<br>";
            } 
            // Método 2: file_put_contents
            elseif (file_put_contents($archivoRed, file_get_contents($archivoLocal))) {
                $copiado = true;
                echo "✅ Archivo copiado exitosamente usando file_put_contents<br>";
            }
            // Método 3: Usar COM si es Windows
            elseif (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Comando de Windows para copiar
                $comando = 'copy "' . $archivoLocal . '" "' . $archivoRed . '"';
                exec($comando, $output, $returnCode);
                
                if ($returnCode === 0) {
                    $copiado = true;
                    echo "✅ Archivo copiado usando comando Windows<br>";
                }
            }

            if ($copiado) {
                echo "📁 <strong>Archivo en red:</strong> " . $archivoRed . "<br>";
                // Opcional: eliminar el archivo local
                unlink($archivoLocal);
            } else {
                echo "⚠️ <strong>No se pudo copiar a la red</strong><br>";
                echo "📁 <strong>Archivo local:</strong> " . $archivoLocal . "<br>";
                echo "🔗 <a href='" . url('descargar-excel/' . basename($archivoLocal)) . "' target='_blank'>Descargar aquí</a><br>";
                
                // También puedes moverlo a una carpeta pública
                $rutaPublica = public_path('descargas/' . $titulo . '.xls');
                if (copy($archivoLocal, $rutaPublica)) {
                    echo "📁 <strong>Archivo público:</strong> " . url('descargas/' . $titulo . '.xls') . "<br>";
                }
            }



            $emailfrom = WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $email = WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00045')->first();

            $array = [
                'fecha_actual' => $ayer,
            ];

            // 1. Ruta de red
            $archivoRed               =   $archivoRed;

            // 2. Ruta local temporal
            $rutaLocal = storage_path('app/temp_email/');
            if (!file_exists($rutaLocal)) {
                mkdir($rutaLocal, 0777, true);
            }

            $archivoLocal = $rutaLocal . basename($archivoRed);

            // 3. Copiar de red a local
            if (file_exists($archivoRed)) {
                // Intentar copiar
                if (copy($archivoRed, $archivoLocal)) {
                    $file = $archivoLocal; // Usar la copia local
                } else {
                    // Si no se puede copiar, intentar leer el contenido
                    $contenido = file_get_contents($archivoRed);
                    if ($contenido) {
                        file_put_contents($archivoLocal, $contenido);
                        $file = $archivoLocal;
                    } else {
                        // Si todo falla, usar la ruta de red y esperar que funcione
                        $file = $archivoRed;
                    }
                }
            } else {
                throw new \Exception("El archivo no existe en la ruta de red: " . $archivoRed);
            }

            // 4. Enviar email
            $nombre_archivo = basename($archivoRed);

            Mail::send('emails.emailcompraaprobadoadmin', $array, function($message) use ($emailfrom, $email, $file, $nombre_archivo, $ayer, $archivoLocal) {
                $emailprincipal = explode(",", $email->correoprincipal);
                
                $message->from($emailfrom->correoprincipal, 'Compras Masivas ' .$ayer );
                
                // Adjuntar archivo
                $message->attach($file, [
                    'as' => $nombre_archivo,
                    'mime' => 'application/vnd.ms-excel',
                ]);
                
                if (!empty($email->correocopia)) {
                    $emailcopias = explode(",", $email->correocopia);
                    $message->to($emailprincipal)->cc($emailcopias);
                } else {
                    $message->to($emailprincipal);
                }
                
                $message->subject($email->descripcion . ' - ' . $ayer);
                
                // 5. Limpiar archivo temporal después de enviar (opcional)
                // Nota: No se puede eliminar aquí porque se envía async
            });

            // 6. Programar limpieza para después del envío
            // Podrías usar Jobs o programar limpieza manual
            register_shutdown_function(function() use ($archivoLocal) {
                if (file_exists($archivoLocal)) {
                    unlink($archivoLocal);
                }
            });

            FeDocumento::where(function($q) {
                            $q->whereNull('IND_EMAIL_APROBADO_ADMIN')
                              ->orWhere('IND_EMAIL_APROBADO_ADMIN', 0);
                        })
                        ->whereDate('fecha_ap', $ayer)
                        ->update(
                                [
                                    'IND_EMAIL_APROBADO_ADMIN'=>'1'
                                ]);  


        }

    }





    private function envio_correo_jefeacopiolqc() {

        $listadocumentos          =   FeDocumento::where('OPERACION','=','LIQUIDACION_COMPRA_ANTICIPO')
                                      ->where('COD_ESTADO','=','ETM0000000000012')
                                      ->where('IND_EMAIL_JEFE_ACOPIO','=',0)
                                      ->get();

        foreach($listadocumentos as $item){

            $ordenpago              =      VMergeOP::where('COD_ESTADO','=','1')
                                                ->where('COD_AUTORIZACION','=',$item->ID_DOCUMENTO)
                                                ->first();

            $emailfrom              =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00001')->first();
            $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00042')->first();
            if($ordenpago->COD_CENTRO == 'CEN0000000000004'){ //rioja
                $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00042')->first();
            }else{
                if($ordenpago->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                    $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00042')->first();
                }else{
                    if($ordenpago->COD_CENTRO == 'CEN0000000000002'){ //bellavista
                        $email                  =   WEBMaestro::where('codigoatributo','=','0001')->where('codigoestado','=','00042')->first();
                    }
                }
            }
            $subjectcorreo = "LIQUIDACION DE COMPRA ANTICIPO (".$item->ID_DOCUMENTO.")";
            $array  =        [
                                    'ordenpago'       => $ordenpago,
                                    'estado'            => 'POR APROBAR JEFE DE ACOPIO',
                             ];

            Mail::send('emails.emailliquidacioncompraanticipogenerado', $array, function($message) use ($emailfrom,$item,$email,$subjectcorreo)
            {
                $emailcopias        = explode(",", $email->correocopia);  
                $message->from($emailfrom->correoprincipal, 'LIQUIDACION DE COMPRA ANTICIPO JEFE ACOPIO ('.$item->ID_DOCUMENTO.')');
                $message->to($email->correoprincipal)->cc($emailcopias);
                $message->subject($subjectcorreo);
            });

            FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                        ->update(
                                [
                                    'IND_EMAIL_JEFE_ACOPIO'=>'1'
                                ]);  

        }

        print_r("Se envio correctamente el correo jefe de acopio");
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