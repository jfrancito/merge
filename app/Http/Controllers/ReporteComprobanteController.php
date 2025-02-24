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
use App\Modelos\Archivo;
use App\Modelos\CMPReferecenciaAsoc;
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
use Hashids;
use SplFileInfo;
use Maatwebsite\Excel\Facades\Excel;

class ReporteComprobanteController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;

    public function actionComprobanteMasivoTesoreriaExcel($fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id,$idopcion)
    {
        set_time_limit(0);

        $cod_empresa            =   Session::get('usuario')->usuarioosiris_id;
        $fechadia               =   date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual           =   date("Y-m-d");
        $titulo                 =   'Comprobantes-Merge-'.$operacion_id;
        $funcion                =   $this;

        $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_tesoreria_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id);
        Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
            $excel->sheet('COMPROBANTE', function($sheet) use ($listadatos,$titulo,$funcion) {
                $sheet->loadView('reporte/excel/listacomprobantemasivotesoreria')->with('listadatos',$listadatos)
                                                                   ->with('titulo',$titulo)
                                                                   ->with('funcion',$funcion);                                               
            });
        })->export('xls');


    }

    public function actionComprobanteMasivoExcel($fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id,$idopcion)
    {
        set_time_limit(0);

        $cod_empresa            =   Session::get('usuario')->usuarioosiris_id;
        $fechadia               =   date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual           =   date("Y-m-d");
        $titulo                 =   'Comprobantes-Merge-'.$operacion_id;
        $funcion                =   $this;


        if($operacion_id=='ORDEN_COMPRA'){

            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
            Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                $excel->sheet('ORDEN COMPRA', function($sheet) use ($listadatos,$titulo,$funcion) {

                    $sheet->loadView('reporte/excel/listacomprobantemasivo')->with('listadatos',$listadatos)
                                                                       ->with('titulo',$titulo)
                                                                       ->with('funcion',$funcion);                                               
                });
            })->export('xls');

        }else{

            if($operacion_id=='CONTRATO'){

                $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_contrato_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
                Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                    $excel->sheet('CONTRATO', function($sheet) use ($listadatos,$titulo,$funcion) {
                        $sheet->loadView('reporte/excel/listacomprobantemasivocontrato')->with('listadatos',$listadatos)
                                                                           ->with('titulo',$titulo)
                                                                           ->with('funcion',$funcion);                                               
                    });
                })->export('xls');

            }else{



                $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_estiba_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id);
                Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion,$operacion_id) {
                    $excel->sheet($operacion_id, function($sheet) use ($listadatos,$titulo,$funcion,$operacion_id) {

                        $sheet->loadView('reporte/excel/listacomprobantemasivoestiba')->with('listadatos',$listadatos)
                                                                           ->with('titulo',$titulo)
                                                                           ->with('funcion',$funcion);                                               
                    });
                })->export('xls');


            } 

        }

    }



}
