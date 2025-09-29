<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\VMergeOC;
use App\Modelos\FeDocumento;
use App\Modelos\CMPCategoria;
use App\Modelos\CMPOrden;
use App\Modelos\STDTrabajador;
use App\Modelos\SGDUsuario;
use App\Modelos\VMergeActual;
use App\Modelos\Archivo;
use App\Modelos\VMergeDocumento;
use App\Modelos\VMergeDocumentoActual;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\WEBRol;
use App\Modelos\FeRefAsoc;
use App\Modelos\CONRegistroCompras;
use App\Modelos\Estado;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\ViewDPagar;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\STDEmpresa;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\Whatsapp;


use App\Modelos\ProRentaCuartaCategoria;
use App\Modelos\PlaMovilidad;
use App\Modelos\PlaDetMovilidad;
use App\Modelos\FePlanillaEntregable;
use App\User;

use ZipArchive;
use SplFileInfo;
use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use SoapClient;
use Carbon\Carbon;

trait CuartaCategoriaTraits
{

    private function pla_lista_renta_cuarta_categoria_contabilidad() {

        $lrentacuartacategoria  =   ProRentaCuartaCategoria::where('ACTIVO','=','1')
                                    ->where('COD_ESTADO','=','ETM0000000000004')
                                    ->orderby('FECHA_CREA','DESC')->get();

        return  $lrentacuartacategoria;
    }

    private function pla_lista_renta_cuarta_categoria_contabilidad_gestion() {

        $lrentacuartacategoria  =   ProRentaCuartaCategoria::where('ACTIVO','=','1')
                                    ->orderby('FECHA_CREA','DESC')->get();
        return  $lrentacuartacategoria;
    }


    private function pla_lista_renta_cuarta_categoria() {

        if(Session::get('usuario')->id== '1CIX00000001'){

            $lrentacuartacategoria  =   ProRentaCuartaCategoria::where('ACTIVO','=','1')
                                        ->orderby('FECHA_CREA','DESC')->get();
                                    
        }else{

            $lrentacuartacategoria  =   ProRentaCuartaCategoria::where('ACTIVO','=','1')
                                        ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                        ->orderby('FECHA_CREA','DESC')->get();


        }

        return  $lrentacuartacategoria;
    }


}