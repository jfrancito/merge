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
use App\Modelos\CMPCategoria;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\Archivo;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPDetalleProducto;


use App\Modelos\CMPOrden;
use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;
use Greenter\Xml\Parser\RHParser;


use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;
use App\Traits\WhatsappTraits;
use App\Traits\ComprobanteProvisionTraits;


use Storage;
use ZipArchive;
use Hashids;
use SplFileInfo;

class GestionDocumentoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;


    public function actionListarDOC($idopcion)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Subidos');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $listadatos     =   array();
        $funcion        =   $this;
        $procedencia    =   'SUE';//documentos sueltos

        return View::make('documento/listadocumentos',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }




    public function actionDetalleDocumentos($procedencia,$idopcion,$prefijo, $iddocumento, Request $request) {

        if($iddocumento!='NUE'){
            $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        }else{
            $idoc                   =   '';
        }
        $fedocumento                =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('TXT_PROCEDENCIA','=',$procedencia)->first();
        View::share('titulo','REGISTRO DE DOCUMENTOS');
        $tiposerie                  =   '';
        if(count($fedocumento)>0){
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$fedocumento->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$fedocumento->ID_DOCUMENTO)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                            ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                            ->get();
            }else{
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$fedocumento->ID_DOCUMENTO)->where('COD_ESTADO','=',1)
                                            ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                            ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                            ->get();
            }

        }else{
            $detallefedocumento     =   array();
        }



        $funcion                    =   $this;

        return View::make('documento/registrodocumento',
                         [
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'procedencia'           =>  $procedencia,
                            'tarchivos'             =>  $tarchivos,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }





}
