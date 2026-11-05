<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

use App\Modelos\WEBGrupoopcion;
use App\Modelos\WEBOpcion;
use App\Modelos\WEBRol;
use App\Modelos\WEBRolOpcion;
use App\Modelos\STDEmpresaDireccion;
use App\Modelos\TESCuentaBancaria;
use App\Modelos\CMPCategoria;
use App\Modelos\STDEmpresa;
use App\Modelos\WEBUserEmpresaCentro;
use App\User;

use App\Modelos\VMergeOC;
use App\Modelos\FeFormaPago;
use App\Modelos\FeDetalleDocumento;
use App\Modelos\FeDocumento;
use App\Modelos\Estado;
use App\Modelos\CMPOrden;
use App\Modelos\FeToken;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;
use App\Modelos\STDTrabajador;
use App\Modelos\Archivo;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\DetCompraHarold;
use App\Modelos\SuperPrecio;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use Stdclass;
use App\Traits\UserTraits;
use App\Traits\GeneralesTraits;
use App\Traits\PrecioCompetenciaTraits;
use Maatwebsite\Excel\Facades\Excel;


class PrecioCompetenciaController extends Controller {

    use UserTraits;
    use GeneralesTraits;
    use PrecioCompetenciaTraits;


    public function actionModificarGlosaLiquidacion()
    {
        $this->modificarglosahabilitacion();
    }

    public function actionGuardarPdfOi()
    {
        $this->guadarpdfoi();
    }

    public function actionDocumentoLGAutomaticoNuevo()
    {
        $this->documentolgautomaticonuevo();
    }


    public function actionDocumentoLGAutomatico()
    {
        $this->documentolgautomatico();
    }




    public function actionScrapearPrecios()
    {
        try{    
            DB::beginTransaction();
            set_time_limit(0);
        	SuperPrecio::whereDate('FECHA',date('Ymd'))->delete();
            $this->scrapear_plazavea('PLAZAVEA');
            $this->scrapear_metro('METRO');
            $this->scrapear_tottus('TOTTUS');
            $this->scrapear_wong('WONG');
            $lista_precios = SuperPrecio::orderby('MARCA','asc')->get();
            //dd($lista_precios);
            Excel::create('DATAAUTOMATICA_BD', function($excel) use ($lista_precios) {
                $excel->sheet('PRECIOS_SUPER', function($sheet) use ($lista_precios) {
                    $sheet->loadView('reporte/excel/listapreciossupermercados')->with('lista_precios',$lista_precios);                                               
                });
            })->store('xlsx', 'F:/Data_Drive');

            DB::commit();
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
        }
    }



}
