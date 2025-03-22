<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\Modelos\PlaMovilidad;
use App\Modelos\PlaDetMovilidad;
use App\Modelos\PlaSerie;
use App\Modelos\STDTrabajador;




use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;

use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use Hashids;
use SplFileInfo;
use Excel;

class GestionPlanillaMovilidadController extends Controller
{
    use GeneralesTraits;


    public function actionListarPlanillaMovilidad($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Planillas de Movilidad');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio   =   $this->fecha_menos_diez_dias;
        $fecha_fin      =   $this->fecha_sin_hora;
        $listadatos     =   array();
        $funcion        =   $this;

        return View::make('planillamovilidad/listaplanillamovilidad',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin
                         ]);
    }


    public function actionAgregarPlanillaMovilidad($idopcion,Request $request)
    {


        if($_POST)
        {

            //try{    
                
                // DB::beginTransaction();

                // $ruc                        =   $request['ruc'];
                // $razonsocial                =   $request['razonsocial'];
                // $direccion                  =   $request['direccion'];
                // $cuenta_detraccion          =   $request['cuenta_detraccion'];
                // $lblcontrasena              =   $request['lblcontrasena'];
                // $lblcontrasenaconfirmar     =   $request['lblcontrasenaconfirmar'];
                // $nombre                     =   $request['nombre'];
                // $lblcelular                 =   $request['lblcelular'];
                // $lblemail                   =   $request['lblemail'];
                // $lblconfirmaremail          =   $request['lblconfirmaremail'];
                // $cod_empresa                =   $request['cod_empresa'];
                // $usuario                    =   User::where('usuarioosiris_id','=',$cod_empresa)->first();

                // if(count($usuario) > 0){
                //         return Redirect::back()->withInput()->with('errorurl', 'El usuario ya se cuenta registrado');
                // }

                // $idusers                    =   $this->funciones->getCreateIdMaestra('users');
                // $cabecera                   =   new User;
                // $cabecera->id               =   $idusers;
                // $cabecera->nombre           =   $razonsocial;
                // $cabecera->name             =   $ruc;
                // $cabecera->passwordmobil    =   $lblcontrasena;
                // $cabecera->fecha_crea       =   $this->fechaactual;
                // $cabecera->password         =   Crypt::encrypt($lblcontrasena);
                // $cabecera->rol_id           =   '1CIX00000024';
                // $cabecera->usuarioosiris_id =   $cod_empresa;
                // $cabecera->email            =   $lblemail;
                // $cabecera->direccion_fiscal     =   $direccion;
                // $cabecera->cuenta_detraccion    =   $cuenta_detraccion;
                // $cabecera->nombre_contacto      =   $nombre;
                // $cabecera->celular_contacto     =   $lblcelular;
                // $cabecera->email_confirmacion   =   0;
                // $cabecera->ind_confirmacion     =   0;
                // $cabecera->save();
     

                // $id                         =   $this->funciones->getCreateIdMaestra('WEB.userempresacentros');
                // $detalle                    =   new WEBUserEmpresaCentro;
                // $detalle->id                =   $id;
                // $detalle->empresa_id        =   'IACHEM0000010394';
                // $detalle->centro_id         =   'CEN0000000000001';
                // $detalle->fecha_crea        =   $this->fechaactual;
                // $detalle->usuario_id        =   $idusers;
                // $detalle->save();

                // $id                         =   $this->funciones->getCreateIdMaestra('WEB.userempresacentros');
                // $detalle                    =   new WEBUserEmpresaCentro;
                // $detalle->id                =   $id;
                // $detalle->empresa_id        =   'IACHEM0000007086';
                // $detalle->centro_id         =   'CEN0000000000001';
                // $detalle->fecha_crea        =   $this->fechaactual;
                // $detalle->usuario_id        =   $idusers;
                // $detalle->save();

                // Session::forget('usuario');
                // Session::forget('listamenu');
                // Session::forget('listaopciones');
                // DB::commit();

                // }catch(\Exception $ex){
                //     DB::rollback(); 
                //     return Redirect::to('registrate')->with('errorbd', $ex.' Ocurrio un error inesperado');
                // }

                // return Redirect::to('/login')->with('bienhecho', 'Proveedor '.$razonsocial.' registrado con exito (Se le a enviado un email para que pueda confirmar su acceso al sitema)');



        }else{

            $anio           =   $this->anio;
            $mes            =   $this->mes;

            $periodo        =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
            $serie          =   $this->gn_serie($anio, $mes);
            $numero         =   $this->gn_numero($serie);
            $centro         =   Session::get('usuario')->txt_centro;
            $txttrabajador  =   '';
            $doctrabajador  =   '';
            $dtrabajador    =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
            if(count($dtrabajador)>0){
                $txttrabajador  =   $dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES;
                $doctrabajador  =   $dtrabajador->NRO_DOCUMENTO;
            }
            return View::make('planillamovilidad.agregarplanillamovilidad',
                             [
                                'periodo' => $periodo,
                                'serie' => $serie,
                                'numero' => $numero,
                                'comcentrobolistaclientes' => $combocentrolistaclientes,
                                'txttrabajador' => $txttrabajador,
                                'doctrabajador' => $doctrabajador,
                                'idopcion' => $idopcion
                             ]);
        }   

    }




}
