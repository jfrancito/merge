<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\RequerimientoTraits;
use App\Traits\ConfiguracionTraits;
use Hashids;

class GestionMenuController extends Controller
{
    use GeneralesTraits;
    use ConfiguracionTraits;

        //

        /////////////////////////////////////////////////////////////////////////////////////////
    ////    SECCION GRUPO OPCIONES
    /////////////////////////////////////////////////////////////////////////////////////////
    
    public function actionListarGrupoOpciones($idopcion) {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl != 'true') {return $validarurl;}
        /******************************************************/

        View::share('titulo','Lista de Grupo Opciones');
        $listadatos = Grupoopcion::where('activo','=',1)->orderBy('orden', 'asc')->get();

        return View::make('gestionmenu/listagrupoopciones',
            [
                'listadatos' => $listadatos,
                'idopcion' => $idopcion,
            ]);

    }

    public function actionModificarGrupoOpcion($idopcion,$idregistro,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $registro_id = $this->funciones->decodificarmaestra($idregistro);

        View::share('titulo','Modificar Grupo Opcion');

        if($_POST)
        {

            /**** Validaciones laravel ****/
            $this->validate($request, [
                'nombre' => 'unique:grupoopciones,nombre,'.$registro_id.',id',
            ], [
                'nombre.unique' => 'Grupoopcion ya registrado',
            ]);

            /******************************/

            $cabecera                =  Grupoopcion::find($registro_id);
            $cabecera->nombre        =  $request['nombre'];
            $cabecera->activo        =  $request['activo'];         
            $cabecera->icono         =  $request['icono'];          
            $cabecera->save();


            return Redirect::to('/gestion-grupo-opciones/'.$idopcion)->with('bienhecho', 'Rol '.$request['nombre'].' modificado con exito');

        }else{

                $registro = Grupoopcion::where('id', $registro_id)->first();
                return View::make('gestionmenu/modificargrupoopcion', 
                                [
                                    'registro'  => $registro,
                                    'idopcion' => $idopcion
                                ]);
        }

    }

    public function actionAgregarGrupoOpcion($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $usuario_id = Session::get('usuario')->id;
        View::share('titulo','Agregar Grupo Opcion');
        if($_POST)
        {
            /**** Validaciones laravel ****/

            $this->validate($request, [
                'nombre' => 'unique:grupoopciones',
            ], [
                'nombre.unique' => 'Grupoopcion ya registrado',
            ]);

            /******************************/
            $orden                   =  ((int) Grupoopcion::max('orden'))+1; 
            $idnuevo                 =   $this->funciones->getCreateIdMaestra('grupoopciones');
            $cabecera                =  new Grupoopcion;
            $cabecera->id            =  $idnuevo;
            $cabecera->nombre        =  $request['nombre'];
            $cabecera->icono         =  $request['icono'];
            $cabecera->fecha_crea    =  $this->fechaactual;
            $cabecera->usuario_crea  =  $usuario_id;
            $cabecera->orden         =  $orden;
            $cabecera->activo        =  1;
            $cabecera->save();



            return Redirect::to('/gestion-grupo-opciones/'.$idopcion)->with('bienhecho', 'Grupo Opcion '.$request['nombre'].' registrado con exito');

        }else{

            return View::make('gestionmenu/agregargrupoopcion',
                        [
                            'idopcion' => $idopcion
                        ]);
        }
    }


    /////////////////////////////////////////////////////////////////////////////////////////
    ////    SECCION OPCIONES
    /////////////////////////////////////////////////////////////////////////////////////////
    public function actionListarOpciones($idopcion) {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl != 'true') {return $validarurl;}
        /******************************************************/

        View::share('titulo','Lista de Opciones');
        $listadatos = Opcion::where('activo','=','1')->orderBy('id', 'asc')->get();

        return View::make('gestionmenu/listaopciones',
            [
                'listadatos' => $listadatos,
                'idopcion' => $idopcion,
            ]);

    }
    
    public function actionAgregarOpcion($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Agregar Opcion');
        $usuario_id = Session::get('usuario')->id;

        if($_POST)
        {

            /**** Validaciones laravel ****/
            $this->validate($request, [
                'name' => 'unique:opciones',
                'pagina' => 'unique:opciones',

            ], [
                'name.unique' => 'Opcion ya registrada',
                'pagina.unique' => 'Pagina ya registrado',
                
            ]);

            try{
                DB::beginTransaction();

                /******************************/

                $cabecera                   =   new Opcion;
                $idnuevaopcion                   =   $this->funciones->getCreateIdMaestra('opciones');
                $cabecera->id               =   $idnuevaopcion;
                $cabecera->nombre           =   $request['nombre'];
                $cabecera->descripcion      =   $request['descripcion'];
                $cabecera->pagina           =   $request['pagina'];
                $cabecera->grupoopcion_id   =   $request['grupoopcion_id'];
                $cabecera->fecha_crea       =  $this->fechaactual;
                $cabecera->usuario_crea     =  $usuario_id;
                $cabecera->save();

                $listaroles     =   Rol::get();
                $orden=0;
                $consultaorden = Rolopcion::selectRaw("MAX(orden) as orden")->first();
                if(count((array)$consultaorden)>0 && !empty($consultaorden)){
                    $orden = (int)$consultaorden->orden+1;
                }
                $cont= 0;
                foreach ($listaroles as $index => $rol) {
                    
                    $idrolopcion            =   $this->funciones->getCreateIdMaestra('rolopciones');
                    $rolopcion                  =   new Rolopcion;
                    $rolopcion->id              =   $idrolopcion;
                    $rolopcion->opcion_id       =   $idnuevaopcion;
                    $rolopcion->rol_id          =   $rol->id;
                    $rolopcion->orden           =   $orden;
                    $rolopcion->fecha_crea      =   $this->fechaactual;
                    $rolopcion->usuario_crea    =   $usuario_id;

                    if($cont==0){
                        $rolopcion->ver         =   1;
                        $rolopcion->anadir      =   1;
                        $rolopcion->modificar   =   1;
                        $rolopcion->eliminar    =   1;
                        $rolopcion->todas       =   1;
                    }
                    else{

                        $rolopcion->ver         =   0;
                        $rolopcion->anadir      =   0;
                        $rolopcion->modificar   =   0;
                        $rolopcion->eliminar    =   0;
                        $rolopcion->todas       =   0;
                    }
                    $cont++;
                    $rolopcion->save();
                }

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                $sw =   1;
                $mensaje  = $this->ge_getMensajeError($ex);
                return Redirect::to('/agregar-opcion/'.$idopcion)->with('errorbd', $mensaje);

            }

            return Redirect::to('/gestion-opciones/'.$idopcion)->with('bienhecho', 'Opcion '.$request['nombre'].' '.$request['pagina'].' registrada con exito');
        }else{

            $grupoopcion        = DB::table('grupoopciones')->where('activo','=',1)->pluck('nombre','id')->toArray();
            $combogrupoopcion   = array('' => "Seleccione Grupo Opcion") + $grupoopcion;
            return View::make('gestionmenu/agregaropcion',
                        [
                            'combogrupoopcion' => $combogrupoopcion,
                            'idopcion' => $idopcion
                        ]);
        }

    }

    public function actionModificarOpcion($idopcion,$idregistro,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $usuario_id = Session::get('usuario')->id;
        $registro_id = $this->funciones->decodificarmaestra($idregistro);
        if($_POST)
        {

            /**** Validaciones laravel ****/
            $this->validate($request, [
                'name' => 'unique:opciones,name,'.$registro_id.',id',
                // 'pagina' => 'unique:opciones,pagina,'.$registro_id.',id',

            ], [
                'name.unique' => 'Opcion ya registrada',
                // 'pagina.unique' => 'Pagina ya registrado',
            ]);

            /******************************/

            $cabecera                   =   Opcion::find($registro_id);
            $cabecera->nombre           =   $request['nombre'];
            $cabecera->descripcion      =   $request['descripcion'];
            $cabecera->fecha_mod        =  $this->fechaactual;
            $cabecera->usuario_mod      =  $usuario_id;
            // $cabecera->password   =  Crypt::encrypt($request['password']);
            $cabecera->activo           =   $request['activo'];         
            $cabecera->grupoopcion_id   =   $request['grupoopcion_id'];
            $cabecera->save();


            return Redirect::to('/gestion-opciones/'.$idopcion)->with('bienhecho', 'Opcion '.$request['nombre'].' modificada con exito');

        }else{

                $opcion     = Opcion::where('id', $registro_id)->first();
                $grupoopcion        = DB::table('grupoopciones')->where('activo','=',1)->pluck('nombre','id')->toArray();
                $combogrupoopcion   = array($opcion->grupoopcion_id => $opcion->grupoopcion->nombre) + $grupoopcion;

                return View::make('gestionmenu/modificaropcion', 
                                [
                                    'registro'              => $opcion,
                                    'combogrupoopcion'  => $combogrupoopcion,
                                    'idopcion'          => $idopcion
                                ]);
        }

    }

}
