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

trait EnviarCorreoVRApruebaTraits 
{
    public function enviarCorreoValeRendirAprueba($valerendir_id)
    {
        try {


            \Log::error("ingreso al envio ");
            \Log::info("Celda stop");

            $VALE_RENDIR = WEBValeRendir::where("ID", '=', $valerendir_id)->first();

            $emailTrabajador = DB::table('WEB.VALE_RENDIR as vr')
            ->join('STD.EMPRESA as emp', 'emp.COD_EMPR', '=', 'vr.COD_EMPR_CLIENTE')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.DNI', '=', 'emp.NRO_DOCUMENTO')
            ->where('vr.ID', $valerendir_id)
            ->select('tra.emailcorp', 'tra.centro_osiris_id')

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

            if (!$VALE_RENDIR) {
                \Log::error("No se encontró el vale con ID: " . $valerendir_id);
                return false;
            }

             $emailfrom = $emailTrabajador->emailcorp;
             $emailfromcentro = $emailTrabajador->centro_osiris_id;

            if ($emailfromcentro === 'CEN0000000000004') {
                $destinatarios = ["doris.delgado@induamerica.com.pe"];
                $copias = ["doris.delgado@induamerica.com.pe"]; 
            } elseif ($emailfromcentro === 'CEN0000000000006') {
                $destinatarios = ["diana.paredes@induamerica.com.pe"];
                $copias = ["diana.paredes@induamerica.com.pe"]; 
            } else {
                $destinatarios = ["tesoreria.cix@induamerica.com.pe"];
                $copias = [
                    $emailTrabajador->emailcorp,
                    'marley.sucse@induamerica.com.pe',
                    'diana.malca@induamerica.com.pe',
                    'karim.ramirez@induamerica.com.pe',
                    'franklin.llontop@induamerica.com.pe'
                ];
            }

            Mail::send('emails.emailvalerendiraprueba',
            ['vale' => $VALE_RENDIR],
            function ($message) use ($emailfrom, $emailTrabajador, $emailTrabajadorAutoriza, $emailTrabajadorAprueba, $nombreCompleto,  $destinatarios, $copias) {
                $message->from($emailfrom, $nombreCompleto)
                        ->to($destinatarios)
                        ->cc($copias)
                        ->subject('VALE RENDIR - INDUAMERICA');
            });

            return true;

        } catch (\Exception $ex) {
            \Log::error("Error al enviar correo: " . $ex->getMessage());
            return false;
        }
    }

}

