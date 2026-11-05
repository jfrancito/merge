<?php

namespace App\Http\Controllers;

use App\Models\VentaLote;
use App\Models\CuotaCronograma;
use App\Models\Proyecto;
use App\Models\Lote;
use App\Models\Cliente;
use App\Models\Vendedor;
use App\Models\Reserva;
use App\Models\PagoCuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class VentaController extends Controller
{
    use UserTraits;

    public function actionListarVentas($idopcion)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Contratos de Venta de Lotes');

        $empresa_id = session('empresa_id');
        $ventas = VentaLote::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->with(['proyecto', 'lote.manzana', 'cliente', 'vendedor', 'cuotas'])
            ->orderBy('id', 'desc')
            ->get();

        return View::make('pages.inmobiliaria.ventas.listaventas', [
            'ventas' => $ventas,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionCrearVenta($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Formalizar Venta de Lote');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'lote_id' => 'required|string|exists:lotes,id',
                'cliente_id' => 'required|string|exists:clientes,id',
                'vendedor_id' => 'nullable|string|exists:vendedores,id',
                'tipo_venta' => 'required|string|in:contado,credito',
                'precio_lote' => 'required|numeric|min:1',
                'descuento' => 'nullable|numeric|min:0',
                'precio_final' => 'required|numeric|min:1',
                'monto_inicial' => 'nullable|numeric|min:0',
                'numero_cuotas' => 'nullable|integer|min:1',
                'dia_pago_mensual' => 'nullable|integer|min:1|max:31',
                'fecha_primer_vencimiento' => 'nullable|date',
                'fecha_venta' => 'required|date',
            ]);

            $lote = Lote::find($request->input('lote_id'));
            if ($lote->estado === 'vendido') {
                return redirect()->back()->withInput()->with('errorbd', 'Este lote ya se encuentra registrado como Vendido.');
            }

            try {
                DB::beginTransaction();

                $idventa = $this->user_CreateIdMaestra('ventas_lotes');

                $year = date('Y');
                $count = VentaLote::where('empresa_id', $empresa_id)->whereYear('fecha_crea', $year)->count() + 1;
                $codigoContrato = 'CTR-' . $year . '-' . str_pad($count, 4, "0", STR_PAD_LEFT);

                $precioLote = (float)$request->input('precio_lote');
                $descuento = (float)$request->input('descuento', 0.00);
                $precioFinal = max(0, $precioLote - $descuento);
                $tipoVenta = $request->input('tipo_venta', 'credito');

                $montoInicial = $tipoVenta === 'contado' ? $precioFinal : (float)$request->input('monto_inicial', 0.00);
                $saldoFinanciar = $tipoVenta === 'contado' ? 0.00 : max(0, $precioFinal - $montoInicial);
                $numeroCuotas = $tipoVenta === 'contado' ? 1 : max(1, (int)$request->input('numero_cuotas', 1));
                $montoCuota = $numeroCuotas > 0 && $saldoFinanciar > 0 ? round($saldoFinanciar / $numeroCuotas, 2) : 0.00;

                $diaPago = (int)$request->input('dia_pago_mensual', 15);
                $primerVencimiento = $request->input('fecha_primer_vencimiento') ?: date('Y-m-d', strtotime('+1 month'));

                $venta = new VentaLote();
                $venta->id = $idventa;
                $venta->empresa_id = $empresa_id;
                $venta->codigo_contrato = $codigoContrato;
                $venta->proyecto_id = $request->input('proyecto_id');
                $venta->lote_id = $request->input('lote_id');
                $venta->cliente_id = $request->input('cliente_id');
                $venta->vendedor_id = $request->input('vendedor_id');
                $venta->reserva_id = $request->input('reserva_id');
                $venta->tipo_venta = $tipoVenta;
                $venta->precio_lote = $precioLote;
                $venta->descuento = $descuento;
                $venta->precio_final = $precioFinal;
                $venta->monto_inicial = $montoInicial;
                $venta->saldo_financiar = $saldoFinanciar;
                $venta->numero_cuotas = $numeroCuotas;
                $venta->monto_cuota_mensual = $montoCuota;
                $venta->dia_pago_mensual = $diaPago;
                $venta->fecha_primer_vencimiento = $primerVencimiento;
                $venta->fecha_venta = $request->input('fecha_venta');
                $venta->estado = $tipoVenta === 'contado' ? 'cancelado_total' : 'activo';
                $venta->clausulas_adicionales = $request->input('clausulas_adicionales');
                $venta->activo = 1;
                $venta->usuario_crea = session('usuario')->id;
                $venta->fecha_crea = date('Y-m-d H:i:s');
                $venta->save();

                // 2. GENERAR CRONOGRAMA DE CUOTAS
                if ($tipoVenta === 'contado') {
                    // Cuota única pagada
                    $idCuota = $this->user_CreateIdMaestra('cuotas_cronograma');
                    $cuota = new CuotaCronograma();
                    $cuota->id = $idCuota;
                    $cuota->empresa_id = $empresa_id;
                    $cuota->venta_id = $idventa;
                    $cuota->numero_cuota = 1;
                    $cuota->descripcion = 'Pago Total Contado';
                    $cuota->fecha_vencimiento = $venta->fecha_venta;
                    $cuota->monto_cuota = $precioFinal;
                    $cuota->monto_pagado = $precioFinal;
                    $cuota->saldo_pendiente = 0.00;
                    $cuota->estado = 'pagado';
                    $cuota->fecha_ultimo_pago = $venta->fecha_venta;
                    $cuota->activo = 1;
                    $cuota->fecha_crea = date('Y-m-d H:i:s');
                    $cuota->save();

                    // Emitir Recibo de Pago en Caja por Contado
                    $idPago = $this->user_CreateIdMaestra('pagos_cuotas');
                    $year = date('Y');
                    $count = PagoCuota::where('empresa_id', $empresa_id)->whereYear('fecha_crea', $year)->count() + 1;
                    $codigoRecibo = 'REC-' . $year . '-' . str_pad($count, 5, "0", STR_PAD_LEFT);

                    $pago = new PagoCuota();
                    $pago->id = $idPago;
                    $pago->empresa_id = $empresa_id;
                    $pago->venta_id = $idventa;
                    $pago->cuota_id = $idCuota;
                    $pago->codigo_recibo = $codigoRecibo;
                    $pago->monto_pagado = $precioFinal;
                    $pago->mora_pagada = 0.00;
                    $pago->fecha_pago = $venta->fecha_venta;
                    $pago->metodo_pago = $request->input('metodo_pago', 'transferencia');
                    $pago->banco_destino = $request->input('banco_destino');
                    $pago->numero_operacion = $request->input('numero_operacion');
                    $pago->observaciones = 'Cancelación Total por Venta al Contado';
                    $pago->activo = 1;
                    $pago->usuario_crea = session('usuario')->id;
                    $pago->fecha_crea = date('Y-m-d H:i:s');
                    $pago->save();

                } else {
                    // Si hubo cuota inicial, crear cuota 0 pagada y su recibo
                    if ($montoInicial > 0) {
                        $idCuota0 = $this->user_CreateIdMaestra('cuotas_cronograma');
                        $cuota0 = new CuotaCronograma();
                        $cuota0->id = $idCuota0;
                        $cuota0->empresa_id = $empresa_id;
                        $cuota0->venta_id = $idventa;
                        $cuota0->numero_cuota = 0;
                        $cuota0->descripcion = 'Cuota Inicial';
                        $cuota0->fecha_vencimiento = $venta->fecha_venta;
                        $cuota0->monto_cuota = $montoInicial;
                        $cuota0->monto_pagado = $montoInicial;
                        $cuota0->saldo_pendiente = 0.00;
                        $cuota0->estado = 'pagado';
                        $cuota0->fecha_ultimo_pago = $venta->fecha_venta;
                        $cuota0->activo = 1;
                        $cuota0->fecha_crea = date('Y-m-d H:i:s');
                        $cuota0->save();

                        // Emitir Recibo de Pago en Caja por Cuota Inicial
                        $idPago = $this->user_CreateIdMaestra('pagos_cuotas');
                        $year = date('Y');
                        $count = PagoCuota::where('empresa_id', $empresa_id)->whereYear('fecha_crea', $year)->count() + 1;
                        $codigoRecibo = 'REC-' . $year . '-' . str_pad($count, 5, "0", STR_PAD_LEFT);

                        $pago = new PagoCuota();
                        $pago->id = $idPago;
                        $pago->empresa_id = $empresa_id;
                        $pago->venta_id = $idventa;
                        $pago->cuota_id = $idCuota0;
                        $pago->codigo_recibo = $codigoRecibo;
                        $pago->monto_pagado = $montoInicial;
                        $pago->mora_pagada = 0.00;
                        $pago->fecha_pago = $venta->fecha_venta;
                        $pago->metodo_pago = $request->input('metodo_pago', 'transferencia');
                        $pago->banco_destino = $request->input('banco_destino');
                        $pago->numero_operacion = $request->input('numero_operacion');
                        $pago->observaciones = 'Pago de Cuota Inicial de Contrato ' . $venta->codigo_contrato;
                        $pago->activo = 1;
                        $pago->usuario_crea = session('usuario')->id;
                        $pago->fecha_crea = date('Y-m-d H:i:s');
                        $pago->save();
                    }

                    // Cuotas mensuales 1 a N
                    $fechaBase = new \DateTime($primerVencimiento);
                    for ($n = 1; $n <= $numeroCuotas; $n++) {
                        $fechaVenc = clone $fechaBase;
                        if ($n > 1) {
                            $fechaVenc->modify('+' . ($n - 1) . ' month');
                        }

                        $idCuotaN = $this->user_CreateIdMaestra('cuotas_cronograma');
                        $cuotaN = new CuotaCronograma();
                        $cuotaN->id = $idCuotaN;
                        $cuotaN->empresa_id = $empresa_id;
                        $cuotaN->venta_id = $idventa;
                        $cuotaN->numero_cuota = $n;
                        $cuotaN->descripcion = "Cuota $n de $numeroCuotas";
                        $cuotaN->fecha_vencimiento = $fechaVenc->format('Y-m-d');
                        $cuotaN->monto_cuota = $montoCuota;
                        $cuotaN->monto_pagado = 0.00;
                        $cuotaN->saldo_pendiente = $montoCuota;
                        $cuotaN->estado = 'pendiente';
                        $cuotaN->activo = 1;
                        $cuotaN->fecha_crea = date('Y-m-d H:i:s');
                        $cuotaN->save();
                    }
                }

                // 3. Cambiar estado del lote a 'vendido'
                $lote->estado = 'vendido';
                $lote->save();

                // 4. Si viene de reserva, marcar como cerrada
                if ($venta->reserva_id) {
                    $res = Reserva::find($venta->reserva_id);
                    if ($res) {
                        $res->estado = 'convertida_a_venta';
                        $res->save();
                    }
                }

                DB::commit();

                return redirect()->to('/gestion-de-ventas/' . $idopcion)
                    ->with('bienhecho', 'Venta y Contrato ' . $venta->codigo_contrato . ' generados exitosamente con su cronograma de cuotas.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al procesar la venta: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre', 'asc')->get();
        $clientes = Cliente::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre_razon_social', 'asc')->get();
        $vendedores = Vendedor::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre', 'asc')->get();

        return View::make('pages.inmobiliaria.ventas.form.crearventa', [
            'idopcion' => $idopcion,
            'proyectos' => $proyectos,
            'clientes' => $clientes,
            'vendedores' => $vendedores,
            'lote_id_selected' => $request->get('lote_id'),
            'reserva_id_selected' => $request->get('reserva_id'),
        ]);
    }

    public function actionVerVenta($idopcion, $idventa)
    {
        $empresa_id = session('empresa_id');
        $idVentaReal = $this->user_decodificarmaestra($idventa);

        $venta = VentaLote::where('id', $idVentaReal)
            ->where('empresa_id', $empresa_id)
            ->with(['proyecto', 'lote.manzana', 'cliente', 'vendedor', 'cuotas.pagos', 'empresa'])
            ->first();

        if (!$venta) {
            return redirect()->back()->with('errorbd', 'Venta no encontrada.');
        }

        return View::make('pages.inmobiliaria.ventas.detalleventa', [
            'venta' => $venta,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionImprimirContrato($idopcion, $idventa)
    {
        $empresa_id = session('empresa_id');
        $idVentaReal = $this->user_decodificarmaestra($idventa);

        $venta = VentaLote::where('id', $idVentaReal)
            ->where('empresa_id', $empresa_id)
            ->with(['proyecto', 'lote.manzana', 'cliente', 'vendedor', 'cuotas', 'empresa'])
            ->first();

        if (!$venta) {
            return redirect()->back()->with('errorbd', 'Venta no encontrada.');
        }

        return View::make('pages.inmobiliaria.ventas.contratodocumento', [
            'venta' => $venta,
            'idopcion' => $idopcion,
        ]);
    }
}
