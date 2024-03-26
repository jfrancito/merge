<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\Modelos\Requerimiento;
use App\Modelos\Institucion;
use App\Modelos\Director;
use App\Modelos\Archivo;
use App\Modelos\Conei;
use App\Modelos\Estado;
use App\Modelos\OtroIntegranteConei;
use App\Modelos\Certificado;

use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\CertificadoTraits;
use Hashids;
use SplFileInfo;

class GestionCertificadoController extends Controller
{
    use GeneralesTraits;
    use CertificadoTraits;

    public function actionListarCertificados($idopcion)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Certificados');

        $user_id        =   Session::get('usuario')->id;
        $listadatos     =   $this->con_lista_certificados();
        $funcion        =   $this;

        return View::make('requerimiento/listacertificado',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }



    public function actionAgregarCertificado($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Agregar Certificado');

        if($_POST)
        {

            /**** Validaciones laravel ****/
                /**** Validaciones laravel ****/

            // $this->validate($request, [
            //     // 'nombre' => 'unique:seccionpaginas',
            //     'titulo' => 'unique:seccionpaginas',
            // ], [
            //     // 'nombre.unique' => 'Nombre ya registrado',
            //     'titulo.unique' => 'Titulo ya registrado',
            // ]);
            if($request['indimagen']==1 && is_null($request['foto'])){
                   return Redirect::back()->withInput()->with('errorurl', 'Debe Cargar una Imagen');
            }

            try {
                    DB::beginTransaction();
                    /******************************/
                    $indimagen      =   $request['indimagen'];
                    $urlmedio      =   '';
                    $categoria_id   =   $this->categoria_id;
                    $nuevoid        =   $this->ge_getNuevoId('detalleseccionpaginas');
                    $orden          =   $this->ge_getOrden('detalleseccionpaginas',$cabecera->id);
                    $fotos          =   $request['foto'];


                    $rutadondeguardar =$this->pathImg.$this->pathLocal.'/'.$nuevoid.'/'.$this->carpetaimg;

                    $cabecera_id            =   $this->funciones->decodificar($request['idregistrocabecera']);
                    $titulo                 =   $request['titulo'];
                    $subtitulo              =   $request['subtitulo'];
                    $indpublicacion         =   $request['indpublicacion'];
                    $indlink                =   $request['indlink'];
                    $urllinkpagina          =   '';

                    if($indlink==1){
                        $urllinkpagina          =   $request['urllinkpagina'];
                    }


                    $texto                  =   $request['texto'];
                    

                    $cabecera                   =   new DetalleRegistro();
                    $cabecera->titulo           =   $titulo;
                    $cabecera->subtitulo        =   $subtitulo;
                    $cabecera->seccionpagina_id =   $cabecera_id;
                    $cabecera->indpublicacion   =   $indpublicacion;
                    $cabecera->indlink          =   $indlink;
                    $cabecera->orden            =   $orden;
                    $cabecera->urllinkpagina    =   $urllinkpagina;
                    $cabecera->texto            =   $texto;
                    $cabecera->fechacrea        =   $this->fechacrea;
                    $cabecera->usercrea         =   Session::get('usuario')->id;
                     $cabecera->save();

                    if($indimagen==1){
                        if(!is_null($fotos)){
                            foreach($fotos as $file){
                                dd($file);
                                $cantidad       =   1;
                                $id_multimedia  =   1;

                                $multimedia     =   Multimedia::where('detseccionpagina_id', '=' , $nuevoid)
                                                    ->where('texto','=',$this->textomultimedia)
                                                    // ->where('activo','=',1)
                                                    ->first();

                                if(count($multimedia)>0){
                                    $cantidad       =   (int)$multimedia->cantidad +1;
                                    $id_multimedia  =   $multimedia->id;
                                }else{
                                    $cantidad       =   1;
                                    $id_multimedia  =   $this->ge_getNuevoId('multimedias');
                                }

                                $nombreimagen = $cantidad.'.'.$file->guessExtension();
                                
                                $ruta = public_path($rutadondeguardar);
                                $valor = $this->ge_crearCarpetaSiNoExiste($ruta);
                                copy($file->getRealPath(),$ruta.$nombreimagen);
                                $urlmedio = 'public/'.$rutadondeguardar.$nombreimagen;

                                if(count($multimedia)>0){
                                    $multimedia->nombre             =   $nombreimagen;
                                    $multimedia->cantidad           =   $cantidad;
                                    $multimedia->texto              =   $this->textomultimedia;
                                    $multimedia->urlmedio           =   $urlmedio;
                                    $multimedia->save();

                                }else{

                                    $cabecera                       =   new Multimedia;
                                    $cabecera->nombre               =   $nombreimagen;
                                    $cabecera->cantidad             =   $cantidad;  
                                    $cabecera->detseccionpagina_id  =   $nuevoid;
                                    $cabecera->texto                =   $this->textomultimedia;
                                    $cabecera->urlmedio             =   $urlmedio;   
                                    $cabecera->fechacrea            =   $this->fechacrea;
                                    $cabecera->usercrea             =   Session::get('usuario')->id;
                                    $cabecera->save();

                                }

                            }
                        }
                    }         

                    DB::commit();
                
            } catch (Exception $ex) {
                DB::rollback();
                  $msj =$this->ge_getMensajeError($ex);
                return Redirect::to('/gestion-de-'.$this->urlopciones.'/'.$idopcion)->with('errorurl', $msj);
            }
            /******************************/

            return Redirect::to('/gestion-de-'.$this->urlopciones.'/'.$idopcion)->with('bienhecho', 'Registro '.$request['titulo'].' registrado con exito');

        }else{

            $datos              =   DB::table('instituciones')->where('activo','=',1)
                                    ->where('id','<>','1CIX00000001')->pluck('nombre','id')->toArray();
            $comboinstituciones =   array('' => "Seleccione Categoria") + $datos;
            $selectinstituciones=   '';
            $comboperiodo       =   $this->gn_generacion_combo_tabla('estados','id','nombre','Seleccione periodo','','APAFA_CONEI_PERIODO');
            $selectperiodo      =   '';
            $comboprocedencia   =   $this->gn_generacion_combo_tabla('estados','id','nombre','Seleccione procedencia','','APAFA_CONEI');
            $selectprocedencia  =   '';


            return View::make('requerimiento/agregarcertificado',
                        [
                            'idopcion'              =>  $idopcion,
                            'comboinstituciones'    =>  $comboinstituciones, 
                            'selectinstituciones'   =>  $selectinstituciones,
                            'comboperiodo'          =>  $comboperiodo, 
                            'selectperiodo'         =>  $selectperiodo,
                            'comboprocedencia'      =>  $comboprocedencia, 
                            'selectprocedencia'     =>  $selectprocedencia
                        ]);
        }

    }



}
