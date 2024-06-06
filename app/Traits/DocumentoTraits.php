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
use App\Modelos\Estado;

use ZipArchive;
use SplFileInfo;
use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;

trait DocumentoTraits
{

    private function con_lista_cabecera_documentos($cliente_id) {

        $listadatos     =   FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('TXT_PROCEDENCIA','=','SUE')
                            ->get();

        return  $listadatos;

    }

    public function llenar_array_productos($documento_id){

        $documento                  =   VMergeDocumento::where('COD_DOCUMENTO_CTBLE','=',$documento_id)->first();

        return                      array(
                                            "COD_DOCUMENTO_CTBLE"           => $documento->COD_DOCUMENTO_CTBLE,
                                            "NRO_SERIE"                     => $documento->NRO_SERIE,
                                            "NRO_DOC"                       => $documento->NRO_DOC,
                                            "FEC_EMISION"                   => $documento->FEC_EMISION,
                                            "TXT_EMPR_EMISOR"               => $documento->TXT_EMPR_EMISOR,
                                            "TXT_CATEGORIA_MONEDA"          => $documento->TXT_CATEGORIA_MONEDA,
                                            "CAN_SUB_TOTAL"                 => $documento->CAN_SUB_TOTAL,
                                            "CAN_IMPUESTO_VTA"              => $documento->CAN_IMPUESTO_VTA,
                                            "CAN_TOTAL"                     => $documento->CAN_TOTAL
                                        );



    }


    public function llenar_array_productos_merge($documento_id){

        $documento                  =   FeDocumento::where('ID_DOCUMENTO','=',$documento_id)->first();

        return                      array(
                                            "ID_DOCUMENTO"              => $documento->ID_DOCUMENTO,
                                            "SERIE"                     => $documento->SERIE,
                                            "NUMERO"                    => $documento->NUMERO,
                                            "FEC_VENTA"                 => $documento->FEC_VENTA,
                                            "FORMA_PAGO"                => $documento->FORMA_PAGO,
                                            "RUC_PROVEEDOR"             => $documento->RUC_PROVEEDOR,
                                            "RZ_PROVEEDOR"              => $documento->RZ_PROVEEDOR,
                                            "TOTAL_VENTA_ORIG"          => $documento->TOTAL_VENTA_ORIG
                                        );



    }




}