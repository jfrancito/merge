<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;


use Illuminate\Http\Request;
use App\Traits\EnviarCorreoVRGeneradoTraits;
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


class EnviarCorreoValeRendirDetalleImporteController extends Controller
{
    use EnviarCorreoVRDetalleImporteTraits;

    public function actionEnviarCorreoVRDetalleImporte(Request $request)
    {
      
    }

}



