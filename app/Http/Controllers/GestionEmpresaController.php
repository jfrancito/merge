<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\Modelos\Cliente;
use App\Modelos\Categoria;
use App\Modelos\Precotizacion;
use App\Modelos\Requerimiento;
use App\Modelos\Archivo;
use App\Modelos\Cotizacion;
use App\Modelos\Empresa;

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
use SplFileInfo;

class GestionEmpresaController extends Controller
{
    use GeneralesTraits;
    use RequerimientoTraits;
    use ConfiguracionTraits;

    private   $montobase        = 0;
    private   $indajustliq      = 1;
    private   $ruta             = 'empresa';
    private   $urlprincipal     = 'gestion-empresa';
    private   $urlcompleto      = 'gestion-empresa';
    private   $urlopciones      = 'empresa';
    private   $rutaview         = 'empresa';
    private   $rutaviewblade    = 'empresa';
    private   $tregistro        = 'empresas';
    private   $tdetalle         = 'plantillaadenda';
    private   $idmodal          = 'empresa';
    private   $tipoarchivo      = 'empresa';
    // private   $tipocontratoprueba = '97';
    //PERMISOS DEL USUARIO
    private   $opciones;

    public function actionListarEmpresa($idopcion)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Listar Empresa');
        // $codempresa = Session::get('empresas')->id;
        $user_id        = Session::get('usuario')->id;
        $this->opciones = $this->getPermisosOpciones($idopcion,$user_id);

        $listadatos     =   Empresa::from($this->tregistro.' as E')->where('E.activo',1)->get();
        $funcion        =   $this;

        return View::make($this->rutaview.'/lista',
                         [
                            'listadatos'        => $listadatos,
                            'funcion'           => $funcion,
                            'idopcion'          => $idopcion,
                            'view'              =>  $this->rutaviewblade,
                            'url'               =>  $this->urlopciones,
                            'ruta'              =>  $this->ruta,
                            'idmodal'           =>  $this->idmodal,
                            'opciones'          =>  $this->opciones,
                         ]);
    }


}
