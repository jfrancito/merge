<?php

namespace App\Http\Controllers;

use App\Traits\AsientoTraits;
use Illuminate\Http\Request;
use View;
use Session;
use App\Traits\GeneralesTraits;

class GestionComprobantesContabilidadController extends Controller
{
    use GeneralesTraits;
    use AsientoTraits;
    public function actionGestionComprobantesContabilidad($idopcion)
    {
        $funcion = $this;
        $titulo = 'Gestion Comprobantes Contabilidad';
        $mes_defecto = date('m', strtotime($this->fechaactual));

        $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
        $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
        $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($this->anio, $mes_defecto, Session::get('empresas')->COD_EMPR);
        $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($this->anio, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
        $periodo_defecto = $array_periodo_pc->COD_PERIODO;

        return View::make('comprobante/listacontabilidadasientos',
            [
                'funcion' => $funcion,
                'titulo' => $titulo,
                'idopcion' => $idopcion,
                // Agregando las nuevas variables a la vista
                'array_anio' => $combo_anio_pc,
                'array_periodo' => $combo_periodo,
                'periodo_defecto' => $periodo_defecto,
                'anio_defecto' => $this->anio,
            ]);
    }

    public function actionListarComprobantesContabilidad(Request $request)
    {
        $COD_PERIODO = $request['cod_periodo'];
        $COD_EMPR = Session::get('empresas')->COD_EMPR;
        $asientos = json_encode($this->lista_asientos_fe($COD_EMPR, $COD_PERIODO));
        return $asientos;
    }
}
