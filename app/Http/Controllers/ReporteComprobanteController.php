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


        if($operacion_id=='ORDEN_COMPRA' || $operacion_id=='ORDEN_COMPRA_ANTICIPO'){

            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id);
            Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion,$operacion_id) {
                $excel->sheet($operacion_id == 'ORDEN_COMPRA_ANTICIPO' ? 'ORDEN COMPRA ANTICIPO' : 'ORDEN COMPRA', function($sheet) use ($listadatos,$titulo,$funcion) {

                    $sheet->loadView('reporte/excel/listacomprobantemasivo')->with('listadatos',$listadatos)
                                                                       ->with('titulo',$titulo)
                                                                       ->with('funcion',$funcion);                                               
                });
            })->export('xls');

        }else{

            if($operacion_id=='CONTRATO' || $operacion_id=='CONTRATO_ANTICIPO'){

                $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_contrato_excel($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id);
                Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion,$operacion_id) {
                    $excel->sheet($operacion_id == 'CONTRATO_ANTICIPO' ? 'CONTRATO ANTICIPO' : 'CONTRATO', function($sheet) use ($listadatos,$titulo,$funcion) {
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

    public function actionComprobanteMasivoAdministracionExcel($fecha_inicio, $fecha_fin, $proveedor_id, $estado_id, $operacion_id, $idopcion)
    {
        set_time_limit(0);

        $cod_empresa    = Session::get('usuario')->usuarioosiris_id;
        $fechadia       = date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual   = date("Y-m-d");
        $titulo         = 'Reporte-Administracion-Contratos-' . $operacion_id;
        $funcion        = $this;

        $listadatos = $this->con_lista_cabecera_comprobante_administracion_excel($fecha_inicio, $fecha_fin, $proveedor_id, $estado_id, $operacion_id);

        Excel::create($titulo . '-(' . $fecha_actual . ')', function($excel) use ($listadatos, $titulo, $funcion, $fecha_inicio, $fecha_fin, $proveedor_id) {
            $excel->sheet('ADMINISTRACION', function($sheet) use ($listadatos, $titulo, $funcion, $fecha_inicio, $fecha_fin, $proveedor_id) {
                $sheet->loadView('reporte/excel/listacomprobantemasivoadministracion')
                      ->with('listadatos', $listadatos)
                      ->with('titulo', $titulo)
                      ->with('fecha_inicio', $fecha_inicio)
                      ->with('fecha_fin', $fecha_fin)
                      ->with('proveedor_id', $proveedor_id)
                      ->with('funcion', $funcion);
            });
        })->export('xls');
    }

    private function con_lista_cabecera_comprobante_administracion_excel($fecha_inicio, $fecha_fin, $proveedor_id, $estado_id, $operacion_id)
    {
        // 1. Normalizar fechas a formato Y-m-d para SQL Server
        $f_ini = date('Y-m-d', strtotime($fecha_inicio));
        $f_fin = date('Y-m-d', strtotime($fecha_fin));

        $bindings = [
            'f_ini' => $f_ini,
            'f_fin' => $f_fin,
        ];

        // 2. Filtro de Proveedor (si no es 'TODO')
        $whereProveedor = "";
        if (trim($proveedor_id) != 'TODO' && trim($proveedor_id) != '') {
            $whereProveedor = " AND fe.RUC_PROVEEDOR = :proveedor_id ";
            $bindings['proveedor_id'] = $proveedor_id;
        }

        // 3. Filtro de Estado (si no es 'TODO')
        $whereEstado = "";
        if (trim($estado_id) != 'TODO' && trim($estado_id) != '') {
            $whereEstado = " AND fe.COD_ESTADO = :estado_id ";
            $bindings['estado_id'] = $estado_id;
        }

        // 4. Operación (por defecto CONTRATO)
        $operacion = (trim($operacion_id) != '' && trim($operacion_id) != 'TODO') ? $operacion_id : 'CONTRATO';
        $bindings['operacion'] = $operacion;

        $sql = "
            SELECT 
                -- CONTRATO
                fe.ID_DOCUMENTO AS ID_CONTRATO,
                ctt.NRO_SERIE + '-' + ctt.NRO_DOC AS NRO_CONTRATO,
                CONVERT(VARCHAR(10), ctt.FEC_EMISION, 103) AS FECHA_EMISION_CONTRATO,
                ctt.FEC_EMISION AS FEC_EMISION_CONTRATO_RAW,
                
                -- EMPRESA / SEDE
                fe.COD_EMPR,
                fe.TXT_EMPR AS EMPRESA_RECEPTORA,
                centro.NOM_CENTRO AS SEDE_CENTRO,

                -- PROVEEDOR
                fe.RUC_PROVEEDOR,
                fe.RZ_PROVEEDOR,

                -- FACTURA
                fe.ID_TIPO_DOC,
                fe.SERIE + '-' + fe.NUMERO AS NRO_COMPROBANTE,
                CONVERT(VARCHAR(10), fe.FEC_VENTA, 103) AS FECHA_EMISION_FACTURA,
                fe.FEC_VENTA AS FEC_VENTA_FACTURA_RAW,
                fe.MONEDA,
                COALESCE(ctt.CAN_TIPO_CAMBIO, 1) AS TIPO_CAMBIO,
                fe.SUB_TOTAL_VENTA_ORIG AS SUBTOTAL_FACTURA,
                fe.VALOR_IGV_ORIG AS IGV_FACTURA,
                fe.TOTAL_VENTA_ORIG AS TOTAL_FACTURA,
                fe.TXT_ESTADO AS ESTADO_COMPROBANTE,
                fe.COD_ESTADO AS COD_ESTADO_FE,

                -- DETRACCIÓN
                fe.TIPO_DETRACCION,
                COALESCE(fe.MONTO_DETRACCION_RED, fe.MONTO_DETRACCION, 0) AS MONTO_DETRACCION,
                fe.FOLIO_DETRACCION,
                fe.NRO_CUENTA,

                -- PRODUCTO / GLOSA / GUIAS
                det.PRODUCTO AS DESCRIPCION_SERVICIO,
                (
                    SELECT STUFF((
                        SELECT '// ' + DOC_INTERNO.NRO_SERIE + '-' + DOC_INTERNO.NRO_DOC + ' ' + DOC_INTERNO.TXT_CATEGORIA_MOTIVO_TRASLADO
                        FROM CMP.REFERENCIA_ASOC AS REF_INTERNO
                        INNER JOIN CMP.DOCUMENTO_CTBLE AS DOC_INTERNO ON REF_INTERNO.COD_TABLA_ASOC = DOC_INTERNO.COD_DOCUMENTO_CTBLE
                        WHERE REF_INTERNO.COD_TABLA = fe.ID_DOCUMENTO
                          AND DOC_INTERNO.COD_CATEGORIA_TIPO_DOC = 'TDO0000000000009'
                        FOR XML PATH('')
                    ), 1, 2, '')
                ) AS GUIAS_ASOCIADAS,

                fe.TXT_CONTACTO AS USUARIO_CONTACTO,

                -- PAGOS AGREGADOS (100% confiable y sin duplicidad de líneas)
                CONVERT(VARCHAR(10), pago.FECHA_PAGO_PROVEEDOR, 103) AS FECHA_PAGO,
                pago.FECHA_PAGO_PROVEEDOR AS FECHA_PAGO_RAW,
                pago.MEDIO_PAGO,
                pago.BANCO_PAGO,
                COALESCE(pago.IMPORTE_NETO_PAGADO, 0) AS IMPORTE_NETO_PAGADO,
                COALESCE(pago.IMPORTE_DETRACCION_PAGADO, 0) AS IMPORTE_DETRACCION_PAGADO,
                COALESCE(pago.TOTAL_IMPORTE_PAGADO, 0) AS TOTAL_IMPORTE_PAGADO,
                CASE WHEN pago.FECHA_PAGO_PROVEEDOR IS NOT NULL THEN 'PAGADO' ELSE 'PENDIENTE' END AS ESTADO_PAGO,

                -- DÍAS DE DIFERENCIA (CLAVE)
                CASE 
                    WHEN pago.FECHA_PAGO_PROVEEDOR IS NOT NULL 
                    THEN DATEDIFF(day, fe.FEC_VENTA, pago.FECHA_PAGO_PROVEEDOR) 
                    ELSE DATEDIFF(day, fe.FEC_VENTA, GETDATE()) 
                END AS DIAS_DIFERENCIA_FACTURA,

                CASE 
                    WHEN pago.FECHA_PAGO_PROVEEDOR IS NOT NULL 
                    THEN DATEDIFF(day, ctt.FEC_EMISION, pago.FECHA_PAGO_PROVEEDOR) 
                    ELSE DATEDIFF(day, ctt.FEC_EMISION, GETDATE()) 
                END AS DIAS_DIFERENCIA_CONTRATO

            FROM FE_DOCUMENTO fe
            INNER JOIN CMP.DOCUMENTO_CTBLE ctt ON fe.ID_DOCUMENTO = ctt.COD_DOCUMENTO_CTBLE
            LEFT JOIN ALM.CENTRO centro ON ctt.COD_CENTRO = centro.COD_CENTRO
            LEFT JOIN (
                SELECT ID_DOCUMENTO, MAX(PRODUCTO) AS PRODUCTO
                FROM FE_DETALLE_DOCUMENTO
                GROUP BY ID_DOCUMENTO
            ) det ON fe.ID_DOCUMENTO = det.ID_DOCUMENTO

            LEFT JOIN (
                SELECT r.COD_TABLA, d.COD_DOCUMENTO_CTBLE
                FROM CMP.DOCUMENTO_CTBLE d
                INNER JOIN CMP.REFERENCIA_ASOC r ON d.COD_DOCUMENTO_CTBLE = r.COD_TABLA_ASOC
                WHERE d.COD_ESTADO = '1' AND r.COD_ESTADO = '1'
                  AND d.COD_CATEGORIA_TIPO_DOC IN ('TDO0000000000001','TDO0000000000003','TDO0000000000002','TDO0000000000010')
            ) fac ON fe.ID_DOCUMENTO = fac.COD_TABLA

            LEFT JOIN (
                SELECT 
                    COD_DOCUMENTO_CTBLE,
                    MIN(FECHA_PAGO) AS PRIMERA_FECHA_PAGO,
                    MAX(FECHA_PAGO) AS ULTIMA_FECHA_PAGO,
                    COALESCE(MAX(CASE WHEN TXT_GLOSA NOT LIKE '%DETR%' THEN FECHA_PAGO ELSE NULL END), MAX(FECHA_PAGO)) AS FECHA_PAGO_PROVEEDOR,
                    COALESCE(MAX(CASE WHEN TXT_GLOSA NOT LIKE '%DETR%' THEN NOMBRE_BANCO ELSE NULL END), MAX(NOMBRE_BANCO)) AS BANCO_PAGO,
                    COALESCE(MAX(CASE WHEN TXT_GLOSA NOT LIKE '%DETR%' THEN MEDIO_PAGO ELSE NULL END), MAX(MEDIO_PAGO)) AS MEDIO_PAGO,
                    SUM(CASE WHEN TXT_GLOSA NOT LIKE '%DETR%' THEN IMPORTE ELSE 0 END) AS IMPORTE_NETO_PAGADO,
                    SUM(CASE WHEN TXT_GLOSA LIKE '%DETR%' THEN IMPORTE ELSE 0 END) AS IMPORTE_DETRACCION_PAGADO,
                    SUM(IMPORTE) AS TOTAL_IMPORTE_PAGADO
                FROM WEBPAGOSOC
                GROUP BY COD_DOCUMENTO_CTBLE
            ) pago ON fac.COD_DOCUMENTO_CTBLE = pago.COD_DOCUMENTO_CTBLE

            WHERE fe.OPERACION = :operacion
              AND CAST(COALESCE(ctt.FEC_EMISION, fe.FEC_VENTA) AS DATE) >= :f_ini
              AND CAST(COALESCE(ctt.FEC_EMISION, fe.FEC_VENTA) AS DATE) <= :f_fin
              {$whereProveedor}
              {$whereEstado}
            ORDER BY ctt.FEC_EMISION DESC
        ";

        return DB::select($sql, $bindings);
    }
}
