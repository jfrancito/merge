<?php

namespace App\Http\Controllers;

use App\Models\CuotaCronograma;
use App\Models\PagoCuota;
use App\Models\VentaLote;
use App\Models\Proyecto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class CobranzaController extends Controller
{
    use UserTraits;

    public function actionListarCobranzas($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Caja y Cobranzas de Cuotas');

        $empresa_id = session('empresa_id');
        $buscar = trim($request->get('buscar'));
        $estado = $request->get('estado', 'pendiente');

        $query = CuotaCronograma::where('cuotas_cronograma.empresa_id', $empresa_id)
            ->where('cuotas_cronograma.activo', 1)
            ->join('ventas_lotes', 'ventas_lotes.id', '=', 'cuotas_cronograma.venta_id')
            ->join('clientes', 'clientes.id', '=', 'ventas_lotes.cliente_id')
            ->join('lotes', 'lotes.id', '=', 'ventas_lotes.lote_id')
            ->join('manzanas', 'manzanas.id', '=', 'lotes.manzana_id')
            ->join('proyectos', 'proyectos.id', '=', 'ventas_lotes.proyecto_id')
            ->select(
                'cuotas_cronograma.*',
                'ventas_lotes.codigo_contrato',
                'clientes.nombre_razon_social',
                'clientes.apellidos as cliente_apellidos',
                'clientes.numero_documento as cliente_dni',
                'clientes.telefono as cliente_telefono',
                'lotes.numero_lote',
                'manzanas.nombre as manzana_nombre',
                'proyectos.nombre as proyecto_nombre',
                'proyectos.moneda as proyecto_moneda'
            );

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('clientes.numero_documento', 'LIKE', "%{$buscar}%")
                    ->orWhere('clientes.nombre_razon_social', 'ILIKE', "%{$buscar}%")
                    ->orWhere('clientes.apellidos', 'ILIKE', "%{$buscar}%")
                    ->orWhere('ventas_lotes.codigo_contrato', 'ILIKE', "%{$buscar}%")
                    ->orWhere('lotes.numero_lote', 'LIKE', "%{$buscar}%");
            });
        }

        $hoy = date('Y-m-d');
        if ($estado === 'vencido') {
            $query->where('cuotas_cronograma.estado', '!=', 'pagado')
                ->where('cuotas_cronograma.fecha_vencimiento', '<', $hoy);
        } elseif ($estado === 'pendiente') {
            $query->where('cuotas_cronograma.estado', '!=', 'pagado');
        } elseif ($estado === 'pagado') {
            $query->where('cuotas_cronograma.estado', 'pagado');
        }

        $cuotas = $query->orderBy('cuotas_cronograma.fecha_vencimiento', 'asc')
            ->limit(150)
            ->get();

        // Pagos recientes para la pestaña de historial
        $pagosRecientes = PagoCuota::where('pagos_cuotas.empresa_id', $empresa_id)
            ->where('pagos_cuotas.activo', 1)
            ->with(['venta.cliente', 'venta.lote.manzana', 'cuota'])
            ->orderBy('pagos_cuotas.id', 'desc')
            ->limit(30)
            ->get();

        return View::make('pages.inmobiliaria.cobranzas.listacobranzas', [
            'cuotas' => $cuotas,
            'pagosRecientes' => $pagosRecientes,
            'buscar' => $buscar,
            'estado' => $estado,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionRegistrarPagoCuota($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        $request->validate([
            'cuota_id' => 'required|string|exists:cuotas_cronograma,id',
            'monto_pagar' => 'required|numeric|min:0.01',
            'mora' => 'nullable|numeric|min:0',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
            'voucher_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,pdf|max:3072',
        ]);

        $empresa_id = session('empresa_id');
        $cuota = CuotaCronograma::where('id', $request->input('cuota_id'))
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$cuota) {
            return redirect()->back()->with('errorbd', 'Cuota no encontrada.');
        }

        try {
            DB::beginTransaction();

            $idpago = $this->user_CreateIdMaestra('pagos_cuotas');

            $year = date('Y');
            $count = PagoCuota::where('empresa_id', $empresa_id)->whereYear('fecha_crea', $year)->count() + 1;
            $codigoRecibo = 'REC-' . $year . '-' . str_pad($count, 5, "0", STR_PAD_LEFT);

            $montoPagar = (float)$request->input('monto_pagar');
            $mora = (float)$request->input('mora', 0.00);

            $voucherPath = null;
            if ($request->hasFile('voucher_foto')) {
                $voucherPath = $request->file('voucher_foto')->store('vouchers', 'public');
            }

            // 1. Registrar pago
            $pago = new PagoCuota();
            $pago->id = $idpago;
            $pago->empresa_id = $empresa_id;
            $pago->venta_id = $cuota->venta_id;
            $pago->cuota_id = $cuota->id;
            $pago->codigo_recibo = $codigoRecibo;
            $pago->monto_pagado = $montoPagar;
            $pago->mora_pagada = $mora;
            $pago->fecha_pago = $request->input('fecha_pago');
            $pago->metodo_pago = $request->input('metodo_pago');
            $pago->banco_destino = $request->input('banco_destino');
            $pago->numero_operacion = $request->input('numero_operacion');
            $pago->voucher_foto = $voucherPath;
            $pago->observaciones = $request->input('observaciones');
            $pago->activo = 1;
            $pago->usuario_crea = session('usuario')->id;
            $pago->fecha_crea = date('Y-m-d H:i:s');
            $pago->save();

            // 2. Actualizar Cuota
            $nuevoTotalPagado = $cuota->monto_pagado + $montoPagar;
            $nuevoSaldo = max(0, $cuota->monto_cuota - $nuevoTotalPagado);

            $cuota->monto_pagado = $nuevoTotalPagado;
            $cuota->saldo_pendiente = $nuevoSaldo;
            $cuota->monto_mora = $mora;
            $cuota->fecha_ultimo_pago = $request->input('fecha_pago');
            $cuota->estado = $nuevoSaldo <= 0 ? 'pagado' : 'parcial';
            $cuota->fecha_modifica = date('Y-m-d H:i:s');
            $cuota->save();

            // 3. Si todas las cuotas de la venta están pagadas, marcar venta como 'cancelado_total'
            $venta = VentaLote::find($cuota->venta_id);
            if ($venta) {
                $cuotasPendientes = CuotaCronograma::where('venta_id', $venta->id)
                    ->where('estado', '!=', 'pagado')
                    ->count();

                if ($cuotasPendientes === 0) {
                    $venta->estado = 'cancelado_total';
                    $venta->save();
                }
            }

            DB::commit();

            return redirect()->back()->with('bienhecho', 'Pago registrado con éxito. Recibo N° ' . $codigoRecibo);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errorbd', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function actionVerRecibo($idopcion, $idpago)
    {
        $empresa_id = session('empresa_id');
        $idPagoReal = $this->user_decodificarmaestra($idpago);

        $pago = PagoCuota::where('id', $idPagoReal)
            ->where('empresa_id', $empresa_id)
            ->with(['venta.cliente', 'venta.lote.manzana', 'venta.proyecto', 'cuota', 'venta.empresa'])
            ->first();

        if (!$pago) {
            return redirect()->back()->with('errorbd', 'Recibo de pago no encontrado.');
        }

        return View::make('pages.inmobiliaria.cobranzas.recibopago', [
            'pago' => $pago,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionReporteMorosidad($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Reporte de Morosidad (Cartera Pesada)');

        $empresa_id = session('empresa_id');
        $hoy = date('Y-m-d');

        $cuotasVencidas = CuotaCronograma::where('cuotas_cronograma.empresa_id', $empresa_id)
            ->where('cuotas_cronograma.activo', 1)
            ->where('cuotas_cronograma.estado', '!=', 'pagado')
            ->where('cuotas_cronograma.fecha_vencimiento', '<', $hoy)
            ->join('ventas_lotes', 'ventas_lotes.id', '=', 'cuotas_cronograma.venta_id')
            ->join('clientes', 'clientes.id', '=', 'ventas_lotes.cliente_id')
            ->join('lotes', 'lotes.id', '=', 'ventas_lotes.lote_id')
            ->join('manzanas', 'manzanas.id', '=', 'lotes.manzana_id')
            ->join('proyectos', 'proyectos.id', '=', 'ventas_lotes.proyecto_id')
            ->select(
                'cuotas_cronograma.*',
                DB::raw("(CURRENT_DATE - cuotas_cronograma.fecha_vencimiento) as dias_mora"),
                'ventas_lotes.codigo_contrato',
                'clientes.nombre_razon_social',
                'clientes.apellidos as cliente_apellidos',
                'clientes.numero_documento as cliente_dni',
                'clientes.telefono as cliente_telefono',
                'lotes.numero_lote',
                'manzanas.nombre as manzana_nombre',
                'proyectos.nombre as proyecto_nombre',
                'proyectos.moneda as proyecto_moneda'
            )
            ->orderBy('dias_mora', 'desc')
            ->get();

        $resumenMora = [
            'total_deuda' => $cuotasVencidas->sum('saldo_pendiente'),
            'total_cuotas_vencidas' => $cuotasVencidas->count(),
            'clientes_unicos' => $cuotasVencidas->pluck('cliente_dni')->unique()->count(),
            'mora_1_30' => $cuotasVencidas->whereBetween('dias_mora', [1, 30])->sum('saldo_pendiente'),
            'mora_31_60' => $cuotasVencidas->whereBetween('dias_mora', [31, 60])->sum('saldo_pendiente'),
            'mora_mas_60' => $cuotasVencidas->where('dias_mora', '>', 60)->sum('saldo_pendiente'),
        ];

        return View::make('pages.inmobiliaria.cobranzas.reportemorosidad', [
            'cuotasVencidas' => $cuotasVencidas,
            'resumenMora' => $resumenMora,
            'idopcion' => $idopcion,
        ]);
    }
}
