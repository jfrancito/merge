<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\VMergeOC;
use App\Modelos\FeDocumento;
use App\Modelos\CMPCategoria;
use App\Modelos\CMPOrden;
use App\Modelos\STDTrabajador;
use App\Modelos\SGDUsuario;
use App\Modelos\VMergeActual;
use App\Modelos\Archivo;
use App\Modelos\VMergeDocumento;
use App\Modelos\VMergeDocumentoActual;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\WEBRol;
use App\Modelos\FeRefAsoc;
use App\Modelos\CONRegistroCompras;


use App\Modelos\Estado;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\ViewDPagar;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\STDEmpresa;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\Whatsapp;
use App\User;

use ZipArchive;
use SplFileInfo;
use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use SoapClient;
use Carbon\Carbon;

trait ComprobanteTraits
{

    public function con_array_canjes() {
        $array = ['ESTIBA','DOCUMENTO_INTERNO_PRODUCCION','DOCUMENTO_INTERNO_SECADO','DOCUMENTO_SERVICIO_BALANZA'];
        return $array;
    }    

    public function con_categoria_canje($valor) {
        $array = [  'ESTIBA'=>'TDO0000000000067',
                    'DOCUMENTO_INTERNO_PRODUCCION'=>'TDO0000000000092',
                    'DOCUMENTO_INTERNO_SECADO'=>'TDO0000000000096',
                    'DOCUMENTO_SERVICIO_BALANZA'=>'TDO0000000000071'];
        $id = $array[$valor];

        return $id;
    }   

    public function con_usuarios_cambio_cuenta() {
        $sw = 0;
        $array = ['1CIX00000217','1CIX00000001'];
        $valor = Session::get('usuario')->id;

        if (in_array($valor, $array)) {
            $sw = 1;
        } 
        return $sw;
    } 




    public function con_si_hay_retencion_lista($data_folio) {

        $listaentrarvalidacion  =   DB::table('FE_DOCUMENTO')
                                    ->join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
                                    ->where('FOLIO_RESERVA', $data_folio)
                                    ->where('OPERACION', 'ORDEN_COMPRA')
                                    ->where('CAN_IMPUESTO_VTA', '>', 0)
                                    //->where('IND_MATERIAL_SERVICIO', 'M')
                                    ->where('MONTO_DETRACCION_RED', '<=', 0)
                                    ->whereNotIn('RUC_PROVEEDOR', function ($query) {
                                        $query->select('RUC')->from('CON.PROVEEDORES_BCRP');
                                    })
                                    ->groupBy('RUC_PROVEEDOR', 'RZ_PROVEEDOR')
                                    ->havingRaw('SUM(TOTAL_VENTA_ORIG) >= ?', [701])
                                    ->selectRaw('RUC_PROVEEDOR, RZ_PROVEEDOR, SUM(MONTO_RETENCION) AS RETENCION_IGV, SUM(TOTAL_VENTA_ORIG) AS TOTAL_VENTA_ORIG')
                                    ->get();

        //dd($listaentrarvalidacion);

        $array                  =   array();
        foreach ($listaentrarvalidacion as $index => $item) {
            $ldocumentosretencion  =   DB::table('FE_DOCUMENTO')
                                        ->join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
                                        ->where('FOLIO_RESERVA', $data_folio)
                                        ->where('RUC_PROVEEDOR', $item->RUC_PROVEEDOR)
                                        ->where('OPERACION', 'ORDEN_COMPRA')
                                        ->where('CAN_IMPUESTO_VTA', '>', 0)
                                        //->where('IND_MATERIAL_SERVICIO', 'M')
                                        ->where('MONTO_DETRACCION_RED', '<=', 0)
                                        ->get();
            foreach ($ldocumentosretencion as $index02 => $item02) {
                $arrayitem       =   array();
                if($item02->MONTO_RETENCION<=0){
                    $total_retencion = $item02->TOTAL_VENTA_ORIG*0.03;
                    $arrayitem =    array(
                                    "ID_DOCUMENTO"              => $item02->ID_DOCUMENTO,
                                    "PORCENTAJE_RETENCION"      => 3,
                                    "RETENCION"                 => $total_retencion
                                );
                    array_push($array,$arrayitem);
                }

            }

        }

        return $array;

    }   








    public function con_zona($folio) {

        $folio = FeRefAsoc::where('LOTE','=',$folio)->first();  
        if (strpos($folio->ID_DOCUMENTO, 'CH') !== false) {
            return 'CHICLAYO';
        } else{
            if (strpos($folio->ID_DOCUMENTO, 'LM') !== false) {
                return 'LIMA';
            } else {
                if (strpos($folio->ID_DOCUMENTO, 'RJ') !== false) {
                    return 'RIOJA';
                } else {
                    if (strpos($folio->ID_DOCUMENTO, 'BE') !== false) {
                        return 'BELLAVISTA';
                    } else {
                        return 'SIN ZONA';
                    }
                }
            }
        }
    }    

    public function con_transferencia($id_orden) {

        $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$id_orden)->first();  
        $resultado = '';
        // Verificar si la cadena contiene 'TPS' o 'TPL'
        if (strpos($ordencompra->NRO_ITT, 'TPS') !== false || strpos($ordencompra->NRO_ITT, 'TPL') !== false) {
            $partes = explode(' / ', $ordencompra->NRO_ITT);
            $resultado = $partes[0];
        }
        $transferencia        =   CMPOrden::where('COD_ORDEN','=',$resultado)->first();  

        return $transferencia;

    }    


    private function con_lista_documentos_estiba_folio($folio) {


        $listadatos         =   DB::table('FE_DOCUMENTO')
                                ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                })
                                ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                         ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                         ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                })
                                ->leftjoin('CMP.CATEGORIA as CAT_CUENTA', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                ->leftjoin('CMP.CATEGORIA as CAT_MONEDA', 'CAT_MONEDA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.COD_CATEGORIA_MONEDA')
                                ->leftjoin('CMP.CATEGORIA as CAT_MONEDA_ABONO', 'CAT_MONEDA_ABONO.COD_CATEGORIA', '=', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA')
                                ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                ->where('FE_DOCUMENTO.FOLIO', $folio)
                                ->where('FE_DOCUMENTO.OPERACION', 'ESTIBA')
                                ->select(
                                        DB::raw('DISTINCT   CMP.DOCUMENTO_CTBLE.*, 
                                                    FE_DOCUMENTO.*, 
                                                    CMP.DOCUMENTO_CTBLE.NRO_SERIE,
                                                    CMP.CATEGORIA.TXT_TIPO_REFERENCIA,
                                                    CMP.CATEGORIA.TXT_GLOSA AS TXT_GLOSA_INTER,
                                                    STD.EMPRESA.NRO_DOCUMENTO, 
                                                    CMP.DOCUMENTO_CTBLE.FEC_EMISION, 
                                                    CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO, 
                                                    CMP.DOCUMENTO_CTBLE.NRO_DOC, 
                                                    CMP.DOCUMENTO_CTBLE.TXT_CATEGORIA_TIPO_DOC, 
                                                    CAT_CUENTA.CODIGO_SUNAT AS TIPO_CUENTA,
                                                    CAT_MONEDA.CODIGO_SUNAT AS TIPO_MONEDA, 
                                                    CAT_MONEDA_ABONO.TXT_ABREVIATURA AS TIPO_MONEDA_ABONO,
                                                    FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, 
                                                    FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO'))
                                ->get();


        return  $listadatos;


    }



    private function con_lista_documentos_contrato_folio($folio) {

        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);



        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })

                                    ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                        $join->on('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                             ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                             ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                    })
                                    ->leftjoin('CMP.CATEGORIA as CAT_CUENTA', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                    ->leftjoin('CMP.CATEGORIA as CAT_MONEDA', 'CAT_MONEDA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.COD_CATEGORIA_MONEDA')
                                    ->leftjoin('CMP.CATEGORIA as CAT_MONEDA_ABONO', 'CAT_MONEDA_ABONO.COD_CATEGORIA', '=', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA')
                                    ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                    ->where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(
                                        DB::raw('   CMP.DOCUMENTO_CTBLE.*, 
                                                    FE_DOCUMENTO.*, 
                                                    documentos.NRO_SERIE,
                                                    CMP.CATEGORIA.TXT_TIPO_REFERENCIA,
                                                    CMP.CATEGORIA.TXT_GLOSA AS TXT_GLOSA_INTER,
                                                    STD.EMPRESA.NRO_DOCUMENTO, 
                                                    documentos.FEC_EMISION, 
                                                    documentos.FEC_VENCIMIENTO, 
                                                    documentos.NRO_DOC, 
                                                    documentos.TXT_CATEGORIA_TIPO_DOC, 
                                                    CAT_CUENTA.CODIGO_SUNAT AS TIPO_CUENTA,
                                                    CAT_MONEDA.CODIGO_SUNAT AS TIPO_MONEDA, 
                                                    CAT_MONEDA_ABONO.TXT_ABREVIATURA AS TIPO_MONEDA_ABONO,
                                                    FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, 
                                                    FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO')
                                    )
                                    ->get();

        return  $listadatos;


    }


    private function con_lista_documentos_contrato_folio_oc($folio) {

        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.REFERENCIA_ASOC.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);



        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })

                                    ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                        $join->on('CMP.ORDEN.COD_EMPR_CLIENTE', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                             ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                             ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                    })
                                    ->leftjoin('CMP.CATEGORIA as CAT_CUENTA', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                    ->leftjoin('CMP.CATEGORIA as CAT_MONEDA', 'CAT_MONEDA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.COD_CATEGORIA_MONEDA')
                                    ->leftjoin('CMP.CATEGORIA as CAT_MONEDA_ABONO', 'CAT_MONEDA_ABONO.COD_CATEGORIA', '=', 'CMP.ORDEN.COD_CATEGORIA_MONEDA')
                                    ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.ORDEN.COD_EMPR_CLIENTE')
                                    ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                    ->where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(
                                        DB::raw('   CMP.ORDEN.*, 
                                                    FE_DOCUMENTO.*, 
                                                    documentos.NRO_SERIE,
                                                    CMP.CATEGORIA.TXT_TIPO_REFERENCIA,
                                                    CMP.CATEGORIA.TXT_GLOSA AS TXT_GLOSA_INTER,
                                                    STD.EMPRESA.NRO_DOCUMENTO, 
                                                    documentos.FEC_EMISION, 
                                                    documentos.FEC_VENCIMIENTO, 
                                                    documentos.NRO_DOC, 
                                                    documentos.TXT_CATEGORIA_TIPO_DOC, 
                                                    CAT_CUENTA.CODIGO_SUNAT AS TIPO_CUENTA,
                                                    CAT_MONEDA.CODIGO_SUNAT AS TIPO_MONEDA, 
                                                    CAT_MONEDA_ABONO.TXT_ABREVIATURA AS TIPO_MONEDA_ABONO,
                                                    FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, 
                                                    FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO')
                                    )
                                    ->get();

        return  $listadatos;


    }



    private function con_lista_documentos_proveedores_folio($folio,$empresa_id) {

        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);

        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                    ->where('FOLIO','=',$folio)
                                    ->where('FE_DOCUMENTO.RUC_PROVEEDOR','=',$empresa_id)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(
                                        DB::raw('CMP.DOCUMENTO_CTBLE.*, FE_DOCUMENTO.*, documentos.NRO_SERIE, documentos.FEC_EMISION, documentos.FEC_VENCIMIENTO, documentos.NRO_DOC, FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO'),
                                        DB::raw("(SELECT SUM(CAN_PRODUCTO)  FROM CMP.DETALLE_PRODUCTO WHERE CMP.DETALLE_PRODUCTO.COD_TABLA = CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE AND CMP.DETALLE_PRODUCTO.COD_ESTADO = 1 AND CMP.DETALLE_PRODUCTO.IND_MATERIAL_SERVICIO = 'M') AS TOTAL_CAN_SACOS")
                                    )
                                    ->get();

        return  $listadatos;


    }


    private function con_lista_documentos_proveedores_estiba_folio($folio,$empresa_id) {


        $listadatos         =   DB::table('FE_DOCUMENTO')
                                ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                })
                                ->where('FE_DOCUMENTO.FOLIO', $folio)
                                ->where('FE_DOCUMENTO.RUC_PROVEEDOR','=',$empresa_id)
                                ->where('FE_DOCUMENTO.OPERACION', 'ESTIBA')
                                ->select(
                                    DB::raw('DISTINCT FE_DOCUMENTO.*, CMP.DOCUMENTO_CTBLE.*'),
                                    DB::raw("(SELECT SUM(CAN_PRODUCTO)  FROM CMP.DETALLE_PRODUCTO WHERE CMP.DETALLE_PRODUCTO.COD_TABLA = CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE AND CMP.DETALLE_PRODUCTO.COD_ESTADO = 1 AND CMP.DETALLE_PRODUCTO.IND_MATERIAL_SERVICIO = 'M') AS TOTAL_CAN_SACOS")
                                )
                                ->get();

        return  $listadatos;


    }


    private function con_lista_cabecera_comprobante_entregable_contrato($cliente_id,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id,$moneda_id) {


        $fecha_corte            =   date('Ymd');

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id          =       $trabajador->COD_ZONA_TIPO;

        $array_usuarios         =   SGDUsuario::Area($area_id)
                                    ->whereNotNull('COD_CATEGORIA_AREA')
                                    ->pluck('COD_USUARIO')
                                    ->toArray();

        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);

        $rol            =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        if($rol->ind_uc == 1){

            $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                        //->Join('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                                        ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                                $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                     ->addBinding($documento->getBindings());
                                            })

                                        ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                             FROM DEUDA_TOTAL_MERGE_SUM 
                                                             GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                            'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')

                                        ->whereRaw("CAST(FE_DOCUMENTO.fecha_pa  AS DATE) >= ? and CAST(FE_DOCUMENTO.fecha_pa  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('OPERACION','=','CONTRATO')
                                        ->where(function ($query) {
                                            $query->where('FOLIO', '=', '');
                                            $query->orWhereNull('FOLIO');
                                        })
                                        ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005'])
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_EMPR','=',$empresa_id)
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                        ->where('FE_DOCUMENTO.COD_CATEGORIA_BANCO','=',$banco_id)
                                        //->whereIn('CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->select(
                                                    DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE NRO_SERIE_DOC,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC NRO_DOC_DOC,FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO')
                                                    //,DB::raw("CMP.OBTENER_NC_PROVEEDOR(CMP.DOCUMENTO_CTBLE.COD_EMPR, CMP.DOCUMENTO_CTBLE.COD_CENTRO, '{$fecha_corte}', CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR, CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA) AS NC_PROVEEDOR")
                                                    ,DB::raw("deuda.CAN_DEUDA AS CAN_DEUDA")
                                                )
                                        ->orderBy('documentos.FEC_VENCIMIENTO ', 'asc')
                                        ->get();

        }else{

          $listadatos             =     CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                        //->Join('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                                        ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })

                                        ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                         FROM DEUDA_TOTAL_MERGE_SUM 
                                                         GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                        'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')

                                        ->whereRaw("CAST(FE_DOCUMENTO.fecha_pa  AS DATE) >= ? and CAST(FE_DOCUMENTO.fecha_pa  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('OPERACION','=','CONTRATO')
                                        ->where(function ($query) {
                                            $query->where('FOLIO', '=', '');
                                            $query->orWhereNull('FOLIO');
                                        })
                                        ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005'])
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_EMPR','=',$empresa_id)
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                        //->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                        ->whereIn('CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('FE_DOCUMENTO.COD_CATEGORIA_BANCO','=',$banco_id)
                                        ->select(
                                                    DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE NRO_SERIE_DOC,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC NRO_DOC_DOC,FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO')
                                                    //,DB::raw("CMP.OBTENER_NC_PROVEEDOR(CMP.DOCUMENTO_CTBLE.COD_EMPR, CMP.DOCUMENTO_CTBLE.COD_CENTRO, '{$fecha_corte}', CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR, CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA) AS NC_PROVEEDOR")
                                                    ,DB::raw("deuda.CAN_DEUDA AS CAN_DEUDA")
                                                )
                                        ->orderBy('documentos.FEC_VENCIMIENTO ', 'asc')
                                        ->get();

        }







        return  $listadatos;


    }

    private function con_lista_cabecera_comprobante_entregable_estiba($cliente_id,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id,$operacion_id,$moneda_id) {


        $fecha_corte            =   date('Ymd');

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id          =       $trabajador->COD_ZONA_TIPO;

        $array_usuarios         =   SGDUsuario::Area($area_id)
                                    ->whereNotNull('COD_CATEGORIA_AREA')
                                    ->pluck('COD_USUARIO')
                                    ->toArray();



        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);

        $rol            =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        if($rol->ind_uc == 1){

            $listadatos                 = DB::table('FE_DOCUMENTO')
                                        ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                        ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                        ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                            $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                                 ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                        })
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_EMPR','=',$empresa_id)
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                        ->where('FE_DOCUMENTO.COD_CATEGORIA_BANCO','=',$banco_id)
                                        ->where('FE_DOCUMENTO.usuario_pa','=',Session::get('usuario')->id)
                                        //->whereIn('CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('FE_DOCUMENTO.COD_ESTADO', 'ETM0000000000005')
                                        //->where('FE_DOCUMENTO.ID_DOCUMENTO', '00000180')
                                        ->where('FE_DOCUMENTO.OPERACION', $operacion_id)
                                        ->where(function ($query) {
                                            $query->where('FOLIO', '=', '');
                                            $query->orWhereNull('FOLIO');
                                        })
                                        ->selectRaw('DISTINCT FE_DOCUMENTO.*, CMP.DOCUMENTO_CTBLE.*') // DISTINCT aplicado solo a estas columnas
                                        ->get();




        }else{


            $listadatos                 = DB::table('FE_DOCUMENTO')
                                        ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                        ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                        ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                            $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                                 ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                        })
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_EMPR','=',$empresa_id)
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                        ->where('FE_DOCUMENTO.COD_CATEGORIA_BANCO','=',$banco_id)
                                        ->whereIn('CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('FE_DOCUMENTO.COD_ESTADO', 'ETM0000000000005')
                                        ->where(function ($query) {
                                            $query->where('FOLIO', '=', '');
                                            $query->orWhereNull('FOLIO');
                                        })
                                        //->where('FE_DOCUMENTO.ID_DOCUMENTO', '00000180')
                                        ->where('FE_DOCUMENTO.OPERACION', $operacion_id)
                                        ->selectRaw('DISTINCT FE_DOCUMENTO.*, CMP.DOCUMENTO_CTBLE.*') // DISTINCT aplicado solo a estas columnas
                                        ->get();


            //dd($listadatos);


        }

        return  $listadatos;

    }


    private function con_lista_cabecera_comprobante_entregable_contrato_sinfolio($cliente_id,$empresa_id) {


        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id          =       $trabajador->COD_ZONA_TIPO;
        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);

        $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        if($rol->ind_uc == 1){

            $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                        ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                                $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                     ->addBinding($documento->getBindings());
                                            })
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('OPERACION','=','CONTRATO')
                                        ->where(function ($query) {
                                            $query->where('FOLIO', '=', '');
                                            $query->orWhereNull('FOLIO');
                                        })
                                        ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005'])
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_EMPR','=',$empresa_id)
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                        ->select(
                                                    DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE NRO_SERIE_DOC,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC NRO_DOC_DOC,FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO')
                                                )
                                        ->orderBy('documentos.FEC_VENCIMIENTO ', 'asc')
                                        ->get();

        }else{

          $listadatos             =     CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                        ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('OPERACION','=','CONTRATO')
                                        ->where(function ($query) {
                                            $query->where('FOLIO', '=', '');
                                            $query->orWhereNull('FOLIO');
                                        })
                                        ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005'])
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_EMPR','=',$empresa_id)
                                        ->select(
                                                    DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE NRO_SERIE_DOC,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC NRO_DOC_DOC,FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO')
                                                )
                                        ->orderBy('documentos.FEC_VENCIMIENTO ', 'asc')
                                        ->get();
        }

        return  $listadatos;
    }




    private function con_lista_doc_proveedor_banco_estiba_folio($folio,$banco_txt) {


        $listadatos             =   DB::table('FE_DOCUMENTO')
                                    ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                    ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                        $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                             ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                    })
                                    ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                        $join->on('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                             ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                             ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                    })
                                    ->leftjoin('CMP.CATEGORIA as CAT_CUENTA ', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                    ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                    ->where('FE_DOCUMENTO.FOLIO', $folio)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->where('FE_DOCUMENTO.OPERACION', 'ESTIBA')
                                    ->distinct()
                                    ->select(DB::raw('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA,
                                                    CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR,
                                                    CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR,
                                                    STD.EMPRESA.NRO_DOCUMENTO,
                                                    CMP.CATEGORIA.CODIGO_SUNAT,
                                                    CAT_CUENTA.TXT_ABREVIATURA,
                                                    CAN_TOTAL TOTAL,
                                                    CASE 
                                                            WHEN FE_DOCUMENTO.COD_PAGO_DETRACCION = CMP.DOCUMENTO_CTBLE.COD_EMPR 
                                                            THEN CAN_TOTAL - ISNULL(MONTO_ANTICIPO_DESC,0) - MONTO_DETRACCION_RED
                                                            ELSE CAN_TOTAL - ISNULL(MONTO_ANTICIPO_DESC,0)
                                                        END AS TOTAL_PAGAR,
                                                    MONTO_DETRACCION_RED DETRACCION'))
                                    ->get();

        return  $listadatos;

    }


    private function con_lista_doc_proveedor_banco_folio($folio,$banco_txt) {


        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                        $join->on('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                             ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                             ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                    })
                                    ->leftjoin('CMP.CATEGORIA as CAT_CUENTA ', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                    ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                    ->where('FOLIO','=',$folio)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA,
                                                    CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR,
                                                    CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR,
                                                    STD.EMPRESA.NRO_DOCUMENTO,
                                                    CMP.CATEGORIA.CODIGO_SUNAT,
                                                    CAT_CUENTA.TXT_ABREVIATURA,

                                                    SUM(TOTAL_VENTA_ORIG) TOTAL,
                                                    SUM(CASE 
                                                            WHEN FE_DOCUMENTO.COD_PAGO_DETRACCION = CMP.DOCUMENTO_CTBLE.COD_EMPR 
                                                            THEN ISNULL(FE_DOCUMENTO.TOTAL_VENTA_ORIG,0) - ROUND(ISNULL(FE_DOCUMENTO.MONTO_DETRACCION_RED,0), 0) - ISNULL(FE_DOCUMENTO.MONTO_RETENCION,0) - ISNULL(FE_DOCUMENTO.CAN_IMPUESTO_RENTA,0) - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + ISNULL(FE_DOCUMENTO.PERCEPCION,0)
                                                            ELSE ISNULL(FE_DOCUMENTO.TOTAL_VENTA_ORIG,0) - ISNULL(FE_DOCUMENTO.MONTO_RETENCION,0) - ISNULL(FE_DOCUMENTO.CAN_IMPUESTO_RENTA,0)  - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + ISNULL(FE_DOCUMENTO.PERCEPCION,0)
                                                        END) AS TOTAL_PAGAR,
                                                    SUM(ROUND(MONTO_DETRACCION_RED, 0)) DETRACCION'))
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR')
                                    ->groupBy('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA')
                                    ->groupBy('STD.EMPRESA.NRO_DOCUMENTO')
                                    ->groupBy('CMP.CATEGORIA.CODIGO_SUNAT')
                                    ->groupBy('CAT_CUENTA.TXT_ABREVIATURA')
                                    ->get();

        return  $listadatos;

    }



    private function con_lista_doc_proveedor_banco_folio_oc_union($folio,$banco_txt) {

        $listadatos01             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
                                    ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                        $join->on('CMP.ORDEN.COD_EMPR_CLIENTE', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                             ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                             ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                    })
                                    ->leftjoin('CMP.CATEGORIA as CAT_CUENTA ', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                    ->leftjoin('CMP.CATEGORIA as CAT_MONEDA', 'CAT_MONEDA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.COD_CATEGORIA_MONEDA')
                                    ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.ORDEN.COD_EMPR_CLIENTE')
                                    ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                    ->where('FOLIO','=',$folio)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA,
                                                    CMP.ORDEN.COD_EMPR_CLIENTE,
                                                    CMP.ORDEN.TXT_EMPR_CLIENTE,
                                                    STD.EMPRESA.NRO_DOCUMENTO,
                                                    CAT_MONEDA.TXT_REFERENCIA AS TIPO_MONEDA, 
                                                    CMP.CATEGORIA.CODIGO_SUNAT,
                                                    CAT_CUENTA.TXT_ABREVIATURA,
                                                    SUM(TOTAL_VENTA_ORIG) TOTAL,
                                                    SUM(CASE 
                                                            WHEN FE_DOCUMENTO.COD_PAGO_DETRACCION = CMP.ORDEN.COD_EMPR 
                                                            THEN ISNULL(FE_DOCUMENTO.TOTAL_VENTA_ORIG,0) - ROUND(ISNULL(FE_DOCUMENTO.MONTO_DETRACCION_RED,0), 0) - ISNULL(FE_DOCUMENTO.MONTO_RETENCION,0) - ISNULL(FE_DOCUMENTO.CAN_IMPUESTO_RENTA,0) - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + ISNULL(FE_DOCUMENTO.PERCEPCION,0)
                                                            ELSE ISNULL(FE_DOCUMENTO.TOTAL_VENTA_ORIG,0) - ISNULL(FE_DOCUMENTO.MONTO_RETENCION,0) - ISNULL(FE_DOCUMENTO.CAN_IMPUESTO_RENTA,0)  - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + ISNULL(FE_DOCUMENTO.PERCEPCION,0)
                                                        END) AS TOTAL_PAGAR,
                                                    SUM(ROUND(MONTO_DETRACCION_RED, 0)) DETRACCION'))
                                    ->groupBy('CMP.ORDEN.COD_EMPR_CLIENTE')
                                    ->groupBy('CMP.ORDEN.TXT_EMPR_CLIENTE')
                                    ->groupBy('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA')
                                    ->groupBy('STD.EMPRESA.NRO_DOCUMENTO')
                                    ->groupBy('CMP.CATEGORIA.CODIGO_SUNAT')
                                    ->groupBy('CAT_MONEDA.TXT_REFERENCIA')
                                    ->groupBy('CAT_CUENTA.TXT_ABREVIATURA');
        //                             ->get();

        // dd($listadatos01);


        $listadatos02           =   DB::table('FE_DOCUMENTO')
                                    ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                    ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                        $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                             ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                    })
                                    ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                        $join->on('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                             ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                             ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                    })
                                    ->leftjoin('CMP.CATEGORIA as CAT_CUENTA ', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                    ->leftjoin('CMP.CATEGORIA as CAT_MONEDA', 'CAT_MONEDA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.COD_CATEGORIA_MONEDA')
                                    ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                    ->where('FE_DOCUMENTO.FOLIO', $folio)
                                    ->where('CMP.REFERENCIA_ASOC.COD_ESTADO', 1)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->distinct()
                                    ->select(DB::raw('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA,
                                                    CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR COD_EMPR_CLIENTE,
                                                    CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR TXT_EMPR_CLIENTE,
                                                    STD.EMPRESA.NRO_DOCUMENTO,
                                                    FE_DOCUMENTO.ID_DOCUMENTO,
                                                    CAT_MONEDA.TXT_REFERENCIA AS TIPO_MONEDA,
                                                    CMP.CATEGORIA.CODIGO_SUNAT,
                                                    CAT_CUENTA.TXT_ABREVIATURA,
                                                    MAX(TOTAL_VENTA_ORIG) TOTAL,
                                                    MAX(CASE
                                                        WHEN FE_DOCUMENTO.COD_PAGO_DETRACCION = CMP.DOCUMENTO_CTBLE.COD_EMPR 
                                                            THEN ISNULL(FE_DOCUMENTO.TOTAL_VENTA_ORIG,0) - ROUND(ISNULL(FE_DOCUMENTO.MONTO_DETRACCION_RED,0), 0) - ISNULL(FE_DOCUMENTO.MONTO_RETENCION,0) - ISNULL(FE_DOCUMENTO.CAN_IMPUESTO_RENTA,0) - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + ISNULL(FE_DOCUMENTO.PERCEPCION,0)
                                                            ELSE ISNULL(FE_DOCUMENTO.TOTAL_VENTA_ORIG,0) - ISNULL(FE_DOCUMENTO.MONTO_RETENCION,0) - ISNULL(FE_DOCUMENTO.CAN_IMPUESTO_RENTA,0)  - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + ISNULL(FE_DOCUMENTO.PERCEPCION,0)
                                                        END) AS TOTAL_PAGAR,
                                                    MAX(ROUND(MONTO_DETRACCION_RED, 0)) DETRACCION'))
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR')
                                    ->groupBy('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA')
                                    ->groupBy('STD.EMPRESA.NRO_DOCUMENTO')
                                    ->groupBy('CMP.CATEGORIA.CODIGO_SUNAT')
                                    ->groupBy('CAT_MONEDA.TXT_REFERENCIA')
                                    ->groupBy('FE_DOCUMENTO.ID_DOCUMENTO')
                                    ->groupBy('CAT_CUENTA.TXT_ABREVIATURA')
                                    ->get();



                $listadatos02 = $listadatos02->groupBy(function ($item) {
                    return $item->TXT_NRO_CUENTA_BANCARIA . '-' . $item->COD_EMPR_CLIENTE;
                })->map(function ($group) {
                    return (object) [
                        'TXT_NRO_CUENTA_BANCARIA' => $group->first()->TXT_NRO_CUENTA_BANCARIA,
                        'COD_EMPR_CLIENTE' => $group->first()->COD_EMPR_CLIENTE,
                        'TXT_EMPR_CLIENTE' => $group->first()->TXT_EMPR_CLIENTE,
                        'NRO_DOCUMENTO' => $group->first()->NRO_DOCUMENTO,
                        'TIPO_MONEDA' => $group->first()->TIPO_MONEDA,
                        'CODIGO_SUNAT' => $group->first()->CODIGO_SUNAT,
                        'TXT_ABREVIATURA' => $group->first()->TXT_ABREVIATURA,
                        'TOTAL' => $group->sum('TOTAL'),
                        'TOTAL_PAGAR' => $group->sum('TOTAL_PAGAR'),
                        'DETRACCION' => $group->sum('DETRACCION'),
                    ];
                })->values();


        $listadatos01 = collect($listadatos01->get()); // Aseguramos que sea una colección
        $listadatos02 = collect($listadatos02); // Ya es una colección después de ->groupBy()->map()

        $listadatos = $listadatos01->merge($listadatos02);

        //dd($listadatos);

        //$listadatos             =   $listadatos01->union($listadatos02)->get();

        return  $listadatos;


    }


    private function con_lista_doc_proveedor_banco_folio_oc($folio,$banco_txt) {

        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
                                    ->leftJoin('TES.CUENTA_BANCARIA', function ($join) {
                                        $join->on('CMP.ORDEN.COD_EMPR_CLIENTE', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_TITULAR')
                                             ->on('FE_DOCUMENTO.COD_CATEGORIA_BANCO', '=', 'TES.CUENTA_BANCARIA.COD_EMPR_BANCO')
                                             ->on('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA', '=', 'TES.CUENTA_BANCARIA.TXT_NRO_CUENTA_BANCARIA');
                                    })
                                    ->leftjoin('CMP.CATEGORIA as CAT_CUENTA ', 'CAT_CUENTA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.TXT_TIPO_REFERENCIA')
                                    ->leftjoin('CMP.CATEGORIA as CAT_MONEDA', 'CAT_MONEDA.COD_CATEGORIA', '=', 'TES.CUENTA_BANCARIA.COD_CATEGORIA_MONEDA')
                                    ->leftjoin('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'CMP.ORDEN.COD_EMPR_CLIENTE')
                                    ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'STD.EMPRESA.COD_TIPO_DOCUMENTO')
                                    ->where('FOLIO','=',$folio)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA,
                                                    CMP.ORDEN.COD_EMPR_CLIENTE,
                                                    CMP.ORDEN.TXT_EMPR_CLIENTE,
                                                    STD.EMPRESA.NRO_DOCUMENTO,
                                                    CAT_MONEDA.TXT_REFERENCIA AS TIPO_MONEDA, 
                                                    CMP.CATEGORIA.CODIGO_SUNAT,
                                                    CAT_CUENTA.TXT_ABREVIATURA,
                                                    SUM(CAN_TOTAL) TOTAL,
                                                    SUM(CASE 
                                                            WHEN FE_DOCUMENTO.COD_PAGO_DETRACCION = CMP.ORDEN.COD_EMPR 
                                                            THEN CMP.ORDEN.CAN_TOTAL - ROUND(CMP.ORDEN.CAN_DETRACCION, 0) - CMP.ORDEN.CAN_RETENCION - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + CMP.ORDEN.CAN_PERCEPCION
                                                            ELSE CMP.ORDEN.CAN_TOTAL - CMP.ORDEN.CAN_RETENCION - ISNULL(FE_DOCUMENTO.MONTO_ANTICIPO_DESC,0) + CMP.ORDEN.CAN_PERCEPCION
                                                        END) AS TOTAL_PAGAR,
                                                    SUM(ROUND(CAN_DETRACCION, 0)) DETRACCION'))
                                    ->groupBy('CMP.ORDEN.COD_EMPR_CLIENTE')
                                    ->groupBy('CMP.ORDEN.TXT_EMPR_CLIENTE')
                                    ->groupBy('FE_DOCUMENTO.TXT_NRO_CUENTA_BANCARIA')
                                    ->groupBy('STD.EMPRESA.NRO_DOCUMENTO')
                                    ->groupBy('CMP.CATEGORIA.CODIGO_SUNAT')
                                    ->groupBy('CAT_MONEDA.TXT_REFERENCIA')
                                    ->groupBy('CAT_CUENTA.TXT_ABREVIATURA')
                                    ->get();

        return  $listadatos;


    }

    private function con_lista_proveedores_banco_estiba_folio($folio,$banco_txt) {


       $listadatos         =    DB::table('FE_DOCUMENTO')
                                ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                })
                                ->where('FE_DOCUMENTO.FOLIO', $folio)
                                ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                ->where('FE_DOCUMENTO.OPERACION', 'ESTIBA')
                                ->select(DB::raw('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR,CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR'))
                                ->groupBy('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                ->groupBy('CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR')
                                ->get();

        return  $listadatos;


    }

    private function con_lista_proveedores_banco_folio($folio,$banco_txt) {


        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->where('FOLIO','=',$folio)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR,CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR'))
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR')
                                    ->get();

        return  $listadatos;


    }

    private function con_lista_proveedores_banco_folio_oc($folio,$banco_txt) {


        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
                                    ->where('FOLIO','=',$folio)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('CMP.ORDEN.COD_EMPR_CLIENTE,CMP.ORDEN.TXT_EMPR_CLIENTE'))
                                    ->groupBy('CMP.ORDEN.COD_EMPR_CLIENTE')
                                    ->groupBy('CMP.ORDEN.TXT_EMPR_CLIENTE')
                                    ->get();

        return  $listadatos;


    }


    private function con_lista_proveedores_banco_folio_oc_union($folio,$banco_txt) {


        $listadatos             =   FeDocumento::where('FOLIO','=',$folio)
                                    ->where('TXT_CATEGORIA_BANCO','=',$banco_txt)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('RUC_PROVEEDOR,RZ_PROVEEDOR'))
                                    ->groupBy('RUC_PROVEEDOR')
                                    ->groupBy('RZ_PROVEEDOR')
                                    ->get();

        return  $listadatos;


    }



    private function con_lista_proveedores_folio($folio) {

        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR,CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR'))
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                    ->groupBy('CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR')
                                    ->get();

        return  $listadatos;

    }

    private function con_lista_proveedores_estiba_folio($folio) {

        $listadatos         =   DB::table('FE_DOCUMENTO')
                                ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                })
                                ->where('FE_DOCUMENTO.FOLIO', $folio)
                                ->where('FE_DOCUMENTO.OPERACION', 'ESTIBA')
                                ->select(DB::raw('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR,CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR'))
                                ->groupBy('CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR')
                                ->groupBy('CMP.DOCUMENTO_CTBLE.TXT_EMPR_EMISOR')
                                ->get();
        //dd("hola");
        return  $listadatos;

    }





    private function con_lista_bancos_estiba_folio($folio) {

       $listadatos         =   DB::table('FE_DOCUMENTO')
                                ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                })
                                ->where('FE_DOCUMENTO.FOLIO', $folio)
                                ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                ->where('FE_DOCUMENTO.OPERACION', 'ESTIBA')
                                ->select(DB::raw('FE_DOCUMENTO.COD_CATEGORIA_BANCO,FE_DOCUMENTO.TXT_CATEGORIA_BANCO'))
                                ->groupBy('FE_DOCUMENTO.COD_CATEGORIA_BANCO')
                                ->groupBy('FE_DOCUMENTO.TXT_CATEGORIA_BANCO')
                                ->get();

        return  $listadatos;


    }
    private function con_lista_bancos_folio($folio) {


        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('FE_DOCUMENTO.COD_CATEGORIA_BANCO,FE_DOCUMENTO.TXT_CATEGORIA_BANCO'))
                                    ->groupBy('FE_DOCUMENTO.COD_CATEGORIA_BANCO')
                                    ->groupBy('FE_DOCUMENTO.TXT_CATEGORIA_BANCO')
                                    ->get();

        return  $listadatos;


    }



    private function con_lista_bancos_folio_oc($folio) {


        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
                                    ->where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('FE_DOCUMENTO.COD_CATEGORIA_BANCO,FE_DOCUMENTO.TXT_CATEGORIA_BANCO'))
                                    ->groupBy('FE_DOCUMENTO.COD_CATEGORIA_BANCO')
                                    ->groupBy('FE_DOCUMENTO.TXT_CATEGORIA_BANCO')
                                    ->get();

        return  $listadatos;


    }


    private function con_lista_bancos_folio_oc_union($folio) {

        $listadatos             =   FeDocumento::where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('FE_DOCUMENTO.COD_CATEGORIA_BANCO,FE_DOCUMENTO.TXT_CATEGORIA_BANCO'))
                                    ->groupBy('FE_DOCUMENTO.COD_CATEGORIA_BANCO')
                                    ->groupBy('FE_DOCUMENTO.TXT_CATEGORIA_BANCO')
                                    ->get();

        return  $listadatos;


    }




    private function cambiar_parcialmente() {

        DB::table('CMP.ORDEN')
            ->join('CMP.REFERENCIA_ASOC', function($join) {
                $join->on('CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                     ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
            })
            ->join('CMP.DOCUMENTO_CTBLE', function($join) {
                $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                     ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE', '=', 'EDC0000000000009');
            })
            ->where('CMP.ORDEN.COD_CATEGORIA_TIPO_ORDEN', '=', 'TOR0000000000001')
            ->whereIn('CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN', ['EOR0000000000012'])
            ->update([
                'CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN' => 'EOR0000000000003',
                'CMP.ORDEN.TXT_CATEGORIA_ESTADO_ORDEN' => 'TERMINADA',
                'CMP.ORDEN.COD_USUARIO_MODIF_AUD' => 'MERGE',
                'CMP.ORDEN.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
            ]);

        if ($this->validarConexion('sqlsrv_b')) {

            DB::connection('sqlsrv_b')->table('CMP.ORDEN')
                ->join('CMP.REFERENCIA_ASOC', function($join) {
                    $join->on('CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                })
                ->join('CMP.DOCUMENTO_CTBLE', function($join) {
                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                         ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE', '=', 'EDC0000000000009');
                })
                ->where('CMP.ORDEN.COD_CATEGORIA_TIPO_ORDEN', '=', 'TOR0000000000001')
                ->whereIn('CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN', ['EOR0000000000012'])
                ->update([
                    'CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN' => 'EOR0000000000003',
                    'CMP.ORDEN.TXT_CATEGORIA_ESTADO_ORDEN' => 'TERMINADA',
                    'CMP.ORDEN.COD_USUARIO_MODIF_AUD' => 'MERGE',
                    'CMP.ORDEN.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                ]);


        }

        if ($this->validarConexion('sqlsrv_r')) {

            DB::connection('sqlsrv_r')->table('CMP.ORDEN')
                ->join('CMP.REFERENCIA_ASOC', function($join) {
                    $join->on('CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                })
                ->join('CMP.DOCUMENTO_CTBLE', function($join) {
                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                         ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE', '=', 'EDC0000000000009');
                })
                ->where('CMP.ORDEN.COD_CATEGORIA_TIPO_ORDEN', '=', 'TOR0000000000001')
                ->whereIn('CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN', ['EOR0000000000012'])
                ->update([
                    'CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN' => 'EOR0000000000003',
                    'CMP.ORDEN.TXT_CATEGORIA_ESTADO_ORDEN' => 'TERMINADA',
                    'CMP.ORDEN.COD_USUARIO_MODIF_AUD' => 'MERGE',
                    'CMP.ORDEN.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                ]);
            
        }




        print_r("SE REALIZO TODA LA OPERACION");

    }


    public function validarConexion($conexion) {
        try {
            DB::connection($conexion)->getPdo();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    private function cambiar_fecha_vencimiento() {


                    // CHICLAYO Y LIMA

                    //ORDEN DE COMPRA CREDITO
                    DB::table('CMP.DOCUMENTO_CTBLE')
                    ->join('CMP.REFERENCIA_ASOC', function($join) {
                        $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE');
                    })
                    ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                    ->join('FE_FORMAPAGO', function($join) {
                        $join->on('FE_FORMAPAGO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                             ->on('FE_FORMAPAGO.DOCUMENTO_ITEM', '=', 'FE_DOCUMENTO.DOCUMENTO_ITEM');
                    })
                    ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                    ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                    ->where('FE_DOCUMENTO.OPERACION', 'ORDEN_COMPRA')
                    ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                    ->whereRaw('DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, FE_FORMAPAGO.FECHA_PAGO) <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                    ->where('FE_DOCUMENTO.FORMA_PAGO', 'Credito')
                    ->where('FE_FORMAPAGO.ID_CUOTA', 'like', '%Cuota001%')
                    ->update([
                        'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                        'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                        'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                    ]);

                    //ORDEN DE COMPRA CONTADO
                    DB::table('CMP.DOCUMENTO_CTBLE')
                    ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                    ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                    ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                    ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                    ->where('FE_DOCUMENTO.OPERACION', 'ORDEN_COMPRA')
                    ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                    ->where('FE_DOCUMENTO.FORMA_PAGO', 'Contado')
                    ->whereRaw('CMP.CATEGORIA.COD_CTBLE <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                    ->update([
                        'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                        'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                        'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                    ]);


                    //////////////////////////CONTRATO


                    
                    DB::table('CMP.DOCUMENTO_CTBLE')
                    ->join('CMP.REFERENCIA_ASOC', function($join) {
                        $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                             ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', 'like', '%FC%');
                    })
                    ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                    ->join('FE_FORMAPAGO', function($join) {
                        $join->on('FE_FORMAPAGO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                             ->on('FE_FORMAPAGO.DOCUMENTO_ITEM', '=', 'FE_DOCUMENTO.DOCUMENTO_ITEM');
                    })
                    ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                    ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                    ->where('FE_DOCUMENTO.OPERACION', 'CONTRATO')
                    ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                    ->whereRaw('DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, FE_FORMAPAGO.FECHA_PAGO) <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                    ->where('FE_DOCUMENTO.FORMA_PAGO', 'Credito')
                    ->where('FE_FORMAPAGO.ID_CUOTA', 'like', '%Cuota001%')
                    ->update([
                        'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                        'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                        'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                    ]);

                    //CONTRATO CONTADO
                    DB::table('CMP.DOCUMENTO_CTBLE')
                    ->join('CMP.REFERENCIA_ASOC', function($join) {
                        $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                             ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', 'like', '%FC%');
                    })
                    ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                    ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                    ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                    ->where('FE_DOCUMENTO.OPERACION', 'CONTRATO')
                    ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                    ->where('FE_DOCUMENTO.FORMA_PAGO', 'Contado')
                    ->whereRaw('CMP.CATEGORIA.COD_CTBLE <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                    ->update([
                        'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                        'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                        'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                    ]);




                    if ($this->validarConexion('sqlsrv_b')) {

                        //BELLAVISTA

                        DB::connection('sqlsrv_b')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', function($join) {
                            $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE');
                        })
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('FE_FORMAPAGO', function($join) {
                            $join->on('FE_FORMAPAGO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                 ->on('FE_FORMAPAGO.DOCUMENTO_ITEM', '=', 'FE_DOCUMENTO.DOCUMENTO_ITEM');
                        })
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'ORDEN_COMPRA')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->whereRaw('DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, FE_FORMAPAGO.FECHA_PAGO) <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Credito')
                        ->where('FE_FORMAPAGO.ID_CUOTA', 'like', '%Cuota001%')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);

                        //ORDEN DE COMPRA CONTADO
                        DB::connection('sqlsrv_b')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', function($join) {
                            $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE');
                        })
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'ORDEN_COMPRA')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Contado')
                        ->whereRaw('CMP.CATEGORIA.COD_CTBLE <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);


                        //////////////////////////CONTRATO
                        DB::connection('sqlsrv_b')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', function($join) {
                            $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                 ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', 'like', '%FC%');
                        })
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('FE_FORMAPAGO', function($join) {
                            $join->on('FE_FORMAPAGO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                 ->on('FE_FORMAPAGO.DOCUMENTO_ITEM', '=', 'FE_DOCUMENTO.DOCUMENTO_ITEM');
                        })
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'CONTRATO')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->whereRaw('DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, FE_FORMAPAGO.FECHA_PAGO) <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Credito')
                        ->where('FE_FORMAPAGO.ID_CUOTA', 'like', '%Cuota001%')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);

                        //ORDEN DE COMPRA CONTADO
                        DB::connection('sqlsrv_b')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', function($join) {
                            $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                 ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', 'like', '%FC%');
                        })
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'CONTRATO')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Contado')
                        ->whereRaw('CMP.CATEGORIA.COD_CTBLE <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);


                    }


                    if ($this->validarConexion('sqlsrv_r')) {
                        DB::connection('sqlsrv_r')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', function($join) {
                            $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE');
                        })
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('FE_FORMAPAGO', function($join) {
                            $join->on('FE_FORMAPAGO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                 ->on('FE_FORMAPAGO.DOCUMENTO_ITEM', '=', 'FE_DOCUMENTO.DOCUMENTO_ITEM');
                        })
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'ORDEN_COMPRA')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->whereRaw('DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, FE_FORMAPAGO.FECHA_PAGO) <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Credito')
                        ->where('FE_FORMAPAGO.ID_CUOTA', 'like', '%Cuota001%')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);

                        //ORDEN DE COMPRA CONTADO
                        DB::connection('sqlsrv_r')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'ORDEN_COMPRA')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Contado')
                        ->whereRaw('CMP.CATEGORIA.COD_CTBLE <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);


                        //////////////////////////CONTRATO
                        DB::connection('sqlsrv_r')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', function($join) {
                            $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                 ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', 'like', '%FC%');
                        })
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('FE_FORMAPAGO', function($join) {
                            $join->on('FE_FORMAPAGO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                 ->on('FE_FORMAPAGO.DOCUMENTO_ITEM', '=', 'FE_DOCUMENTO.DOCUMENTO_ITEM');
                        })
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'CONTRATO')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->whereRaw('DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, FE_FORMAPAGO.FECHA_PAGO) <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Credito')
                        ->where('FE_FORMAPAGO.ID_CUOTA', 'like', '%Cuota001%')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('FE_FORMAPAGO.FECHA_PAGO'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);

                        //ORDEN DE COMPRA CONTADO
                        DB::connection('sqlsrv_r')->table('CMP.DOCUMENTO_CTBLE')
                        ->join('CMP.REFERENCIA_ASOC', function($join) {
                            $join->on('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                 ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC', 'like', '%FC%');
                        })
                        ->join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA')
                        ->join('CMP.CATEGORIA', 'CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_PAGO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
                        ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000005', 'ETM0000000000008'])
                        ->where('FE_DOCUMENTO.OPERACION', 'CONTRATO')
                        ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', 'CMP.DOCUMENTO_CTBLE')
                        ->where('FE_DOCUMENTO.FORMA_PAGO', 'Contado')
                        ->whereRaw('CMP.CATEGORIA.COD_CTBLE <> DATEDIFF(DAY, CMP.DOCUMENTO_CTBLE.FEC_EMISION, CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO)')
                        ->update([
                            'CMP.DOCUMENTO_CTBLE.FEC_VENCIMIENTO' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_GRACIA' => DB::raw('CMP.DOCUMENTO_CTBLE.FEC_EMISION'),
                            'CMP.DOCUMENTO_CTBLE.FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);




                    }

                    //RIOJA



                    print_r("SE REALIZO TODA LA OPERACION");

    }



    private function lectura_cdr_archivo($idoc,$path,$prefijocarperta,$NRO_DOCUMENTO_CLIENTE) {

        $fedocumento      =   FeDocumento::where('SERIE','like','F%')->where('CODIGO_CDR','=','')->first();
        $nombre_doc      = $fedocumento->SERIE.'-'.$fedocumento->NUMERO;
        $numerototal     = $fedocumento->NUMERO;
        $numerototalsc    = ltrim($numerototal, '0');
        $nombre_doc_sinceros = $fedocumento->SERIE.'-'.$numerototalsc;

        //dd($fedocumento);
        if(count($fedocumento)>0){
            $archivo            =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('TIPO_ARCHIVO','=','DCC0000000000004')->where('ACTIVO','=','1')->first();
            //dd($archivo);
            if(count($archivo)>0){
                $rutafile           =   $path.'\\comprobantes\\'.$prefijocarperta.'\\'.$NRO_DOCUMENTO_CLIENTE;
                $zipFilePath        =   $rutafile.'\\'.$archivo->NOMBRE_ARCHIVO;
                // Obtener el nombre del archivo ZIP sin la extensión
                $zipFileName = pathinfo($zipFilePath, PATHINFO_FILENAME);
                $zip = new ZipArchive();
                // Intentar abrir el archivo ZIP
                if ($zip->open($zipFilePath) === TRUE) {
                    // Iterar sobre cada archivo en el ZIP
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $fileInfo = $zip->statIndex($i);
                        echo 'Archivo dentro del ZIP: ' . $fileInfo['name'] . "\n";
                    }
                    // Cerrar el archivo ZIP
                    $zip->close();
                } 

                // Directorio base de destino (cámbialo a donde deseas guardar el archivo descomprimido)
                $extractToDir = $rutafile . DIRECTORY_SEPARATOR . $zipFileName;

                // Asegúrate de que el directorio de destino exista
                if (!file_exists($extractToDir)) {
                    mkdir($extractToDir, 0777, true);
                }

                // Crear una nueva instancia de ZipArchive
                $zip = new ZipArchive();
                // Intentar abrir el archivo ZIP
                if ($zip->open($zipFilePath) === TRUE) {
                    // Extraer todo el contenido al directorio de destino
                    $zip->extractTo($rutafile);
                    $zip->close();
                } 
                $extractedFile = $rutafile.'\\'.$fileInfo['name'];
                $extension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
                // Verificar si es un archivo XML
                //dd($extension);
                if ($extension === 'xml' or $extension === 'XML') {
                    if (file_exists($extractedFile)) {
                        //dd($extractedFile);
                        //cbc
                        $xml = simplexml_load_file($extractedFile);



                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if('cbc'==$prefix){
                                $cbc = 1;  
                            }
                        }

                        $codigocdr = '';
                        $respuestacdr = '';


                        if($cbc>=1){

                            foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                            {
                                $codigocdr  = (string)$ResponseCode;
                            }

                            foreach($xml->xpath('//cbc:Description') as $Description)
                            {
                                $respuestacdr  = $Description;
                            }
                            foreach($xml->xpath('//cbc:ID') as $ID)
                            {
                                $factura_cdr_id  = $ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }  
                        }else{

                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                            {
                                $codigocdr  = (string)$ResponseCodes->ResponseCode;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                            {
                                $respuestacdr  = $Description->Description;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                            {
                                $factura_cdr_id  = $ID->ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }

                            //dd($respuestacdr);
                        }



                        if($codigocdr!=''){

                            FeDocumento::where('ID_DOCUMENTO','=',$idoc)
                                        ->update(
                                            [
                                                'CODIGO_CDR'=>$codigocdr,
                                                'RESPUESTA_CDR'=>$respuestacdr
                                            ]
                                        );

                        }                        
                    } 
                } 

            }
        }

        return true;

    }




    private function lista_archivos_total_sin_voucher($idoc,$DOCUMENTO_ITEM) {




        $archivos               =   Archivo::leftJoin('CMP.CATEGORIA','TIPO_ARCHIVO','=','COD_CATEGORIA')
                                    ->where('ID_DOCUMENTO','=',$idoc)
                                    ->where('ACTIVO','=','1')
                                    ->where('DOCUMENTO_ITEM','=',$DOCUMENTO_ITEM)
                                    ->where(function ($query) {
                                        $query->where('TIPO_ARCHIVO', '<>', 'DCC0000000000028')
                                              ->orWhere(function ($query) {
                                                  $query->where('USUARIO_CREA', '=', '1CIX00000001')
                                                        ->where('TIPO_ARCHIVO', '=', 'DCC0000000000028');
                                              });
                                    })
                                    ->select(DB::raw("
                                      ARCHIVOS.*,
                                      COALESCE(COD_TIPO_DOCUMENTO,20) AS ORDEN_ITEM")
                                    )
                                    ->orderBy('ORDEN_ITEM','asc')
                                    ->get();

        return  $archivos;

    }

    private function lista_archivos_total_pdf_sin_voucher($idoc,$DOCUMENTO_ITEM) {

        $archivos               =   Archivo::leftJoin('CMP.CATEGORIA','TIPO_ARCHIVO','=','COD_CATEGORIA')
                                    ->where('ID_DOCUMENTO','=',$idoc)
                                    ->where('ACTIVO','=','1')
                                    ->where('DOCUMENTO_ITEM','=',$DOCUMENTO_ITEM)
                                    ->where(function ($query) {
                                        $query->where('TIPO_ARCHIVO', '<>', 'DCC0000000000028')
                                              ->orWhere(function ($query) {
                                                  $query->where('USUARIO_CREA', '=', '1CIX00000001')
                                                        ->where('TIPO_ARCHIVO', '=', 'DCC0000000000028');
                                              });
                                    })
                                    ->where('EXTENSION', 'like', '%'.'pdf'.'%')
                                    ->select(DB::raw("
                                      ARCHIVOS.*,
                                      COALESCE(COD_TIPO_DOCUMENTO,20) AS ORDEN_ITEM")
                                    )
                                    ->orderBy('ORDEN_ITEM','asc')
                                    ->get();

        return  $archivos;

    }




    private function lista_archivos_total($idoc,$DOCUMENTO_ITEM) {

        $archivos               =   Archivo::leftJoin('CMP.CATEGORIA','TIPO_ARCHIVO','=','COD_CATEGORIA')
                                    ->where('ID_DOCUMENTO','=',$idoc)
                                    ->where('ACTIVO','=','1')
                                    ->where('DOCUMENTO_ITEM','=',$DOCUMENTO_ITEM)
                                    ->select(DB::raw("
                                      ARCHIVOS.*,
                                      COALESCE(COD_TIPO_DOCUMENTO,20) AS ORDEN_ITEM")
                                    )
                                    ->orderBy('ORDEN_ITEM','asc')
                                    ->get();

        return  $archivos;

    }

    private function lista_archivos_total_pdf($idoc,$DOCUMENTO_ITEM) {

        $archivospdf            =   Archivo::leftJoin('CMP.CATEGORIA','TIPO_ARCHIVO','=','COD_CATEGORIA')
                                    ->where('ID_DOCUMENTO','=',$idoc)
                                    ->where('ACTIVO','=','1')
                                    ->where('EXTENSION', 'like', '%'.'pdf'.'%')
                                    ->where('DOCUMENTO_ITEM','=',$DOCUMENTO_ITEM)
                                    ->select(DB::raw("
                                      ARCHIVOS.*,
                                      COALESCE(COD_TIPO_DOCUMENTO,20) AS ORDEN_ITEM")
                                    )
                                    ->orderBy('ORDEN_ITEM','asc')
                                    ->get();

        return  $archivospdf;

    }





    private function ejecutar_orden_ingreso() {


        $listafedocumentos      =   FeDocumento::where('COD_ESTADO','=','ETM0000000000009')->where('OPERACION','=','ORDEN_COMPRA')->get();

        foreach($listafedocumentos as $index=>$item){

            $orden              =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();
            $referenciaasoc     =   CMPReferecenciaAsoc::join('CMP.ORDEN','CMP.ORDEN.COD_ORDEN','=','CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->where('CMP.REFERENCIA_ASOC.COD_TABLA','=',$item->ID_DOCUMENTO)
                                    ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC','LIKE','%OI%')
                                    ->where('CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN','=','EOR0000000000001')
                                    ->first();
            //dd($referenciaasoc->COD_TABLA_ASOC);
            if(count($referenciaasoc)>0){
                $wsdl = 'http://10.1.0.201/WCF_Orden.svc?wsdl';
                // URL del WSDL del servicio WCF 
                if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                     $wsdl = 'http://10.1.7.200:83/WCF_Orden.svc?wsdl';
                }else{
                    if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                        $wsdl = 'http://10.1.9.43:81/WCF_Orden.svc?wsdl';
                    }
                }
                $mode = array (
                    'soap_version'  => 'SOAP_1_2', // use soap 1.2 client
                    'keep_alive'    => true,
                    'trace'         => 1,
                    'encoding'      => 'utf-8',
                    'compression'   => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
                    'Content-Encoding'=> 'UTF-8',
                    'exceptions'    => true,
                    'cache_wsdl'    => WSDL_CACHE_NONE,
                );
                $params = [
                    'ls_Tipo' => 'I', 
                    'codOrdenI' => $referenciaasoc->COD_TABLA_ASOC
                ];
                $client     = new SoapClient($wsdl, $mode); 
                $res        = $client->EjecutarOIMerge($params);
                $json       = response()->json($res);
                $jsonData   = $json->getContent();
                $dataArray  = json_decode($jsonData, true);
                $message    = $dataArray['EjecutarOIMergeResult'];
            }

        }
    }




    private function orden_ingreso_ejecutada() {

        $listafedocumentos      =   FeDocumento::where('COD_ESTADO','=','ETM0000000000009')->get();
        $COD_ORDEN_COMPRA = '';
        $pathFiles='\\\\10.1.50.2';
        foreach($listafedocumentos as $index=>$item){

            $orden                  =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();
            $fechaactual            = date('Ymd H:i:s');
            $conexionbd         = 'sqlsrv';
            if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                $conexionbd         = 'sqlsrv_r';
            }else{
                if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                    $conexionbd         = 'sqlsrv_b';
                }
            }
            $referenciaasoc = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->Join('CMP.ORDEN', 'CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                              ->where('CMP.REFERENCIA_ASOC.COD_TABLA','=',$item->ID_DOCUMENTO)
                              ->where('CMP.REFERENCIA_ASOC.COD_ESTADO','=','1')
                              ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC','like','%'.'OI'.'%')
                              ->where('CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN','=','EOR0000000000003')
                              ->first();

            if(count($referenciaasoc)>0){

                //SI ES MATERIAL
                FeDocumento::where('ID_DOCUMENTO',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000003',
                                    'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                    'ind_email_ap'=>0,
                                    'fecha_uc'=>$fechaactual,
                                    'usuario_uc'=>$item->usuario_uc
                                ]
                            );

                $usuario        = User::where('id','=',$item->usuario_uc)->first();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $item->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $item->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $fechaactual;
                $documento->USUARIO_ID                  =   $usuario->id;
                $documento->USUARIO_NOMBRE              =   $usuario->nombre;
                $documento->TIPO                        =   'APROBADO POR USUARIO CONTACTO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //whatsaap para contabilidad
                $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)->first();
                $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();            
                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                if(1==0){
                    $this->insertar_whatsaap_sp('51979820173','JORGE FRANCELLI',$mensaje,'');
                }else{
                    $this->insertar_whatsaap_sp('51979820173','JORGE FRANCELLI',$mensaje,'');
                    $this->insertar_whatsaap_sp('51979659002','HAMILTON',$mensaje,'');
                    $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                    //CONTABILIDAD
                    if($prefijocarperta=='II'){
                        $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                        $this->insertar_whatsaap('51988650421','LUCELY',$mensaje,'');           //INTERNACIONAL
                    }else{
                        $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                        $this->insertar_whatsaap('51935387084','VASQUEZ',$mensaje,'');          //COMERCIAL
                    }
                } 

            }
            print_r("EJECUTO ORDEN DE INGRESO");
 
        }

    }

    public function insertar_whatsaap_sp($numero,$nombre,$mensaje,$rutaimagen){
            $cabecera                   =   new Whatsapp;
            $cabecera->numero_contacto  =   $numero;
            $cabecera->nombre_contacto  =   $nombre;
            $cabecera->mensaje          =   $mensaje;
            $cabecera->ruta_imagen      =   $rutaimagen;
            $cabecera->ind_envio        =   0;
            $cabecera->nombre_proyecto  =   'MERGE';
            $cabecera->fecha_crea       =   date('d-m-Y H:i:s');
            $cabecera->activo           =   1;
            $cabecera->save();
    }

    private function sunat_cdr() {

        $listafedocumentos      =   FeDocumento::where('COD_ESTADO','=','ETM0000000000007')->where('OPERACION','=','ORDEN_COMPRA')->get();
        //dd($listafedocumentos);

        $COD_ORDEN_COMPRA = '';
        $pathFiles='\\\\10.1.50.2';

        foreach($listafedocumentos as $index=>$item){

                $COD_ORDEN_COMPRA       = '';
                $sw_opecion             =   0;
                $sw                     =   1;
                $codigocdr              =   '';
                $respuestacdr           =   '';

                $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($item->ID_DOCUMENTO);
                $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();
                $prefijocarperta        =   $this->prefijo_empresa($item->ID_DOCUMENTO);
                $fechaemision           =   date_format(date_create($item->FEC_VENTA), 'd/m/Y');
                $nombre_doc             =   $item->SERIE.'-'.$item->NUMERO;


                $numerototal     = $item->NUMERO;
                $numerototalsc    = ltrim($numerototal, '0');
                $nombre_doc_sinceros = $item->SERIE.'-'.$numerototalsc;

                // if($item->ID_TIPO_DOC == 'R1'){
                //     //LECTURA DE CDR
                //     $archivo                =   Archivo::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                //                                 ->where('TIPO_ARCHIVO','=','DCC0000000000004')
                //                                 ->first();

                //     if(count($archivo)>0){


                //         $rutafile        =      $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                //         $nombrefile      =      $archivo->NOMBRE_ARCHIVO;
                //         $valor           =      $this->versicarpetanoexiste($rutafile);
                //         $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                //         $zipFilePath = $archivo->URL_ARCHIVO;
                //         $extractPath = $rutafile;

                //         $zip = new ZipArchive;
                //         $fileNames = '';
                //         if ($zip->open($zipFilePath) === TRUE) {
                //             if ($zip->extractTo($extractPath)) {
                //                 for ($i = 0; $i < $zip->numFiles; $i++) {
                //                     $fileNames = $zip->getNameIndex($i);
                //                 }
                //             } else {
                //                 echo 'Hubo un error al descomprimir el archivo.';
                //             }
                //             $zip->close();
                //         } else {
                //             echo 'No se pudo abrir el archivo zip.';
                //         }

                //         $extractedFile = $extractPath.'\\'.$fileNames;
                //         if (file_exists($extractedFile)) {

                //             //cbc
                //             $xml = simplexml_load_file($extractedFile);
                //             $cbc = 0;
                //             $namespaces = $xml->getNamespaces(true);
                //             foreach ($namespaces as $prefix => $namespace) {
                //                 if('cbc'==$prefix){
                //                     $cbc = 1;  
                //                 }
                //             }
                //             if($cbc>=1){
                //                 foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                //                 {
                //                     $codigocdr  = (string)$ResponseCode;
                //                 }
                //                 foreach($xml->xpath('//cbc:Description') as $Description)
                //                 {
                //                     $respuestacdr  = $Description;
                //                 }
                //                 foreach($xml->xpath('//cbc:ID') as $ID)
                //                 {
                //                     $factura_cdr_id  = $ID;
                //                     if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                //                         $sw = 1;
                //                     }
                //                 }  
                //             }else{
                //                 $xml_ns = simplexml_load_file($extractedFile);

                //                 // Namespace definitions
                //                 $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                //                 $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                //                 // Register namespaces
                //                 $xml_ns->registerXPathNamespace('ns4', $ns4);
                //                 $xml_ns->registerXPathNamespace('ns3', $ns3);
                //                 // Querying XML
                //                 foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                //                 {
                //                     $codigocdr  = (string)$ResponseCodes->ResponseCode;
                //                 }
                //                 foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                //                 {
                //                     $respuestacdr  = $Description->Description;
                //                 }
                //                 foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                //                 {
                //                     $factura_cdr_id  = $ID->ID;
                //                     if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                //                         $sw = 1;
                //                     }
                //                 }
                //             }
                //             if($codigocdr!="0"){
                //                 dd("cdr malo");
                //             }


                //         } 

                //     }else{
                //         $sw = 1;
                //     }

                // }else{
                //         $sw = 1;
                // }


                //LECTURA A SUNAT
                $token = '';
                $estadoCp = '';
                $swlectur = 0;
                if($prefijocarperta =='II'){
                    $token           =      $this->generartoken_ii();
                }else{
                    $token           =      $this->generartoken_is();
                }


                $rh              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                            ->where('COD_ESTADO','=',1)
                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                            ->get();

                if(count($rh)<=0){
                    //FACTURA
                    $rvalidar = $this->validar_xml( $token,
                                                    $item->ID_CLIENTE,
                                                    $item->RUC_PROVEEDOR,
                                                    $item->ID_TIPO_DOC,
                                                    $item->SERIE,
                                                    $item->NUMERO,
                                                    $fechaemision,
                                                    $item->TOTAL_VENTA_ORIG);
                }else{
                    //RECIBO POR HONORARIO
                    $rvalidar = $this->validar_xml( $token,
                                                    $item->ID_CLIENTE,
                                                    $item->RUC_PROVEEDOR,
                                                    $item->ID_TIPO_DOC,
                                                    $item->SERIE,
                                                    $item->NUMERO,
                                                    $fechaemision,
                                                    $item->TOTAL_VENTA_ORIG+$item->MONTO_RETENCION);
                }


                $arvalidar = json_decode($rvalidar, true);
                if(isset($arvalidar['success'])){
                    if($arvalidar['success']){

                        $datares              = $arvalidar['data'];

                        if (isset($datares['estadoCp'])){
                            $estadoCp             = $datares['estadoCp'];
                            $tablaestacp          = Estado::where('tipo','=','estadoCp')->where('codigo','=',$estadoCp)->first();

                            $estadoRuc            = '';
                            $txtestadoRuc         = '';
                            $estadoDomiRuc        = '';
                            $txtestadoDomiRuc     = '';

                            if(isset($datares['estadoRuc'])){
                                $tablaestaruc          = Estado::where('tipo','=','estadoRuc')->where('codigo','=',$datares['estadoRuc'])->first();
                                $estadoRuc             = $tablaestaruc->codigo;
                                $txtestadoRuc          = $tablaestaruc->nombre;
                            }
                            if(isset($datares['condDomiRuc'])){
                                $tablaestaDomiRuc       = Estado::where('tipo','=','condDomiRuc')->where('codigo','=',$datares['condDomiRuc'])->first();
                                $estadoDomiRuc          = $tablaestaDomiRuc->codigo;
                                $txtestadoDomiRuc       = $tablaestaDomiRuc->nombre;
                            }

                            FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                        ->update(
                                                [
                                                    'success'=>$arvalidar['success'],
                                                    'message'=>$arvalidar['message'],
                                                    'estadoCp'=>$tablaestacp->codigo,
                                                    'nestadoCp'=>$tablaestacp->nombre,
                                                    'estadoRuc'=>$estadoRuc,
                                                    'nestadoRuc'=>$txtestadoRuc,
                                                    'condDomiRuc'=>$estadoDomiRuc,
                                                    'ncondDomiRuc'=>$txtestadoDomiRuc,
                                                ]);
                            $swlectur = 1;
                        }

                    }else{
                        FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                    ->update(
                                            [
                                                'success'=>$arvalidar['success'],
                                                'message'=>$arvalidar['message']
                                            ]);
                    }
                }
                //PASAR PARA EL USUARIO DE CONTACTO REALIZE SU APLICACION
                //el cdr es el de la factura

                if($sw==1 && $swlectur==1){
                    FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000002',
                                        'TXT_ESTADO'=>'POR APROBAR USUARIO CONTACTO'
                                    ]
                                );
                }
        }

        print_r('Exitoso '. $COD_ORDEN_COMPRA);

    }



    private function sunat_cdr_contrato() {

        $listafedocumentos      =   FeDocumento::where('COD_ESTADO','=','ETM0000000000007')->where('OPERACION','=','CONTRATO')->get();
        //dd($listafedocumentos);

        $COD_ORDEN_COMPRA = '';
        $pathFiles='\\\\10.1.50.2';

        foreach($listafedocumentos as $index=>$item){

                $COD_ORDEN_COMPRA       = '';
                $sw_opecion             =   0;
                $sw                     = 0;
                $codigocdr              = '';
                $respuestacdr              = '';


                $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($item->ID_DOCUMENTO);
                $ordencompra_t          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$item->ID_DOCUMENTO)->first();


                $prefijocarperta        =   $this->prefijo_empresa($item->ID_DOCUMENTO);
                $fechaemision           =   date_format(date_create($item->FEC_VENTA), 'd/m/Y');
                $nombre_doc             =   $item->SERIE.'-'.$item->NUMERO;


                $numerototal     = $item->NUMERO;
                $numerototalsc    = ltrim($numerototal, '0');
                $nombre_doc_sinceros = $item->SERIE.'-'.$numerototalsc;




                if($item->ID_TIPO_DOC == 'R1'){

                    //LECTURA DE CDR
                    $archivo                =   Archivo::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                                ->where('TIPO_ARCHIVO','=','DCC0000000000004')
                                                ->first();

                    if(count($archivo)>0){


                        $rutafile        =      $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $archivo->NOMBRE_ARCHIVO;
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $zipFilePath = $archivo->URL_ARCHIVO;
                        $extractPath = $rutafile;

                        $zip = new ZipArchive;
                        $fileNames = '';
                        if ($zip->open($zipFilePath) === TRUE) {
                            if ($zip->extractTo($extractPath)) {
                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                    $fileNames = $zip->getNameIndex($i);
                                }
                            } else {
                                echo 'Hubo un error al descomprimir el archivo.';
                            }
                            $zip->close();
                        } else {
                            echo 'No se pudo abrir el archivo zip.';
                        }

                        $extractedFile = $extractPath.'\\'.$fileNames;
                        if (file_exists($extractedFile)) {

                            //cbc
                            $xml = simplexml_load_file($extractedFile);
                            $cbc = 0;
                            $namespaces = $xml->getNamespaces(true);
                            foreach ($namespaces as $prefix => $namespace) {
                                if('cbc'==$prefix){
                                    $cbc = 1;  
                                }
                            }
                            if($cbc>=1){
                                foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                                {
                                    $codigocdr  = $ResponseCode;
                                }
                                foreach($xml->xpath('//cbc:Description') as $Description)
                                {
                                    $respuestacdr  = $Description;
                                }
                                foreach($xml->xpath('//cbc:ID') as $ID)
                                {
                                    $factura_cdr_id  = $ID;
                                    if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                        $sw = 1;
                                    }
                                }  
                            }else{
                                $xml_ns = simplexml_load_file($extractedFile);

                                // Namespace definitions
                                $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                                $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                                // Register namespaces
                                $xml_ns->registerXPathNamespace('ns4', $ns4);
                                $xml_ns->registerXPathNamespace('ns3', $ns3);
                                // Querying XML
                                foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                                {
                                    $codigocdr  = $ResponseCodes->ResponseCode;
                                }
                                foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                                {
                                    $respuestacdr  = $Description->Description;
                                }
                                foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                                {
                                    $factura_cdr_id  = $ID->ID;
                                    if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                        $sw = 1;
                                    }
                                }
                            }
                        } 

                    }else{
                        $sw = 1;
                    }

                }else{
                        $sw = 1;
                }

                //LECTURA A SUNAT
                $token = '';
                $estadoCp = '';
                $swlectur = 0;
                if($prefijocarperta =='II'){
                    $token           =      $this->generartoken_ii();
                }else{
                    $token           =      $this->generartoken_is();
                }


                $rh              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLEod)
                                            ->where('COD_ESTADO','=',1)
                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                            ->get();

                if(count($rh)<=0){
                    //FACTURA
                    $rvalidar = $this->validar_xml( $token,
                                                    $item->ID_CLIENTE,
                                                    $item->RUC_PROVEEDOR,
                                                    $item->ID_TIPO_DOC,
                                                    $item->SERIE,
                                                    $item->NUMERO,
                                                    $fechaemision,
                                                    $item->TOTAL_VENTA_ORIG);
                }else{
                    //RECIBO POR HONORARIO
                    $rvalidar = $this->validar_xml( $token,
                                                    $item->ID_CLIENTE,
                                                    $item->RUC_PROVEEDOR,
                                                    $item->ID_TIPO_DOC,
                                                    $item->SERIE,
                                                    $item->NUMERO,
                                                    $fechaemision,
                                                    $item->TOTAL_VENTA_ORIG+$item->MONTO_RETENCION);
                }


                $arvalidar = json_decode($rvalidar, true);
                if(isset($arvalidar['success'])){

                    if($arvalidar['success']){




                        $datares              = $arvalidar['data'];
                        if (!isset($datares['estadoCp'])){
                            return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                        }
                        
                        $estadoCp             = $datares['estadoCp'];
                        $tablaestacp          = Estado::where('tipo','=','estadoCp')->where('codigo','=',$estadoCp)->first();

                        $estadoRuc            = '';
                        $txtestadoRuc         = '';
                        $estadoDomiRuc        = '';
                        $txtestadoDomiRuc     = '';

                        if(isset($datares['estadoRuc'])){
                            $tablaestaruc          = Estado::where('tipo','=','estadoRuc')->where('codigo','=',$datares['estadoRuc'])->first();
                            $estadoRuc             = $tablaestaruc->codigo;
                            $txtestadoRuc          = $tablaestaruc->nombre;
                        }
                        if(isset($datares['condDomiRuc'])){
                            $tablaestaDomiRuc       = Estado::where('tipo','=','condDomiRuc')->where('codigo','=',$datares['condDomiRuc'])->first();
                            $estadoDomiRuc          = $tablaestaDomiRuc->codigo;
                            $txtestadoDomiRuc       = $tablaestaDomiRuc->nombre;
                        }

                        FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                    ->update(
                                            [
                                                'success'=>$arvalidar['success'],
                                                'message'=>$arvalidar['message'],
                                                'estadoCp'=>$tablaestacp->codigo,
                                                'nestadoCp'=>$tablaestacp->nombre,
                                                'estadoRuc'=>$estadoRuc,
                                                'nestadoRuc'=>$txtestadoRuc,
                                                'condDomiRuc'=>$estadoDomiRuc,
                                                'ncondDomiRuc'=>$txtestadoDomiRuc,
                                            ]);
                        $swlectur = 1;
                    }else{
                        FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                    ->update(
                                            [
                                                'success'=>$arvalidar['success'],
                                                'message'=>$arvalidar['message']
                                            ]);
                    }
                }
                //PASAR PARA EL USUARIO DE CONTACTO REALIZE SU APLICACION
                //el cdr es el de la factura

                if($sw==1 and $swlectur==1){
                    FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000002',
                                        'TXT_ESTADO'=>'POR APROBAR USUARIO CONTACTO',
                                        'CODIGO_CDR'=>$codigocdr,
                                        'RESPUESTA_CDR'=>$respuestacdr
                                    ]
                                );
                }
        }

        print_r('Exitoso '. $COD_ORDEN_COMPRA);

    }




	private function con_lista_cabecera_comprobante_provisionar($cliente_id) {

		$listadatos 	= 	VMergeOC::leftJoin('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
							->whereIn('COD_ESTADO', ['ETM0000000000005'])
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
							->select(DB::raw('	COD_ORDEN,
												FEC_ORDEN,
												TXT_CATEGORIA_MONEDA,
												TXT_EMPR_CLIENTE,
												MAX(CAN_TOTAL) CAN_TOTAL,
												MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
												MAX(COD_ESTADO) AS COD_ESTADO,
												MAX(TXT_ESTADO) AS TXT_ESTADO
											'))
							->groupBy('COD_ORDEN')
							->groupBy('FEC_ORDEN')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('TXT_EMPR_CLIENTE')
							->get();

	 	return  $listadatos;
	}


	private function con_lista_cabecera_comprobante_total_uc($cliente_id) {

		//HACER UNA UNION DE TODAS LOS ID DE TRABAJADORES QUE TIENE ESTE USUARIO
		$trabajador 		 = 		STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();

		$array_trabajadores  =		STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
									->pluck('COD_TRAB')
									->toArray();
	
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =       FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                        //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                        //->whereIn('FE_DOCUMENTO.COD_CONTACTO',$array_trabajadores)
                                        //->where('TXT_PROCEDENCIA','<>','SUE')
                                        ->where('OPERACION','=','ORDEN_COMPRA')
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000002','ETM0000000000007'])
                                        //->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000002')
                                        ->get();

        }else{

            $listadatos         =       FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                        //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                        ->whereIn('FE_DOCUMENTO.COD_CONTACTO',$array_trabajadores)
                                        //->where('TXT_PROCEDENCIA','<>','SUE')
                                        ->where('OPERACION','=','ORDEN_COMPRA')
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000002','ETM0000000000007'])
                                        //->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000002')
                                        ->get();

        }




	 	return  $listadatos;
	}


    private function con_lista_cabecera_comprobante_total_contrato_uc($cliente_id) {


        //HACER UNA UNION DE TODAS LOS ID DE TRABAJADORES QUE TIENE ESTE USUARIO
        $trabajador             =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();

        $centro_id              =       $trabajador->COD_ZONA_TIPO;

        $array_trabajadores     =      STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                        ->pluck('COD_TRAB')
                                        ->toArray();
    
        $listadatos             =       FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                        //->whereIn('FE_DOCUMENTO.COD_CONTACTO',$array_trabajadores)
                                        ->where('OPERACION','=','CONTRATO')
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000002','ETM0000000000007'])
                                        ->get();

        return  $listadatos;
    }


	private function con_lista_cabecera_comprobante_total_cont($cliente_id) {

		$listadatos 	= 	FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->leftJoin('CMP.CATEGORIA as PAGO', 'PAGO.COD_CATEGORIA', '=', 'CMP.Orden.COD_CATEGORIA_TIPO_PAGO')
							//->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
							->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC,PAGO.NOM_CATEGORIA COND_PAGO'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })
                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orwhere('area_observacion', '=', 'UCO')
                                      ->orWhereNull('area_observacion');
                            })
                     		->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
							->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')
							->get();

	 	return  $listadatos;
	}


    private function con_lista_cabecera_comprobante_total_cont_obs_levantadas($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->leftJoin('CMP.CATEGORIA as PAGO', 'PAGO.COD_CATEGORIA', '=', 'CMP.Orden.COD_CATEGORIA_TIPO_PAGO')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC,PAGO.NOM_CATEGORIA COND_PAGO'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','CONT')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_cont_obs($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->leftJoin('CMP.CATEGORIA as PAGO', 'PAGO.COD_CATEGORIA', '=', 'CMP.Orden.COD_CATEGORIA_TIPO_PAGO')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC,PAGO.NOM_CATEGORIA COND_PAGO'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('ind_observacion','=',1)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')
                            ->get();

        return  $listadatos;
    }



    private function con_lista_cabecera_comprobante_total_cont_estiba($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC'))
                            ->where('OPERACION','=',$operacion_id)
                            //->where('FE_DOCUMENTO.ID_DOCUMENTO','=','00000004')
                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })
                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orwhere('area_observacion', '=', 'UCO')
                                      ->orWhereNull('area_observacion');
                            })
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')

                            ->get();

        return  $listadatos;
    }

    private function con_lista_cabecera_comprobante_total_cont_contrato($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC'))
                            ->where('OPERACION','=','CONTRATO')

                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })
                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orwhere('area_observacion', '=', 'UCO')
                                      ->orWhereNull('area_observacion');
                            })
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')

                            ->get();

        return  $listadatos;
    }
    private function con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC'))
                            ->where('OPERACION','=',$operacion_id)
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','CONT')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')

                            ->get();

        return  $listadatos;
    }
    private function con_lista_cabecera_comprobante_total_cont_contrato_levantadas($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','CONT')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')

                            ->get();

        return  $listadatos;
    }
    private function con_lista_cabecera_comprobante_total_cont_estiba_obs($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC'))
                            ->where('OPERACION','=',$operacion_id)
                             ->where('ind_observacion','=',1)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')

                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_cont_contrato_obs($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC'))
                            ->where('OPERACION','=','CONTRATO')
                             ->where('ind_observacion','=',1)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')

                            ->get();

        return  $listadatos;
    }
    private function con_lista_cabecera_comprobante_total_adm_contrato_obs_levantadas($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','ADM')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')
                            ->get();

        return  $listadatos;
    }

    private function con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=',$operacion_id)
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','ADM')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('ind_observacion','asc')
                            ->orderBy('fecha_uc','asc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_tes_contrato($cliente_id,$proveedor_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->leftJoin('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->whereNull('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->select(DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->ProveedorFE($proveedor_id)
                            //->where('TXT_PROCEDENCIA','<>','SUE')
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000005')
                            ->orderBy('fecha_uc','desc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_tes_contrato_pagado($cliente_id,$proveedor_id,$fecha_inicio,$fecha_fin) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->select(DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->ProveedorFE($proveedor_id)
                            ->Fecha('RE',$fecha_inicio,$fecha_fin)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000008')
                            ->orderBy('fecha_uc','desc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_tes($cliente_id,$proveedor_id) {

        $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->leftJoin('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->select(DB::raw('FE_DOCUMENTO.*,CMP.Orden.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->whereNull('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000005')
                            ->ProveedorFE($proveedor_id)
                            ->orderBy('fecha_uc','desc')
                            ->get();

        return  $listadatos;
    }

    private function con_lista_cabecera_comprobante_total_tes_pagado($cliente_id,$proveedor_id,$fecha_inicio,$fecha_fin) {

        $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->Join('ARCHIVOS', 'ARCHIVOS.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                            ->select(DB::raw('FE_DOCUMENTO.*,CMP.Orden.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('ARCHIVOS.TIPO_ARCHIVO','=','DCC0000000000028')
                            ->where('ARCHIVOS.ACTIVO','=','1')
                            ->where('ARCHIVOS.USUARIO_CREA','<>','1CIX00000001')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000008')
                            ->Fecha('RE',$fecha_inicio,$fecha_fin)
                            ->ProveedorFE($proveedor_id)
                            ->orderBy('fecha_uc','desc')
                            ->get();

        return  $listadatos;
    }



    private function con_lista_cabecera_comprobante_total_tes_sp($cliente_id,$proveedor_id) {

        $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->Join('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->select(DB::raw('FE_DOCUMENTO.*,CMP.Orden.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000005')
                            ->ProveedorFE($proveedor_id)
                            ->orderBy('fecha_uc','desc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_tes_contrato_sp($cliente_id,$proveedor_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->leftJoin('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->select(DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            //->where('TXT_PROCEDENCIA','<>','SUE')
                            ->ProveedorFE($proveedor_id)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000005')
                            ->orderBy('fecha_uc','desc')
                            ->get();

        return  $listadatos;
    }



	private function con_lista_cabecera_comprobante_total_adm_obs($cliente_id) {

		$listadatos 	= 	FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
							//->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
							->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
							->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
							->where('ind_observacion','=',1)
							->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
							->get();

	 	return  $listadatos;
	}


    private function con_lista_cabecera_comprobante_total_adm_obs_levantadas($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','ADM')
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_adm($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })
                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orWhereNull('area_observacion')
                                      ->orWhereIn('area_observacion',['CONT','UCO']);
                            })
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
                            ->get();

        return  $listadatos;
    }



    private function con_lista_cabecera_comprobante_total_adm_contrato($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')

                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')

                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,deuda.CAN_DEUDA AS CAN_DEUDA'))

                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })

                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orWhereNull('area_observacion')
                                      ->orWhereIn('area_observacion',['CONT','UCO']);
                            })

                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
                            ->get();

        return  $listadatos;
    }

    private function con_lista_cabecera_comprobante_total_adm_estiba($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=',$operacion_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })
                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orWhereNull('area_observacion')
                                      ->orWhereIn('area_observacion',['CONT','UCO']);
                            })
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_adm_contrato_obs($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')

                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')

                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('ind_observacion','=',1)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
                            ->get();

        return  $listadatos;
    }
    private function con_lista_cabecera_comprobante_total_adm_estiba_obs($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')

                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')

                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=',$operacion_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('ind_observacion','=',1)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
                            ->get();

        return  $listadatos;
    }

    private function array_usuario_jefes() {
        $array = ['1CIX00000072','1CIX00000075','1CIX00000073','1CIX00000188','1CIX00000217'];
        return $array;
    }

    private function array_usuario_jefes_folio() {
        $array = ['1CIX00000072','1CIX00000075','1CIX00000073','1CIX00000188'];
        return $array;
    }

    private function con_lista_cabecera_comprobante_total_gestion($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id) {


        $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        $trabajador             =   STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores     =      STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                        ->pluck('COD_TRAB')
                                        ->toArray();
        $array_usuarios         =   SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                        ->pluck('COD_USUARIO')
                                        ->toArray();

        $usuario_id             =   Session::get('usuario')->id;
        $array_jefes            =   $this->array_usuario_jefes();

        if($rol->ind_uc == 1 && !in_array($usuario_id, $array_jefes)){


            $listadatos     =   FeDocumento::join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.Orden.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->Fecha($filtrofecha_id,$fecha_inicio,$fecha_fin)
                                //->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])

                                //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','ORDEN_COMPRA')
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->whereIn('CMP.Orden.COD_USUARIO_CREA_AUD',$array_usuarios)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,CMP.CATEGORIA.NOM_CATEGORIA AS AREA,FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_UC'))
                                ->orderBy('fecha_uc','asc')
                                ->get();


        }else{

            $listadatos     =   FeDocumento::join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.Orden.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')
                                //->where('FE_DOCUMENTO.ID_DOCUMENTO','=','IICHCL0000009227')
                                ->Fecha($filtrofecha_id,$fecha_inicio,$fecha_fin)

                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','ORDEN_COMPRA')
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,CMP.CATEGORIA.NOM_CATEGORIA AS AREA,FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_UC'))
                                ->orderBy('fecha_uc','asc')
                                ->get();

        }



        return  $listadatos;
    }

    private function con_lista_cabecera_comprobante_total_gestion_tesoreria_excel($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id) {


        $listadatos             =       FeDocumento::whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('OPERACION','=','ORDEN_COMPRA')
                                        ->ProveedorFE($proveedor_id)
                                        ->EstadoFE($estado_id)
                                        ->where('OPERACION','=',$operacion_id)
                                        ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                        ->orderBy('FEC_VENTA','asc')
                                        ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_gestion_estiba_excel($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$operacion_id) {

        $rol                    =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
        $trabajador             =       STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores     =       STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                        ->pluck('COD_TRAB')
                                        ->toArray();
        $array_usuarios         =       SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                        ->pluck('COD_USUARIO')
                                        ->toArray();

        if($rol->ind_uc == 1){


                    $sql = "
                        SELECT 
                            FE_DOCUMENTO.*, 
                            CMP.DOCUMENTO_CTBLE.*,
                            FE_DETALLE_DOCUMENTO.*,
                            FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_FE, 
                            CMP.DOCUMENTO_CTBLE.TXT_GLOSA AS TXT_GLOSA_ORDEN,
                            FE_DOCUMENTO.TXT_REPARABLE AS TXT_REPARABLE_SN, 
                            FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_N,
                            CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                            (
                                SELECT STUFF(
                                    (
                                        SELECT '// ' + d2_interno.TXT_NOMBRE_PRODUCTO
                                        FROM CMP.DETALLE_PRODUCTO d2_interno
                                        WHERE d2_interno.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO
                                        FOR XML PATH('')
                                    ), 1, 2, ''
                                )
                            ) AS productos_cabecera2,
                            (
                                SELECT STUFF(
                                    (
                                        SELECT '// ' + d2_interno.MENSAJE
                                        FROM FE_DOCUMENTO_HISTORIAL d2_interno
                                        WHERE d2_interno.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                                          AND FE_DOCUMENTO.IND_REPARABLE = 1
                                          AND TIPO LIKE 'DOCUMENTO ARCHIVO_%' 
                                        FOR XML PATH('')
                                    ), 1, 2, ''
                                )
                            ) AS productos_reparable
                        FROM FE_DOCUMENTO
                        CROSS APPLY (
                            SELECT TOP 1 * 
                            FROM FE_REF_ASOC 
                            WHERE LOTE = FE_DOCUMENTO.ID_DOCUMENTO 
                            ORDER BY FE_REF_ASOC.ID_DOCUMENTO
                        ) AS D
                        INNER JOIN CMP.DOCUMENTO_CTBLE ON D.ID_DOCUMENTO = CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE
                        INNER JOIN FE_DETALLE_DOCUMENTO ON FE_DETALLE_DOCUMENTO.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                        LEFT JOIN SGD.USUARIO ON SGD.USUARIO.COD_USUARIO = CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD
                        LEFT JOIN CMP.CATEGORIA ON CMP.CATEGORIA.COD_CATEGORIA = SGD.USUARIO.COD_CATEGORIA_AREA
                        WHERE CAST(fecha_pa AS DATE) >= ? 
                          AND CAST(fecha_pa AS DATE) <= ?
                          AND FE_DOCUMENTO.COD_EMPR = ?
                          AND FE_DOCUMENTO.OPERACION = ?
                          AND FE_DOCUMENTO.COD_ESTADO <> ''
                        ORDER BY FEC_VENTA ASC
                    ";

                    $listadatos = DB::select($sql, [
                        $fecha_inicio,
                        $fecha_fin,
                        Session::get('empresas')->COD_EMPR,
                        $operacion_id
                    ]);

        }else{


                $sql = "
                    SELECT 
                        FE_DOCUMENTO.*, 
                        CMP.DOCUMENTO_CTBLE.*,
                        FE_DETALLE_DOCUMENTO.*,
                        FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_FE, 
                        CMP.DOCUMENTO_CTBLE.TXT_GLOSA AS TXT_GLOSA_ORDEN,
                        FE_DOCUMENTO.TXT_REPARABLE AS TXT_REPARABLE_SN, 
                        FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_N,
                        CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                        (
                            SELECT STUFF(
                                (
                                    SELECT '// ' + d2_interno.TXT_NOMBRE_PRODUCTO
                                    FROM CMP.DETALLE_PRODUCTO d2_interno
                                    WHERE d2_interno.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO
                                    FOR XML PATH('')
                                ), 1, 2, ''
                            )
                        ) AS productos_cabecera2,
                        (
                            SELECT STUFF(
                                (
                                    SELECT '// ' + d2_interno.MENSAJE
                                    FROM FE_DOCUMENTO_HISTORIAL d2_interno
                                    WHERE d2_interno.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                                      AND FE_DOCUMENTO.IND_REPARABLE = 1
                                      AND TIPO LIKE 'DOCUMENTO ARCHIVO_%' 
                                    FOR XML PATH('')
                                ), 1, 2, ''
                            )
                        ) AS productos_reparable
                    FROM FE_DOCUMENTO
                    CROSS APPLY (
                        SELECT TOP 1 * 
                        FROM FE_REF_ASOC 
                        WHERE LOTE = FE_DOCUMENTO.ID_DOCUMENTO 
                        ORDER BY FE_REF_ASOC.ID_DOCUMENTO
                    ) AS D
                    INNER JOIN CMP.DOCUMENTO_CTBLE ON D.ID_DOCUMENTO = CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE
                    INNER JOIN FE_DETALLE_DOCUMENTO ON FE_DETALLE_DOCUMENTO.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                    LEFT JOIN SGD.USUARIO ON SGD.USUARIO.COD_USUARIO = CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD
                    LEFT JOIN CMP.CATEGORIA ON CMP.CATEGORIA.COD_CATEGORIA = SGD.USUARIO.COD_CATEGORIA_AREA
                    WHERE CAST(fecha_pa AS DATE) >= ? 
                      AND CAST(fecha_pa AS DATE) <= ?
                      AND FE_DOCUMENTO.COD_EMPR = ?
                      AND FE_DOCUMENTO.OPERACION = ?
                      AND FE_DOCUMENTO.COD_ESTADO <> ''
                    ORDER BY FEC_VENTA ASC
                ";

                $listadatos = DB::select($sql, [
                    $fecha_inicio,
                    $fecha_fin,
                    Session::get('empresas')->COD_EMPR,
                    $operacion_id
                ]);
                //dd($listadatos);

        }



        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_gestion_excel($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id) {

        $rol                    =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
        $trabajador             =       STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores     =       STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                        ->pluck('COD_TRAB')
                                        ->toArray();
        $array_usuarios         =       SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                        ->pluck('COD_USUARIO')
                                        ->toArray();

        if($rol->ind_uc == 1){


            $listadatos     =   FeDocumento::join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                ->join('FE_DETALLE_DOCUMENTO', 'FE_DETALLE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.Orden.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')
                                ->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','ORDEN_COMPRA')
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->whereIn('CMP.Orden.COD_USUARIO_CREA_AUD',$array_usuarios)

                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw("
                                    FE_DOCUMENTO.*, 
                                    CMP.ORDEN.*,
                                    FE_DETALLE_DOCUMENTO.*,

                                    FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_FE, 
                                    CMP.Orden.TXT_GLOSA AS TXT_GLOSA_ORDEN,
                                    FE_DOCUMENTO.TXT_REPARABLE AS TXT_REPARABLE_SN, 
                                    FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_N,

                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                                    (
                                        SELECT STUFF(
                                            (
                                                SELECT '// ' + d2_interno.TXT_NOMBRE_PRODUCTO
                                                FROM CMP.DETALLE_PRODUCTO d2_interno
                                                WHERE d2_interno.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO
                                                FOR XML PATH('')
                                            ), 1, 2, ''
                                        )
                                    ) AS productos_cabecera2,

                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                                    (
                                        SELECT STUFF(
                                            (
                                                SELECT '// ' + d2_interno.MENSAJE
                                                FROM FE_DOCUMENTO_HISTORIAL d2_interno
                                                WHERE d2_interno.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                                                AND FE_DOCUMENTO.IND_REPARABLE = 1
                                                AND TIPO LIKE 'DOCUMENTO ARCHIVO_%' 
                                                FOR XML PATH('')
                                            ), 1, 2, ''
                                        )
                                    ) AS productos_reparable

                                "))
                                ->orderBy('FEC_VENTA','asc')
                                ->get();


        }else{

            $listadatos     =   FeDocumento::join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                ->leftjoin('FE_DETALLE_DOCUMENTO', 'FE_DETALLE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.Orden.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')
                                ->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','ORDEN_COMPRA')
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                //->where('FE_DOCUMENTO.ID_DOCUMENTO','=','IICHCL0000010224')
                                ->select(DB::raw("
                                    FE_DOCUMENTO.*, 
                                    CMP.ORDEN.*,
                                    FE_DETALLE_DOCUMENTO.*,
                                    FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_FE, 
                                    CMP.Orden.TXT_GLOSA AS TXT_GLOSA_ORDEN,
                                    FE_DOCUMENTO.TXT_REPARABLE AS TXT_REPARABLE_SN, 
                                    FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_N,
                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                                    (
                                        SELECT STUFF(
                                            (
                                                SELECT '// ' + d2_interno.TXT_NOMBRE_PRODUCTO
                                                FROM CMP.DETALLE_PRODUCTO d2_interno
                                                WHERE d2_interno.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO
                                                FOR XML PATH('')
                                            ), 1, 2, ''
                                        )
                                    ) AS productos_cabecera2,

                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                                    (
                                        SELECT STUFF(
                                            (
                                                SELECT '// ' + d2_interno.MENSAJE
                                                FROM FE_DOCUMENTO_HISTORIAL d2_interno
                                                WHERE d2_interno.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                                                AND FE_DOCUMENTO.IND_REPARABLE = 1
                                                AND TIPO LIKE 'DOCUMENTO ARCHIVO_%'
                                                FOR XML PATH('')
                                            ), 1, 2, ''
                                        )
                                    ) AS productos_reparable

                                "))
                                ->orderBy('FEC_VENTA','asc')
                                ->get();


            //dd($listadatos);


        }



        return  $listadatos;
    }

    private function con_lista_cabecera_comprobante_total_gestion_contrato_excel($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id) {


        $trabajador     =       STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id      =       $trabajador->COD_ZONA_TIPO;
        $rol            =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();


        if($rol->ind_uc == 1 && Session::get('usuario')->id != '1CIX00000142'){


            $listadatos     =   FeDocumento::join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                ->join('FE_DETALLE_DOCUMENTO', 'FE_DETALLE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                ->join('ALM.CENTRO', 'ALM.CENTRO.COD_CENTRO', '=', 'CMP.DOCUMENTO_CTBLE.COD_CENTRO')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')
                                ->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','CONTRATO')
                                ->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)

                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw("
                                    FE_DOCUMENTO.*, 
                                    CMP.DOCUMENTO_CTBLE.*, 
                                    FE_DETALLE_DOCUMENTO.*, 
                                    FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_FE, 
                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA,
                                    FE_DOCUMENTO.TXT_REPARABLE AS TXT_REPARABLE_SN, 
                                    FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_N,


                                    (
                                        SELECT STUFF((
                                            SELECT '// ' + DOC_INTERNO.NRO_SERIE + '-' + DOC_INTERNO.NRO_DOC + ' ' + DOC_INTERNO.TXT_CATEGORIA_MOTIVO_TRASLADO
                                            FROM CMP.REFERENCIA_ASOC AS REF_INTERNO
                                            INNER JOIN CMP.DOCUMENTO_CTBLE AS DOC_INTERNO ON REF_INTERNO.COD_TABLA_ASOC = DOC_INTERNO.COD_DOCUMENTO_CTBLE
                                            WHERE REF_INTERNO.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO
                                            AND DOC_INTERNO.COD_CATEGORIA_TIPO_DOC = 'TDO0000000000009'
                                            FOR XML PATH('')
                                        ), 1, 2, '')
                                    ) AS productos_cabecera2,

                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                                    (
                                        SELECT STUFF(
                                            (
                                                SELECT '// ' + d2_interno.MENSAJE
                                                FROM FE_DOCUMENTO_HISTORIAL d2_interno
                                                WHERE d2_interno.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                                                AND FE_DOCUMENTO.IND_REPARABLE = 1
                                                AND TIPO LIKE 'DOCUMENTO ARCHIVO_%'
                                                FOR XML PATH('')
                                            ), 1, 2, ''
                                        )
                                    ) AS productos_reparable





                                "))
                                ->orderBy('FEC_VENTA', 'desc')
                                ->get();


        }else{

            $listadatos     =   FeDocumento::join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                ->join('FE_DETALLE_DOCUMENTO', 'FE_DETALLE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_DOCUMENTO.ID_DOCUMENTO')
                                ->join('ALM.CENTRO', 'ALM.CENTRO.COD_CENTRO', '=', 'CMP.DOCUMENTO_CTBLE.COD_CENTRO')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')
                                ->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','CONTRATO')
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw("
                                    FE_DOCUMENTO.*, 
                                    CMP.DOCUMENTO_CTBLE.*, 
                                    FE_DETALLE_DOCUMENTO.*, 
                                    FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_FE, 
                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA,
                                    FE_DOCUMENTO.TXT_REPARABLE AS TXT_REPARABLE_SN, 
                                    FE_DOCUMENTO.TXT_CONTACTO AS TXT_CONTACTO_N,

                                    (
                                        SELECT STUFF((
                                            SELECT '// ' + DOC_INTERNO.NRO_SERIE + '-' + DOC_INTERNO.NRO_DOC + ' ' + DOC_INTERNO.TXT_CATEGORIA_MOTIVO_TRASLADO
                                            FROM CMP.REFERENCIA_ASOC AS REF_INTERNO
                                            INNER JOIN CMP.DOCUMENTO_CTBLE AS DOC_INTERNO ON REF_INTERNO.COD_TABLA_ASOC = DOC_INTERNO.COD_DOCUMENTO_CTBLE
                                            WHERE REF_INTERNO.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO
                                            AND DOC_INTERNO.COD_CATEGORIA_TIPO_DOC = 'TDO0000000000009'
                                            FOR XML PATH('')
                                        ), 1, 2, '')
                                    ) AS productos_cabecera2,
                                    CMP.CATEGORIA.NOM_CATEGORIA AS AREA, 
                                    (
                                        SELECT STUFF(
                                            (
                                                SELECT '// ' + d2_interno.MENSAJE
                                                FROM FE_DOCUMENTO_HISTORIAL d2_interno
                                                WHERE d2_interno.ID_DOCUMENTO = FE_DOCUMENTO.ID_DOCUMENTO
                                                AND FE_DOCUMENTO.IND_REPARABLE = 1
                                                AND TIPO LIKE 'DOCUMENTO ARCHIVO_%'
                                                FOR XML PATH('')
                                            ), 1, 2, ''
                                        )
                                    ) AS productos_reparable
                                    
                                "))
                                ->orderBy('FEC_VENTA', 'desc')
                                ->get();



        }





        return  $listadatos;


    }




    private function con_lista_cabecera_comprobante_total_gestion_contrato($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id) {


        $trabajador     =       STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id      =       $trabajador->COD_ZONA_TIPO;
        $rol            =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();


        if($rol->ind_uc == 1 && Session::get('usuario')->id != '1CIX00000142'){

            $listadatos     =   FeDocumento::join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                ->join('ALM.CENTRO', 'ALM.CENTRO.COD_CENTRO', '=', 'CMP.DOCUMENTO_CTBLE.COD_CENTRO')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')

                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                //->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->Fecha($filtrofecha_id,$fecha_inicio,$fecha_fin)
                                //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                ->where('OPERACION','=','CONTRATO')
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,CMP.CATEGORIA.NOM_CATEGORIA AS AREA'))
                                ->orderBy('fecha_pa', 'desc')
                                ->get();

        }else{

            $listadatos     =   FeDocumento::join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                ->join('ALM.CENTRO', 'ALM.CENTRO.COD_CENTRO', '=', 'CMP.DOCUMENTO_CTBLE.COD_CENTRO')
                                ->leftjoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'CMP.DOCUMENTO_CTBLE.COD_USUARIO_CREA_AUD')
                                ->leftjoin('CMP.CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'SGD.USUARIO.COD_CATEGORIA_AREA')

                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                //->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->Fecha($filtrofecha_id,$fecha_inicio,$fecha_fin)
                                //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                //->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                ->where('OPERACION','=','CONTRATO')
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,CMP.CATEGORIA.NOM_CATEGORIA AS AREA'))
                                ->orderBy('fecha_pa', 'desc')
                                ->get();
        }





        return  $listadatos;


    }


    private function con_lista_cabecera_comprobante_total_gestion_estiba($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id,$operacion_id) {


        $trabajador     =       STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id      =       $trabajador->COD_ZONA_TIPO;
        $rol            =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();


        if($rol->ind_uc == 1 && Session::get('usuario')->id != '1CIX00000142'){

            $listadatos     =   FeDocumento::Fecha($filtrofecha_id,$fecha_inicio,$fecha_fin)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=',$operacion_id)
                                ->where('usuario_pa','=',Session::get('usuario')->id)
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->orderBy('fecha_pa', 'desc')
                                ->get();

        }else{

            $listadatos     =   FeDocumento::Fecha($filtrofecha_id,$fecha_inicio,$fecha_fin)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=',$operacion_id)
                                ->ProveedorFE($proveedor_id)
                                ->EstadoFE($estado_id)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->orderBy('fecha_pa', 'desc')
                                ->get();
        }





        return  $listadatos;


    }




    private function con_lista_cabecera_comprobante_total_gestion_agrupado($cliente_id) {


        $listadatos     =   FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->select(DB::raw('TXT_ESTADO,COUNT(TXT_ESTADO) AS CANT'))
                            ->groupBy('TXT_ESTADO')
                            ->get();

        return  $listadatos;


    }

    private function con_lista_cabecera_comprobante_total_gestion_agrupado_con($cliente_id) {


        $listadatos     =   FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('OPERACION','=','CONTRATO')
                            ->select(DB::raw('TXT_ESTADO,COUNT(TXT_ESTADO) AS CANT'))
                            ->groupBy('TXT_ESTADO')
                            ->get();

        return  $listadatos;


    }


    private function gn_combo_proveedor_fe_documento_xestado($todo,$estado_id) {
            
        $array                      =   FeDocumento::where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                        ->select(DB::raw('RUC_PROVEEDOR,RZ_PROVEEDOR'))
                                        ->groupBy('RUC_PROVEEDOR')
                                        ->groupBy('RZ_PROVEEDOR')
                                        ->pluck('RZ_PROVEEDOR','RUC_PROVEEDOR')
                                        ->toArray();

        if($todo=='TODO'){
            $combo                  =   array($todo => $todo) + $array;
        }else{
            $combo                  =   $array;
        }
        return  $combo;                             
    }



    private function gn_combo_proveedor_fe_documento($todo) {
            
        $array                      =   FeDocumento::where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                        ->select(DB::raw('RUC_PROVEEDOR,RZ_PROVEEDOR'))
                                        ->groupBy('RUC_PROVEEDOR')
                                        ->groupBy('RZ_PROVEEDOR')
                                        ->pluck('RZ_PROVEEDOR','RUC_PROVEEDOR')
                                        ->toArray();


        if($todo=='TODO'){
            $combo                  =   array($todo => $todo) + $array;
        }else{
            $combo                  =   $array;
        }
        return  $combo;                             
    }


    private function gn_combo_estado_fe_documento($todo) {

		$array 							= 	DB::table('CMP.CATEGORIA')
        									->where('COD_ESTADO','=',1)
        									->where('TXT_GRUPO','=','ESTADO_MERGE')
		        							->pluck('NOM_CATEGORIA','COD_CATEGORIA')
											->toArray();
		if($todo=='TODO'){
			$combo  				= 	array($todo => $todo) + $array;
		}else{
			$combo  				= 	$array;
		}
	 	return  $combo;	                   
    }


    private function gn_combo_area_usuario($todo) {

        $array                          =   DB::table('CMP.CATEGORIA')
                                            ->where('COD_ESTADO','=',1)
                                            ->where('TXT_GRUPO','=','AREA_EMPRESA')
                                            ->pluck('NOM_CATEGORIA','COD_CATEGORIA')
                                            ->toArray();
        if($todo=='TODO'){
            $combo                  =   array($todo => $todo) + $array;
        }else{
            $combo                  =   $array;
        }
        return  $combo;                    
    }

    private function gn_combo_empresa($todo) {

        $array                          =   DB::table('STD.EMPRESA')
                                            ->whereIn('COD_EMPR',['IACHEM0000010394','IACHEM0000007086'])
                                            ->pluck('NOM_EMPR','COD_EMPR')
                                            ->toArray();
        if($todo=='TODO'){
            $combo                  =   array($todo => $todo) + $array;
        }else{
            $combo                  =   $array;
        }
        return  $combo;                    
    }

    private function gn_combo_empresa_empresa($empresa_id) {

        $array                          =   DB::table('STD.EMPRESA')
                                            ->whereIn('COD_EMPR',[$empresa_id])
                                            ->pluck('NOM_EMPR','COD_EMPR')
                                            ->toArray();

        $combo                  =   $array;
 
        return  $combo;                    
    }


    private function gn_combo_centro_r($todo) {

        $array                          =   DB::table('ALM.CENTRO')
                                            ->whereIn('COD_CENTRO',['CEN0000000000001','CEN0000000000002','CEN0000000000004','CEN0000000000006'])
                                            ->pluck('NOM_CENTRO','COD_CENTRO')
                                            ->toArray();



        if($todo=='TODO'){
            $combo                  =   array($todo => $todo) + $array;
        }else{
            $combo                  =   $array;
        }
        return  $combo;                    
    }

    private function con_lista_cabecera_comprobante_total_gestion_observados_oc_proveedor($cliente_id) {

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->where('FE_DOCUMENTO.ind_observacion','=','1')
                                //->where('COD_EMPR_CLIENTE','=',$cliente_id)
                                ->where('FE_DOCUMENTO.area_observacion','=','UCO')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->get();

        }else{

            $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->where('FE_DOCUMENTO.ind_observacion','=','1')
                                ->where('COD_EMPR_CLIENTE','=',$cliente_id)
                                ->where('FE_DOCUMENTO.area_observacion','=','UCO')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->get();

        }



        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_gestion_reparable($cliente_id,$tipoarchivo_id,$estado_id) {


        $rol            =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
        if($rol->ind_uc == 1){

            $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                ->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->whereNotIn('FE_DOCUMENTO.COD_ESTADO',['','ETM0000000000006'])
                                ->TipoArchivo($tipoarchivo_id)
                                ->EstadoReparable($estado_id)
                                //->where('FE_DOCUMENTO.MODO_REPARABLE','=',$tipoarchivo_id)
                                //->where('FE_DOCUMENTO.IND_REPARABLE','=','1')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->orderBy('IND_OBSERVACION_REPARABLE','asc')
                                ->get();

        }else{

           
            $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                ->whereNotIn('FE_DOCUMENTO.COD_ESTADO',['','ETM0000000000006'])
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                //->where('FE_DOCUMENTO.IND_REPARABLE','=','1')
                                ->TipoArchivo($tipoarchivo_id)
                                ->EstadoReparable($estado_id)
                                //->where('FE_DOCUMENTO.MODO_REPARABLE','=',)
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->orderBy('IND_OBSERVACION_REPARABLE','asc')
                                ->get();

        }



        return  $listadatos;
    }
    private function con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cliente_id,$tipoarchivo_id,$estado_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id           =      $trabajador->COD_ZONA_TIPO;
        $rol                 =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        if($rol->ind_uc == 1){

            $listadatos          =      FeDocumento::Join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                        ->where('OPERACION','=','CONTRATO')
                                        ->whereNotIn('FE_DOCUMENTO.COD_ESTADO',['','ETM0000000000006'])
                                        //->where('FE_DOCUMENTO.IND_REPARABLE','=','1')
                                        ->TipoArchivo($tipoarchivo_id)
                                        ->EstadoReparable($estado_id)
                                        //->where('FE_DOCUMENTO.MODO_REPARABLE','=',$tipoarchivo_id)
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->orderBy('IND_OBSERVACION_REPARABLE','asc')
                                        ->get();

        }else{

            $listadatos          =      FeDocumento::Join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('OPERACION','=','CONTRATO')
                                        ->TipoArchivo($tipoarchivo_id)
                                        ->EstadoReparable($estado_id)
                                        //->where('FE_DOCUMENTO.MODO_REPARABLE','=',$tipoarchivo_id)
                                        ->whereNotIn('FE_DOCUMENTO.COD_ESTADO',['','ETM0000000000006'])
                                        //->where('FE_DOCUMENTO.IND_REPARABLE','=','1')
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->orderBy('IND_OBSERVACION_REPARABLE','asc')
                                        ->get();

        }


        return  $listadatos;
    }
    private function con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cliente_id,$tipoarchivo_id,$estado_id,$operacion_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id           =      $trabajador->COD_ZONA_TIPO;
        $rol                 =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        if($rol->ind_uc == 1){

            $listadatos          =      FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        //->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                        ->where('OPERACION','=',$operacion_id)
                                        ->whereNotIn('FE_DOCUMENTO.COD_ESTADO',['','ETM0000000000006'])
                                        //->where('FE_DOCUMENTO.IND_REPARABLE','=','1')
                                        ->TipoArchivo($tipoarchivo_id)
                                        ->EstadoReparable($estado_id)
                                        ->where('usuario_pa','=',Session::get('usuario')->id)
                                        //->where('FE_DOCUMENTO.MODO_REPARABLE','=',$tipoarchivo_id)
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->orderBy('IND_OBSERVACION_REPARABLE','asc')
                                        ->get();

        }else{

            $listadatos          =      FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('OPERACION','=',$operacion_id)
                                        ->TipoArchivo($tipoarchivo_id)
                                        ->EstadoReparable($estado_id)
                                        //->where('FE_DOCUMENTO.MODO_REPARABLE','=',$tipoarchivo_id)
                                        ->whereNotIn('FE_DOCUMENTO.COD_ESTADO',['','ETM0000000000006'])
                                        //->where('FE_DOCUMENTO.IND_REPARABLE','=','1')
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->orderBy('IND_OBSERVACION_REPARABLE','asc')
                                        ->get();

        }


        return  $listadatos;
    }


	private function con_lista_cabecera_comprobante_total_gestion_observados($cliente_id) {

        $rol            =       WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
        if($rol->ind_uc == 1){

        $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('FE_DOCUMENTO.ind_observacion','=','1')
                            ->where('FE_DOCUMENTO.area_observacion','<>','UCO')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->get();

        }else{

        $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('FE_DOCUMENTO.ind_observacion','=','1')
                            ->where('FE_DOCUMENTO.area_observacion','<>','UCO')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->get();
        }

        


	 	return  $listadatos;
	}

    private function con_lista_cabecera_comprobante_total_gestion_observados_estibas($cliente_id,$operacion_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id           =      $trabajador->COD_ZONA_TIPO;
        


        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos          =      FeDocumento::where('OPERACION','=',$operacion_id)
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        //->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                        ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                        ->where('FE_DOCUMENTO.area_observacion','<>','UCO')
                                        ->where('FE_DOCUMENTO.ind_observacion','=','1')
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->get();

        }else{

            $listadatos          =      FeDocumento::where('OPERACION','=',$operacion_id)
                                        ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('usuario_pa','=',Session::get('usuario')->id)
                                        ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                        ->where('FE_DOCUMENTO.area_observacion','<>','UCO')
                                        ->where('FE_DOCUMENTO.ind_observacion','=','1')
                                        ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                        ->get();

        }



        return  $listadatos;
    }



    private function con_lista_cabecera_comprobante_total_gestion_observados_contrato($cliente_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $centro_id           =      $trabajador->COD_ZONA_TIPO;
        $listadatos          =      FeDocumento::Join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                    ->where('OPERACION','=','CONTRATO')
                                    ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CENTRO','=',$centro_id)
                                    ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                    ->where('FE_DOCUMENTO.area_observacion','<>','UCO')
                                    ->where('FE_DOCUMENTO.ind_observacion','=','1')
                                    ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                    ->get();

        return  $listadatos;
    }



    private function con_lista_cabecera_comprobante_total_gestion_observados_contrato_proveedores($cliente_id) {

        $listadatos          =      FeDocumento::Join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                                    ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                    ->where('COD_EMPR_EMISOR','=',$cliente_id)
                                    ->where('FE_DOCUMENTO.area_observacion','=','UCO')
                                    ->where('FE_DOCUMENTO.ind_observacion','=','1')
                                    ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                    ->get();

        return  $listadatos;
    }

	private function con_lista_cabecera_comprobante_total_gestion_historial($cliente_id) {

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','ORDEN_COMPRA')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->orderBy('CMP.Orden.FEC_ORDEN','desc')
                                ->get();

        }else{

            $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                ->where('FE_DOCUMENTO.RUC_PROVEEDOR','=',$cliente_id)
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('OPERACION','=','ORDEN_COMPRA')
                                ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                                ->orderBy('CMP.Orden.FEC_ORDEN','desc')
                                ->get();

        } 








	 	return  $listadatos;
	}


    private function con_lista_cabecera_comprobante_total_gestion_historial_contrato($cliente_id) {


        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->where('FE_DOCUMENTO.RUC_PROVEEDOR','=',$cliente_id)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('OPERACION','=','CONTRATO')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->orderBy('CMP.DOCUMENTO_CTBLE.FEC_EMISION','desc')
                            ->get();

                            //dd($listadatos);

        return  $listadatos;
    }





	private function con_validar_documento($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento){

		$ind_ruc 			=	0;
		$ind_rz 			=	0;
		$ind_moneda 		=	0;
		$ind_total 			=	0;
		$ind_cantidaditem 	=	0;
		$ind_formapago 		=	0;
		$ind_errototal 		=	1;
		//ruc
		if($ordencompra->NRO_DOCUMENTO_CLIENTE == $fedocumento->RUC_PROVEEDOR){
			$ind_ruc 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }

		if(ltrim(rtrim(strtoupper($ordencompra->TXT_EMPR_CLIENTE))) == ltrim(rtrim(strtoupper($fedocumento->RZ_PROVEEDOR)))){
			$ind_rz 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }


		//moneda
		$txtmoneda 			=	'';
		if($fedocumento->MONEDA == 'PEN'){
			$txtmoneda 			=	'SOLES';	
		}else{
			$txtmoneda 			=	'DOLARES';
		}
		if($ordencompra->TXT_CATEGORIA_MONEDA == $txtmoneda){
			$ind_moneda 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }
		//total
		if(number_format($ordencompra->CAN_TOTAL, 4, '.', '') == number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', '')){
			$ind_total 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }


        $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();

		if($ordencompra_t->IND_MATERIAL_SERVICIO == 'S'){
			$ind_cantidaditem 			=	1;	
		}else{
			//numero_items
			if(count($detalleordencompra) == count($detallefedocumento)){
				$ind_cantidaditem 			=	1;	
			}else{ 	$ind_errototal 		=	0;  }

		}

		$tp = CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
		//print($tp->CODIGO_SUNAT);
		//dd(substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3));

		if($tp->CODIGO_SUNAT == substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3)){
			$ind_formapago 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }




		// if($tp->CODIGO_SUNAT == substr(strtoupper($fedocumento->FORMA_PAGO), 0, 3)){

		// 	if( $tp->CODIGO_SUNAT == 'CRE' ){
		// 		$ind_formapago 			=	1;	
		// 		$diasdeorden = $tp->COD_CTBLE;
		// 		if($fedocumento->FORMA_PAGO_DIAS != $diasdeorden){
		// 			$ind_formapago 			=	0;
		// 			$ind_errototal 			=	0; 
		// 		}
		// 	}
		// }else{ 	$ind_errototal 		=	0;  }


        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                    ->update(
                            [
                                'ind_ruc'=>$ind_ruc,
                                'ind_rz'=>$ind_rz,
                                
                                'ind_moneda'=>$ind_moneda,
                                'ind_total'=>$ind_total,
                                'ind_cantidaditem'=>$ind_cantidaditem,
                                'ind_formapago'=>$ind_formapago,
                                'ind_errototal'=>$ind_errototal,
                            ]);

	}

	private function con_validar_documento_proveedor($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento){

		$ind_ruc 			=	0;
		$ind_rz 			=	0;
		$ind_moneda 		=	0;
		$ind_total 			=	0;
		$ind_cantidaditem 	=	0;
		$ind_formapago 		=	0;
		$ind_errototal 		=	1;
        $ind_fecha          =   0;


        //validar orden de compra que sea mayor a un dia

        $fecha1 = Carbon::parse($ordencompra->FEC_ORDEN); // Primera fecha
        $fecha2 = Carbon::parse($fedocumento->FEC_VENTA); // Segunda fecha
        $diferenciaEnDias = $fecha1->diffInDays($fecha2);

        if($diferenciaEnDias==-1){
            $diferenciaEnDias = 0;
        }

        if($diferenciaEnDias>=0){
            $ind_fecha             =   1;  
        }else{  $ind_errototal      =   0;  }

		//ruc
		if($ordencompra->NRO_DOCUMENTO_CLIENTE == $fedocumento->RUC_PROVEEDOR){
			$ind_ruc 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }

        $fe_rz =str_replace('  ', ' ', $fedocumento->RZ_PROVEEDOR);
		if(ltrim(rtrim(strtoupper($ordencompra->TXT_EMPR_CLIENTE))) == ltrim(rtrim(strtoupper($fe_rz)))){
			$ind_rz 			=	1;	
		}//else{ 	$ind_errototal 		=	0;  }

		//moneda
		$txtmoneda 			=	'';
		if($fedocumento->MONEDA == 'PEN'){
			$txtmoneda 			=	'SOLES';	
		}else{
			$txtmoneda 			=	'DOLARES';
		}
		if($ordencompra->TXT_CATEGORIA_MONEDA == $txtmoneda){
			$ind_moneda 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }
		//total
        $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();


        $total_1 = $ordencompra->CAN_TOTAL-$ordencompra_t->CAN_RETENCION+$ordencompra_t->CAN_PERCEPCION-$ordencompra_t->CAN_IMPUESTO_RENTA;
        $total_2 = $fedocumento->TOTAL_VENTA_ORIG+$ordencompra_t->CAN_PERCEPCION-$ordencompra_t->CAN_RETENCION;//+$fedocumento->PERCEPCION+$fedocumento->MONTO_RETENCION;
        $tt_totales = round(abs($total_1 - $total_2), 2);


        // print_r($total_1.'-');
        // print_r($total_2);
        // dd($tt_totales);


        $diferencia_total = 0;
        //0.02
		if($tt_totales <= 0.04){
			$ind_total 			=	1;
            $diferencia_total = round($total_1 - $total_2,2);
		}else{ 	$ind_errototal 		=	0;  }


        //dd($fe_rz);

        // if($fedocumento->RUC_PROVEEDOR == '20100007348'){
        //     $ind_total          =   1; 
        //     $ind_errototal      =   1;
        // }


		if($ordencompra_t->IND_MATERIAL_SERVICIO == 'S'){
			$ind_cantidaditem 			=	1;	
		}else{

            if($ordencompra_t->TXT_CONFORMIDAD != ''){
                $ind_cantidaditem           =   1;  
            }else{
                //numero_items
                if(count($detalleordencompra) == count($detallefedocumento)){
                    $ind_cantidaditem           =   1;  
                }else{  $ind_errototal      =   0;  }

            }

		}

		$tp = CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
		if($tp->CODIGO_SUNAT == substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3)){
			$ind_formapago 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }

        //dd($ind_formapago);

        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                    ->update(
                            [
                                'ind_ruc'=>$ind_ruc,
                                'ind_rz'=>$ind_rz,
                                'ind_fecha'=>$ind_fecha,                         
                                'ind_moneda'=>$ind_moneda,
                                'ind_total'=>$ind_total,
                                'ind_cantidaditem'=>$ind_cantidaditem,
                                'ind_formapago'=>$ind_formapago,
                                'ind_errototal'=>$ind_errototal,
                                'CAN_CENTIMO'=>$diferencia_total,
                            ]);

	}


    private function con_validar_documento_proveedor_contrato($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento){

        $ind_ruc            =   0;
        $ind_rz             =   0;
        $ind_moneda         =   0;
        $ind_total          =   0;
        $ind_cantidaditem   =   0;
        $ind_formapago      =   0;
        $ind_errototal      =   1;
        //ruc
        if($ordencompra->NRO_DOCUMENTO_CLIENTE == $fedocumento->RUC_PROVEEDOR){
            $ind_ruc            =   1;  
        }else{  $ind_errototal      =   0;  }

        if(ltrim(rtrim(strtoupper($ordencompra->TXT_EMPR_EMISOR))) == ltrim(rtrim(strtoupper($fedocumento->RZ_PROVEEDOR)))){
            $ind_rz             =   1;  
        }//else{  $ind_errototal      =   0;  }


        //moneda
        $txtmoneda          =   '';
        if($fedocumento->MONEDA == 'PEN'){
            $txtmoneda          =   'SOLES';    
        }else{
            $txtmoneda          =   'DOLARES';
        }
        if($ordencompra->TXT_CATEGORIA_MONEDA == $txtmoneda){
            $ind_moneda             =   1;  
        }else{  $ind_errototal      =   0;  }
        //total



        $total_1 = $ordencompra->CAN_TOTAL;
        $total_2 = $fedocumento->TOTAL_VENTA_ORIG;
        $tt_totales = round(abs($total_1 - $total_2), 2);

        //dd($tt_totales);
        $diferencia_total = 0;
        //0.02
        if($tt_totales <= 0.04){
            $ind_total          =   1;  
            $diferencia_total = round($total_1 - $total_2,2);

        }else{  $ind_errototal      =   0;  }


        // if(number_format($ordencompra->CAN_TOTAL, 4, '.', '') == number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', '')){
        //     $ind_total          =   1;  
        // }else{  $ind_errototal      =   0;  }



        $ordencompra_t          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$ordencompra->COD_DOCUMENTO_CTBLE)->first();


        if($ordencompra_t->IND_MATERIAL_SERVICIO == 'S'){
            $ind_cantidaditem           =   1;  
        }else{
            //numero_items
            if(count($detalleordencompra) == count($detallefedocumento)){
                $ind_cantidaditem           =   1;  
            }else{  $ind_errototal      =   0;  }

        }

        $tp = CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        if($tp->CODIGO_SUNAT == substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3)){
            $ind_formapago          =   1;  
        }else{  $ind_errototal      =   0;  }



        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                    ->update(
                            [
                                'ind_ruc'=>$ind_ruc,
                                'ind_rz'=>$ind_rz,
                                
                                'ind_moneda'=>$ind_moneda,
                                'ind_total'=>$ind_total,
                                'ind_cantidaditem'=>$ind_cantidaditem,
                                'ind_formapago'=>$ind_formapago,
                                'ind_errototal'=>$ind_errototal,
                                'CAN_CENTIMO'=>$diferencia_total,

                            ]);

    }

    private function con_validar_documento_proveedor_estiba($documento_asociados,$documento_top,$fedocumento,$detallefedocumento,$idoc){

        $ind_ruc            =   0;
        $ind_rz             =   0;
        $ind_moneda         =   0;
        $ind_total          =   0;
        $ind_cantidaditem   =   0;
        $ind_formapago      =   0;
        $ind_errototal      =   1;
        //ruc
        $ind_ruc            =   1;  
        $ind_rz             =   1;  
        //moneda
        $txtmoneda          =   '';
        if($fedocumento->MONEDA == 'PEN'){
            $txtmoneda          =   'SOLES';    
        }else{
            $txtmoneda          =   'DOLARES';
        }
        if($documento_top->TXT_CATEGORIA_MONEDA == $txtmoneda){
            $ind_moneda             =   1;  
        }else{  $ind_errototal      =   0;  }
        $total_1 = $documento_asociados->sum('CAN_TOTAL');
        $total_2 = $fedocumento->TOTAL_VENTA_ORIG;
        $tt_totales = round(abs($total_1 - $total_2), 2);
        $diferencia_total = 0;

        //0.02
        if($tt_totales <= 0.04){
            $ind_total          =   1;  
            $diferencia_total = round($total_1 - $total_2,2);

        }else{  $ind_errototal      =   0;  }

        $ind_cantidaditem           =   1;
        $ind_formapago              =   1; 

        FeDocumento::where('ID_DOCUMENTO','=',$idoc)
                    ->update(
                            [
                                'ind_ruc'=>$ind_ruc,
                                'ind_rz'=>$ind_rz,
                                'ind_moneda'=>$ind_moneda,
                                'ind_total'=>$ind_total,
                                'ind_cantidaditem'=>$ind_cantidaditem,
                                'ind_formapago'=>$ind_formapago,
                                'ind_errototal'=>$ind_errototal,
                                'CAN_CENTIMO'=>$diferencia_total,

                            ]);

    }


    private function array_rol_contrato() {
        $array = ['1CIX00000003','1CIX00000008','1CIX00000005'];
        return $array;
    }

	private function con_lista_cabecera_comprobante($cliente_id) {

		$estado_no      =   'ETM0000000000006';

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos     =   VMergeOC:://leftJoin('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                //->where('COD_EMPR_CLIENTE','=',$cliente_id)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                //->where('VMERGEOC.COD_ORDEN','=','IICHCT0000002218')

                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(COD_ESTADO) AS COD_ESTADO,
                                                    MAX(TXT_ESTADO) AS TXT_ESTADO
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                //->havingRaw("MAX(COD_ESTADO) <> 'ETM0000000000006'")
                                ->get();


        }else{


            $listadatos     =   VMergeOC:://leftJoin('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                ->where('COD_EMPR_CLIENTE','=',$cliente_id)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                //->where('VMERGEOC.COD_ORDEN','=','IICHCT0000002218')

                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(COD_ESTADO) AS COD_ESTADO,
                                                    MAX(TXT_ESTADO) AS TXT_ESTADO
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                //->havingRaw("MAX(COD_ESTADO) <> 'ETM0000000000006'")
                                ->get();


        }




        //dd($listadatos);
	 	return  $listadatos;
	}




    private function con_lista_cabecera_comprobante_contrato($cliente_id) {

        $estado_no          =   'ETM0000000000006';

                                    
        $estado_no          =       'ETM0000000000006';
        $centro_id          =       'CEN0000000000001';
        $tipodoc_id         =       'TDO0000000000014';

        $listadatos         =       VMergeDocumento::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                            ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                    })
                                    ->where('COD_EMPR_EMISOR','=',$cliente_id)
                                    ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where(function ($query) {
                                        $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                              ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                              ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                    })
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->whereIn('COD_CENTRO',['CEN0000000000001','CEN0000000000002'])
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                        FEC_EMISION,
                                                        TXT_CATEGORIA_MONEDA,
                                                        TXT_EMPR_EMISOR,
                                                        COD_USUARIO_CREA_AUD,
                                                        CAN_TOTAL,
                                                        NRO_SERIE,
                                                        NRO_DOC,
                                                        
                                                        FE_DOCUMENTO.ID_DOCUMENTO,
                                                        FE_DOCUMENTO.COD_ESTADO,
                                                        FE_DOCUMENTO.TXT_ESTADO
                                                    '))
                                    ->get();

        //dd($listadatos);
        return  $listadatos;
    }







    private function con_lista_cabecera_comprobante_entregable_modal($folio) {


        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);


        $oi                     =   DB::table('CMP.ORDEN')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('REFERENCIA_ASOC.*'))
                                    ->whereIn('COD_CATEGORIA_TIPO_ORDEN', ['TOR0000000000002']);

        //dd($folio);

        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                    ->leftJoin(DB::raw("({$oi->toSql()}) as oi"), function ($join) use ($oi) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'oi.COD_TABLA')
                                                 ->addBinding($oi->getBindings());
                                        })
                                    ->where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005'])
                                    ->select(DB::raw('CMP.Orden.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC,oi.COD_TABLA_ASOC,
                                        FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER'))
                                    ->orderBy('documentos.FEC_VENCIMIENTO','asc')
                                    ->get();

        //dd($listadatos);


        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_entregable_modal_moneda($folio,$moneda_id) {

        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('REFERENCIA_ASOC.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','<>','EDC0000000000012')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002',
                                        'TDO0000000000034'
                                    ]);

        $oi                     =   DB::table('CMP.ORDEN')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->where('REFERENCIA_ASOC.COD_ESTADO','=','1')
                                    ->select(DB::raw('REFERENCIA_ASOC.*'))
                                    ->whereIn('COD_CATEGORIA_TIPO_ORDEN', ['TOR0000000000002']);


        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                    ->leftJoin(DB::raw("({$oi->toSql()}) as oi"), function ($join) use ($oi) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'oi.COD_TABLA')
                                                 ->addBinding($oi->getBindings());
                                        })
                                    ->where('FOLIO','=',$folio)
                                    ->where('CMP.ORDEN.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('CMP.Orden.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC,oi.COD_TABLA_ASOC,
                                        FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER'))
                                    ->orderBy('documentos.FEC_VENCIMIENTO','asc')
                                    ->get();
        return  $listadatos;
    }





    private function con_lista_cabecera_comprobante_entregable($cliente_id,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id,$moneda_id) {


        $fecha_corte            =   date('Ymd');


        //UPDATE SI TIENE NOTA DE CREDITO
        DB::statement("
            UPDATE FE_DOCUMENTO
            SET MONTO_NC = (
                SELECT SUM(DOC.CAN_TOTAL)
                FROM CMP.REFERENCIA_ASOC PR
                INNER JOIN CMP.REFERENCIA_ASOC PR2 ON PR.COD_TABLA_ASOC = PR2.COD_TABLA 
                    AND PR2.COD_TABLA_ASOC LIKE '%NC%' 
                    AND PR2.COD_ESTADO = 1
                INNER JOIN CMP.DOCUMENTO_CTBLE DOC ON PR2.COD_TABLA_ASOC = DOC.COD_DOCUMENTO_CTBLE
                WHERE PR.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO 
                    AND PR.COD_TABLA_ASOC LIKE '%FC%' 
                    AND PR.COD_ESTADO = 1
                    AND OPERACION = 'ORDEN_COMPRA'
                    AND ISNULL(FOLIO, '') = ''
                    AND FE_DOCUMENTO.COD_ESTADO = 'ETM0000000000005'
                    AND DOC.COD_CATEGORIA_ESTADO_DOC_CTBLE = 'EDC0000000000009'
            )
            WHERE EXISTS (
                SELECT 1
                FROM CMP.REFERENCIA_ASOC PR
                INNER JOIN CMP.REFERENCIA_ASOC PR2 ON PR.COD_TABLA_ASOC = PR2.COD_TABLA 
                    AND PR2.COD_TABLA_ASOC LIKE '%NC%' 
                    AND PR2.COD_ESTADO = 1
                INNER JOIN CMP.DOCUMENTO_CTBLE DOC ON PR2.COD_TABLA_ASOC = DOC.COD_DOCUMENTO_CTBLE
                WHERE PR.COD_TABLA = FE_DOCUMENTO.ID_DOCUMENTO 
                    AND PR.COD_TABLA_ASOC LIKE '%FC%' 
                    AND PR.COD_ESTADO = 1
                    AND OPERACION = 'ORDEN_COMPRA'
                    AND ISNULL(FOLIO, '') = ''
                    AND FE_DOCUMENTO.COD_ESTADO = 'ETM0000000000005'
                    AND DOC.COD_CATEGORIA_ESTADO_DOC_CTBLE = 'EDC0000000000009'
            );
        ");


        //DESCONTAR LA RETENCION DE IGV 
        $documentosdetraccion = DB::select("
                SELECT 
                    FE.*,
                    (
                        SELECT SUM(DOC.CAN_TOTAL)
                        FROM CMP.REFERENCIA_ASOC PR
                        INNER JOIN CMP.REFERENCIA_ASOC PR2 
                            ON PR.COD_TABLA_ASOC = PR2.COD_TABLA
                            AND PR2.COD_TABLA_ASOC LIKE '%NC%' 
                            AND PR2.COD_ESTADO = 1
                        INNER JOIN CMP.DOCUMENTO_CTBLE DOC 
                            ON PR2.COD_TABLA_ASOC = DOC.COD_DOCUMENTO_CTBLE
                        WHERE PR.COD_TABLA = FE.ID_DOCUMENTO 
                            AND PR.COD_TABLA_ASOC LIKE '%FC%' 
                            AND PR.COD_ESTADO = 1
                            AND OPERACION = 'ORDEN_COMPRA'
                            AND ISNULL(FOLIO, '') = ''
                            AND FE.COD_ESTADO = 'ETM0000000000005'
                            AND DOC.COD_CATEGORIA_ESTADO_DOC_CTBLE = 'EDC0000000000009'
                    ) AS MONTO_NC
                FROM FE_DOCUMENTO FE
                WHERE EXISTS (
                    SELECT 1
                    FROM CMP.REFERENCIA_ASOC PR
                    INNER JOIN CMP.REFERENCIA_ASOC PR2 
                        ON PR.COD_TABLA_ASOC = PR2.COD_TABLA
                        AND PR2.COD_TABLA_ASOC LIKE '%NC%' 
                        AND PR2.COD_ESTADO = 1
                    INNER JOIN CMP.DOCUMENTO_CTBLE DOC 
                        ON PR2.COD_TABLA_ASOC = DOC.COD_DOCUMENTO_CTBLE
                    WHERE PR.COD_TABLA = FE.ID_DOCUMENTO 
                        AND PR.COD_TABLA_ASOC LIKE '%FC%' 
                        AND PR.COD_ESTADO = 1
                        AND OPERACION = 'ORDEN_COMPRA'
                        AND ISNULL(FOLIO, '') = ''
                        AND FE.COD_ESTADO = 'ETM0000000000005'
                        AND DOC.COD_CATEGORIA_ESTADO_DOC_CTBLE = 'EDC0000000000009'
                ) AND FE.MONTO_RETENCION > 0;
            ");


        //RENTA DE CUARTA CATEGORIA

        DB::table('FE_DOCUMENTO')
            ->join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
            ->where('CMP.ORDEN.CAN_IMPUESTO_RENTA', '>', 0)
            ->whereColumn('FE_DOCUMENTO.TOTAL_VENTA_ORIG', '<>', 'CMP.ORDEN.CAN_TOTAL')
            ->update([
                'FE_DOCUMENTO.TOTAL_VENTA_ORIG' => DB::raw('CMP.ORDEN.CAN_TOTAL')
            ]);

        

        //dd($documentosdetraccion);
        foreach($documentosdetraccion as $index => $item){

            $retencionigv = (float)($item->TOTAL_VENTA_ORIG-$item->MONTO_NC)*(3/100);
            //FE_DOCUMENTO
            FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                        ->update(
                            [
                                'MONTO_RETENCION'=>$retencionigv
                            ]
                        );
            //OC
            CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)
                        ->update(
                            [
                                'CAN_RETENCION'=>$retencionigv,
                                'CAN_NETO_PAGAR' => \DB::raw('CAN_TOTAL - ' . $retencionigv)
                            ]
                        );



            $documento02      =     DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.REFERENCIA_ASOC.COD_ESTADO','=','1')
                                    ->where('CMP.REFERENCIA_ASOC.COD_TABLA','=',$item->ID_DOCUMENTO)
                                    ->whereIn('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ])->first();

            if(count($documento02)>0){
                CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$documento02->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'CAN_RETENCION'=>$retencionigv,
                                    'CAN_DCTO'=>3
                                ]
                            );
                CONRegistroCompras::where('COD_DOCUMENTO_CTBLE','=',$documento02->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'CAN_RETENCION_MONTO'=>$retencionigv,
                                    'CAN_RETENCION_PORCENTAJE'=>3
                                ]
                            );
            }
        }

        ////////////////////////////////////






        $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        $trabajador             =   STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores     =   STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                    ->pluck('COD_TRAB')
                                    ->toArray();

        $array_usuarios         =   SGDUsuario::Area($area_id)
                                    ->whereNotNull('COD_CATEGORIA_AREA')
                                    ->pluck('COD_USUARIO')
                                    ->toArray();

        $fecha_corte            =   date('Ymd');


        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->where('CMP.REFERENCIA_ASOC.COD_ESTADO','=','1')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000034',
                                        'TDO0000000000002'
                                    ]);

        //dd($moneda_id);

        $oi                     =   DB::table('CMP.ORDEN')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->where('CMP.REFERENCIA_ASOC.COD_ESTADO','=','1')
                                    ->select(DB::raw('REFERENCIA_ASOC.*'))
                                    ->whereIn('COD_CATEGORIA_TIPO_ORDEN', ['TOR0000000000002']);


        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                    //->Join('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                    ->leftJoin(DB::raw("({$oi->toSql()}) as oi"), function ($join) use ($oi) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'oi.COD_TABLA')
                                                 ->addBinding($oi->getBindings());
                                        })

                                    ->whereRaw("CAST(documentos.FEC_EMISION AS DATE) >= ? and CAST(documentos.FEC_EMISION AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                    ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where('FE_DOCUMENTO.OPERACION','=','ORDEN_COMPRA')
                                    ->where('documentos.COD_ESTADO','=','1')
                                    ->where(function ($query) {
                                        $query->where('FOLIO', '=', '');
                                        $query->orWhereNull('FOLIO');
                                    })
                                    //->where('CMP.Orden.COD_ORDEN','=','ISBECL0000001705')
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005'])
                                    ->where('CMP.Orden.COD_EMPR','=',$empresa_id)
                                    ->where('CMP.Orden.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                    //->where('CMP.Orden.COD_CENTRO','=',$centro_id)
                                    ->whereIn('CMP.Orden.COD_USUARIO_CREA_AUD',$array_usuarios)
                                    ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                    ->where('FE_DOCUMENTO.COD_CATEGORIA_BANCO','=',$banco_id)
                                    ->select(
                                        DB::raw('CMP.Orden.*, FE_DOCUMENTO.*, documentos.NRO_SERIE, documentos.FEC_VENCIMIENTO, documentos.NRO_DOC, oi.COD_TABLA_ASOC, FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO'),
                                        DB::raw("CMP.OBTENER_NC_PROVEEDOR(CMP.Orden.COD_EMPR, '', '{$fecha_corte}', CMP.Orden.COD_CONTRATO, CMP.Orden.COD_CATEGORIA_MONEDA) AS NC_PROVEEDOR")
                                        //DB::raw("CMP.OBTENER_ADELANTOS_PROVEEDOR(CMP.Orden.COD_EMPR, '', '{$fecha_corte}', CMP.Orden.COD_CONTRATO, CMP.Orden.COD_CATEGORIA_MONEDA) AS ADELANTOS_PROVEEDOR")
                                    )
                                    ->orderBy('documentos.FEC_EMISION','asc')
                                    ->get();
        return  $listadatos;

    }


    private function con_lista_cabecera_comprobante_entregable_sinfolio($empresa_id,$area_id) {


        $array_usuarios         =   SGDUsuario::Area($area_id)
                                    ->whereNotNull('COD_CATEGORIA_AREA')
                                    ->pluck('COD_USUARIO')
                                    ->toArray();
        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000034',
                                        'TDO0000000000002'
                                    ]);

        $oi                     =   DB::table('CMP.ORDEN')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('REFERENCIA_ASOC.*'))
                                    ->whereIn('COD_CATEGORIA_TIPO_ORDEN', ['TOR0000000000002']);


        $listadatos             =   CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                    ->leftJoin(DB::raw("({$oi->toSql()}) as oi"), function ($join) use ($oi) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'oi.COD_TABLA')
                                                 ->addBinding($oi->getBindings());
                                        })
                                    ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where('FE_DOCUMENTO.OPERACION','=','ORDEN_COMPRA')
                                    ->where(function ($query) {
                                        $query->where('FOLIO', '=', '');
                                        $query->orWhereNull('FOLIO');
                                    })
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005'])
                                    ->where('CMP.Orden.COD_EMPR','=',$empresa_id)
                                    ->whereIn('CMP.Orden.COD_USUARIO_CREA_AUD',$array_usuarios)
                                    ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                    ->select(
                                        DB::raw('CMP.Orden.*, FE_DOCUMENTO.*, documentos.NRO_SERIE, documentos.FEC_VENCIMIENTO, documentos.NRO_DOC, oi.COD_TABLA_ASOC, FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER, FE_DOCUMENTO.TXT_CATEGORIA_BANCO AS TXT_BANCO')
                                    )
                                    ->orderBy('documentos.FEC_VENCIMIENTO','asc')
                                    ->get();

        return  $listadatos;


    }





    private function con_lista_cabecera_comprobante_entregable_contrato_modal($folio) {




        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);

        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                    ->where('FOLIO','=',$folio)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC,
                                        FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER'))
                                    ->orderBy('documentos.FEC_VENCIMIENTO ', 'asc')
                                    ->get();

        return  $listadatos;


    }


    private function con_lista_cabecera_comprobante_entregable_contrato_modal_moneda($folio,$moneda_id) {




        $documento              =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*,REFERENCIA_ASOC.COD_TABLA,REFERENCIA_ASOC.COD_TABLA_ASOC'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_ESTADO_DOC_CTBLE','=','EDC0000000000009')
                                    
                                    ->whereIn('COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ]);

        $listadatos             =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                                    ->leftJoin(DB::raw("({$documento->toSql()}) as documentos"), function ($join) use ($documento) {
                                            $join->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'documentos.COD_TABLA')
                                                 ->addBinding($documento->getBindings());
                                        })
                                    ->where('FOLIO','=',$folio)
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                    ->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000005','ETM0000000000008'])
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.* ,FE_DOCUMENTO.*,documentos.NRO_SERIE,documentos.FEC_VENCIMIENTO,documentos.NRO_DOC,
                                        FE_DOCUMENTO.COD_ESTADO AS COD_ESTADO_VOUCHER'))
                                    ->orderBy('documentos.FEC_VENCIMIENTO ', 'asc')
                                    ->get();

        return  $listadatos;


    }


    private function con_lista_cabecera_comprobante_entregable_estiba_modal_moneda_union($folio,$moneda_id) {

        $listadatos         =   DB::table('FE_DOCUMENTO')
                                ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                })
                                ->where('CMP.REFERENCIA_ASOC.COD_ESTADO', 1)
                                ->where('FE_DOCUMENTO.FOLIO', $folio)
                                ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                ->whereIn('FE_DOCUMENTO.OPERACION',$this->con_array_canjes())
                                ->selectRaw('DISTINCT FE_DOCUMENTO.*, CMP.DOCUMENTO_CTBLE.*')
                                ->get();

        return  $listadatos;


    }



    private function con_lista_cabecera_comprobante_entregable_estiba_modal_moneda($folio,$moneda_id) {


        $listadatos         =   DB::table('FE_DOCUMENTO')
                                ->join('FE_REF_ASOC', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                ->join('CMP.REFERENCIA_ASOC', 'CMP.REFERENCIA_ASOC.COD_TABLA', '=', 'FE_REF_ASOC.ID_DOCUMENTO')
                                ->join('CMP.DOCUMENTO_CTBLE', function ($join) {
                                    $join->on('CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                         ->where('CMP.REFERENCIA_ASOC.TXT_TABLA_ASOC', '=', 'CMP.DOCUMENTO_CTBLE');
                                })
                                ->where('FE_DOCUMENTO.FOLIO', $folio)
                                ->where('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_MONEDA','=',$moneda_id)
                                ->where('FE_DOCUMENTO.OPERACION', 'ESTIBA')
                                ->selectRaw('DISTINCT FE_DOCUMENTO.*, CMP.DOCUMENTO_CTBLE.*') // DISTINCT aplicado solo a estas columnas
                                ->get();

        return  $listadatos;


    }




	private function con_lista_cabecera_comprobante_administrativo($cliente_id) {

		$trabajador 		 = 		STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
		$array_trabajadores  =		STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
									->pluck('COD_TRAB')
									->toArray();

		$array_usuarios  	 =		SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
									->pluck('COD_USUARIO')
									->toArray();
		$estado_no           =      'ETM0000000000006';

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos     =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                //->whereIn('VMERGEOC.COD_USUARIO_CREA_AUD',$array_usuarios)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    COD_USUARIO_CREA_AUD,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(FE_DOCUMENTO.ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(FE_DOCUMENTO.COD_ESTADO) AS COD_ESTADO,
                                                    MAX(FE_DOCUMENTO.TXT_ESTADO) AS TXT_ESTADO
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                ->groupBy('COD_USUARIO_CREA_AUD')
                                ->get();

        }else{

            $listadatos     =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                ->whereIn('VMERGEOC.COD_USUARIO_CREA_AUD',$array_usuarios)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    COD_USUARIO_CREA_AUD,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(FE_DOCUMENTO.ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(FE_DOCUMENTO.COD_ESTADO) AS COD_ESTADO,
                                                    MAX(FE_DOCUMENTO.TXT_ESTADO) AS TXT_ESTADO
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                ->groupBy('COD_USUARIO_CREA_AUD')
                                ->get();

        }


	 	return  $listadatos;
	}


    private function con_lista_cabecera_comprobante_administrativo_filtro($cliente_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores  =      STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                    ->pluck('COD_TRAB')
                                    ->toArray();

        $array_usuarios      =      SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                    ->pluck('COD_USUARIO')
                                    ->toArray();
        $estado_no          =       'ETM0000000000006';


        $listadatos         =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                            ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                    })
                                //->whereIn('VMERGEOC.COD_USUARIO_CREA_AUD',$array_usuarios)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    COD_USUARIO_CREA_AUD,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(COD_ESTADO) AS COD_ESTADO,
                                                    MAX(TXT_ESTADO) AS TXT_ESTADO,
                                                    MAX(TXT_CONFORMIDAD) AS TXT_CONFORMIDAD
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                ->groupBy('COD_USUARIO_CREA_AUD')
                                ->get();



        return  $listadatos;
    }


    private function con_lista_cabecera_contrato_administrativo($cliente_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores  =      STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                    ->pluck('COD_TRAB')
                                    ->toArray();

        $array_usuarios      =      SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                    ->pluck('COD_USUARIO')
                                    ->toArray();
                                    
        $estado_no          =       'ETM0000000000006';



        $centro_id          =       $trabajador->COD_ZONA_TIPO;
        $tipodoc_id         =       'TDO0000000000014';


        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =       VMergeDocumento::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                                ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                        //->whereIn('VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where(function ($query) {
                                            $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                                  ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                                  ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                        })
                                        ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                        ->whereRaw('YEAR(FEC_EMISION) >= ?', [2024])
                                        ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                        ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                            FEC_EMISION,
                                                            TXT_CATEGORIA_MONEDA,
                                                            TXT_EMPR_EMISOR,
                                                            COD_USUARIO_CREA_AUD,
                                                            CAN_TOTAL,
                                                            NRO_SERIE,
                                                            NRO_DOC,
                                                            
                                                            FE_DOCUMENTO.ID_DOCUMENTO,
                                                            FE_DOCUMENTO.COD_ESTADO,
                                                            FE_DOCUMENTO.TXT_ESTADO
                                                        '))
                                        ->get();

        }else{

        $listadatos         =       VMergeDocumento::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                            ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                    })
                                    //->whereIn('VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD',$array_usuarios)
                                    ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where(function ($query) {
                                        $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                              ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                              ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                    })
                                    ->whereRaw('YEAR(FEC_EMISION) >= ?', [2024])
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->where('COD_CENTRO','=',$centro_id)
                                    //->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                        FEC_EMISION,
                                                        TXT_CATEGORIA_MONEDA,
                                                        TXT_EMPR_EMISOR,
                                                        COD_USUARIO_CREA_AUD,
                                                        CAN_TOTAL,
                                                        NRO_SERIE,
                                                        NRO_DOC,
                                                        
                                                        FE_DOCUMENTO.ID_DOCUMENTO,
                                                        FE_DOCUMENTO.COD_ESTADO,
                                                        FE_DOCUMENTO.TXT_ESTADO
                                                    '))
                                    ->get();

        }




        return  $listadatos;
    }

    private function con_lista_cabecera_estibas_administrativo($cod_empresa,$area_id,$fecha_inicio,$fecha_fin,$proveedor_id,$categoria_id) {

        $estado_no          =       'ETM0000000000006';
        $trabajador         =      STDTrabajador::where('COD_TRAB','=',$cod_empresa)->first();
        $centro_id          =       $trabajador->COD_ZONA_TIPO;


        $tipodoc_id         =       $categoria_id;
        $array_usuarios     =       SGDUsuario::Area($area_id)
                                    ->whereNotNull('COD_CATEGORIA_AREA')
                                    ->pluck('COD_USUARIO')
                                    ->toArray();

        //marilu
        if(Session::get('usuario')->name=='MPACHECU'){
            array_push($array_usuarios, 'HPEREZAL');
        }
   

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =       VMergeDocumento::leftJoin('FE_REF_ASOC', function ($leftJoin){
                                            $leftJoin->on('FE_REF_ASOC.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                                ->where('FE_REF_ASOC.COD_ESTADO', '=', '1');
                                        })
                                        ->leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                                ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                        //->WHERE('VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE','=','IICHEST000068311')
                                        ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where(function ($query) {
                                            $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                                  ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                                  ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                        })
                                        ->whereRaw("CAST(VMERGEDOCUMENTOS.FEC_EMISION AS DATE) >= ? and CAST(VMERGEDOCUMENTOS.FEC_EMISION AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                        ->where('COD_EMPR_EMISOR','=',$proveedor_id)
                                        ->WHERE('VMERGEDOCUMENTOS.COD_ESTADO','=','1')
                                        //->whereIn('VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
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
                                                            FE_DOCUMENTO.COD_ESTADO,
                                                            FE_DOCUMENTO.TXT_ESTADO
                                                        '))
                                        ->get();


        }else{


            $listadatos         =       VMergeDocumento::leftJoin('FE_REF_ASOC', function ($leftJoin){
                                            $leftJoin->on('FE_REF_ASOC.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                                ->where('FE_REF_ASOC.COD_ESTADO', '=', '1');
                                        })
                                        ->leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                                ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                        //->WHERE('VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE','=','IICHEST000068311')
                                        ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where(function ($query) {
                                            $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                                  ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                                  ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                        })
                                        //->where('COD_CENTRO','=',$centro_id)
                                        ->whereRaw("CAST(VMERGEDOCUMENTOS.FEC_EMISION AS DATE) >= ? and CAST(VMERGEDOCUMENTOS.FEC_EMISION AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                        ->where('COD_EMPR_EMISOR','=',$proveedor_id)
                                        ->WHERE('VMERGEDOCUMENTOS.COD_ESTADO','=','1')
                                        ->whereIn('VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
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
                                                            FE_DOCUMENTO.COD_ESTADO,
                                                            FE_DOCUMENTO.TXT_ESTADO
                                                        '))
                                        ->get();

        }




        return  $listadatos;
    }

    private function con_combo_cabecera_estibas_administrativo($cliente_id,$area_id,$categoria_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();

        $array_trabajadores  =      STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                    ->pluck('COD_TRAB')
                                    ->toArray();

        $array_usuarios      =      SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                    ->pluck('COD_USUARIO')
                                    ->toArray();
        $estado_no          =       'ETM0000000000006';
        $centro_id          =       $trabajador->COD_ZONA_TIPO;
        $tipodoc_id         =       $categoria_id;


        $array_usuarios     =       SGDUsuario::Area($area_id)
                                    ->whereNotNull('COD_CATEGORIA_AREA')
                                    ->pluck('COD_USUARIO')
                                    ->toArray();


        //marilu
        if(Session::get('usuario')->name=='MPACHECU'){
            array_push($array_usuarios, 'HPEREZAL');
        }



        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =       VMergeDocumento::leftJoin('FE_REF_ASOC', function ($leftJoin){
                                            $leftJoin->on('FE_REF_ASOC.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                                ->where('FE_REF_ASOC.COD_ESTADO', '=', '1');
                                        })
                                        ->leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                                ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                        //->WHERE('VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE','=','IICHEST000068311')
                                        ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where(function ($query) {
                                            $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                                  ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                                  ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                        })
                                        ->WHERE('VMERGEDOCUMENTOS.COD_ESTADO','=','1')
                                        //->whereIn('VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                        ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                            FEC_EMISION,
                                                            TXT_CATEGORIA_MONEDA,
                                                            COD_EMPR_EMISOR,
                                                            TXT_EMPR_EMISOR,
                                                            COD_USUARIO_CREA_AUD,
                                                            CAN_TOTAL,
                                                            NRO_SERIE,
                                                            NRO_DOC,
                                                            FE_REF_ASOC.LOTE AS LOTE_DOC,
                                                            FE_DOCUMENTO.ID_DOCUMENTO,
                                                            FE_DOCUMENTO.COD_ESTADO,
                                                            FE_DOCUMENTO.TXT_ESTADO
                                                        '))
                                        ->pluck('TXT_EMPR_EMISOR','COD_EMPR_EMISOR')
                                        ->toArray();


        }else{


            $listadatos         =       VMergeDocumento::leftJoin('FE_REF_ASOC', function ($leftJoin){
                                            $leftJoin->on('FE_REF_ASOC.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                                ->where('FE_REF_ASOC.COD_ESTADO', '=', '1');
                                        })
                                        ->leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'FE_REF_ASOC.LOTE')
                                                ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                        //->WHERE('VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE','=','IICHEST000068311')
                                        ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where(function ($query) {
                                            $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                                  ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                                  ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                        })
                                        ->WHERE('VMERGEDOCUMENTOS.COD_ESTADO','=','1')
                                        ->whereIn('VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD',$array_usuarios)
                                        ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                        ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                            FEC_EMISION,
                                                            TXT_CATEGORIA_MONEDA,
                                                            COD_EMPR_EMISOR,
                                                            TXT_EMPR_EMISOR,
                                                            COD_USUARIO_CREA_AUD,
                                                            CAN_TOTAL,
                                                            NRO_SERIE,
                                                            NRO_DOC,
                                                            FE_REF_ASOC.LOTE AS LOTE_DOC,
                                                            
                                                            FE_DOCUMENTO.ID_DOCUMENTO,
                                                            FE_DOCUMENTO.COD_ESTADO,
                                                            FE_DOCUMENTO.TXT_ESTADO
                                                        '))
                                            ->pluck('TXT_EMPR_EMISOR','COD_EMPR_EMISOR')
                                            ->toArray();

        }

        $combo                  =   array(''=>'Seleccionar Porveedor') + $listadatos;
        return  $combo; 

    }





    private function con_lista_cabecera_comprobante_administrativo_total() {

        $estado_no          =   'ETM0000000000006';
        $toarray            =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                ->leftJoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'VMERGEOC.COD_USUARIO_CREA_AUD')
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    SGD.USUARIO.NOM_TRABAJADOR
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('SGD.USUARIO.NOM_TRABAJADOR')
                                //->pluck('NOM_TRABAJADOR','COD_ORDEN')
                                ->get()->toArray();


        $groupbyarray       =   $this->groupBy($toarray, 'NOM_TRABAJADOR');


        $togroupbyarray       =   $this->sortGroupsBySize($groupbyarray);
        //dd($togroupbyarray);


        return  $groupbyarray;
    }



    private function con_lista_cabecera_comprobante_administrativo_total_contrato() {


        $estado_no          =       'ETM0000000000006';
        $centro_id          =       'CEN0000000000001';
        $tipodoc_id         =       'TDO0000000000014';

        $toarray         =          VMergeDocumento::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                            ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                    })
                                    ->leftJoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD')
                                    ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where(function ($query) {
                                        $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                              ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                              ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                    })
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->where('COD_CENTRO','=',$centro_id)
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                        SGD.USUARIO.NOM_TRABAJADOR
                                                    '))
                                    ->groupBy('COD_DOCUMENTO_CTBLE')
                                    ->groupBy('SGD.USUARIO.NOM_TRABAJADOR')
                                    ->get()->toArray();



        $groupbyarray       =   $this->groupBy($toarray, 'NOM_TRABAJADOR');


        $togroupbyarray       =   $this->sortGroupsBySize($groupbyarray);
        //dd($togroupbyarray);


        return  $groupbyarray;
    }





    // Función para agrupar un array por una clave
    function groupBy(array $array, $key) {
        return array_reduce($array, function($result, $item) use ($key) {
            $result[$item[$key]][] = $item;
            return $result;
        }, []);
    }

    function sortGroupsBySize(array &$groups) {

        uasort($groups, function($a, $b) {
            return count($b) - count($a);
        });

        return $groups;

        //dd($groups);

    }

	private function con_lista_cabecera_comprobante_total($cliente_id) {

		$listadatos 	= 	VMergeOC::leftJoin('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
							//->where('COD_ESTADO','=','ETM0000000000002')
							->whereIn('COD_ESTADO', ['ETM0000000000001', 'ETM0000000000002', 'ETM0000000000003', 'ETM0000000000004', 'ETM0000000000005', 'ETM0000000000006'])
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
							->select(DB::raw('	COD_ORDEN,
												FEC_ORDEN,
												TXT_CATEGORIA_MONEDA,
												TXT_EMPR_CLIENTE,
												MAX(CAN_TOTAL) CAN_TOTAL,
												MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
												MAX(COD_ESTADO) AS COD_ESTADO,
												MAX(TXT_ESTADO) AS TXT_ESTADO
											'))
							->groupBy('COD_ORDEN')
							->groupBy('FEC_ORDEN')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('TXT_EMPR_CLIENTE')
							->get();

	 	return  $listadatos;
	}


	private function con_lista_cabecera_comprobante_idoc_actual($idoc) {


		$oc 	= 	VMergeActual::where('COD_ORDEN','=',$idoc)
							->select(DB::raw('COD_ORDEN,COD_EMPR,NOM_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,
												TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL,COD_CATEGORIA_TIPO_PAGO
												,COD_USUARIO_CREA_AUD'))
							->groupBy('COD_ORDEN')
							->groupBy('FEC_ORDEN')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('TXT_EMPR_CLIENTE')
							->groupBy('NRO_DOCUMENTO_CLIENTE')
							->groupBy('NRO_DOCUMENTO')
							->groupBy('COD_EMPR')
							->groupBy('NOM_EMPR')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('COD_CATEGORIA_TIPO_PAGO')
							->groupBy('COD_USUARIO_CREA_AUD')
							->first();

	 	return  $oc;
	}


	private function con_lista_cabecera_comprobante_idoc($idoc) {

		$oc 	             = 	VMergeOC::where('COD_ORDEN','=',$idoc)
    							->select(DB::raw('COD_ORDEN,COD_EMPR,NOM_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,
    												TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL,COD_CATEGORIA_TIPO_PAGO
    												,COD_USUARIO_CREA_AUD'))
    							->groupBy('COD_ORDEN')
    							->groupBy('FEC_ORDEN')
    							->groupBy('TXT_CATEGORIA_MONEDA')
    							->groupBy('TXT_EMPR_CLIENTE')
    							->groupBy('NRO_DOCUMENTO_CLIENTE')
    							->groupBy('NRO_DOCUMENTO')
    							->groupBy('COD_EMPR')
    							->groupBy('NOM_EMPR')
    							->groupBy('TXT_CATEGORIA_MONEDA')
    							->groupBy('COD_CATEGORIA_TIPO_PAGO')
    							->groupBy('COD_USUARIO_CREA_AUD')
    							->first();

	 	return  $oc;
	}


    private function con_lista_cabecera_comprobante_contrato_idoc($idoc) {


        $contrato                =      VMergeDocumento::where('COD_ESTADO','=','1')
                                            ->where('COD_DOCUMENTO_CTBLE','=',$idoc)
                                            ->first();

        return  $contrato;
    }

    private function con_lista_cabecera_comprobante_contrato_idoc_actual($idoc) {


        $contrato                =      VMergeDocumentoActual::where('COD_ESTADO','=','1')
                                            ->where('COD_DOCUMENTO_CTBLE','=',$idoc)
                                            ->first();

        return  $contrato;
    }

    private function con_lista_detalle_contrato_comprobante_idoc($idoc) {

        $doc                    =   CMPDetalleProducto::where('COD_TABLA','=',$idoc)
                                    ->where('COD_ESTADO','=',1)
                                    ->where('IND_MATERIAL_SERVICIO','=','S')
                                    ->get();

        return  $doc;

    }




	private function con_lista_detalle_comprobante_idoc($idoc) {

		$doc 	= 	VMergeOC::where('COD_ORDEN','=',$idoc)
							->get();

	 	return  $doc;

	}

	private function con_lista_detalle_comprobante_idoc_actual($idoc) {

		$doc 	= 	VMergeActual::where('COD_ORDEN','=',$idoc)

							->get();

	 	return  $doc;

	}

	private function prefijo_empresa($idempresa) {
		if($idempresa == 'IACHEM0000010394'){
			$prefijo = 'II';
		}else{
			$prefijo = 'IS';
		}
	 	return  $prefijo;
	}

	private function versicarpetanoexiste($ruta) {
		$valor = false;
		if (!file_exists($ruta)) {
		    mkdir($ruta, 0777, true);
		    $valor=true;
		}
		return $valor;
	}


	private function generartoken_ii() {

		$cliente_id = 'fb4f07e7-7ef4-4345-b434-11f3b1fd9f02';
		$client_secret = '6BnfVO7Uc0bSAPU/FcfkIw==';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-seguridad.sunat.gob.pe/v1/clientesextranet/'.$cliente_id.'/oauth2/token/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_POST => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_AUTOREFERER => true,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.sunat.gob.pe%2Fv1%2Fcontribuyente%2Fcontribuyentes&client_id='.$cliente_id.'&client_secret='.$client_secret,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Cookie: BIGipServerpool-e-plataformaunica-https=!npyoItrPwoiiUEHNnEfW6R1uaTqJDv+jJpdnaYgKdF+RvWima7xHYkuTAfphnUd/q7rgRvf+p/i4jA==; TS019e7fc2=019edc9eb870d9467c32c316be86f95256352673bd84f6776735f1a4bd678d04918fc02cf3d561b81ca4461a95d35151850b9e2387'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$atoken = json_decode($response, true);
		$token = $this->existe_vacio($atoken,'access_token');

		return $token;

	}


	private function generartoken_is() {
		
		$cliente_id = '1649d1ba-1fc9-45b9-a506-ebe0cc16393f';
		$client_secret = 'WJgOtY9fz91iHv6NZuWeew==';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-seguridad.sunat.gob.pe/v1/clientesextranet/'.$cliente_id.'/oauth2/token/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_POST => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_AUTOREFERER => true,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.sunat.gob.pe%2Fv1%2Fcontribuyente%2Fcontribuyentes&client_id='.$cliente_id.'&client_secret='.$client_secret,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Cookie: BIGipServerpool-e-plataformaunica-https=!npyoItrPwoiiUEHNnEfW6R1uaTqJDv+jJpdnaYgKdF+RvWima7xHYkuTAfphnUd/q7rgRvf+p/i4jA==; TS019e7fc2=019edc9eb870d9467c32c316be86f95256352673bd84f6776735f1a4bd678d04918fc02cf3d561b81ca4461a95d35151850b9e2387'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$atoken = json_decode($response, true);
		$token = $this->existe_vacio($atoken,'access_token');
		return $token;

	}

	private function validar_xml($token,$ruc,$numRuc,$codComp,$numeroSerie,$numero,$fechaEmision,$monto) {

		$json 				= 	'{
								    "numRuc" : "'.$numRuc.'",
								    "codComp" : "'.$codComp.'",
								    "numeroSerie" : "'.$numeroSerie.'",
								    "numero" : "'.$numero.'",
								    "fechaEmision" : "'.$fechaEmision.'",
								    "monto" : "'.round($monto,4).'"
								}';

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes/'.$ruc.'/validarcomprobante',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_POST => true,

		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_AUTOREFERER => true,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>$json,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$token,
		    'Cookie: TS012c881c=019edc9eb8ff55ad0feefbb4565864996e15bb9e987323078781cb5b85100d034c66c76db2bb1bf9ccf4a82c15d22272160b5a62d6'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		
		return $response;


	}



	public function existe_vacio($item,$nombre)
	{
		$valor = '';
		if(!isset($item[$nombre])){
			$valor  = 	'';
		}else{
			$valor  = 	rtrim(ltrim($item[$nombre]));
		}
		return $valor;

	}






}