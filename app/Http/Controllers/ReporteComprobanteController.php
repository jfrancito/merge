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

                if($operacion_id=='COMISION'){

                        $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_comision_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id);
                        //dd($listadatos);

                        Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion,$operacion_id) {
                            $excel->sheet($operacion_id, function($sheet) use ($listadatos,$titulo,$funcion,$operacion_id) {

                                $sheet->loadView('reporte/excel/listacomprobantemasivocomision')->with('listadatos',$listadatos)
                                                                                   ->with('titulo',$titulo)
                                                                                   ->with('funcion',$funcion);                                               
                            });
                        })->export('xls');


                }else{

                    if($operacion_id=='PROVISION_GASTO'){

                        $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_provision_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
                        Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                            $excel->sheet('PROVISION_GASTO', function($sheet) use ($listadatos,$titulo,$funcion) {
                                $sheet->loadView('reporte/excel/listacomprobantemasivoprovisiongasto')->with('listadatos',$listadatos)
                                                                                   ->with('titulo',$titulo)
                                                                                   ->with('funcion',$funcion);                                               
                            });
                        })->export('xls');


                    }else{



                        if($operacion_id=='NOTA_CREDITO'){

                            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_nc_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
                            Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                                $excel->sheet('NOTA_CREDITO', function($sheet) use ($listadatos,$titulo,$funcion) {
                                    $sheet->loadView('reporte/excel/listacomprobantemasivoprovisiongasto')->with('listadatos',$listadatos)
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

        }

    }



    public function actionComprobanteMasivoReparableExcel($tipoarchivo_id,$estado_id,$operacion_id,$idopcion,$anio_id='')
    {
        set_time_limit(0);

        $cod_empresa            =   Session::get('usuario')->usuarioosiris_id;
        $fechadia               =   date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual           =   date("Y-m-d");
        $titulo                 =   'Comprobantes-Merge-'.$operacion_id;
        $funcion                =   $this;


        if($operacion_id=='ORDEN_COMPRA'){


            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_excel($cod_empresa,$tipoarchivo_id,$estado_id,$anio_id);
            Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                $excel->sheet('ORDEN COMPRA REPARABLE', function($sheet) use ($listadatos,$titulo,$funcion) {

                    $sheet->loadView('reporte/excel/listacomprobantemasivo')->with('listadatos',$listadatos)
                                                                       ->with('titulo',$titulo)
                                                                       ->with('funcion',$funcion);                                               
                });
            })->export('xls');

        }else{

            if($operacion_id=='CONTRATO'){

                $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_contrato_reparable_excel($cod_empresa,$tipoarchivo_id,$estado_id,$anio_id);
                Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                    $excel->sheet('CONTRATO REPARABLE', function($sheet) use ($listadatos,$titulo,$funcion) {
                        $sheet->loadView('reporte/excel/listacomprobantemasivocontrato')->with('listadatos',$listadatos)
                                                                           ->with('titulo',$titulo)
                                                                           ->with('funcion',$funcion);                                               
                    });
                })->export('xls');

            } else{



                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_estiba_reparable_excel($cod_empresa,$tipoarchivo_id,$estado_id,$operacion_id,$anio_id);
                    
                    Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion,$operacion_id) {
                        $excel->sheet($operacion_id.' REPARABLE', function($sheet) use ($listadatos,$titulo,$funcion,$operacion_id) {

                            $sheet->loadView('reporte/excel/listacomprobantemasivoestiba')->with('listadatos',$listadatos)
                                                                               ->with('titulo',$titulo)
                                                                               ->with('funcion',$funcion);                                               
                        });
                    })->export('xls');

            }

        }

    }



    public function actionComprobanteEnReparacionExcel($anio_id,$idopcion)
    {
        set_time_limit(0);

        $cod_empresa            =   Session::get('usuario')->usuarioosiris_id;
        $fecha_actual           =   date("Y-m-d");
        $titulo                 =   'Comprobantes-En-Reparacion';
        $funcion                =   $this;

        $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_reporte($cod_empresa,$anio_id);

        Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
            $excel->sheet('REPARACIÓN', function($sheet) use ($listadatos,$titulo,$funcion) {
                $sheet->loadView('reporte/excel/listareparacionreporte')->with('listadatos',$listadatos)
                                                                   ->with('titulo',$titulo)
                                                                   ->with('funcion',$funcion);                                               
            });
        })->export('xls');
    }

    public function actionComprobanteMasivoMarketingExcel($fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id,$idopcion)
    {
        set_time_limit(0);

        $cod_empresa            =   Session::get('usuario')->usuarioosiris_id;
        $fechadia               =   date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual           =   date("Y-m-d");
        $titulo                 =   'Comprobantes-Marketing-'.$operacion_id;
        $funcion                =   $this;

        $listadatos = $this->con_lista_cabecera_comprobante_marketing_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);

        Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
            $excel->sheet('MARKETING', function($sheet) use ($listadatos,$titulo,$funcion) {
                $sheet->loadView('reporte/excel/listacomprobantemasivomarketing')->with('listadatos',$listadatos)
                                                                   ->with('titulo',$titulo)
                                                                   ->with('funcion',$funcion);                                               
            });
        })->export('xls');
    }

    private function con_lista_cabecera_comprobante_marketing_excel($cliente_id, $fecha_inicio, $fecha_fin, $proveedor_id, $estado_id)
    {
        $fecha_inicio_iso = \Carbon\Carbon::createFromFormat('d-m-Y', $fecha_inicio)->format('Ymd') . ' 00:00:00';
        $fecha_fin_iso = \Carbon\Carbon::createFromFormat('d-m-Y', $fecha_fin)->format('Ymd') . ' 23:59:59';

        // 1. Obtener los IDs de los documentos válidos dentro del rango de fecha y filtros básicos (Sargable)
        $document_ids = FeDocumento::where('fecha_pa', '>=', $fecha_inicio_iso)
            ->where('fecha_pa', '<=', $fecha_fin_iso)
            ->where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
            ->where('OPERACION', '=', 'ORDEN_COMPRA')
            ->where('COD_ESTADO', '<>', '')
            ->whereIn('TXT_ESTADO', ['TERMINADA', 'APROBADO', 'APROBADOO'])
            ->where('COD_GRUPO_MK', '<>', '')
            ->whereNotNull('COD_GRUPO_MK')
            ->pluck('ID_DOCUMENTO')
            ->toArray();

        if (!empty($document_ids)) {
            // 2. Filtrar únicamente los documentos del rango que tengan cuenta contable en '000000', vacía o NULL
            $ids_to_update = FeDocumento::whereIn('ID_DOCUMENTO', $document_ids)
                ->where(function($q) {
                    $q->where('NRO_CUENTA', '=', '000000')
                      ->orWhereNull('NRO_CUENTA')
                      ->orWhere('NRO_CUENTA', '=', '');
                })
                ->pluck('ID_DOCUMENTO')
                ->toArray();

            // 3. Si hay documentos pendientes por actualizar, ejecutar la sincronización solo para esos IDs específicos (Index Seek)
            if (!empty($ids_to_update)) {
                $ids_str = implode(',', array_map(function($id) { return "'" . $id . "'"; }, $ids_to_update));
                DB::statement("
                    ;WITH CUENTAS AS
                    (
                        SELECT
                            AST.TXT_REFERENCIA,
                            STUFF((
                                SELECT DISTINCT
                                       ',' + ASM2.TXT_CUENTA_CONTABLE
                                FROM WEB.asientos AS AST2 (NOLOCK)
                                INNER JOIN WEB.asientomovimientos AS ASM2 (NOLOCK)
                                    ON AST2.COD_ASIENTO = ASM2.COD_ASIENTO
                                    AND ASM2.COD_ESTADO = 1
                                    AND LEFT(ASM2.TXT_CUENTA_CONTABLE,1) <> '4'
                                    AND ASM2.IND_PRODUCTO <> 2
                                WHERE AST2.COD_ESTADO = 1
                                    AND AST2.TXT_TIPO_REFERENCIA = 'dbo.FE_DOCUMENTO'
                                    AND AST2.TXT_REFERENCIA = AST.TXT_REFERENCIA
                                FOR XML PATH('')
                            ),1,1,'') AS CUENTAS
                        FROM WEB.asientos AS AST (NOLOCK)
                        WHERE AST.COD_ESTADO = 1
                            AND AST.TXT_TIPO_REFERENCIA = 'dbo.FE_DOCUMENTO'
                            AND AST.TXT_REFERENCIA IN ($ids_str)
                        GROUP BY AST.TXT_REFERENCIA
                    )
                    UPDATE FED
                    SET FED.NRO_CUENTA = C.CUENTAS
                    FROM FE_DOCUMENTO AS FED
                    INNER JOIN CUENTAS C
                        ON FED.ID_DOCUMENTO = C.TXT_REFERENCIA
                    WHERE FED.ID_DOCUMENTO IN ($ids_str)
                ");
            }
        }

        $query = FeDocumento::join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
            ->leftjoin('FE_DETALLE_DOCUMENTO', 'FE_DETALLE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
            ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.Orden.COD_USUARIO_CREA_AUD')
            ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')
            ->leftjoin('FE_GRUPO_DOCUMENTO', 'FE_DOCUMENTO.COD_GRUPO_MK', '=', 'FE_GRUPO_DOCUMENTO.ID_DOCUMENTO')
            ->where('fecha_pa', '>=', $fecha_inicio_iso)
            ->where('fecha_pa', '<=', $fecha_fin_iso)
            ->where('FE_DOCUMENTO.COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
            ->where('OPERACION', '=', 'ORDEN_COMPRA')
            ->where('FE_DOCUMENTO.COD_ESTADO', '<>', '')
            ->whereIn('FE_DOCUMENTO.TXT_ESTADO', ['TERMINADA', 'APROBADO', 'APROBADOO'])
            ->where('FE_DOCUMENTO.COD_GRUPO_MK', '<>', '')
            ->whereNotNull('FE_DOCUMENTO.COD_GRUPO_MK');

        if ($proveedor_id !== 'TODO') {
            $query->ProveedorFE($proveedor_id);
        }
        if ($estado_id !== 'TODO') {
            $query->EstadoFE($estado_id);
        }

        $listadatos = $query->select(DB::raw("
            FE_DOCUMENTO.*, 
            CMP.ORDEN.*,
            FE_DETALLE_DOCUMENTO.*,
            FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_FE, 
            CMP.Orden.TXT_GLOSA AS TXT_GLOSA_ORDEN,
            FE_DOCUMENTO.TXT_REPARABLE AS TXT_REPARABLE_SN, 
            FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_N,
            CMP.CATEGORIA.NOM_CATEGORIA AS AREA,
            FE_GRUPO_DOCUMENTO.NOMBRE AS GRUPO_MK_NOMBRE,
            FE_GRUPO_DOCUMENTO.TXT_CATCONTAORDEN AS CLASIFICACION_MK,
            FE_GRUPO_DOCUMENTO.TXT_UBICACION AS UBICACION_MK,
            (
                SELECT STUFF(
                    (
                        SELECT '// ' + d2_interno.TXT_NOMBRE_PRODUCTO
                        FROM CMP.DETALLE_PRODUCTO d2_interno
                        WHERE d2_interno.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO
                        FOR XML PATH('')
                    ), 1, 2, ''
                )
            ) AS productos_cabecera2
        "))
        ->orderBy('FEC_VENTA', 'asc')
        ->get();

        return $listadatos;
    }
}
