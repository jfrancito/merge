<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

trait EnviarCorreoOPTerminadoTraits
{
    public function enviarCorreoOrdenPedidoTerminado($id_pedido)
    {
        try {
            // Obtener datos del pedido
            $pedido = DB::table('WEB.ORDEN_PEDIDO')
                ->where('ID_PEDIDO', $id_pedido)
                ->first();

            if (!$pedido) {
                Log::error("No se encontró el pedido con ID: $id_pedido");
                return false;
            }

            // Obtener correo del solicitante (emailcorp)
            $emailSolicita = DB::table('WEB.ListaplatrabajadoresGenereal')
                ->where('COD_TRAB', $pedido->COD_TRABAJADOR_SOLICITA)
                ->value('emailcorp');

            // Obtener correo del autorizador (emailcorp)
            $emailAutoriza = DB::table('WEB.ListaplatrabajadoresGenereal')
                ->where('COD_TRAB', $pedido->COD_TRABAJADOR_AUTORIZA)
                ->value('emailcorp');

            $correos = [];
            if ($emailSolicita && !empty(trim($emailSolicita))) {
                $correos[] = trim($emailSolicita);
            }
            if ($emailAutoriza && !empty(trim($emailAutoriza)) && trim($emailAutoriza) != trim($emailSolicita)) {
                $correos[] = trim($emailAutoriza);
            }

            if (empty($correos)) {
                Log::warning("No se encontraron correos válidos para el pedido: $id_pedido (Solicita: $emailSolicita, Autoriza: $emailAutoriza)");
                return false;
            }

            $subject = 'ORDEN DE PEDIDO TERMINADA - ' . $pedido->ID_PEDIDO;

            // Enviar correo
            Mail::send('emails.emailordenpedidoterminado',
            ['pedido' => $pedido],
                function ($message) use ($correos, $subject) {
                $message->from('alertassys@induamerica.com.pe', 'RECOJO ORDEN DE PEDIDO')
                    ->to($correos)
                    ->cc('alertacix@induamerica.com.pe')
                    ->subject($subject);
            });

            return true;

        }
        catch (\Exception $ex) {
            Log::error("Error al enviar correo de OP Terminado ($id_pedido): " . $ex->getMessage());
            return false;
        }
    }
}
