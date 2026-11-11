<?php
namespace App\Biblioteca;

use DOMDocument;
use DB;
use Session;
use PDO;
use App\WEBRegla,App\CMPReferecenciaAsoc,App\CMPOrden,App\WEBOrdenDetalleRegla;
use App\STDEmpresaDireccion,App\CMPContrato,App\Modelos\WEBLISTASERIE;
use App\Modelos\STDTrabajador;
use App\CMPDocumentoCtble,App\CMPCategoria,App\WEBOvFac,App\WEBOcOv,App\WEBDocumentoNotaCredito,App\WEBDetalleDocumentoAsociados;
use App\Biblioteca\Funcion;

class NotaCredito{



    public function agregar_reglas_orden_cen($mensaje,$estado,$orden_id,$producto_id,$array_reglas_id,$proceso_id){


        $mensaje                    =   $mensaje;
        $error                      =   false;
        $funciones                  =   new Funcion();
        $fechaactual                =   date('d-m-Y H:i:s');

        foreach ($array_reglas_id as &$regla) {

            $idordendetalleregla        =   $funciones->getCreateIdMaestra('WEB.ordendetallereglas');

            $cabecera                   =   new WEBOrdenDetalleRegla;
            $cabecera->id               =   $idordendetalleregla;
            $cabecera->estado           =   $estado;
            $cabecera->fecha_crea       =   $fechaactual;
            $cabecera->usuario_crea     =   Session::get('usuario')->name;
            $cabecera->activo           =   1;
            $cabecera->orden_id         =   $orden_id;
            $cabecera->producto_id      =   $producto_id;
            $cabecera->regla_id         =   $regla;
            $cabecera->proceso_id       =   $proceso_id;               
            $cabecera->save();

            $regla                      =   WEBRegla::where('id','=',$regla)->first();
            $regla->cantidadutilizada   =   $regla->cantidadutilizada + 1;              
            $regla->save();


        }
                           
        $response[] = array(
            'error'                 => $error,
            'mensaje'               => $mensaje
        );

        return $response;

 

    }




    public function nombre_motivo($motivo_id){

        $motivo      =   CMPCategoria::where('COD_CATEGORIA','=',$motivo_id)->first();
        return $motivo;
                      
    }
    public function nota_credito_asociada($iddocumentonotacredito){

            $documentonotacredito           =   WEBDocumentoNotaCredito::where('id','=',$iddocumentonotacredito)->first();
            if(strlen (trim($documentonotacredito->nota_credito_id))>0){
                $documento                  =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$documentonotacredito->nota_credito_id)->first();
            }else{
                $documento                  =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=','xxxxxxxx')->first();
            }
            return $documento;
                               
    }
    public function nota_credito_cerrada($iddocumentonotacredito){

            $nota_credito                   =   false;
            $documentonotacredito           =   WEBDocumentoNotaCredito::where('id','=',$iddocumentonotacredito)->where('estado','=','CE')->first();

            if(count($documentonotacredito)>0){
                $nota_credito               =   true;
            }
            return $nota_credito;
                               
    }


    public function nota_credito_relaciona($iddocumentonotacredito){

            $nota_credito                   =   '';
            $documentonotacredito           =   WEBDocumentoNotaCredito::where('id','=',$iddocumentonotacredito)->first();


            if(strlen (trim($documentonotacredito->nota_credito_id))>0){

                $documento                  =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$documentonotacredito->nota_credito_id)->first();
                $nota_credito               =       $documento->NRO_SERIE.'-'.$documento->NRO_DOC;  
            }
            return $nota_credito;
                               
    }




    public function descripcion_reglas_generales($regla_id){

            // orden de la factura
            $reglas          =          WEBRegla::whereIn('id',$regla_id)
                                     //->select(DB::raw("(WEB.reglas.nombre + ' ' + CASE WHEN WEB.reglas.tipodescuento = 'POR' THEN '%' WHEN WEB.reglas.tipodescuento = 'IMP' THEN 'S/.' END + CAST(WEB.reglas.descuento AS varchar(100)) ) AS nombre"))
                                        ->select(DB::raw("(CASE WHEN WEB.reglas.tipodescuento = 'POR' THEN '%' WHEN WEB.reglas.tipodescuento = 'IMP' THEN 'S/.' END + CAST(WEB.reglas.descuento AS varchar(100)) ) AS nombre"))
                                        ->pluck('nombre')
                                        ->toArray();

            return $reglas;
                               
    }


    public function descripcion_reglas_monto($documento_id,$referencia_id,$producto_id,$ordencen_id,$reglas_id){


            // lista de descuento de la nota de credito
            $reglas         =               WEBOrdenDetalleRegla::join('WEB.reglas', 'WEB.ordendetallereglas.regla_id', '=', 'WEB.reglas.id')
                                            ->join('CMP.DETALLE_PRODUCTO', function($join)
                                                    {
                                                        $join->on('CMP.DETALLE_PRODUCTO.COD_PRODUCTO', '=', 'WEB.ordendetallereglas.producto_id');
                                                    })
                                            ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$documento_id)
                                            ->where('WEB.ordendetallereglas.orden_id','=',$ordencen_id)
                                            ->where('WEB.ordendetallereglas.estado','=','OC')
                                            ->whereIn('WEB.ordendetallereglas.regla_id',$reglas_id)
                                            ->where('WEB.ordendetallereglas.producto_id','=',$producto_id)
                                            ->where('WEB.ordendetallereglas.activo','=',1)
                                            ->where('WEB.reglas.tiporegla','=','PNC')
                                            ->select(DB::raw("(CASE WHEN WEB.reglas.tipodescuento = 'POR' THEN '%' WHEN WEB.reglas.tipodescuento = 'IMP' THEN 'S/.' END + CAST(WEB.reglas.descuento AS varchar(100)) ) AS nombre"))
                                            ->groupBy('WEB.reglas.tipodescuento')
                                            ->groupBy('WEB.reglas.descuento')
                                            ->pluck('nombre')
                                            ->toArray();

            return $reglas;
                               
    }


    public function monto_descuento_nota_credito_factura($documento_id,$documento_ref_id,$reglas_id,$orden_cen){

            $descuento_total         =       0.00;

            // lista de descuento de la nota de credito
            $lista_descuentos_nc     =       WEBOrdenDetalleRegla::join('WEB.reglas', 'WEB.ordendetallereglas.regla_id', '=', 'WEB.reglas.id')
                                            ->join('CMP.DETALLE_PRODUCTO', function($join)
                                                    {
                                                        $join->on('CMP.DETALLE_PRODUCTO.COD_PRODUCTO', '=', 'WEB.ordendetallereglas.producto_id');
                                                    })
                                            ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$documento_id)
                                            ->where('WEB.ordendetallereglas.orden_id','=',$orden_cen)
                                            ->where('WEB.ordendetallereglas.estado','=','OC')
                                            ->whereIn('WEB.ordendetallereglas.regla_id',$reglas_id)
                                            ->where('WEB.reglas.tiporegla','=','PNC')
                                            ->select('CMP.DETALLE_PRODUCTO.CAN_VALOR_VTA','WEB.reglas.tipodescuento','WEB.reglas.descuento')
                                            ->where('WEB.ordendetallereglas.activo','=',1)->get();


            // RECORRER TODOS LOS DEPARTAMENTOS CON SU PRECIO
            foreach($lista_descuentos_nc as $item){
                    //tipo porcentanje
                    if($item->tipodescuento == 'POR'){
                            $descuento_total = $descuento_total + ($item->CAN_VALOR_VTA*($item->descuento/100));
                    }else{
                            $descuento_total = $descuento_total + $item->descuento;
                    }       
            }

            return $descuento_total;

                               
    }





        public function factura_ordencen($ordencen_id){

   
            $documento_id       =       '';
            $orden_venta        =       WEBOcOv::where('COD_ORDENCEN','=',$ordencen_id)->first();

            if(count($orden_venta)>0){
                
                $factura        =       WEBOvFac::where('COD_ORDENVENTA','=',$orden_venta->COD_ORDEN)
                                        //->where('COD_EMPRVENTA','=',Session::get('empresas')->COD_EMPR)
                                        ->first();

                if(count($factura)>0){
                    $documento_id   =       $factura->COD_DOCUMENTO_CTBLE;   
                }

            }


            $documento          =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$documento_id)->first();

            return $documento;
                     
        }

        public function id_reglas_nc_seleccionadas($iddocumentonotacredito){


            $array_reglas_id        =   WEBDetalleDocumentoAsociados::join('WEB.documento_asociados', 'WEB.documento_asociados.id', '=', 'WEB.detalle_documento_asociados.documento_asociados_id')
                                        ->where('WEB.detalle_documento_asociados.activo','=',1)
                                        ->where('WEB.documento_asociados.activo','=',1)
                                        ->where('WEB.documento_asociados.documento_nota_credito_id','=',$iddocumentonotacredito)
                                        
                                        ->groupBy('regla_id')
                                        ->pluck('regla_id')
                                        ->toArray();

            $combo_reglas           =   $array_reglas_id;
            return $combo_reglas;   

        }


        public function combo_reglas_nc_seleccionadas($iddocumentonotacredito){


            $array_reglas_id        =   WEBDetalleDocumentoAsociados::join('WEB.documento_asociados', 'WEB.documento_asociados.id', '=', 'WEB.detalle_documento_asociados.documento_asociados_id')
                                        ->where('WEB.detalle_documento_asociados.activo','=',1)
                                        ->where('WEB.documento_asociados.activo','=',1)
                                        ->where('WEB.documento_asociados.documento_nota_credito_id','=',$iddocumentonotacredito)
                                        ->pluck('regla_id')
                                        ->toArray();

            // orden de la factura
            $lista_reglas          =    WEBRegla::whereIn('id',$array_reglas_id)
                                        ->select('WEB.reglas.id', DB::raw("(WEB.reglas.nombre + ' ' + CASE WHEN WEB.reglas.tipodescuento = 'POR' THEN '%' WHEN WEB.reglas.tipodescuento = 'IMP' THEN 'S/.' END + CAST(WEB.reglas.descuento AS varchar(100)) ) AS nombre"))
                                        ->pluck('nombre','id')
                                        ->toArray();


            $combo_reglas           =   $lista_reglas;
            return $combo_reglas;   

        }


        public function combo_reglas_nc_cliente_fechas($fechainicio,$fechafin,$cuenta_id){


            $fechainicio            =   date_format(date_create($fechainicio), 'Y-m-d');
            $fechafin               =   date_format(date_create($fechafin), 'Y-m-d');

            $lista_reglas           =   WEBOrdenDetalleRegla::join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.ordendetallereglas.regla_id')
                                        ->join('CMP.ORDEN', 'CMP.ORDEN.COD_ORDEN', '=', 'WEB.ordendetallereglas.orden_id')
                                        ->where('WEB.reglas.tiporegla','=','PNC')
                                        ->where('WEB.ordendetallereglas.estado','=','OC')
                                        ->where('CMP.ORDEN.COD_CONTRATO','=',$cuenta_id)
                                        ->where('WEB.ordendetallereglas.activo','=',1)
                                        ->whereIn('proceso_id',['OV','OC'])
                                        ->whereRaw('Convert(varchar(10), WEB.ordendetallereglas.fecha_crea, 120) >= ?', [$fechainicio])
                                        ->whereRaw('Convert(varchar(10), WEB.ordendetallereglas.fecha_crea, 120) <= ?', [$fechafin])
                                        ->select('WEB.reglas.id', DB::raw("(WEB.reglas.nombre + ' ' + CASE WHEN WEB.reglas.tipodescuento = 'POR' THEN '%' WHEN WEB.reglas.tipodescuento = 'IMP' THEN 'S/.' END + CAST(WEB.reglas.descuento AS varchar(100)) ) AS nombre"))
                                        ->groupBy('WEB.reglas.id')
                                        ->groupBy('WEB.reglas.nombre')
                                        ->groupBy('WEB.reglas.tipodescuento')
                                        ->groupBy('WEB.reglas.descuento')
                                        ->pluck('nombre','id')
                                        ->toArray();

            


            $combo_reglas           =   array('' => "Seleccione regla") + $lista_reglas;
            return $combo_reglas;   

        }











        public function orden_cen_documento($referencia_id){

                // orden de la factura
                $orden          =       CMPOrden::where('COD_ORDEN','=',$referencia_id)->first();

                return $orden;
                                   
        }


        public function documento_atributos($documento_id){

                // orden de la factura
                $documento          =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$documento_id)->first();

                return $documento;
                                   
        }

        public function existe_descuento_factura_nota_credito($documento_id,$documento_ref_id){

                // referencia de la tabla
                $referencia     =       CMPReferecenciaAsoc::where('COD_TABLA_ASOC','=',$documento_id)
                                        ->where('COD_TABLA','=',$documento_ref_id)->first();
                if(count($referencia)<=0){return '';}

                // orden de la factura
                $orden          =       CMPOrden::where('COD_ORDEN','=',$referencia->COD_TABLA)->first();

                // orden con reglas detalle
                $ordendetalle   =       WEBOrdenDetalleRegla::join('WEB.reglas', 'WEB.ordendetallereglas.regla_id', '=', 'WEB.reglas.id') 
                                        ->where('WEB.ordendetallereglas.orden_id','=',$referencia->COD_TABLA)
                                        ->where('WEB.ordendetallereglas.estado','=','OV')
                                        ->where('WEB.reglas.tiporegla','=','PNC')
                                        ->where('WEB.ordendetallereglas.activo','=',1)->get();

                if(count($ordendetalle)<=0){return '';}

                return          $this->monto_descuento_nota_credito($referencia->COD_TABLA);

                                   
        }



    public function reglas_nc_documentocontable_producto($referencia_id,$producto_id) {


        $lista_reglas                   =   WEBOrdenDetalleRegla::join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.ordendetallereglas.regla_id')
                                            ->where('WEB.ordendetallereglas.activo','=','1')
                                            ->where('WEB.ordendetallereglas.estado','=','OV')
                                            ->where('WEB.ordendetallereglas.orden_id','=',$referencia_id)
                                            ->where('WEB.ordendetallereglas.producto_id','=',$producto_id)
                                            ->where('WEB.reglas.tiporegla','=','PNC')
                                            ->select(DB::raw("(CASE WHEN tipodescuento = 'POR' THEN '%' WHEN tipodescuento = 'IMP' THEN 'S/.' END + CAST(descuento AS varchar(100)) ) AS regla"))
                                            ->pluck('regla')
                                            ->toArray();

        $reglas                         =   implode(" | ", $lista_reglas);


        return   $reglas;                         
    }




    public function monto_descuento_nc_documentocontable_producto($documento_id,$referencia_id,$producto_id,$ordencen_id,$reglas_id) {

        $descuento_total         =       0.00;
        // lista de descuento de la nota de credito


            // lista de descuento de la nota de credito
            $lista_descuentos_nc     =       WEBOrdenDetalleRegla::join('WEB.reglas', 'WEB.ordendetallereglas.regla_id', '=', 'WEB.reglas.id')
                                            ->join('CMP.DETALLE_PRODUCTO', function($join)
                                                    {
                                                        $join->on('CMP.DETALLE_PRODUCTO.COD_PRODUCTO', '=', 'WEB.ordendetallereglas.producto_id');
                                                    })
                                            ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$documento_id)
                                            ->where('WEB.ordendetallereglas.orden_id','=',$ordencen_id)
                                            ->where('WEB.ordendetallereglas.estado','=','OC')
                                            ->whereIn('WEB.ordendetallereglas.regla_id',$reglas_id)
                                            ->where('WEB.ordendetallereglas.producto_id','=',$producto_id)
                                            ->where('WEB.reglas.tiporegla','=','PNC')
                                            ->select('CMP.DETALLE_PRODUCTO.CAN_VALOR_VTA','WEB.reglas.tipodescuento','WEB.reglas.descuento')
                                            ->where('WEB.ordendetallereglas.activo','=',1)->get();


        // RECORRER TODOS LOS DEPARTAMENTOS CON SU PRECIO
        foreach($lista_descuentos_nc as $item){
                //tipo porcentanje
                if($item->tipodescuento == 'POR'){
                        $descuento_total = $descuento_total + ($item->CAN_VALOR_VTA*($item->descuento/100));
                }else{
                        $descuento_total = $descuento_total + $item->descuento;
                }       
        }

        return $descuento_total;


    }

    public function monto_descuento_nc_documentocontable_producto_individual($documento_id,$referencia_id,$producto_id,$ordencen_id,$reglas_id) {

        $descuento_total         =       0.00;
        // lista de descuento de la nota de credito


            // lista de descuento de la nota de credito
            $lista_descuentos_nc     =       WEBOrdenDetalleRegla::join('WEB.reglas', 'WEB.ordendetallereglas.regla_id', '=', 'WEB.reglas.id')
                                            ->join('CMP.DETALLE_PRODUCTO', function($join)
                                                    {
                                                        $join->on('CMP.DETALLE_PRODUCTO.COD_PRODUCTO', '=', 'WEB.ordendetallereglas.producto_id');
                                                    })
                                            ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$documento_id)
                                            ->where('WEB.ordendetallereglas.orden_id','=',$ordencen_id)
                                            ->where('WEB.ordendetallereglas.estado','=','OC')
                                            ->where('WEB.ordendetallereglas.regla_id','=',$reglas_id)
                                            ->where('WEB.ordendetallereglas.producto_id','=',$producto_id)
                                            ->where('WEB.reglas.tiporegla','=','PNC')
                                            ->select('CMP.DETALLE_PRODUCTO.CAN_VALOR_VTA','WEB.reglas.tipodescuento','WEB.reglas.descuento')
                                            ->where('WEB.ordendetallereglas.activo','=',1)->get();


        // RECORRER TODOS LOS DEPARTAMENTOS CON SU PRECIO
        foreach($lista_descuentos_nc as $item){
                //tipo porcentanje
                if($item->tipodescuento == 'POR'){
                        $descuento_total = $descuento_total + ($item->CAN_VALOR_VTA*($item->descuento/100));
                }else{
                        $descuento_total = $descuento_total + $item->descuento;
                }       
        }

        return $descuento_total;


    }


    public function direccion_cuenta($cuenta_id) {


        $contrato   =   CMPContrato::where('COD_CONTRATO','=',$cuenta_id)->first();


        $direccion  =   STDEmpresaDireccion::where('IND_DIRECCION_FISCAL','=',1)
                        ->where('COD_ESTADO','=',1)
                        ->where('COD_EMPR','=',$contrato->COD_EMPR_CLIENTE)->first();

        return $direccion;

    }


    public function direccion_cuenta_boleta($cuenta_id) {


        $txtdireccion   =   '';
        $contrato       =   CMPContrato::where('COD_CONTRATO','=',$cuenta_id)->first();


        $direccion      =   STDEmpresaDireccion::where('IND_DIRECCION_FISCAL','=',1)
                            ->where('COD_ESTADO','=',1)
                            ->where('COD_EMPR','=',$contrato->COD_EMPR_CLIENTE)->first();


        if(count($direccion)>0){
            $txtdireccion = $direccion->COD_DIRECCION;
        }

        return $txtdireccion;

    }



    public function combo_series() {


        $trabajador_sin_sede    =       STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)
                                        ->where('COD_ESTADO','=',1)->first();


        if(count($trabajador_sin_sede)<= 0){
                $combo_series           =       array('' => "Seleccione Serie (0)");
                return $combo_series;     
        }


        $trabajador             =       STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador_sin_sede->NRO_DOCUMENTO)
                                        ->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('COD_ESTADO','=',1)->first();

        if(count($trabajador)<= 0){
                $combo_series           =       array('' => "Seleccione Serie (1)");
                return $combo_series;
        }

        $lista_series           =       WEBLISTASERIE::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
                                        ->where('COD_TRAB','=',$trabajador->COD_TRAB)
                                        ->where('COD_CATEGORIA_TIPO_DOCUMENTO','=','TDO0000000000007') //PARAMETRO FALTA
                                        ->where('NRO_SERIE', 'like', 'B%') //PARAMETRO FALTA
                                        ->pluck('NRO_SERIE','NRO_SERIE')
                                        ->toArray();
                 
        if(count($lista_series)<= 0){
                $combo_series           =       array('' => "Seleccione Serie (2)");
                return $combo_series;
        }else{
                $combo_series           =       array('' => "Seleccione Serie") + $lista_series;
                return $combo_series;         
        }


                 
    }

    public function combo_series_tipodocumento($tipo_doc) {


        


        $trabajador_sin_sede    =       STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)
                                        ->where('COD_ESTADO','=',1)->first();


        if(count($trabajador_sin_sede)<= 0){
                $combo_series           =       array('' => "Seleccione Serie (0)");
                return $combo_series;     
        }


        $trabajador             =       STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador_sin_sede->NRO_DOCUMENTO)
                                        ->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        ->where('COD_ESTADO','=',1)->first();

        if(count($trabajador)<= 0){
                $combo_series           =       array('' => "Seleccione Serie (1)");
                return $combo_series;
        }

        $lista_series           =       WEBLISTASERIE::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                        //->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
                                        ->where('COD_TRAB','=',$trabajador->COD_TRAB)
                                        ->where('COD_CATEGORIA_TIPO_DOCUMENTO','=',$tipo_doc) //PARAMETRO FALTA
                                        //->where('NRO_SERIE', 'like', 'B%') //PARAMETRO FALTA
                                        ->pluck('NRO_SERIE','NRO_SERIE')
                                        ->toArray();
                 
        if(count($lista_series)<= 0){
                $combo_series           =       array('' => "Seleccione Serie (2)");
                return $combo_series;
        }else{
               $combo_series = $lista_series;

                return $combo_series;         
        }


                 
    }





    public function numero_documento($serie,$tipodocumento_id) {

        $nro_documento  =   '00000000';

        $documento      =   CMPDocumentoCtble::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
                                ->where('NRO_SERIE','=',$serie)
                                ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodocumento_id)
                                ->where('IND_COMPRA_VENTA','=','V')
                                ->orderBy('NRO_DOC', 'desc')
                                ->first();

        if(count($documento)>0){
            $numero         =   (int)$documento->NRO_DOC +1;
            //concatenar con ceros
            $nro_documento = str_pad($numero, 8, "0", STR_PAD_LEFT);
        }else{
            $nro_documento = '00000001';   
        }
        return $nro_documento;               
    }

    public function numero_documento_tipodocumento($serie,$tipodocumento_id) {

        $nro_documento  =   '00000000';
        $documento      =   CMPDocumentoCtble::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                //->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
                                ->where('NRO_SERIE','=',$serie)
                                ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodocumento_id)
                                //->where('IND_COMPRA_VENTA','=','V')
                                ->orderBy('NRO_DOC', 'desc')
                                ->first();

        if(count($documento)>0){
            $numero         =   (int)$documento->NRO_DOC +1;
            //concatenar con ceros
            $nro_documento = str_pad($numero, 8, "0", STR_PAD_LEFT);
        }else{
            $nro_documento = '00000001';   
        }
        return $nro_documento;               
    }





    public function numero_documento_conteo($serie,$tipodocumento_id,$suma) {

        $nro_documento  =   '00000000';

        $documento      =   CMPDocumentoCtble::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
                                ->where('NRO_SERIE','=',$serie)
                                ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodocumento_id)
                                ->where('IND_COMPRA_VENTA','=','V')
                                ->orderBy('NRO_DOC', 'desc')
                                ->first();

        if(count($documento)>0){
            $numero         =   (int)$documento->NRO_DOC + $suma;
            //concatenar con ceros
            $nro_documento  =   str_pad($numero, 8, "0", STR_PAD_LEFT);
        }else{

            $numero         =   $suma;
            $nro_documento  =   str_pad($numero, 8, "0", STR_PAD_LEFT);  
        }
        return $nro_documento;               
    }



    public function combo_motivos_documento($tipodocumento_id,$motivos_array) {


        $lista_motivos      =   CMPCategoria::where('COD_ESTADO','=',1)
                                ->where('TXT_GRUPO','=','MOTIVO_EMISION')
                                ->where('COD_TIPO_DOCUMENTO','=',$tipodocumento_id)
                                ->whereIn('COD_CATEGORIA',$motivos_array)
                                ->where(function ($query) {
                                    $query->whereNull('IND_OPERACION_AUTO')
                                          ->orwhereIn('IND_OPERACION_AUTO', ['']);
                                })
                                ->orderBy('COD_CATEGORIA', 'asc')
                                ->pluck('NOM_CATEGORIA','COD_CATEGORIA')
                                ->toArray();
                               


        $combo_motivos       =   array('' => "Seleccione motivo") + $lista_motivos;
        return $combo_motivos;   

     
    }


}


