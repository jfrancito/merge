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

trait EnviarCorreoVRDetalleDiasTraits 
{
    public function enviarCorreoValeRendirDetalleDias($valerendir_id)
    {
        try {


            \Log::error("ingreso al envio ");
            \Log::info("Celda stop");

            $VALE_RENDIR = WEBValeRendir::where("ID", '=', $valerendir_id)->first();
            // Detalles
            $detalles = WEBValeRendirDetalle::where("ID", $valerendir_id)->get();


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

            $nombreAprobador = DB::table('WEB.VALE_RENDIR as vr')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.COD_TRAB', '=', 'vr.USUARIO_APRUEBA')
            ->where('vr.ID', $valerendir_id)
            ->whereIn('tra.codempresa', ['PRMAECEN000000000003', 'PRMAECEN000000000004'])
            ->select('tra.nombres', 'tra.apellidopaterno', 'tra.apellidomaterno')
            ->first();


            $nombreTrabajador = DB::table('WEB.VALE_RENDIR as vr')
            ->join('STD.EMPRESA as emp', 'emp.COD_EMPR', '=', 'vr.COD_EMPR_CLIENTE')
            ->join('WEB.ListaplatrabajadoresGenereal as tra', 'tra.DNI', '=', 'emp.NRO_DOCUMENTO')
            ->where('vr.ID', $valerendir_id)
            ->select('tra.nombres', 'tra.apellidopaterno', 'tra.apellidomaterno', 'tra.emailcorp')
            ->first();

            $nombreCompleto = ucwords(strtolower("{$nombreTrabajador->nombres} {$nombreTrabajador->apellidopaterno} {$nombreTrabajador->apellidomaterno}"));
            $nombreCompletoAp = ucwords(strtolower("{$nombreAprobador->nombres} {$nombreAprobador->apellidopaterno} {$nombreAprobador->apellidomaterno}"));

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

            if (!$VALE_RENDIR) {
                \Log::error("No se encontró el vale con ID: " . $valerendir_id);
                return false;
            }

             /* =========================================================
               ELECCIÓN SEGÚN TIPO DE PERSONAL
            ========================================================= */
            if ($cod_personal_rendir === 'TPR0000000000002') {
                $emailfrom = $emailTrabajadorAprueba;
                $nombreFrom = $nombreCompletoAp;
                $emailTo = $emailTrabajadorTercero;
                $emailfromcentro = $centroVale;

            } else {
                $emailfrom = $emailTrabajadorAprueba;
                $nombreFrom = $nombreCompletoAp;
                $emailTo = $emailTrabajador->emailcorp;
                $emailfromcentro = $emailTrabajador->centro_osiris_id;
            }


            if ($emailfromcentro === 'CEN0000000000004') {
                if ($VALE_RENDIR->TIPO_PAGO == 1) {
                    $destinatarios = [
                           $emailTo
                    ];
                    $copias = [
                        $emailTrabajadorAutoriza,
                        'marley.sucse@induamerica.com.pe',
                        'diana.malca@induamerica.com.pe',
                        'franklin.llontop@induamerica.com.pe'
                    ];
                } else {
                    $destinatarios = [
                           $emailTo
                    ];
                     $copias = [
                        $emailTrabajadorAutoriza,
                        'marley.sucse@induamerica.com.pe',
                        'diana.malca@induamerica.com.pe',
                        'franklin.llontop@induamerica.com.pe'
                    ];
                }

            } elseif ($emailfromcentro === 'CEN0000000000006') {
                if ($VALE_RENDIR->TIPO_PAGO == 1) {
                    $destinatarios = [
                           $emailTo
                    ];

                    $copias = [
                        $emailTrabajadorAutoriza,
                        'marley.sucse@induamerica.com.pe',
                        'diana.malca@induamerica.com.pe',
                        'franklin.llontop@induamerica.com.pe'
                    ];
                } else {
                    $destinatarios = [
                           $emailTo
                    ];

                    $copias = [
                        $emailTrabajadorAutoriza,
                        'marley.sucse@induamerica.com.pe',
                        'diana.malca@induamerica.com.pe',
                        'franklin.llontop@induamerica.com.pe'
                    ];
                }

            } elseif ($emailfromcentro === 'CEN0000000000002') {
                if ($VALE_RENDIR->TIPO_PAGO == 1) {
                    $destinatarios = [
                           $emailTo
                    ];

                    $copias = [
                        $emailTrabajadorAutoriza,
                        'marley.sucse@induamerica.com.pe',
                        'diana.malca@induamerica.com.pe',
                        'franklin.llontop@induamerica.com.pe'
                    ];
                } else {
                    $destinatarios = [
                           $emailTo
                    ];
                    $copias = [
                        $emailTrabajadorAutoriza,
                        'marley.sucse@induamerica.com.pe',
                        'diana.malca@induamerica.com.pe',
                        'franklin.llontop@induamerica.com.pe'
                    ];
                }

            } else {
                    $destinatarios = [
                           $emailTo
                    ];

                    $copias = [
                        $emailTrabajadorAutoriza,
                        'marley.sucse@induamerica.com.pe',
                        'diana.malca@induamerica.com.pe',
                        'franklin.llontop@induamerica.com.pe'
                    ];
            }

            Mail::send('emails.emailvalerendiraprueba',
            [
                'vale' => $VALE_RENDIR,
                'detalles' => $detalles,
            ],
            function ($message) use ($emailfrom, $nombreFrom,  $destinatarios, $copias,  $emailfromcentro) {
                $message->from($emailfrom, $nombreFrom)
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