<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Proyecto;
use App\Models\Lote;
use App\Models\Cliente;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class ReservaController extends Controller
{
    use UserTraits;

    public function actionListarReservas($idopcion)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Separaciones y Reservas');

        $empresa_id = session('empresa_id');
        $reservas = Reserva::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->with(['proyecto', 'lote.manzana', 'cliente', 'vendedor'])
            ->orderBy('id', 'desc')
            ->get();

        return View::make('pages.inmobiliaria.reservas.listareservas', [
            'reservas' => $reservas,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionCrearReserva($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Registrar Separación de Lote');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'lote_id' => 'required|string|exists:lotes,id',
                'cliente_id' => 'required|string|exists:clientes,id',
                'vendedor_id' => 'nullable|string|exists:vendedores,id',
                'monto_reserva' => 'required|numeric|min:1',
                'metodo_pago' => 'required|string',
                'fecha_reserva' => 'required|date',
                'fecha_limite' => 'required|date|after_or_equal:fecha_reserva',
                'voucher_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,pdf|max:3072',
            ], [
                'monto_reserva.required' => 'El monto de separación es obligatorio',
                'fecha_limite.after_or_equal' => 'La fecha límite debe ser igual o posterior a la fecha de reserva',
            ]);

            // Validar que el lote no esté vendido
            $lote = Lote::where('id', $request->input('lote_id'))->first();
            if ($lote->estado === 'vendido') {
                return redirect()->back()->withInput()->with('errorbd', 'El lote seleccionado ya fue vendido.');
            }

            try {
                DB::beginTransaction();

                $idreserva = $this->user_CreateIdMaestra('reservas');

                $year = date('Y');
                $count = Reserva::where('empresa_id', $empresa_id)->whereYear('fecha_crea', $year)->count() + 1;
                $codigo = 'RES-' . $year . '-' . str_pad($count, 4, "0", STR_PAD_LEFT);

                $voucherPath = null;
                if ($request->hasFile('voucher_foto')) {
                    $voucherPath = $request->file('voucher_foto')->store('vouchers', 'public');
                }

                $reserva = new Reserva();
                $reserva->id = $idreserva;
                $reserva->empresa_id = $empresa_id;
                $reserva->codigo_reserva = $codigo;
                $reserva->proyecto_id = $request->input('proyecto_id');
                $reserva->lote_id = $request->input('lote_id');
                $reserva->cliente_id = $request->input('cliente_id');
                $reserva->vendedor_id = $request->input('vendedor_id');
                $reserva->monto_reserva = (float)$request->input('monto_reserva');
                $reserva->metodo_pago = $request->input('metodo_pago');
                $reserva->banco_origen = $request->input('banco_origen');
                $reserva->numero_operacion = $request->input('numero_operacion');
                $reserva->voucher_foto = $voucherPath;
                $reserva->fecha_reserva = $request->input('fecha_reserva');
                $reserva->fecha_limite = $request->input('fecha_limite');
                $reserva->estado = 'vigente';
                $reserva->observaciones = $request->input('observaciones');
                $reserva->activo = 1;
                $reserva->usuario_crea = session('usuario')->id;
                $reserva->fecha_crea = date('Y-m-d H:i:s');
                $reserva->save();

                // Cambiar estado del lote a 'reservado'
                $lote->estado = 'reservado';
                $lote->save();

                DB::commit();

                return redirect()->to('/gestion-de-reservas/' . $idopcion)
                    ->with('bienhecho', 'Separación ' . $reserva->codigo_reserva . ' registrada. El lote quedó bloqueado como Reservado.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al registrar reserva: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre', 'asc')->get();
        $clientes = Cliente::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre_razon_social', 'asc')->get();
        $vendedores = Vendedor::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre', 'asc')->get();

        return View::make('pages.inmobiliaria.reservas.form.crearreserva', [
            'idopcion' => $idopcion,
            'proyectos' => $proyectos,
            'clientes' => $clientes,
            'vendedores' => $vendedores,
            'lote_id_selected' => $request->get('lote_id'),
        ]);
    }

    public function actionVerReserva($idopcion, $idreserva)
    {
        $empresa_id = session('empresa_id');
        $idReservaReal = $this->user_decodificarmaestra($idreserva);

        $reserva = Reserva::where('id', $idReservaReal)
            ->where('empresa_id', $empresa_id)
            ->with(['proyecto', 'lote.manzana', 'cliente', 'vendedor', 'empresa'])
            ->first();

        if (!$reserva) {
            return redirect()->back()->with('errorbd', 'Reserva no encontrada.');
        }

        return View::make('pages.inmobiliaria.reservas.fichareserva', [
            'reserva' => $reserva,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionAnularReserva(Request $request, $idopcion, $idreserva)
    {
        $validarurl = $this->user_url($idopcion, 'eliminar');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        $empresa_id = session('empresa_id');
        $idReservaReal = $this->user_decodificarmaestra($idreserva);

        $reserva = Reserva::where('id', $idReservaReal)->where('empresa_id', $empresa_id)->first();
        if (!$reserva) {
            return redirect()->back()->with('errorbd', 'Reserva no encontrada.');
        }

        try {
            DB::beginTransaction();

            $reserva->estado = 'anulada';
            $reserva->fecha_modifica = date('Y-m-d H:i:s');
            $reserva->save();

            // Liberar lote a disponible si no está vendido
            $lote = Lote::find($reserva->lote_id);
            if ($lote && in_array($lote->estado, ['reservado', 'separado'])) {
                $lote->estado = 'disponible';
                $lote->save();
            }

            DB::commit();

            return redirect()->to('/gestion-de-reservas/' . $idopcion)
                ->with('bienhecho', 'Reserva anulada y Lote liberado a Disponible.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errorbd', 'Error al anular: ' . $e->getMessage());
        }
    }
}
