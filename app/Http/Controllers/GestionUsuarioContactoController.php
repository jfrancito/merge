<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\Modelos\VMergeOC;
use App\Modelos\FeFormaPago;
use App\Modelos\FeDetalleDocumento;
use App\Modelos\FeDocumento;
use App\Modelos\Estado;
use App\Modelos\CMPOrden;



use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;

use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;
use App\Traits\WhatsappTraits;


use Hashids;
use SplFileInfo;

class GestionUsuarioContactoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;


    public function actionListarComprobanteUsuarioContacto($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Comprobantes Pendiente de Pre Aprobar');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $listadatos     =   $this->con_lista_cabecera_comprobante_total_uc($cod_empresa);
        $funcion        =   $this;
        return View::make('comprobante/listausuariocontacto',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }

    public function actionListarPreAprobarUsuarioContacto($idopcion,Request $request)
    {

        if($_POST)
        {
            $msjarray           = array();
            $respuesta          = json_decode($request['pedido'], true);
            $conts              = 0;
            $contw              = 0;
            $contd              = 0;
        
            //dd("hola");
            foreach($respuesta as $obj){

                $pedido_id          =   $obj['id'];
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();


                if($fedocumento->COD_ESTADO == 'ETM0000000000002'){ 

                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000003',
                                        'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                        'ind_email_ap'=>0,
                                        'fecha_uc'=>$this->fechaactual,
                                        'usuario_uc'=>Session::get('usuario')->id
                                    ]
                                );

                    //whatsaap para contabilidad
                    $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                    $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            
                    $mensaje            =   'COMPROBANTE : '.$fedocumento->ID_DOCUMENTO.'%0D%0A'.'Proveedor : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'.'Estado : '.$fedocumento->TXT_ESTADO.'%0D%0A';
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');


                    $msjarray[]                             =   array(  "data_0" => $fedocumento->ID_DOCUMENTO, 
                                                                        "data_1" => 'Comprobante Pre Aprobado', 
                                                                        "tipo" => 'S');
                    $conts                                  =   $conts + 1;
                    $codigo                                 =   $fedocumento->ID_DOCUMENTO;

                }else{
                    /**** ERROR DE PROGRMACION O SINTAXIS ****/
                    $msjarray[] = array("data_0" => $fedocumento->ID_DOCUMENTO, 
                                        "data_1" => 'este comprobante ya esta Pre Aprobado', 
                                        "tipo" => 'D');
                    $contd      =   $contd + 1;

                }

            }


            /************** MENSAJES DEL DETALLE PEDIDO  ******************/
            $msjarray[] = array("data_0" => $conts, 
                                "data_1" => 'Comprobantes Pre Aprobado', 
                                "tipo" => 'TS');

            $msjarray[] = array("data_0" => $contw, 
                                "data_1" => 'Comprobantes Pre Aprobado', 
                                "tipo" => 'TW');     

            $msjarray[] = array("data_0" => $contd, 
                                "data_1" => 'Comprobantes errados', 
                                "tipo" => 'TD');

            $msjjson = json_encode($msjarray);


            return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('xmlmsj', $msjjson);

        
        }
    }



     public function actionExtornarPreAprobar($idopcion, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        View::share('titulo','Extornar  Comprobante');


        if($_POST)
        {
                        
            $descripcion     =   $request['descripcion'];
            FeDocumento::where('ID_DOCUMENTO',$idoc)
                        ->update(
                            [
                                'COD_ESTADO'=>'ETM0000000000001',
                                'TXT_ESTADO'=>'GENERADO',
                                'ind_email_ba'=>0,
                                'mensaje_exuc'=>$descripcion,
                                'fecha_ex'=>$this->fechaactual,
                                'usuario_ex'=>Session::get('usuario')->id
                            ]
                        );

            return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobantes Lote: '.$ordencompra->COD_ORDEN.' EXTORNADA con EXITO');
        
        }
        else{

                  
            return View::make('comprobante/extornar', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



}
