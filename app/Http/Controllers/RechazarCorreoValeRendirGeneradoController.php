<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;


use Illuminate\Http\Request;
use App\Traits\RechazarCorreoVRGeneradoTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, App\STDEmpresa, APP\User, App\CMPCategoria;
use View;
use Validator;


class RechazarCorreoValeRendirGeneradoController extends Controller
{
    use RechazarCorreoVRGeneradoTraits;

    /*public function actionRechazarCorreoVRGenerado(Request $request)
    {
        $valerendir_id = $request->input('valerendir_id');

        if (!$valerendir_id) {
            return response()->json(['success' => false, 'message' => 'ID del vale no recibido.']);
        }

        $vale = WEBValeRendir::where('ID', $valerendir_id)->first();
        if (!$vale) {
            return response()->json(['success' => false, 'message' => 'Vale no encontrado.']);
        }

        $exito = $this->RechazarCorreoValeRendirGenerado($valerendir_id);
        return response()->json(['success' => $exito]);
    }
*/
}



