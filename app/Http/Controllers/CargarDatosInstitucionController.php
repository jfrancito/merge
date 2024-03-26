<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Exception;
use App\Modelos\Categoria;
use App\Modelos\Producto;
use App\Modelos\CalendarioProducto as Registro;
use App\Modelos\Multimedia as Foto;
use App\Modelos\Producto as DetalleRegistro;
use App\Modelos\Multimedia;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\Modelos\Calendario;

use App\Modelos\Produccion;
use App\Modelos\Departamento;
use App\Modelos\Cosecha;
use App\Modelos\Institucion;
use App\Modelos\Director;



use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use Session;
use View;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use TPDF;
use ZipArchive;
use PDO;


use GuzzleHttp\Client;
use App\Traits\GeneralesTraits;

class CargarDatosInstitucionController extends Controller
{
    use GeneralesTraits;



    public function actionCargarDatos($idopcion) {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl != 'true') {return $validarurl;}
        /******************************************************/
        View::share('titulo',' Cargar Datos Institucion y Docente');
        $user_id            =   Session::get('usuario')->id;
        $swedit            =   $this->ge_isUsuarioAdmin($user_id);

        return View::make('cardadata/cargarinstitucion',
            [
                // 'listaregistros'    =>  $listaregistros,
                'idopcion'          =>  $idopcion,
                'swedit'            =>  $swedit,
            ]);
    }


   public function actionCargarDato($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $fileexcel              =   $request['inputdatosexcel'];
        /** Cargando el excel mediante un archivo recibido vía POST con name=RubrosTrabajador en htnml */
        $contador=0;
        $cant_reg=0;
        $msj = '';
        $mensaje = '';

        if($_POST)
        {
            if (!empty($fileexcel)) 
            {
                
                $datosExcel=Excel::load($fileexcel, function($reader) {
                    /*** $reader->get() nos permite obtener todas las filas de nuestro archivo**/
                    $excel = $reader->get();
                })->get();
                //al leer el excel la primera pestaña es cero y las demas son 1, 2 como si fuese un vector
                // la cabecera o primera linea son tomadas como index para cada registro
                // si la cabecera tiene espacios en blanco pone un subgion entre las palabras que conforman el nombre de la cabecera
                try{    
                        DB::beginTransaction();

                        $listadatos = $datosExcel;
                        //dd($listadatos);
                        $cant_reg = count($listadatos);
                        // dd($cant_reg);
                        $fila=0;
                        $idproducto='';
                        foreach ($listadatos as $index => $item) 
                        {


                            if ($item->codigo_modular == null){$mensaje ='CODIGO MODULAR VACIO';throw new Exception($mensaje);}
                            if ($item->codigo_local == null){$mensaje ='CODIGO LOCAL VACIO';throw new Exception($mensaje);}
                            if ($item->nombre_iiee == null){$mensaje ='NOMBRE IIEE VACIO';throw new Exception($mensaje);}
                            if ($item->director == null){$mensaje ='DIRECTOR VACIO';throw new Exception($mensaje);}
                            if ($item->director_dni == null){$mensaje ='DNI DIRECTOR VACIO';throw new Exception($mensaje);}

                            if ($item->direccion_iiee == null){$mensaje ='DIRECCION IIEE VACIO';throw new Exception($mensaje);}
                            //if ($item->localidad == null){$mensaje ='LOCALIDAD VACIO';throw new Exception($mensaje);}
                            //if ($item->centro_poblado == null){$mensaje ='CENTRO POBLADO VACIO';throw new Exception($mensaje);}
                            if ($item->departamento == null){$mensaje ='DEPARTAMENTO VACIO';throw new Exception($mensaje);}
                            if ($item->provincia == null){$mensaje ='PROVINCIA VACIO';throw new Exception($mensaje);}
                            if ($item->distrito == null){$mensaje ='DISTRITO VACIO';throw new Exception($mensaje);}

                            $institucion = Institucion::where('codigo','=',$item->codigo_local)->first();

                            //AGREGAR
                            if(count($institucion)<=0){

                                //INSTITUCION
                                $idinstitucion                              =   $this->funciones->getCreateIdMaestra('instituciones');
                                $cabecera                                   =   new Institucion;
                                $cabecera->id                               =   $idinstitucion;
                                $cabecera->codigo                           =   $item->codigo_local;
                                $cabecera->codigomodular                    =   $item->codigo_modular;
                                $cabecera->nombre                           =   $item->nombre_iiee;            
                                $cabecera->direccion                        =   $item->direccion_iiee;
                                $cabecera->departamento                     =   $item->departamento;
                                $cabecera->provincia                        =   $item->departamento;
                                $cabecera->distrito                         =   $item->distrito;
                                $cabecera->localidad                        =   $item->localidad;
                                $cabecera->centropoblado                    =   $item->centro_poblado;
                                $cabecera->fecha_crea                       =   $this->fechaactual;
                                $cabecera->usuario_crea                     =   Session::get('usuario')->id;
                                $cabecera->save();

                                //DIRECTOR
                                $iddirector                                 =   $this->funciones->getCreateIdMaestra('directores');
                                $director                                   =   new Director;
                                $director->id                               =   $iddirector;
                                $director->dni                              =   $item->director_dni;
                                $director->nombres                          =   $item->director;
                                $director->telefono                         =   $item->telefono;
                                $director->correo                           =   $item->correo_electronico;            
                                $director->institucion_id                   =   $idinstitucion;
                                $director->fecha_crea                       =   $this->fechaactual;
                                $director->usuario_crea                     =   Session::get('usuario')->id;
                                $director->save();

                                $idusers                                    =   $this->funciones->getCreateIdMaestra('users');
                                $users                                      =   new User;
                                $users->id                                  =   $idusers;
                                $users->nombre                              =   $item->nombre_iiee;
                                $users->name                                =   $item->codigo_local;
                                $users->password                            =   Crypt::encrypt($item->codigo_local.substr($item->director, 1, 3));
                                $users->institucion_id                      =   $idinstitucion;
                                $users->rol_id                              =   '1CIX00000002';
                                $users->fecha_crea                          =   $this->fechaactual;
                                $users->usuario_crea                        =   Session::get('usuario')->id;
                                $users->save();

                            }else{

                                //MODIFICAR
                                //INSTITUCIONES
                                $institucion->codigo                        =   $item->codigo_local;
                                $institucion->codigomodular                 =   $item->codigo_modular;
                                $institucion->nombre                        =   $item->nombre_iiee;            
                                $institucion->direccion                     =   $item->director;
                                $institucion->departamento                  =   $item->departamento;
                                $institucion->provincia                     =   $item->departamento;
                                $institucion->distrito                      =   $item->distrito;
                                $institucion->localidad                     =   $item->localidad;
                                $institucion->centropoblado                 =   $item->centro_poblado;
                                $institucion->fecha_mod                     =   $this->fechaactual;
                                $institucion->usuario_mod                   =   Session::get('usuario')->id;
                                $institucion->save();

                                //DOCTOR
                                $director_sel                               =   Director::where('institucion_id','=',$institucion->id)->first();
                                $director_sel->nombres                      =   $item->director;
                                $director_sel->telefono                     =   $item->telefono;
                                $director_sel->correo                       =   $item->correo_electronico;
                                $director_sel->fecha_mod                    =   $this->fechaactual;
                                $director_sel->usuario_mod                  =   Session::get('usuario')->id;
                                $director_sel->save();

                            } 



                            $contador = $contador + 1;
                        }

                    DB::commit();

                }catch(\Exception $ex){
                    DB::rollback(); 
                    $msj = $mensaje. $this->ge_getMensajeError($ex,false);
                    // $msj = $mensaje;
                    return Redirect::to('gestion-de-institucion-docente/'.$idopcion)->with('errorurl', 'Fila:  '.$fila.' Error: '.$msj);
                }

                return Redirect::to('gestion-de-institucion-docente/'.$idopcion)->with('bienhecho', 'Cargaron '.$contador.' registros de '.$cant_reg);
               
            }else{
                return Redirect::to('gestion-de-institucion-docente/'.$idopcion)->with('errorurl', 'Seleccione Archivo Excel a Importar ');
            }

        }
    }
    



    public function actionDescargarFormatoCargaExcel($idopcion) 
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        // $periodo_actual =    $this->funciones->getPeriodoActual();
        $funcion                =   $this;
        $titulo                 =   'Formato Cargar Datos ';

        Excel::create($titulo, function($excel) use ( $funcion ) {
            $company = 'PERUGEL';
            $excel->setTitle('Formato Cargar Datos')
                ->setCreator('SWAP')
                ->setCompany($company)
                ->setDescription('Excel Formato Cargar Datos');
            $excel->sheet('Formato Cargar Datos', function($sheet) use ($funcion) {

                $sheet->loadView('cardadata/excel/formatocarga')
                        ->with('funcion',$funcion);

                $sheet->cells('A1:M1', function($cells) {
                   $cells->setFontColor('#000000');
                   $cells->setAlignment('center');
                   $cells->setValignment('center');
                    $cells->setFont(array(
                        'name'     => 'Tahoma',
                        'size'     => '9',
                        'bold'     =>  true
                    ));



                                    });
                $sheet->getStyle('A1:M1', $sheet->getHighestRow())->getAlignment()->setWrapText(true);

                $sheet->setWidth(array(
                    'A'     =>  '20',
                    'B'     =>  '20',
                    'C'     =>  '20',
                    'D'     =>  '20',
                    'E'     =>  '20',
                    'F'     =>  '25',
                    'G'     =>  '20',
                    'H'     =>  '20',
                    'I'     =>  '20',
                    'J'     =>  '20',
                    'K'     =>  '20',
                    'L'     =>  '20',
                    'M'     =>  '20'
                ));


                //format 
                $sheet->setColumnFormat(array(
                  'B' => '@'
                ));
                //set general font style
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Tahoma',
                        'size'      =>  10,
                        'bold'      =>  false
                    )
                ));


            });
        })->export('xls');
    }




    
}
