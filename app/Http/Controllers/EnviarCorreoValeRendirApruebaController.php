<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;


use Illuminate\Http\Request;
use App\Traits\EnviarCorreoVRApruebaTraits;
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


class EnviarCorreoValeRendirApruebaController extends Controller
{
    use EnviarCorreoVRApruebaTraits;

    public function actionEnviarCorreoVRAprueba(Request $request)
    {
        $valerendir_id = $request->input('valerendir_id');

        if (!$valerendir_id) {
            return response()->json(['success' => false, 'message' => 'ID del vale no recibido.']);
        }

        $vale = WEBValeRendir::where('ID', $valerendir_id)->first();
        if (!$vale) {
            return response()->json(['success' => false, 'message' => 'Vale no encontrado.']);
        }

        $exito = $this->enviarCorreoValeRendirAprueba($valerendir_id);
        return response()->json(['success' => $exito]);
    }

}



