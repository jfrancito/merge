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
use App\Modelos\CMPDetalleProducto;

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
use App\Traits\ComprobanteProvisionTraits;


use Hashids;
use SplFileInfo;

class GestionOCProvisionController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use ComprobanteProvisionTraits;

    public function actionListarProvisionarComprobante($idopcion,Request $request)
    {

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();


                $msjarray           = array();
                $respuesta          = json_decode($request['pedido'], true);
                $conts              = 0;
                $contw              = 0;
                $contd              = 0;

                //dd("hola");
                foreach($respuesta as $obj){

                    $pedido_id                  =   $obj['id'];
                    $orden                      =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();
                    $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                    ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                    ->orderBy('NRO_LINEA','ASC')
                                                    ->get();
                    //  INSERTAR ORDEN DE INGRESO
                    //almacen lote                                
                    $this->insert_almacen_lote($orden,$detalleproducto);
                    $orden_id = $this->insert_orden($orden,$detalleproducto);                 
                    $this->insert_referencia_asoc($orden,$detalleproducto,$orden_id[0]);
                    $this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);
                    //UPDATE DE ORDEN DE COMPRA
                    //$this->update_orden($orden,$detalleproducto);
                    $this->update_detalle_producto($orden,$detalleproducto);
                    CMPOrden::where('COD_ORDEN','=',$orden->COD_ORDEN)
                                ->update(
                                        [
                                            'COD_OPERACION'=>1
                                        ]);

                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000006',
                                        'TXT_ESTADO'=>'PROVISIONADO',
                                        'fecha_pr'=>$this->fechaactual,
                                        'usuario_pr'=>Session::get('usuario')->id
                                    ]
                                );


                    $msjarray[]                 =   array(  "data_0" => $pedido_id, 
                                                                        "data_1" => 'Comprobante Provisionado', 
                                                                        "tipo" => 'S');
                    $conts                      =   $conts + 1;

                }

                /************** MENSAJES DEL DETALLE PEDIDO  ******************/
                $msjarray[] = array("data_0" => $conts, 
                                    "data_1" => 'Comprobantes Provisionado', 
                                    "tipo" => 'TS');

                $msjarray[] = array("data_0" => $contw, 
                                    "data_1" => 'Comprobantes Provisionado', 
                                    "tipo" => 'TW');     

                $msjarray[] = array("data_0" => $contd, 
                                    "data_1" => 'Comprobantes errados', 
                                    "tipo" => 'TD');

                $msjjson = json_encode($msjarray);

                DB::commit();
                return Redirect::to('/gestion-de-provision-comprobante/'.$idopcion)->with('xmlmsj', $msjjson);
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-provision-comprobante/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }




        
        }
    }


    public function actionListarComprobanteProvision($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Comprobantes Pendiente de Provisionar');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $listadatos     =   $this->con_lista_cabecera_comprobante_provisionar($cod_empresa);
        $funcion        =   $this;
        return View::make('comprobante/listaprovisionar',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }







}
