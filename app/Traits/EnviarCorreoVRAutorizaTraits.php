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

            $emailTrabajador = DB::table('WEB.VALE_RENDIR as vr')
            ->join('STD.EMPRESA as emp', 'emp.COD_EMPR', '=', 'vr.COD_EMPR_CLIENTE')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.DNI', '=', 'emp.NRO_DOCUMENTO')
            ->where('vr.ID', $valerendir_id)
            ->value('tra.emailcorp');

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



            if (!$VALE_RENDIR) {
                \Log::error("No se encontró el vale con ID: " . $valerendir_id);
                return false;
            }
 $emailfrom = 'fllontopcr@unprg.edu.pe';

       /*     $emailfrom = $emailTrabajador; // quien envía
            $email = $emailTrabajadorAutoriza;     // quien recibe

            Mail::send('emails.emailvalerendirautoriza',
                ['vale' => $VALE_RENDIR],
                function ($message) use ($email, $emailfrom) {
                    $message->from($emailfrom, "CORREO PRUEBA")->to($email);
                    $message->subject('VALE RENDIR - INDUAMERICA');
                });*/

            Mail::send('emails.emailvalerendirautoriza',
    ['vale' => $VALE_RENDIR],
    function ($message) use ($emailfrom, $emailTrabajador, $emailTrabajadorAutoriza, $emailTrabajadorAprueba) {
        $message->from($emailfrom, "CORREO PRUEBA")
                ->to($emailTrabajadorAutoriza) // destinatario principal - admin autoriza
                ->cc([$emailTrabajador, $emailTrabajadorAprueba]) // copia a estos dos
                ->subject('VALE RENDIR - INDUAMERICA');
    });


            return true;

        } catch (\Exception $ex) {
            \Log::error("Error al enviar correo: " . $ex->getMessage());
            return false;
        }
    }

}