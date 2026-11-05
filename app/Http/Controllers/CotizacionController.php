<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Proyecto;
use App\Models\Manzana;
use App\Models\Lote;
use App\Models\Cliente;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class CotizacionController extends Controller
{
    use UserTraits;

    public function actionListarCotizaciones($idopcion)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Cotizaciones y Proformas');

        $empresa_id = session('empresa_id');
        $cotizaciones = Cotizacion::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->with(['proyecto', 'lote.manzana', 'cliente', 'vendedor'])
            ->orderBy('id', 'desc')
            ->get();

        return View::make('pages.inmobiliaria.cotizaciones.listacotizaciones', [
            'cotizaciones' => $cotizaciones,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionCrearCotizacion($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Cotizador de Lotes en Tiempo Real');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'lote_id' => 'required|string|exists:lotes,id',
                'cliente_id' => 'required|string|exists:clientes,id',
                'vendedor_id' => 'nullable|string|exists:vendedores,id',
                'tipo_pago' => 'required|string|in:contado,credito',
                'precio_lote' => 'required|numeric|min:0',
                'descuento' => 'nullable|numeric|min:0',
                'precio_final' => 'required|numeric|min:0',
                'monto_inicial' => 'nullable|numeric|min:0',
                'numero_cuotas' => 'nullable|integer|min:1',
            ]);

            try {
                DB::beginTransaction();

                $idcotizacion = $this->user_CreateIdMaestra('cotizaciones');

                // Generar código correlativo COT-YYYY-XXXX
                $year = date('Y');
                $count = Cotizacion::where('empresa_id', $empresa_id)->whereYear('fecha_crea', $year)->count() + 1;
                $codigo = 'COT-' . $year . '-' . str_pad($count, 4, "0", STR_PAD_LEFT);

                $precioLote = (float)$request->input('precio_lote');
                $descuento = (float)$request->input('descuento', 0.00);
                $precioFinal = max(0, $precioLote - $descuento);
                $tipoPago = $request->input('tipo_pago', 'credito');

                $montoInicial = $tipoPago === 'contado' ? $precioFinal : (float)$request->input('monto_inicial', 0.00);
                $saldoFinanciar = $tipoPago === 'contado' ? 0.00 : max(0, $precioFinal - $montoInicial);
                $numeroCuotas = $tipoPago === 'contado' ? 1 : max(1, (int)$request->input('numero_cuotas', 1));
                $montoCuota = $numeroCuotas > 0 && $saldoFinanciar > 0 ? round($saldoFinanciar / $numeroCuotas, 2) : 0.00;

                $cotizacion = new Cotizacion();
                $cotizacion->id = $idcotizacion;
                $cotizacion->empresa_id = $empresa_id;
                $cotizacion->codigo_cotizacion = $codigo;
                $cotizacion->proyecto_id = $request->input('proyecto_id');
                $cotizacion->lote_id = $request->input('lote_id');
                $cotizacion->cliente_id = $request->input('cliente_id');
                $cotizacion->vendedor_id = $request->input('vendedor_id');
                $cotizacion->tipo_pago = $tipoPago;
                $cotizacion->precio_lote = $precioLote;
                $cotizacion->descuento = $descuento;
                $cotizacion->precio_final = $precioFinal;
                $cotizacion->monto_inicial = $montoInicial;
                $cotizacion->saldo_financiar = $saldoFinanciar;
                $cotizacion->numero_cuotas = $numeroCuotas;
                $cotizacion->monto_cuota_mensual = $montoCuota;
                $cotizacion->fecha_emision = date('Y-m-d');
                $cotizacion->fecha_vencimiento = date('Y-m-d', strtotime('+15 days'));
                $cotizacion->estado = 'pendiente';
                $cotizacion->observaciones = $request->input('observaciones');
                $cotizacion->activo = 1;
                $cotizacion->usuario_crea = session('usuario')->id;
                $cotizacion->fecha_crea = date('Y-m-d H:i:s');
                $cotizacion->save();

                DB::commit();

                return redirect()->to('/gestion-de-cotizaciones/' . $idopcion)
                    ->with('bienhecho', 'Cotización ' . $cotizacion->codigo_cotizacion . ' generada con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al guardar cotización: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre', 'asc')->get();
        $clientes = Cliente::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre_razon_social', 'asc')->get();
        $vendedores = Vendedor::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre', 'asc')->get();

        return View::make('pages.inmobiliaria.cotizaciones.form.crearcotizacion', [
            'idopcion' => $idopcion,
            'proyectos' => $proyectos,
            'clientes' => $clientes,
            'vendedores' => $vendedores,
            'lote_id_selected' => $request->get('lote_id'),
        ]);
    }

    public function actionVerCotizacion($idopcion, $idcotizacion)
    {
        $empresa_id = session('empresa_id');
        $idCotizacionReal = $this->user_decodificarmaestra($idcotizacion);

        $cotizacion = Cotizacion::where('id', $idCotizacionReal)
            ->where('empresa_id', $empresa_id)
            ->with(['proyecto', 'lote.manzana', 'cliente', 'vendedor', 'empresa'])
            ->first();

        if (!$cotizacion) {
            return redirect()->back()->with('errorbd', 'Cotización no encontrada.');
        }

        return View::make('pages.inmobiliaria.cotizaciones.proforma', [
            'cotizacion' => $cotizacion,
            'idopcion' => $idopcion,
        ]);
    }
}
