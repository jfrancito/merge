<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

use App\Traits\ValeFirmaTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use App\Helpers\NumeroALetras;
use Session;
use App\WEBRegla, App\STDEmpresa, APP\User, App\CMPCategoria;
use View;
use Validator;

class FirmaValeRendirController extends Controller
{
    use ValeFirmaTraits;  

    public function actionRegistroPersonalFirma(Request $request)
    {
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $cod_centro = Session::get('empresas')->COD_CENTRO_SISTEMA;

        $listarFirmaValeRendir = $this->listaFirmaValeRendir(
            "$cod_empr",
            "$cod_centro"
        );

        return view('valerendir.firma.modalfirmavalerendir', [
            'listarFirmaValeRendir' => $listarFirmaValeRendir,
            'ajax' => true,   
        ]);
    }
    
    public function actionexportarpdf($id)
    {
        // 📂 Ruta UNC a la carpeta compartida
        $rutaArchivo = "\\\\10.1.50.2\\comprobantes\\PDF_VALE\\vale_{$id}.pdf";

        $info = DB::table('tes.OPERACION_CAJA as oc')
            ->join('tes.CAJA_BANCO as cb', 'oc.COD_CAJA_BANCO', '=', 'cb.COD_CAJA_BANCO')
            ->join('STD.EMPRESA as e', 'oc.COD_EMPR', '=', 'e.COD_EMPR') // empresa origen
            ->join('STD.EMPRESA as ea', 'oc.COD_EMPR_AFECTA', '=', 'ea.COD_EMPR') // empresa afectada
            ->select(
                'oc.TXT_EMPR_AFECTA',
                'oc.COD_CULTIVO_AFECTA',
                'oc.NRO_CHEQUE',
                'oc.TXT_GLOSA',
                'oc.TXT_DESCRIPCION',
                'oc.FEC_OPERACION',
                'oc.TXT_CATEGORIA_MEDIO_PAGO',
                'oc.COD_OPERACION_CAJA',
                'oc.TXT_CATEGORIA_OPERACION_CAJA',
                'oc.CAN_DEBE_MN',
                'oc.CAN_HABER_MN',
                'oc.CAN_DEBE_ME',
                'oc.CAN_HABER_ME',
                'oc.COD_CATEGORIA_MONEDA',

                'cb.TXT_CATEGORIA_MONEDA',
                'cb.TXT_CAJA_BANCO',

                'e.NOM_EMPR as nombre_empresa_origen',
                'ea.NRO_DOCUMENTO',
                'e.NOM_EMPR'
            )
            ->where('oc.TXT_REFERENCIA', $id)
            ->where('oc.COD_ITEM_MOVIMIENTO', 'IICHFI0000000025')
            ->first();

       
        if (!file_exists($rutaArchivo)) {

    
            if ($info->COD_CATEGORIA_MONEDA == "MON0000000000001") {
                // Moneda en Soles
                $importe = ($info->CAN_DEBE_MN != 0) ? $info->CAN_DEBE_MN : $info->CAN_HABER_MN;
                $textoImporte = NumeroALetras::convertir($importe, 'NUEVOS SOLES');
            } else {
                // Moneda en Dólares
                $importe = ($info->CAN_DEBE_ME != 0) ? $info->CAN_DEBE_ME : $info->CAN_HABER_ME;
                $textoImporte = NumeroALetras::convertir($importe, 'DÓLARES AMERICANOS');
            }

            $pdf = PDF::loadView('valerendir.firma.modal_firma', [
                'id'                          => $id,
                'txt_empr_afecta'             => $info->TXT_EMPR_AFECTA ?? '',
                'cod_cultivo_afecta'          => $info->COD_CULTIVO_AFECTA ?? '',
                'nro_cheque'                  => $info->NRO_CHEQUE ?? '',
                'txt_glosa'                   => $info->TXT_GLOSA ?? '',
                'nom_empr'                    => $info->NOM_EMPR ?? '',
                'fec_operacion'               => $info->FEC_OPERACION ?? '',
                'txt_descripcion'             => $info->TXT_DESCRIPCION ?? '',
                'can_debe_mn'                 => $info->CAN_DEBE_MN ?? '',
                'can_haber_mn'                => $info->CAN_HABER_MN ?? '',
                'can_debe_me'                 => $info->CAN_DEBE_ME ?? '',
                'can_haber_me'                => $info->CAN_HABER_ME ?? '',
                'cod_categoria_moneda'        => $info->COD_CATEGORIA_MONEDA ?? '',
                'nro_doc'                     => $info->NRO_DOCUMENTO ?? '',
                'cod_operacion_caja'          => $info->COD_OPERACION_CAJA ?? '',
                'txt_categoria_medio_pago'    => $info->TXT_CATEGORIA_MEDIO_PAGO ?? '',
                'txt_categoria_operacion_caja'=> $info->TXT_CATEGORIA_OPERACION_CAJA ?? '',
                'txt_categoria_moneda'        => $info->TXT_CATEGORIA_MONEDA ?? '',
                'txt_caja_banco'              => $info->TXT_CAJA_BANCO ?? '',
                'texto_importe'               => $textoImporte
            ]);

            if (!file_exists(dirname($rutaArchivo))) {
                @mkdir(dirname($rutaArchivo), 0777, true);
            }

            $pdf->save($rutaArchivo);
        }

        $rutaWeb = str_replace('\\', '/', $rutaArchivo);
        $rutaCustom = "pdoc://" . $rutaWeb;

        return redirect()->away($rutaCustom);
    }
}


