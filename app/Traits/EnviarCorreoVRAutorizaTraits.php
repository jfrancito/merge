<?php

namespace App\Traits;

use App\WEBMaestro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\ALMCentro;
use App\Modelos\STDTrabajador;
use App\WEBRegla, App\STDEmpresa, APP\User, App\CMPCategoria;
use View;
use Session;
use Nexmo;
use PDO;

trait EnviarCorreoVRAutorizaTraits 
{
    public function enviarCorreoValeRendir($valerendir_id)
    {
        try {
            $VALE_RENDIR = WEBValeRendir::where("ID", '=', $valerendir_id)->first();

            $cod_personal_rendir = DB::table('WEB.VALE_RENDIR')
                ->where('ID', $valerendir_id)
                ->value('COD_PERSONAL_RENDIR');
            $centroVale = DB::table('WEB.VALE_RENDIR')
                ->where('ID', $valerendir_id)
                ->value('COD_CENTRO');


             /* =========================================================
               CORREOS Y NOMBRES - EMPRESA PRINCIPAL
            ========================================================= */

            $emailTrabajador = DB::table('WEB.VALE_RENDIR as vr')
            ->join('STD.EMPRESA as emp', 'emp.COD_EMPR', '=', 'vr.COD_EMPR_CLIENTE')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.DNI', '=', 'emp.NRO_DOCUMENTO')
            ->where('vr.ID', $valerendir_id)
            ->select('tra.emailcorp', 'tra.centro_osiris_id')
            ->first();

            $emailTrabajadorAutoriza = DB::table('WEB.VALE_RENDIR as vr')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.COD_TRAB', '=', 'vr.USUARIO_AUTORIZA')
            ->where('vr.ID', $valerendir_id)
            ->whereIn('tra.codempresa', ['PRMAECEN000000000003', 'PRMAECEN000000000004'])
            ->value('tra.emailcorp');

            $emailTrabajadorAprueba = DB::table('WEB.VALE_RENDIR as vr')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.COD_TRAB', '=', 'vr.USUARIO_APRUEBA')
            ->where('vr.ID', $valerendir_id)
            ->whereIn('tra.codempresa', ['PRMAECEN000000000003', 'PRMAECEN000000000004'])
            ->value('tra.emailcorp');

            $nombreTrabajador = DB::table('WEB.VALE_RENDIR as vr')
            ->join('STD.EMPRESA as emp', 'emp.COD_EMPR', '=', 'vr.COD_EMPR_CLIENTE')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.DNI', '=', 'emp.NRO_DOCUMENTO')
            ->where('vr.ID', $valerendir_id)
            ->select('tra.nombres', 'tra.apellidopaterno', 'tra.apellidomaterno', 'tra.emailcorp')
            ->first();

            $nombreCompleto = ucwords(strtolower("{$nombreTrabajador->nombres} {$nombreTrabajador->apellidopaterno} {$nombreTrabajador->apellidomaterno}"));

             /* =========================================================
               CORREOS Y NOMBRES - TERCEROS
            ========================================================= */

             $emailTrabajadorTercero = DB::table('WEB.VALE_RENDIR as vr')
                ->join('STD.EMPRESA as emp', 'emp.COD_EMPR', '=', 'vr.COD_EMPR_CLIENTE')
                ->join('STD.TRABAJADOR as tra', 'tra.NRO_DOCUMENTO', '=', 'emp.NRO_DOCUMENTO')
                ->whereIn('tra.COD_EMPR', ['IACHEM0000010394', 'IACHEM0000007086'])
                ->where('vr.ID', $valerendir_id)
                ->whereNotNull('tra.TXT_CORREO_ELECTRONICO')
                ->whereRaw("LTRIM(RTRIM(tra.TXT_CORREO_ELECTRONICO)) <> ''")
                ->value('tra.TXT_CORREO_ELECTRONICO');

            $nombreTrabajadorTercero = DB::table('WEB.VALE_RENDIR as vr')
                ->join('STD.EMPRESA as emp', 'emp.COD_EMPR', '=', 'vr.COD_EMPR_CLIENTE')
                ->join('STD.TRABAJADOR as tra', 'tra.NRO_DOCUMENTO', '=', 'emp.NRO_DOCUMENTO')
                ->whereIn('tra.COD_EMPR', ['IACHEM0000010394', 'IACHEM0000007086'])
                ->where('vr.ID', $valerendir_id)
                ->select('tra.TXT_NOMBRES', 'tra.TXT_APE_PATERNO', 'tra.TXT_APE_MATERNO')
                ->first();

            $nombreCompletoTercero = $nombreTrabajadorTercero 
                ? ucwords(strtolower("{$nombreTrabajadorTercero->TXT_NOMBRES} {$nombreTrabajadorTercero->TXT_APE_PATERNO} {$nombreTrabajadorTercero->TXT_APE_MATERNO}"))
                : null;

            $emailAutorizaTercero = DB::table('WEB.VALE_RENDIR as vr')
                ->join('STD.TRABAJADOR as tra', 'tra.COD_TRAB', '=', 'vr.USUARIO_AUTORIZA')
                ->whereIn('tra.COD_EMPR', ['IACHEM0000010394', 'IACHEM0000007086'])
                ->where('vr.ID', $valerendir_id)
                ->whereNotNull('tra.TXT_CORREO_ELECTRONICO')
                ->whereRaw("LTRIM(RTRIM(tra.TXT_CORREO_ELECTRONICO)) <> ''")
                ->value('tra.TXT_CORREO_ELECTRONICO');

             /* =========================================================
               ELECCIÓN SEGÚN TIPO DE PERSONAL
            ========================================================= */
            if ($cod_personal_rendir === 'TPR0000000000002') {
                $emailfrom = $emailTrabajadorTercero;
                $nombreFrom = $nombreCompletoTercero;
                $emailTo = $emailTrabajadorAutoriza;
                $emailfromcentro = $centroVale;

            } else {
                $emailfrom = $emailTrabajador->emailcorp;
                $nombreFrom = $nombreCompleto;
                $emailTo = $emailTrabajadorAutoriza;
                $emailfromcentro = $emailTrabajador->centro_osiris_id;
            }


            if (!$VALE_RENDIR) {
                \Log::error("No se encontró el vale con ID: " . $valerendir_id);
                return false;
            }
      

            if ($emailfromcentro === 'CEN0000000000004') {
                $destinatarios = ["doris.delgado@induamerica.com.pe"];
            } elseif ($emailfromcentro === 'CEN0000000000006') {
                $destinatarios = ["diana.paredes@induamerica.com.pe"];
            } elseif ($emailfromcentro === 'CEN0000000000002') {
                $destinatarios = ["lizbeth.marcas@induamerica.com.pe"];
            } else {
                $destinatarios = ["marley.sucse@induamerica.com.pe", "diana.malca@induamerica.com.pe"];
            }

            Mail::send('emails.emailvalerendirautoriza',
            ['vale' => $VALE_RENDIR],
            function ($message) use ($emailfrom, $nombreFrom, $emailTo, $destinatarios, $emailfromcentro) {
                $message->from($emailfrom, $nombreFrom)
                        ->to($destinatarios)
                        ->cc($emailTo)
                        ->subject('VALE RENDIR - INDUAMERICA');
            });


            return true;

        } catch (\Exception $ex) {
            \Log::error("Error al enviar correo: " . $ex->getMessage());
            return false;
        }
    }

}