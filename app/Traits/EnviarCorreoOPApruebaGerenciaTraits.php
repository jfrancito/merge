<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

trait EnviarCorreoOPApruebaGerenciaTraits
{
    public function enviarCorreoOPApruebaGerencia($id_pedido)
    {
        try {
            // 1. Obtener datos del pedido
            $pedido = DB::table('WEB.ORDEN_PEDIDO')
                ->where('ID_PEDIDO', $id_pedido)
                ->first();

            if (!$pedido) {
                Log::error("No se encontró el pedido con ID: $id_pedido para envío de correo gerencia.");
                return false;
            }

            // 2. Validación: Si no existe gerente que aprueba, no se manda correo
            if (empty($pedido->COD_TRABAJADOR_APRUEBA_GER) || empty($pedido->TXT_TRABAJADOR_APRUEBA_GER)) {
                return false;
            }

            // 3. Obtener correos (emailcorp) de la tabla ListaplatrabajadoresGenereal
            $emailGerencia = DB::table('WEB.ListaplatrabajadoresGenereal')
                ->where('COD_TRAB', $pedido->COD_TRABAJADOR_APRUEBA_GER)
                ->value('emailcorp');

            $emailSolicita = DB::table('WEB.ListaplatrabajadoresGenereal')
                ->where('COD_TRAB', $pedido->COD_TRABAJADOR_SOLICITA)
                ->value('emailcorp');

            $destinatarios = [];
            if ($emailGerencia && !empty(trim($emailGerencia))) {
                $destinatarios[] = trim($emailGerencia);
            }
            if ($emailSolicita && !empty(trim($emailSolicita)) && !in_array(trim($emailSolicita), $destinatarios)) {
                $destinatarios[] = trim($emailSolicita);
            }

            // Si no hay emails válidos, abortar
            if (empty($destinatarios)) {
                Log::warning("No se encontraron correos válidos para aprobación gerencia OP: $id_pedido");
                return false;
            }

            // 4. Preparar datos para la vista
            $data = [
                'manager_name' => $pedido->TXT_TRABAJADOR_APRUEBA_GER,
                'pedido_id' => $pedido->ID_PEDIDO,
                'solicita_name' => $pedido->TXT_TRABAJADOR_SOLICITA,
                'glosa' => $pedido->TXT_GLOSA
            ];

            $subject = "ORDEN DE PEDIDO - POR APROBAR GERENCIA - " . $pedido->ID_PEDIDO;

            // 5. Enviar el correo
            Mail::send('emails.notificacion_aprueba_gerencia', $data, function ($message) use ($destinatarios, $subject) {
                $message->from('alertassys@induamerica.com.pe', 'ORDEN DE PEDIDO')
                    ->to($destinatarios)
                    ->cc('alertacix@induamerica.com.pe')
                    ->subject($subject);
            });

            return true;

        }
        catch (\Exception $e) {
            Log::error("Error enviando correo de aprobación gerencia ($id_pedido): " . $e->getMessage());
            return false;
        }
    }
}
