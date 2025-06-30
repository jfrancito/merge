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
use App\Modelos\PlaMovilidad;
use App\Modelos\PlaDetMovilidad;
use App\Modelos\STDTipoDocumento;
use App\Modelos\LqgDetDocumentoLiquidacionGasto;
use App\Modelos\LqgDetLiquidacionGasto;
use App\Modelos\LqgLiquidacionGasto;

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
use PDO;
trait LiquidacionGastoTraits
{

    private function lg_descargar_archivo_sunat_lg() {

        $listasunattareas       =       DB::table('SUNAT_DOCUMENTO')
                                        ->where('MODULO', 'LIQUIDACION_GASTO')
                                        ->where('ACTIVO', 1)
                                        ->where('USUARIO_ID', Session::get('usuario')->id)
                                        ->get();
                                        
        foreach($listasunattareas as $index => $item){

            $primeraLetra               =   substr($item->SERIE, 0, 1);
            if(Session::get('empresas')->COD_EMPR == 'IACHEM0000010394'){
                $prefijocarperta = 'II';
            }else{
                $prefijocarperta = 'IS';
            }
            $rutafile                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
            $valor                      =   $this->versicarpetanoexiste($rutafile);

            $ruta_xml                   =   "";
            $ruta_pdf                   =   "";
            $ruta_cdr                   =   "";
            $nombre_xml                 =   "";
            $nombre_pdf                 =   "";
            $nombre_cdr                 =   "";

            $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/02';
            $respuetaxml                =   $this->buscar_archivo_sunat_lg($urlxml,$fetoken,$this->pathFiles,$prefijocarperta,$ID_DOCUMENTO);
            $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/01';
            $respuetapdf                =   $this->buscar_archivo_sunat_lg($urlxml,$fetoken,$this->pathFiles,$prefijocarperta,$ID_DOCUMENTO);
            
            if($primeraLetra == 'F'){
                $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/03';
                $respuetacdr                =   $this->buscar_archivo_sunat_lg($urlxml,$fetoken,$this->pathFiles,$prefijocarperta,$ID_DOCUMENTO);
                if($respuetacdr['cod_error']==0){
                    $ruta_cdr = $respuetacdr['ruta_completa'];
                    $nombre_cdr = $respuetacdr['nombre_archivo'];
                }
            }
            if($respuetaxml['cod_error']==0){
                $ruta_xml = $respuetaxml['ruta_completa'];
                $nombre_xml = $respuetaxml['nombre_archivo'];
            }
            if($respuetapdf['cod_error']==0){
                $ruta_pdf = $respuetapdf['ruta_completa'];
                $nombre_pdf = $respuetapdf['nombre_archivo'];
            }



        }



                 
    }


    private function lg_enviar_osiris_empresa($centro_id,$empresa_id,$rz,$ruc,$direccion,$departamento_id,$provincia_id,$distrito_id,$zona,$zona02,$ind_empresa,$ind_contrato) {

        $conexionbd         = 'sqlsrv';
        if($centro_id == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($centro_id == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }

        $accion                                         =       'I';
        $vacio                                          =       '';
        $valor_cero                                     =       '0';
        $cod_estado                                     =       1;

        $cod_usuario_registro                           =       Session::get('usuario')->name;

        $fecha_ilimitada                                =       date_format(date_create('1901-01-01'), 'Y-m-d');
        $COD_TIPO_DOCUMENTO                             =       'TDI0000000000006';
        $COD_CATEGORIA_EMPR                             =       'TEM0000000000001';
        $TXT_TIPO_GARANTIA                              =       'ESPECIFICAR';


        if($ind_empresa == 0){

            $stmt = DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC STD.EMPRESA_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
            $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                   //@IND_TIPO_OPERACION='I',
            $stmt->bindParam(2, $vacio  ,PDO::PARAM_STR);                                   //@COD_EMPR=@p2 output,
            $stmt->bindParam(3, $empresa_id ,PDO::PARAM_STR);                               //@COD_EMPR_SISTEMA='IACHEM0000010394',
            $stmt->bindParam(4, $centro_id ,PDO::PARAM_STR);                                //@COD_CENTRO_SISTEMA='CEN0000000000001',
            $stmt->bindParam(5, $rz ,PDO::PARAM_STR);                                       //@NOM_EMPR='TOMOGRAFIAS CHICLAYO E.I.R.L.',
            $stmt->bindParam(6, $vacio  ,PDO::PARAM_STR);                                   //@NOM_CORTO='',
            $stmt->bindParam(7, $vacio  ,PDO::PARAM_STR);                                   //@TXT_ABREVIATURA='',
            $stmt->bindParam(8, $vacio  ,PDO::PARAM_STR);                                   //@COD_CONTACTO='                ',
            $stmt->bindParam(9, $vacio  ,PDO::PARAM_STR);                                   //@TXT_TELEFONO='',
            $stmt->bindParam(10, $vacio  ,PDO::PARAM_STR);                                  //@TXT_IMAGEN='',

            $stmt->bindParam(11, $COD_TIPO_DOCUMENTO  ,PDO::PARAM_STR);                     //@COD_TIPO_DOCUMENTO='TDI0000000000006',
            $stmt->bindParam(12, $ruc ,PDO::PARAM_STR);                                     //@NRO_DOCUMENTO='20608383957',
            $stmt->bindParam(13, $vacio  ,PDO::PARAM_STR);                                  //@TXT_FAX='',
            $stmt->bindParam(14, $vacio  ,PDO::PARAM_STR);                                  //@TXT_EMAIL='',
            $stmt->bindParam(15, $vacio ,PDO::PARAM_STR);                                   //@TXT_APE_PATERNO='', 
            $stmt->bindParam(16, $vacio ,PDO::PARAM_STR);                                   //@TXT_APE_MATERNO='', 
            $stmt->bindParam(17, $vacio ,PDO::PARAM_STR);                                   //@TXT_NOMBRES='',
            $stmt->bindParam(18, $fecha_ilimitada ,PDO::PARAM_STR);                         //@FEC_NACIMIENTO='1901-01-01 00:00:00',
            $stmt->bindParam(19, $valor_cero ,PDO::PARAM_STR);                              //@IND_CHOFER=0,
            $stmt->bindParam(20, $vacio ,PDO::PARAM_STR);                                   //@COD_TIPO_BREVETE='                ',


            $stmt->bindParam(21, $vacio ,PDO::PARAM_STR);                                   //@NRO_BREVETE='',
            $stmt->bindParam(22, $COD_CATEGORIA_EMPR ,PDO::PARAM_STR);                      //@COD_CATEGORIA_EMPR='TEM0000000000001',
            $stmt->bindParam(23, $vacio ,PDO::PARAM_STR);                                   //@TXT_GLOSA='',
            $stmt->bindParam(24, $valor_cero ,PDO::PARAM_STR);                              //@IND_SISTEMA=0,
            $stmt->bindParam(25, $valor_cero ,PDO::PARAM_STR);                              //@IND_CLIENTE=0,
            $stmt->bindParam(26, $cod_estado ,PDO::PARAM_STR);                              //@IND_PROVEEDOR=1,
            $stmt->bindParam(27, $valor_cero  ,PDO::PARAM_STR);                             //@IND_SUPERMERCADO=0,
            $stmt->bindParam(28, $valor_cero ,PDO::PARAM_STR);                              //@IND_TRANSPORTISTA=0,
            $stmt->bindParam(29, $valor_cero ,PDO::PARAM_STR);                              //@IND_CUADRILLA=0,
            $stmt->bindParam(30, $valor_cero  ,PDO::PARAM_STR);                             //@IND_ACOPIADOR=0,


            $stmt->bindParam(31, $valor_cero ,PDO::PARAM_STR);                              //@IND_GARANTE=0,
            $stmt->bindParam(32, $valor_cero ,PDO::PARAM_STR);                              //@IND_FORMAL=0,
            $stmt->bindParam(33, $valor_cero ,PDO::PARAM_STR);                              //@IND_RELACIONADO=0,
            $stmt->bindParam(34, $valor_cero ,PDO::PARAM_STR);                              //@IND_COMERCIAL_ACOPIO=0,
            $stmt->bindParam(35, $vacio  ,PDO::PARAM_STR);                                  //@COD_TIPO_GARANTIA='                ',
            $stmt->bindParam(36, $TXT_TIPO_GARANTIA  ,PDO::PARAM_STR);                      //@TXT_TIPO_GARANTIA='ESPECIFICAR',
            $stmt->bindParam(37, $vacio  ,PDO::PARAM_STR);                                  //@TXT_DESCRIPCION_GARANTIA='',
            $stmt->bindParam(38, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_GARANTIA=0,
            $stmt->bindParam(39, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_LIMITE=0,
            $stmt->bindParam(40, $cod_estado  ,PDO::PARAM_STR);                             //@COD_ESTADO=1,

            $stmt->bindParam(41, $cod_usuario_registro  ,PDO::PARAM_STR);                   //@COD_USUARIO_REGISTRO='JSALDANR        ',
            $stmt->bindParam(42, $valor_cero  ,PDO::PARAM_STR);                             //@IND_INAFECTOIGV=0,
            $stmt->bindParam(43, $valor_cero  ,PDO::PARAM_STR);                             //@IND_GEN_DOC_ELEC=0,
            $stmt->bindParam(44, $valor_cero  ,PDO::PARAM_STR);                             //@IND_COMERCIAL_SERVICIO=0,
            $stmt->bindParam(45, $valor_cero  ,PDO::PARAM_STR);                             //@IND_BOLETEO_INTERES=0,
            $stmt->bindParam(46, $valor_cero  ,PDO::PARAM_STR);                             //@IND_COSTO=0, 
            $stmt->bindParam(47, $valor_cero  ,PDO::PARAM_STR);                             //@IND_GASTO=0,
            $stmt->bindParam(48, $vacio  ,PDO::PARAM_STR);                                  //@COD_CATEGORIA_BANCO='',
            $stmt->bindParam(49, $vacio  ,PDO::PARAM_STR);                                  //@NRO_CUENTA_BANCARIA='',
            $stmt->bindParam(50, $vacio  ,PDO::PARAM_STR);                                  //@TXT_CLAVE_LLAVE=''

            $stmt->execute();
            $coddocumento = $stmt->fetch();

            $COD_ESTABLECIMIENTO_SUNAT  = '0001';
            $stmt = DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC STD.EMPRESA_DIRECCION_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?');
            $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                   //@IND_TIPO_OPERACION='I',
            $stmt->bindParam(2, $vacio  ,PDO::PARAM_STR);                                   //@COD_DIRECCION='                ',
            $stmt->bindParam(3, $coddocumento[0] ,PDO::PARAM_STR);                          //@COD_EMPR='IICHEM0000009259',
            $stmt->bindParam(4, $empresa_id ,PDO::PARAM_STR);                               //@COD_EMPR_SISTEMA='IACHEM0000010394',
            $stmt->bindParam(5, $centro_id ,PDO::PARAM_STR);                                //@COD_CENTRO_SISTEMA='CEN0000000000001',
            $stmt->bindParam(6, $direccion  ,PDO::PARAM_STR);                               //@NOM_DIRECCION='CAL. CRISTOBAL COLON NRO 222 CERCADO DE CHICLAYO ',

            $stmt->bindParam(7, $departamento_id  ,PDO::PARAM_STR);                         //@COD_DEPARTAMENTO='DEP0000000000014',
            $stmt->bindParam(8, $provincia_id  ,PDO::PARAM_STR);                            //@COD_PROVINCIA='PRO0000000000125',
            $stmt->bindParam(9, $distrito_id  ,PDO::PARAM_STR);                             //@COD_DISTRITO='DIS0000000001211',

            $stmt->bindParam(10, $valor_cero  ,PDO::PARAM_STR);                             //@IND_DEFAULT=0,
            $stmt->bindParam(11, $cod_estado  ,PDO::PARAM_STR);                             //@IND_DIRECCION_FISCAL=1,
            $stmt->bindParam(12, $cod_estado ,PDO::PARAM_STR);                              //@COD_ESTADO=1,
            $stmt->bindParam(13, $cod_usuario_registro  ,PDO::PARAM_STR);                   //@COD_USUARIO_REGISTRO='JSALDANR        ',
            $stmt->bindParam(14, $COD_ESTABLECIMIENTO_SUNAT  ,PDO::PARAM_STR);              //@COD_ESTABLECIMIENTO_SUNAT='0001           '
            $stmt->execute();

            $cod_id = $coddocumento[0];


        }else{

            $empresa              =   STDEmpresa::where('NRO_DOCUMENTO','=',$ruc)->first();
            $cod_id               =    $empresa->COD_EMPR;
        }







        //CONTRATO
        $COD_CATEGORIA_TIPO_CONTRATO                =   'TCO0000000000019';  
        $TXT_CATEGORIA_TIPO_CONTRATO                =   'PROVEEDOR'; 
        $COD_CATEGORIA_ESTADO_CONTRATO              =   'ECO0000000000001';
        $TXT_CATEGORIA_ESTADO_CONTRATO              =   'GENERADO';
        $COD_CATEGORIA_MONEDA                       =   'MON0000000000001';
        $TXT_CATEGORIA_MONEDA                       =   'SOLES';
        $COD_CATEGORIA_CANAL_VENTA                  =   'CVE0000000000028';
        $TXT_CATEGORIA_CANAL_VENTA                  =   'PROVEEDOR';
        $COD_CATEGORIA_JEFE_VENTA                   =   'JVE0000000000013';
        $TXT_CATEGORIA_JEFE_VENTA                   =   'ADMINISTRACION';
        $COD_CATEGORIA_SUB_CANAL                    =   'SCV0000000000049';
        $TXT_CATEGORIA_SUB_CANAL                    =   'ADMINISTRACION';
        $fecha_ilimitada                            =    date_format(date_create('1901-01-01'), 'Y-m-d');
        $FEC_CONTRATO                               =    date_format(date_create(date('Y-m-d h:i:s')), 'Ymd');

        //dd($FEC_CONTRATO);


        $stmt = DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.CONTRATO_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
        $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                  //@IND_TIPO_OPERACION='I'
        $stmt->bindParam(2, $vacio  ,PDO::PARAM_STR);                                  //@COD_CONTRATO='                '
        $stmt->bindParam(3, $empresa_id ,PDO::PARAM_STR);                              //@COD_EMPR='IACHEM0000010394'
        $stmt->bindParam(4, $centro_id ,PDO::PARAM_STR);                               //@COD_CENTRO='CEN0000000000001'
        $stmt->bindParam(5, $cod_id ,PDO::PARAM_STR);                                   //@COD_EMPR_CLIENTE='IICHEM0000009259'
        $stmt->bindParam(6, $rz  ,PDO::PARAM_STR);                                     //@TXT_EMPR_CLIENTE='TOMOGRAFIAS CHICLAYO E.I.R.L.'
        $stmt->bindParam(7, $vacio  ,PDO::PARAM_STR);                                  //@COD_EMPR_GARANTE='                '
        $stmt->bindParam(8, $vacio  ,PDO::PARAM_STR);                                  //@TXT_EMPR_GARANTE=''
        $stmt->bindParam(9, $vacio  ,PDO::PARAM_STR);                                  //@COD_EMPR_ACOPIADOR='                '
        $stmt->bindParam(10, $vacio  ,PDO::PARAM_STR);                                 //@TXT_EMPR_ACOPIADOR=''

        $stmt->bindParam(11, $vacio  ,PDO::PARAM_STR);                                 //@COD_DIRECCION=default
        $stmt->bindParam(12, $vacio ,PDO::PARAM_STR);                                  //@COD_TRABAJADOR_APROBACION='                '
        $stmt->bindParam(13, $COD_CATEGORIA_TIPO_CONTRATO  ,PDO::PARAM_STR);           //@COD_CATEGORIA_TIPO_CONTRATO='TCO0000000000019'
        $stmt->bindParam(14, $TXT_CATEGORIA_TIPO_CONTRATO  ,PDO::PARAM_STR);           //@TXT_CATEGORIA_TIPO_CONTRATO='PROVEEDOR'
        $stmt->bindParam(15, $COD_CATEGORIA_ESTADO_CONTRATO ,PDO::PARAM_STR);          //@COD_CATEGORIA_ESTADO_CONTRATO='ECO0000000000001' 
        $stmt->bindParam(16, $TXT_CATEGORIA_ESTADO_CONTRATO ,PDO::PARAM_STR);          //@TXT_CATEGORIA_ESTADO_CONTRATO='GENERADO'
        $stmt->bindParam(17, $COD_CATEGORIA_MONEDA ,PDO::PARAM_STR);                   //@COD_CATEGORIA_MONEDA='MON0000000000001'
        $stmt->bindParam(18, $TXT_CATEGORIA_MONEDA ,PDO::PARAM_STR);                   //@TXT_CATEGORIA_MONEDA='SOLES'
        $stmt->bindParam(19, $COD_CATEGORIA_CANAL_VENTA ,PDO::PARAM_STR);              //@COD_CATEGORIA_CANAL_VENTA='CVE0000000000028'
        $stmt->bindParam(20, $TXT_CATEGORIA_CANAL_VENTA ,PDO::PARAM_STR);              //@TXT_CATEGORIA_CANAL_VENTA='PROVEEDOR'


        $stmt->bindParam(21, $COD_CATEGORIA_JEFE_VENTA ,PDO::PARAM_STR);               //@COD_CATEGORIA_JEFE_VENTA='JVE0000000000013'
        $stmt->bindParam(22, $TXT_CATEGORIA_JEFE_VENTA ,PDO::PARAM_STR);               //@TXT_CATEGORIA_JEFE_VENTA='ADMINISTRACION'
        $stmt->bindParam(23, $COD_CATEGORIA_SUB_CANAL ,PDO::PARAM_STR);                //@COD_CATEGORIA_SUB_CANAL='SCV0000000000049'
        $stmt->bindParam(24, $TXT_CATEGORIA_SUB_CANAL ,PDO::PARAM_STR);                //@TXT_CATEGORIA_SUB_CANAL='ADMINISTRACION'
        $stmt->bindParam(25, $FEC_CONTRATO ,PDO::PARAM_STR);                           //@FEC_CONTRATO='2025-05-06 00:00:00'
        $stmt->bindParam(26, $fecha_ilimitada ,PDO::PARAM_STR);                        //@FEC_INICIO_CAMPANA='1901-01-01 00:00:00'
        $stmt->bindParam(27, $fecha_ilimitada  ,PDO::PARAM_STR);                       //@FEC_FIN_CAMPANA='1901-01-01 00:00:00'
        $stmt->bindParam(28, $valor_cero ,PDO::PARAM_STR);                             //@CAN_LIMITE_CREDITO=0
        $stmt->bindParam(29, $valor_cero ,PDO::PARAM_STR);                             //@CAN_GARANTIA=0
        $stmt->bindParam(30, $valor_cero  ,PDO::PARAM_STR);                            //@CAN_HECTAREAS=0


        $stmt->bindParam(31, $valor_cero ,PDO::PARAM_STR);                             //@CAN_TEA=0
        $stmt->bindParam(32, $valor_cero ,PDO::PARAM_STR);                             //@CAN_SALDO_MN=0
        $stmt->bindParam(33, $valor_cero ,PDO::PARAM_STR);                             //@CAN_SALDO_ME=0
        $stmt->bindParam(34, $valor_cero ,PDO::PARAM_STR);                             //@CAN_SALDO_INTERES=0
        $stmt->bindParam(35, $vacio  ,PDO::PARAM_STR);                                 //@TXT_CAMPANA=''
        $stmt->bindParam(36, $vacio  ,PDO::PARAM_STR);                                 //@TXT_DESCRIPCION_HABILITACION=''
        $stmt->bindParam(37, $vacio  ,PDO::PARAM_STR);                                 //@TXT_TIPO_GARANTIA=''
        $stmt->bindParam(38, $vacio  ,PDO::PARAM_STR);                                 //@TXT_GLOSA=''
        $stmt->bindParam(39, $vacio  ,PDO::PARAM_STR);                                 //@TXT_TIPO_REFERENCIA=''
        $stmt->bindParam(40, $vacio  ,PDO::PARAM_STR);                                 //@TXT_REFERENCIA=''

        $stmt->bindParam(41, $cod_estado  ,PDO::PARAM_STR);                            //@COD_ESTADO=1
        $stmt->bindParam(42, $cod_usuario_registro  ,PDO::PARAM_STR);                  //@COD_USUARIO_REGISTRO='JSALDANR        '
        $stmt->bindParam(43, $valor_cero  ,PDO::PARAM_STR);                            //@CAN_SALDO_SGI=0
        $stmt->bindParam(44, $valor_cero  ,PDO::PARAM_STR);                            //@CAN_DIFERENCIA_SGI=0
        $stmt->bindParam(45, $FEC_CONTRATO  ,PDO::PARAM_STR);                          //@FEC_CIERRE_SGI='2025-05-06'

        $stmt->execute();


        $codcontrato = $stmt->fetch();




        $TXT_DESCRIPCION = 'GENERADO AUTOMATICO';
        $CAN_LIMITE_CREDITO_INDIVIDUAL = 9999999.0000;
        $COD_CATEGORIA_ESTADO = 'ECO0000000000001';
        $TXT_CATEGORIA_ESTADO = 'GENERADO';
        $COD_ZONA_COMERCIAL = $zona->COD_ZONA; 
        $TXT_ZONA_COMERCIAL = $zona->TXT_NOMBRE;
        $COD_ZONA_CULTIVO = $zona02->COD_ZONA;
        $TXT_ZONA_CULTIVO = $zona02->TXT_NOMBRE;




        $stmt = DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.CONTRATO_CULTIVO_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
        $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                 //@IND_TIPO_OPERACION='I',
        $stmt->bindParam(2, $codcontrato[0]  ,PDO::PARAM_STR);                        //@COD_CONTRATO='IICHRC0000012002',
        $stmt->bindParam(3, $vacio ,PDO::PARAM_STR);                                  //@COD_CULTIVO=default,
        $stmt->bindParam(4, $COD_ZONA_COMERCIAL ,PDO::PARAM_STR);                     //@COD_ZONA_COMERCIAL='IICHZON000000001',
        $stmt->bindParam(5, $TXT_ZONA_COMERCIAL ,PDO::PARAM_STR);                     //@TXT_ZONA_COMERCIAL='CHICLAYO',
        $stmt->bindParam(6, $COD_ZONA_CULTIVO  ,PDO::PARAM_STR);                      //@COD_ZONA_CULTIVO='IICHZON000000002',
        $stmt->bindParam(7, $TXT_ZONA_CULTIVO  ,PDO::PARAM_STR);                      //@TXT_ZONA_CULTIVO='CHICLAYO',
        $stmt->bindParam(8, $fecha_ilimitada  ,PDO::PARAM_STR);                       //@FEC_EST_COSECHA='1901-01-01 00:00:00',
        $stmt->bindParam(9, $fecha_ilimitada  ,PDO::PARAM_STR);                       //@FEC_COSECHA='1901-01-01 00:00:00',
        $stmt->bindParam(10, $TXT_DESCRIPCION  ,PDO::PARAM_STR);                      //@TXT_DESCRIPCION='GENERADO AUTOMATICO',

        $stmt->bindParam(11, $valor_cero  ,PDO::PARAM_STR);                           //@CAN_HECTAREA=0,
        $stmt->bindParam(12, $vacio ,PDO::PARAM_STR);                                 //@TXT_DIRECCION='',
        $stmt->bindParam(13, $vacio  ,PDO::PARAM_STR);                                //@COD_CATEGORIA_DEPARTAMENTO='                ',
        $stmt->bindParam(14, $vacio  ,PDO::PARAM_STR);                                //@TXT_CATEGORIA_DEPARTAMENTO='',
        $stmt->bindParam(15, $vacio ,PDO::PARAM_STR);                                 //@COD_CATEGORIA_PROVINCIA='                ',
        $stmt->bindParam(16, $vacio ,PDO::PARAM_STR);                                 //@TXT_CATEGORIA_PROVINCIA='',
        $stmt->bindParam(17, $vacio ,PDO::PARAM_STR);                                 //@COD_CATEGORIA_DISTRITO='                ',
        $stmt->bindParam(18, $vacio ,PDO::PARAM_STR);                                 //@TXT_CATEGORIA_DISTRITO='',
        $stmt->bindParam(19, $vacio ,PDO::PARAM_STR);                                 //@TXT_SECTOR_CULTIVO='',
        $stmt->bindParam(20, $vacio ,PDO::PARAM_STR);                                 //@TXT_PARCELA='',

        $stmt->bindParam(21, $vacio ,PDO::PARAM_STR);                                 //@COD_PRODUCTO='                ',
        $stmt->bindParam(22, $vacio ,PDO::PARAM_STR);                                 //@TXT_PRODUCTO='',
        $stmt->bindParam(23, $CAN_LIMITE_CREDITO_INDIVIDUAL ,PDO::PARAM_STR);         //@CAN_LIMITE_CREDITO_INDIVIDUAL=9999999.0000,
        $stmt->bindParam(24, $CAN_LIMITE_CREDITO_INDIVIDUAL ,PDO::PARAM_STR);         //@CAN_LIMITE_CREDITO_MATERIAL=9999999.0000,
        $stmt->bindParam(25, $CAN_LIMITE_CREDITO_INDIVIDUAL ,PDO::PARAM_STR);         //@CAN_LIMITE_CREDITO_SERVICIO=9999999.0000,
        $stmt->bindParam(26, $COD_CATEGORIA_ESTADO ,PDO::PARAM_STR);                  //@COD_CATEGORIA_ESTADO='ECO0000000000001',
        $stmt->bindParam(27, $TXT_CATEGORIA_ESTADO  ,PDO::PARAM_STR);                 //@TXT_CATEGORIA_ESTADO='GENERADO',
        $stmt->bindParam(28, $cod_estado ,PDO::PARAM_STR);                            //@COD_ESTADO=1,
        $stmt->bindParam(29, $cod_usuario_registro ,PDO::PARAM_STR);                  //@COD_USUARIO_REGISTRO='                '
        $stmt->execute();

        return  $cod_id;
    }







    private function lg_enviar_osiris($liquidaciongastos,$tdetliquidaciongastos,$detdocumentolg,$SERIE,$CORRELATIVO,$periodo) {

        $conexionbd         = 'sqlsrv';
        if($liquidaciongastos->COD_CENTRO == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($liquidaciongastos->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }

        $vacio                                          =       '';
        $valor_cero                                     =       '0';
        $fecha_ilimitada                                =       date_format(date_create('1901-01-01'), 'Y-m-d');
        $accion                                         =       'I';
        $cod_empr                                       =       $liquidaciongastos->COD_EMPRESA;
        $nom_empr                                       =       $liquidaciongastos->TXT_EMPRESA;
        $cod_centro                                     =       $liquidaciongastos->COD_CENTRO;
        $cod_trabajador                                 =       $liquidaciongastos->COD_EMPRESA_TRABAJADOR;
        $nom_trabajador                                 =       $liquidaciongastos->TXT_EMPRESA_TRABAJADOR;
        $cod_categoria_tipo_doc                         =       'TDO0000000000028';
        $nom_categoria_tipo_doc                         =       'LIQUIDACION GASTOS';
        $moneda_id                                      =       'MON0000000000001';
        $moneda_nombre                                  =       'SOLES';
        $cod_contrato_receptor                          =       (string)$liquidaciongastos->COD_CUENTA;
        $cod_cultivo_origen                             =       'CCU0000000000001';
        $fecha_emision                                  =       date_format(date_create(date('Y-m-d')), 'd-m-Y'); //PREGUNTAR POR LA FECHA DE EMISION
        $fecha_vencimiento                              =       date_format(date_create(date('Y-m-d')), 'd-m-Y');
        $ind_material_servicio                          =       'S';
        $ind_compra_venta                               =       'C';
        $operador                                       =       '0';
        $cod_categoria_modulo                           =       'MSI0000000000023';
        $cod_categoria_estado_doc_ctble                 =       'EDC0000000000001';
        $txt_categoria_estado_doc_ctble                 =       'GENERADO';
        $cod_categoria_tipo_pago                        =       'TIP0000000000001';
        $txt_categoria_tipo_pago                        =       'CONTADO CONTRA ENTREGA';
        $tipocambio                                     =       DB::table('WEB.TIPOCAMBIO')
                                                                ->where('FEC_CAMBIO','<=',date('d/m/Y'))
                                                                ->orderBy('FEC_CAMBIO', 'desc')
                                                                ->first();
        $can_tipo_cambio                                =       $tipocambio->CAN_VENTA;  
        $can_impuesto_vta                               =       $valor_cero;
        $can_impuesto_renta                             =       $valor_cero;
        $can_sub_total                                  =       $liquidaciongastos->TOTAL;
        $can_total                                      =       $liquidaciongastos->TOTAL;
        $txt_glosa                                      =       (string)$liquidaciongastos->TXT_GLOSA;//'// TOTTU TRUJILLO / 3997 / 3998,';
        $cod_estado                                     =       1;
        $cod_usuario_registro                           =       Session::get('usuario')->name;
        $cod_periodo                                    =       $periodo->COD_PERIODO;
        $ind_notificacion_cliente                       =       'False';


        $stmt = DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.DOCUMENTO_CTBLE_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
        $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                   //@IND_TIPO_OPERACION='I',
        $stmt->bindParam(2, $vacio  ,PDO::PARAM_STR);                                   //@COD_DOCUMENTO_CTBLE='',
        $stmt->bindParam(3, $SERIE ,PDO::PARAM_STR);                                    //@NRO_SERIE='F005',
        $stmt->bindParam(4, $CORRELATIVO ,PDO::PARAM_STR);                              //@NRO_DOC='00000420',
        $stmt->bindParam(5, $cod_empr ,PDO::PARAM_STR);                                 //@COD_EMPR='IACHEM0000010394',
        $stmt->bindParam(6, $cod_centro  ,PDO::PARAM_STR);                              //@COD_CENTRO='CEN0000000000002'
        $stmt->bindParam(7, $cod_empr  ,PDO::PARAM_STR);                                //@COD_EMPR_EMISOR='IACHEM0000010394',
        $stmt->bindParam(8, $nom_empr  ,PDO::PARAM_STR);                                //@TXT_EMPR_EMISOR='INDUAMERICA INTERNACIONAL S.A.C.',
        $stmt->bindParam(9, $cod_trabajador  ,PDO::PARAM_STR);                          //@COD_EMPR_RECEPTOR='IACHEM0000000513',
        $stmt->bindParam(10, $nom_trabajador  ,PDO::PARAM_STR);                         //@TXT_EMPR_RECEPTOR='HIPERMERCADOS TOTTUS S.A.',

        $stmt->bindParam(11, $vacio  ,PDO::PARAM_STR);                                  //@COD_EMPR_IMPRESION='',
        $stmt->bindParam(12, $vacio ,PDO::PARAM_STR);                                   //@TXT_EMPR_IMPRESION='',
        $stmt->bindParam(13, $vacio  ,PDO::PARAM_STR);                                  //@COD_EMPR_ORIGEN='',
        $stmt->bindParam(14, $vacio  ,PDO::PARAM_STR);                                  //@TXT_EMPR_ORIGEN='',
        $stmt->bindParam(15, $vacio ,PDO::PARAM_STR);                                   //@COD_EMPR_DESTINO='', 
        $stmt->bindParam(16, $vacio ,PDO::PARAM_STR);                                   //@TXT_EMPR_DESTINO='', 
        $stmt->bindParam(17, $vacio ,PDO::PARAM_STR);                                   //@COD_EMPR_BANCO='',
        $stmt->bindParam(18, $vacio ,PDO::PARAM_STR);                                   //@TXT_EMPR_BANCO='',
        $stmt->bindParam(19, $cod_categoria_tipo_doc ,PDO::PARAM_STR);                  //@COD_CATEGORIA_TIPO_DOC='TDO0000000000007',
        $stmt->bindParam(20, $nom_categoria_tipo_doc ,PDO::PARAM_STR);                  //@TXT_CATEGORIA_TIPO_DOC='NOTA DE CREDITO',


        $stmt->bindParam(21, $vacio ,PDO::PARAM_STR);                                   //@COD_CATEGORIA_MOTIVO_TRASLADO='',
        $stmt->bindParam(22, $vacio ,PDO::PARAM_STR);                                   //@TXT_CATEGORIA_MOTIVO_TRASLADO='',
        $stmt->bindParam(23, $moneda_id ,PDO::PARAM_STR);                               //@COD_CATEGORIA_MONEDA='MON0000000000001',
        $stmt->bindParam(24, $moneda_nombre ,PDO::PARAM_STR);                           //@TXT_CATEGORIA_MONEDA='SOLES',
        $stmt->bindParam(25, $vacio ,PDO::PARAM_STR);                                   //@COD_CHOFER='',
        $stmt->bindParam(26, $vacio ,PDO::PARAM_STR);                                   //@TXT_CHOFER='',
        $stmt->bindParam(27, $vacio  ,PDO::PARAM_STR);                                  //@COD_DIRECCION_EMISOR='ISRJDI0000000802',
        $stmt->bindParam(28, $vacio ,PDO::PARAM_STR);                                   //@COD_DIRECCION_RECEPTOR='IACHDI0000000445',
        $stmt->bindParam(29, $vacio ,PDO::PARAM_STR);                                   //@COD_DIRECCION_ORIGEN='',
        $stmt->bindParam(30, $vacio  ,PDO::PARAM_STR);                                  //@COD_DIRECCION_DESTINO='IACHDI0000000445',


        $stmt->bindParam(31, $vacio ,PDO::PARAM_STR);                                   //@COD_DIRECCION_IMPRESION='',
        $stmt->bindParam(32, $vacio ,PDO::PARAM_STR);                                   //@COD_CONTRATO_EMISOR='',
        $stmt->bindParam(33, $vacio ,PDO::PARAM_STR);                                   //@COD_CULTIVO_EMISOR='',
        $stmt->bindParam(34, $cod_contrato_receptor ,PDO::PARAM_STR);                   //@COD_CONTRATO_RECEPTOR='IILMRC0000000795',
        $stmt->bindParam(35, $cod_cultivo_origen  ,PDO::PARAM_STR);                     //@COD_CULTIVO_RECEPTOR='CCU0000000000001',
        $stmt->bindParam(36, $vacio  ,PDO::PARAM_STR);                                  //@COD_CONTRATO_ORIGEN='',
        $stmt->bindParam(37, $vacio  ,PDO::PARAM_STR);                                  //@COD_CULTIVO_ORIGEN='',
        $stmt->bindParam(38, $vacio  ,PDO::PARAM_STR);                                  //@COD_CONTRATO_DESTINO='',
        $stmt->bindParam(39, $vacio  ,PDO::PARAM_STR);                                  //@COD_CULTIVO_DESTINO='',
        $stmt->bindParam(40, $fecha_emision  ,PDO::PARAM_STR);                          //@FEC_EMISION='2019-08-09 00:00:00',

        $stmt->bindParam(41, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_RECEPCION='1901-01-01 00:00:00',
        $stmt->bindParam(42, $fecha_ilimitada  ,PDO::PARAM_STR);                            //@FEC_GRACIA='2019-09-08 00:00:00',
        $stmt->bindParam(43, $fecha_vencimiento  ,PDO::PARAM_STR);                       //@FEC_VENCIMIENTO='2019-09-08 00:00:00',
        $stmt->bindParam(44, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_ENTRADA_PLANTA='1901-01-01 00:00:00',
        $stmt->bindParam(45, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_SALIDA_PLANTA='1901-01-01 00:00:00',
        $stmt->bindParam(46, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_LLEGADA_PLANTA='1901-01-01 00:00:00', 
        $stmt->bindParam(47, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_SALIDA_DESTINO='1901-01-01 00:00:00',
        $stmt->bindParam(48, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_LLEGADA_DESTINO='1901-01-01 00:00:00',
        $stmt->bindParam(49, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_TERMINO='1901-01-01 00:00:00',
        $stmt->bindParam(50, $ind_material_servicio  ,PDO::PARAM_STR);                   //@IND_MATERIAL_SERVICIO='M',

        $stmt->bindParam(51, $ind_compra_venta  ,PDO::PARAM_STR);                       //@IND_COMPRA_VENTA='V', 
        $stmt->bindParam(52, $operador  ,PDO::PARAM_STR);                               //@OPERADOR=1,
        $stmt->bindParam(53, $cod_categoria_modulo  ,PDO::PARAM_STR);                   //@COD_CATEGORIA_MODULO='MSI0000000000010',
        $stmt->bindParam(54, $vacio ,PDO::PARAM_STR);                                   //@COD_CATEGORIA_CONDICION_PAGO='',
        $stmt->bindParam(55, $vacio ,PDO::PARAM_STR);                                   //@TXT_CATEGORIA_CONDICION_PAGO='',
        $stmt->bindParam(56, $vacio  ,PDO::PARAM_STR);           //@COD_CATEGORIA_MOTIVO_EMISION='MEM0000000000015',
        $stmt->bindParam(57, $vacio  ,PDO::PARAM_STR);           //@TXT_CATEGORIA_MOTIVO_EMISION='DESCUENTO POR ITEM',
        $stmt->bindParam(58, $cod_categoria_estado_doc_ctble  ,PDO::PARAM_STR);         //@COD_CATEGORIA_ESTADO_DOC_CTBLE='EDC0000000000001',
        $stmt->bindParam(59, $txt_categoria_estado_doc_ctble  ,PDO::PARAM_STR);         //@TXT_CATEGORIA_ESTADO_DOC_CTBLE='GENERADO',
        $stmt->bindParam(60, $cod_categoria_tipo_pago  ,PDO::PARAM_STR);                //@COD_CATEGORIA_TIPO_PAGO='TIP0000000000005',


        $stmt->bindParam(61, $txt_categoria_tipo_pago  ,PDO::PARAM_STR);                //@TXT_CATEGORIA_TIPO_PAGO='CREDITO A 30 DÍAS', 
        $stmt->bindParam(62, $vacio  ,PDO::PARAM_STR);                                  //@COD_CONCEPTO_CENTRO_COSTO='',
        $stmt->bindParam(63, $vacio  ,PDO::PARAM_STR);                                  //@TXT_CONCEPTO_CENTRO_COSTO='',
        $stmt->bindParam(64, $vacio  ,PDO::PARAM_STR);                                  //@COD_VEHICULO='',
        $stmt->bindParam(65, $vacio  ,PDO::PARAM_STR);                                  //@COD_VEHICULO_NO_MOTRIZ='',
        $stmt->bindParam(66, $can_tipo_cambio  ,PDO::PARAM_STR);                        //@CAN_TIPO_CAMBIO=3.2970, 
        $stmt->bindParam(67, $can_impuesto_vta  ,PDO::PARAM_STR);                       //@CAN_IMPUESTO_VTA='',
        $stmt->bindParam(68, $can_impuesto_renta  ,PDO::PARAM_STR);                     //@CAN_IMPUESTO_RENTA='',
        $stmt->bindParam(69, $can_sub_total  ,PDO::PARAM_STR);                          //@CAN_SUB_TOTAL=35607.3200,
        $stmt->bindParam(70, $can_total ,PDO::PARAM_STR);                               //@CAN_TOTAL=35607.3200,


        $stmt->bindParam(71, $valor_cero ,PDO::PARAM_STR);                              //@CAN_COMISION=0, 
        $stmt->bindParam(72, $valor_cero ,PDO::PARAM_STR);                              //@CAN_COSTO_FLETE=0,
        $stmt->bindParam(73, $valor_cero ,PDO::PARAM_STR);                              //@CAN_COSTO_ESTIBA=0,
        $stmt->bindParam(74, $valor_cero ,PDO::PARAM_STR);                              //@CAN_ADELANTO_CUENTA=0,
        $stmt->bindParam(75, $valor_cero ,PDO::PARAM_STR);                              //@CAN_RETENCION=0,
        $stmt->bindParam(76, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PERCEPCION=0, 
        $stmt->bindParam(77, $valor_cero ,PDO::PARAM_STR);                              //@CAN_DETRACCION=0,
        $stmt->bindParam(78, $valor_cero ,PDO::PARAM_STR);                              //@CAN_DCTO=0,
        $stmt->bindParam(79, $valor_cero ,PDO::PARAM_STR);                              //@CAN_NETO_PAGAR=0,
        $stmt->bindParam(80, $valor_cero ,PDO::PARAM_STR);                              //@CAN_IMPORTE_DETRAER=0,


        $stmt->bindParam(81, $can_total  ,PDO::PARAM_STR);                             //@CAN_SALDO=0, 
        $stmt->bindParam(82, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PESO=0,
        $stmt->bindParam(83, $vacio  ,PDO::PARAM_STR);                                  //@NRO_ITT='',
        $stmt->bindParam(84, $vacio ,PDO::PARAM_STR);                                   //@NRO_CPM='',
        $stmt->bindParam(85, $vacio  ,PDO::PARAM_STR);                                  //@TXT_NRO_DETRACCION=' ',
        $stmt->bindParam(86, $vacio  ,PDO::PARAM_STR);                                  //@COD_PAGO_SEGUN='', 
        $stmt->bindParam(87, $vacio  ,PDO::PARAM_STR);                                  //@COD_CLIENTE_REFERENCIA='',
        $stmt->bindParam(88, $vacio  ,PDO::PARAM_STR);                                  //@TXT_NRO_PEDIDO='228164456',
        $stmt->bindParam(89, $vacio  ,PDO::PARAM_STR);                                  //@COD_ENVIAR_A='',
        $stmt->bindParam(90, $vacio  ,PDO::PARAM_STR);                                  //@COD_SERVICIO_GASTO='',


        $stmt->bindParam(91, $vacio  ,PDO::PARAM_STR);                                  //@NOM_SERVICIO_GASTO='',
        $stmt->bindParam(92, $vacio  ,PDO::PARAM_STR);                                  //@NRO_OPERACIONES_CAJA='',
        $stmt->bindParam(93, $txt_glosa  ,PDO::PARAM_STR);                              //@TXT_GLOSA='// TOTTU TRUJILLO / 3997 / 3998',
        $stmt->bindParam(94, $vacio  ,PDO::PARAM_STR);                                  //@TXT_TIPO_REFERENCIA='',
        $stmt->bindParam(95, $vacio  ,PDO::PARAM_STR);                                  //@TXT_REFERENCIA='',     
        $stmt->bindParam(96, $cod_estado  ,PDO::PARAM_STR);                             //@COD_ESTADO=1, 
        $stmt->bindParam(97, $cod_usuario_registro  ,PDO::PARAM_STR);                   //@COD_USUARIO_REGISTRO='PHORNALL',
        $stmt->bindParam(98, $cod_periodo  ,PDO::PARAM_STR);                            //@COD_PERIODO='',
        $stmt->bindParam(99, $vacio  ,PDO::PARAM_STR);                                  //@COD_CUENTA_CONTABLE='',
        $stmt->bindParam(100, $valor_cero ,PDO::PARAM_STR);                             //@CAN_NO_GRAVADAS=0,


        $stmt->bindParam(101, $vacio ,PDO::PARAM_STR);                                  //@COD_EMPR_TRANS='',
        $stmt->bindParam(102, $vacio  ,PDO::PARAM_STR);                                 //@TXT_EMPR_TRANS='',
        $stmt->bindParam(103, $valor_cero  ,PDO::PARAM_STR);                            //@IND_ENTREGADO=0,
        $stmt->bindParam(104, $vacio  ,PDO::PARAM_STR);                                 //@TXT_ENTREGADO='',
        $stmt->bindParam(105, $valor_cero  ,PDO::PARAM_STR);                            //@IND_RECP_ALTERNO=0,
        $stmt->bindParam(106, $valor_cero  ,PDO::PARAM_STR);                            //@IND_EXTORNO=0, 
        $stmt->bindParam(107, $vacio  ,PDO::PARAM_STR);                                 //@NRO_CTA_CTBLE='',
        $stmt->bindParam(108, $vacio  ,PDO::PARAM_STR);                                 //@TXT_ORIGEN='',
        $stmt->bindParam(109, $vacio ,PDO::PARAM_STR);                                  //@COD_CTA_GASTO_FUNCION='',
        $stmt->bindParam(110, $vacio ,PDO::PARAM_STR);                                  //@NRO_CTA_GASTO_FUNCION='',


        $stmt->bindParam(111, $valor_cero  ,PDO::PARAM_STR);                            //@IND_SUSTENTO=0, 
        $stmt->bindParam(112, $vacio  ,PDO::PARAM_STR);                                 //@COD_TIPO_DOCUMENTO_ASOC_ELEC='TDO0000000000001',
        $stmt->bindParam(113, $valor_cero ,PDO::PARAM_STR);                             //@IND_ENVIADO_ELEC=0,
        $stmt->bindParam(114, $vacio ,PDO::PARAM_STR);                                  //@NRO_SERIE_ELEC='',
        $stmt->bindParam(115, $valor_cero  ,PDO::PARAM_STR);                            //@IND_ELECTRONICO=1,
        $stmt->bindParam(116, $valor_cero  ,PDO::PARAM_STR);                            //@IND_AFECTO_IVAP=0, 
        $stmt->bindParam(117, $vacio ,PDO::PARAM_STR);                                  //@COD_CATEGORIA_SELLO='',
        $stmt->bindParam(118, $vacio  ,PDO::PARAM_STR);                                 //@TXT_INFO_ADICIONAL='',
        $stmt->bindParam(119, $valor_cero  ,PDO::PARAM_STR);                            //@IND_GEN_AUTO=0,
        $stmt->bindParam(120, $vacio  ,PDO::PARAM_STR);                                 //@COD_CATEGORIA_REG_CTBLE='',

        $stmt->bindParam(121, $vacio  ,PDO::PARAM_STR);                                 //@COD_FLUJO_CAJA='', 
        $stmt->bindParam(122, $vacio  ,PDO::PARAM_STR);                                 //@COD_ITEM_MOVIMIENTO='',
        $stmt->bindParam(123, $vacio ,PDO::PARAM_STR);                                  //@ESTADO_ELEC='',
        $stmt->bindParam(124, $fecha_ilimitada ,PDO::PARAM_STR);                        //@FEC_DETRAC='1901-01-01 00:00:00',
        $stmt->bindParam(125, $cod_trabajador  ,PDO::PARAM_STR);                        //@COD_EMPR_DOC='IACHEM0000000513',
        $stmt->bindParam(126, $nom_trabajador  ,PDO::PARAM_STR);                        //@TXT_EMPR_DOC='HIPERMERCADOS TOTTUS S.A.', 
        $stmt->bindParam(127, $cod_contrato_receptor ,PDO::PARAM_STR);                  //@COD_CONTRATO_DOC='IILMRC0000000795',
        $stmt->bindParam(128, $cod_cultivo_origen  ,PDO::PARAM_STR);                    //@COD_CULTIVO_DOC='CCU0000000000001',
        $stmt->bindParam(129, $vacio  ,PDO::PARAM_STR);                                 //@COD_DIRECCION_DOC='IACHDI0000000445',
        $stmt->bindParam(130, $vacio  ,PDO::PARAM_STR);                                 //@COD_DIRECCION_EMPR_SIST='',

        $stmt->bindParam(131, $vacio  ,PDO::PARAM_STR);                                 //@TXT_ORDEN_DEVOLUCION='', 
        $stmt->bindParam(132, $vacio  ,PDO::PARAM_STR);                                 //@COD_EMPR_ALTERNATIVA='',
        $stmt->bindParam(133, $vacio ,PDO::PARAM_STR);                                  //@TXT_EMPR_ALTERNATIVA='',
        $stmt->bindParam(134, $vacio ,PDO::PARAM_STR);                                  //@COD_CONTRATO_ALTERNATIVA='',
        $stmt->bindParam(135, $vacio  ,PDO::PARAM_STR);                                 //@COD_CULTIVO_ALTERNATIVA='',
        $stmt->bindParam(136, $vacio  ,PDO::PARAM_STR);                                 //@COD_DIRECCION_ALTERNATIVA='', 
        $stmt->bindParam(137, $vacio ,PDO::PARAM_STR);                                  //@TXT_DIRECCION_ALTERNATIVA='',
        $stmt->bindParam(138, $vacio  ,PDO::PARAM_STR);                                 //@COD_MOTIVO_EXTORNO='',
        $stmt->bindParam(139, $vacio  ,PDO::PARAM_STR);                                 //@GLOSA_EXTORNO='',
        $stmt->bindParam(140, $vacio  ,PDO::PARAM_STR);                                 //@COD_TIPO_LIQUIDACION='',

        $stmt->bindParam(141, $vacio  ,PDO::PARAM_STR);                                 //@TXT_TIPO_LIQUIDACION='', 
        $stmt->bindParam(142, $ind_notificacion_cliente  ,PDO::PARAM_STR);              //@IND_NOTIFICACION_CLIENTE='False',
        $stmt->bindParam(143, $valor_cero  ,PDO::PARAM_STR);                            //@IND_GRATUITO=0,
        $stmt->bindParam(144, $valor_cero  ,PDO::PARAM_STR);                            //@IND_EXPORTACION=0,
        $stmt->execute();
        $coddocumento = $stmt->fetch();



        foreach($tdetliquidaciongastos as $index => $item){


                $vacio                                          =       '';
                $valor_cero                                     =       '0';
                $fecha_ilimitada                                =       date_format(date_create('1901-01-01'), 'Y-m-d');
                $accion                                         =       'I';
                $cod_empr                                       =       $liquidaciongastos->COD_EMPRESA;
                $nom_empr                                       =       $liquidaciongastos->TXT_EMPRESA;
                $cod_centro                                     =       $liquidaciongastos->COD_CENTRO;
                $cod_trabajador                                 =       $item->COD_EMPRESA_PROVEEDOR;
                $nom_trabajador                                 =       $item->TXT_EMPRESA_PROVEEDOR;
                $cod_categoria_tipo_doc                         =       $item->COD_TIPODOCUMENTO;
                $nom_categoria_tipo_doc                         =       $item->TXT_TIPODOCUMENTO;
                $moneda_id                                      =       'MON0000000000001';
                $moneda_nombre                                  =       'SOLES';
                $cod_contrato_receptor                          =       (string)$item->COD_CUENTA;
                $cod_cultivo_origen                             =       'CCU0000000000001';
                $fecha_emision                                  =       date_format(date_create($item->FECHA_EMISION), 'd-m-Y'); //PREGUNTAR POR LA FECHA DE EMISION
                $fecha_vencimiento                              =       date_format(date_create($item->FECHA_EMISION), 'd-m-Y');
                $ind_material_servicio                          =       'S';
                $ind_compra_venta                               =       'C';
                $operador                                       =       '0';
                $cod_categoria_modulo                           =       'MSI0000000000023';
                $cod_categoria_estado_doc_ctble                 =       'EDC0000000000001';
                $txt_categoria_estado_doc_ctble                 =       'GENERADO';
                $cod_categoria_tipo_pago                        =       'TIP0000000000001';
                $txt_categoria_tipo_pago                        =       'CONTADO CONTRA ENTREGA';
                $tipocambio                                     =       DB::table('WEB.TIPOCAMBIO')
                                                                        ->where('FEC_CAMBIO','<=',date('d/m/Y'))
                                                                        ->orderBy('FEC_CAMBIO', 'desc')
                                                                        ->first();
                $can_tipo_cambio                                =       $tipocambio->CAN_VENTA;  
                $can_impuesto_vta                               =       $item->IGV;;
                $can_impuesto_renta                             =       $valor_cero;
                $can_sub_total                                  =       $item->SUBTOTAL;
                $can_total                                      =       $item->TOTAL;
                $txt_glosa                                      =       (string)$item->TXT_GLOSA;//'// TOTTU TRUJILLO / 3997 / 3998,';
                $cod_estado                                     =       1;
                $cod_usuario_registro                           =       Session::get('usuario')->name;
                $cod_periodo                                    =       $periodo->COD_PERIODO;
                $ind_notificacion_cliente                       =       'False';
                $SERIE                                          =       $item->SERIE;
                $CORRELATIVO                                    =       $item->NUMERO;    

                $COD_CONCEPTO_CENTRO_COSTO                      =       $item->COD_COSTO;
                $TXT_CONCEPTO_CENTRO_COSTO                      =       $item->TXT_COSTO;    
                $TXT_TIPO_REFERENCIA                            =       'CMP.DOCUMENTO_CTBLE';
                $TXT_REFERENCIA                                 =       $coddocumento[0]; 

                $gasto                                          =       DB::table('CON.CUENTA_CONTABLE')->where('COD_CUENTA_CONTABLE','=',$item->COD_GASTO)->first();

                $COD_CTA_GASTO_FUNCION                          =       $item->COD_GASTO;
                $NRO_CTA_GASTO_FUNCION                          =       $gasto->NRO_CUENTA;

                $COD_FLUJO_CAJA                                 =       $item->COD_FLUJO;
                $COD_ITEM_MOVIMIENTO                            =       $item->COD_ITEM;






                $stmt = DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.DOCUMENTO_CTBLE_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
                $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                   //@IND_TIPO_OPERACION='I',
                $stmt->bindParam(2, $vacio  ,PDO::PARAM_STR);                                   //@COD_DOCUMENTO_CTBLE='',
                $stmt->bindParam(3, $SERIE ,PDO::PARAM_STR);                                    //@NRO_SERIE='F005',
                $stmt->bindParam(4, $CORRELATIVO ,PDO::PARAM_STR);                              //@NRO_DOC='00000420',
                $stmt->bindParam(5, $cod_empr ,PDO::PARAM_STR);                                 //@COD_EMPR='IACHEM0000010394',
                $stmt->bindParam(6, $cod_centro  ,PDO::PARAM_STR);                              //@COD_CENTRO='CEN0000000000002'
                $stmt->bindParam(7, $cod_trabajador  ,PDO::PARAM_STR);                          //@COD_EMPR_EMISOR='IACHEM0000010394',
                $stmt->bindParam(8, $nom_trabajador  ,PDO::PARAM_STR);                          //@TXT_EMPR_EMISOR='INDUAMERICA INTERNACIONAL S.A.C.',
                $stmt->bindParam(9, $cod_empr  ,PDO::PARAM_STR);                                //@COD_EMPR_RECEPTOR='IACHEM0000000513',
                $stmt->bindParam(10, $nom_empr  ,PDO::PARAM_STR);                               //@TXT_EMPR_RECEPTOR='HIPERMERCADOS TOTTUS S.A.',

                $stmt->bindParam(11, $vacio  ,PDO::PARAM_STR);                                  //@COD_EMPR_IMPRESION='',
                $stmt->bindParam(12, $vacio ,PDO::PARAM_STR);                                   //@TXT_EMPR_IMPRESION='',
                $stmt->bindParam(13, $vacio  ,PDO::PARAM_STR);                                  //@COD_EMPR_ORIGEN='',
                $stmt->bindParam(14, $vacio  ,PDO::PARAM_STR);                                  //@TXT_EMPR_ORIGEN='',
                $stmt->bindParam(15, $vacio ,PDO::PARAM_STR);                                   //@COD_EMPR_DESTINO='', 
                $stmt->bindParam(16, $vacio ,PDO::PARAM_STR);                                   //@TXT_EMPR_DESTINO='', 
                $stmt->bindParam(17, $vacio ,PDO::PARAM_STR);                                   //@COD_EMPR_BANCO='',
                $stmt->bindParam(18, $vacio ,PDO::PARAM_STR);                                   //@TXT_EMPR_BANCO='',
                $stmt->bindParam(19, $cod_categoria_tipo_doc ,PDO::PARAM_STR);                  //@COD_CATEGORIA_TIPO_DOC='TDO0000000000007',
                $stmt->bindParam(20, $nom_categoria_tipo_doc ,PDO::PARAM_STR);                  //@TXT_CATEGORIA_TIPO_DOC='NOTA DE CREDITO',

                $stmt->bindParam(21, $vacio ,PDO::PARAM_STR);                                   //@COD_CATEGORIA_MOTIVO_TRASLADO='',
                $stmt->bindParam(22, $vacio ,PDO::PARAM_STR);                                   //@TXT_CATEGORIA_MOTIVO_TRASLADO='',
                $stmt->bindParam(23, $moneda_id ,PDO::PARAM_STR);                               //@COD_CATEGORIA_MONEDA='MON0000000000001',
                $stmt->bindParam(24, $moneda_nombre ,PDO::PARAM_STR);                           //@TXT_CATEGORIA_MONEDA='SOLES',
                $stmt->bindParam(25, $vacio ,PDO::PARAM_STR);                                   //@COD_CHOFER='',
                $stmt->bindParam(26, $vacio ,PDO::PARAM_STR);                                   //@TXT_CHOFER='',
                $stmt->bindParam(27, $vacio  ,PDO::PARAM_STR);                                  //@COD_DIRECCION_EMISOR='ISRJDI0000000802',
                $stmt->bindParam(28, $vacio ,PDO::PARAM_STR);                                   //@COD_DIRECCION_RECEPTOR='IACHDI0000000445',
                $stmt->bindParam(29, $vacio ,PDO::PARAM_STR);                                   //@COD_DIRECCION_ORIGEN='',
                $stmt->bindParam(30, $vacio  ,PDO::PARAM_STR);                                  //@COD_DIRECCION_DESTINO='IACHDI0000000445',


                $stmt->bindParam(31, $vacio ,PDO::PARAM_STR);                                   //@COD_DIRECCION_IMPRESION='',
                $stmt->bindParam(32, $cod_contrato_receptor ,PDO::PARAM_STR);                   //@COD_CONTRATO_EMISOR='',
                $stmt->bindParam(33, $cod_cultivo_origen ,PDO::PARAM_STR);                      //@COD_CULTIVO_EMISOR='',
                $stmt->bindParam(34, $vacio ,PDO::PARAM_STR);                                   //@COD_CONTRATO_RECEPTOR='IILMRC0000000795',
                $stmt->bindParam(35, $vacio  ,PDO::PARAM_STR);                                  //@COD_CULTIVO_RECEPTOR='CCU0000000000001',
                $stmt->bindParam(36, $vacio  ,PDO::PARAM_STR);                                  //@COD_CONTRATO_ORIGEN='',
                $stmt->bindParam(37, $vacio  ,PDO::PARAM_STR);                                  //@COD_CULTIVO_ORIGEN='',
                $stmt->bindParam(38, $vacio  ,PDO::PARAM_STR);                                  //@COD_CONTRATO_DESTINO='',
                $stmt->bindParam(39, $vacio  ,PDO::PARAM_STR);                                  //@COD_CULTIVO_DESTINO='',
                $stmt->bindParam(40, $fecha_emision  ,PDO::PARAM_STR);                          //@FEC_EMISION='2019-08-09 00:00:00',

                $stmt->bindParam(41, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_RECEPCION='1901-01-01 00:00:00',
                $stmt->bindParam(42, $fecha_ilimitada  ,PDO::PARAM_STR);                            //@FEC_GRACIA='2019-09-08 00:00:00',
                $stmt->bindParam(43, $fecha_vencimiento  ,PDO::PARAM_STR);                       //@FEC_VENCIMIENTO='2019-09-08 00:00:00',
                $stmt->bindParam(44, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_ENTRADA_PLANTA='1901-01-01 00:00:00',
                $stmt->bindParam(45, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_SALIDA_PLANTA='1901-01-01 00:00:00',
                $stmt->bindParam(46, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_LLEGADA_PLANTA='1901-01-01 00:00:00', 
                $stmt->bindParam(47, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_SALIDA_DESTINO='1901-01-01 00:00:00',
                $stmt->bindParam(48, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_LLEGADA_DESTINO='1901-01-01 00:00:00',
                $stmt->bindParam(49, $fecha_ilimitada  ,PDO::PARAM_STR);                         //@FEC_TERMINO='1901-01-01 00:00:00',
                $stmt->bindParam(50, $ind_material_servicio  ,PDO::PARAM_STR);                   //@IND_MATERIAL_SERVICIO='M',

                $stmt->bindParam(51, $ind_compra_venta  ,PDO::PARAM_STR);                       //@IND_COMPRA_VENTA='V', 
                $stmt->bindParam(52, $operador  ,PDO::PARAM_STR);                               //@OPERADOR=1,
                $stmt->bindParam(53, $cod_categoria_modulo  ,PDO::PARAM_STR);                   //@COD_CATEGORIA_MODULO='MSI0000000000010',
                $stmt->bindParam(54, $vacio ,PDO::PARAM_STR);                                   //@COD_CATEGORIA_CONDICION_PAGO='',
                $stmt->bindParam(55, $vacio ,PDO::PARAM_STR);                                   //@TXT_CATEGORIA_CONDICION_PAGO='',
                $stmt->bindParam(56, $vacio  ,PDO::PARAM_STR);                                  //@COD_CATEGORIA_MOTIVO_EMISION='MEM0000000000015',
                $stmt->bindParam(57, $vacio  ,PDO::PARAM_STR);                                  //@TXT_CATEGORIA_MOTIVO_EMISION='DESCUENTO POR ITEM',
                $stmt->bindParam(58, $cod_categoria_estado_doc_ctble  ,PDO::PARAM_STR);         //@COD_CATEGORIA_ESTADO_DOC_CTBLE='EDC0000000000001',
                $stmt->bindParam(59, $txt_categoria_estado_doc_ctble  ,PDO::PARAM_STR);         //@TXT_CATEGORIA_ESTADO_DOC_CTBLE='GENERADO',
                $stmt->bindParam(60, $cod_categoria_tipo_pago  ,PDO::PARAM_STR);                //@COD_CATEGORIA_TIPO_PAGO='TIP0000000000005',


                $stmt->bindParam(61, $txt_categoria_tipo_pago  ,PDO::PARAM_STR);                //@TXT_CATEGORIA_TIPO_PAGO='CREDITO A 30 DÍAS', 
                $stmt->bindParam(62, $COD_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);              //@COD_CONCEPTO_CENTRO_COSTO='',
                $stmt->bindParam(63, $TXT_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);              //@TXT_CONCEPTO_CENTRO_COSTO='',
                $stmt->bindParam(64, $vacio  ,PDO::PARAM_STR);                                  //@COD_VEHICULO='',
                $stmt->bindParam(65, $vacio  ,PDO::PARAM_STR);                                  //@COD_VEHICULO_NO_MOTRIZ='',
                $stmt->bindParam(66, $can_tipo_cambio  ,PDO::PARAM_STR);                        //@CAN_TIPO_CAMBIO=3.2970,
                $stmt->bindParam(67, $can_impuesto_vta  ,PDO::PARAM_STR);                       //@CAN_IMPUESTO_VTA='',
                $stmt->bindParam(68, $can_impuesto_renta  ,PDO::PARAM_STR);                     //@CAN_IMPUESTO_RENTA='',
                $stmt->bindParam(69, $can_sub_total  ,PDO::PARAM_STR);                          //@CAN_SUB_TOTAL=35607.3200,
                $stmt->bindParam(70, $can_total ,PDO::PARAM_STR);                               //@CAN_TOTAL=35607.3200,


                $stmt->bindParam(71, $valor_cero ,PDO::PARAM_STR);                              //@CAN_COMISION=0, 
                $stmt->bindParam(72, $valor_cero ,PDO::PARAM_STR);                              //@CAN_COSTO_FLETE=0,
                $stmt->bindParam(73, $valor_cero ,PDO::PARAM_STR);                              //@CAN_COSTO_ESTIBA=0,
                $stmt->bindParam(74, $valor_cero ,PDO::PARAM_STR);                              //@CAN_ADELANTO_CUENTA=0,
                $stmt->bindParam(75, $valor_cero ,PDO::PARAM_STR);                              //@CAN_RETENCION=0,
                $stmt->bindParam(76, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PERCEPCION=0, 
                $stmt->bindParam(77, $valor_cero ,PDO::PARAM_STR);                              //@CAN_DETRACCION=0,
                $stmt->bindParam(78, $valor_cero ,PDO::PARAM_STR);                              //@CAN_DCTO=0,
                $stmt->bindParam(79, $valor_cero ,PDO::PARAM_STR);                              //@CAN_NETO_PAGAR=0,
                $stmt->bindParam(80, $valor_cero ,PDO::PARAM_STR);                              //@CAN_IMPORTE_DETRAER=0,


                $stmt->bindParam(81, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_SALDO=0, 
                $stmt->bindParam(82, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PESO=0,
                $stmt->bindParam(83, $vacio  ,PDO::PARAM_STR);                                  //@NRO_ITT='',
                $stmt->bindParam(84, $vacio ,PDO::PARAM_STR);                                   //@NRO_CPM='',
                $stmt->bindParam(85, $vacio  ,PDO::PARAM_STR);                                  //@TXT_NRO_DETRACCION=' ',
                $stmt->bindParam(86, $vacio  ,PDO::PARAM_STR);                                  //@COD_PAGO_SEGUN='', 
                $stmt->bindParam(87, $vacio  ,PDO::PARAM_STR);                                  //@COD_CLIENTE_REFERENCIA='',
                $stmt->bindParam(88, $vacio  ,PDO::PARAM_STR);                                  //@TXT_NRO_PEDIDO='228164456',
                $stmt->bindParam(89, $vacio  ,PDO::PARAM_STR);                                  //@COD_ENVIAR_A='',
                $stmt->bindParam(90, $vacio  ,PDO::PARAM_STR);                                  //@COD_SERVICIO_GASTO='',



                $stmt->bindParam(91, $vacio  ,PDO::PARAM_STR);                                  //@NOM_SERVICIO_GASTO='',
                $stmt->bindParam(92, $vacio  ,PDO::PARAM_STR);                                  //@NRO_OPERACIONES_CAJA='',
                $stmt->bindParam(93, $txt_glosa  ,PDO::PARAM_STR);                              //@TXT_GLOSA='// TOTTU TRUJILLO / 3997 / 3998',
                $stmt->bindParam(94, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);                    //@TXT_TIPO_REFERENCIA='',
                $stmt->bindParam(95, $TXT_REFERENCIA  ,PDO::PARAM_STR);                         //@TXT_REFERENCIA='',     
                $stmt->bindParam(96, $cod_estado  ,PDO::PARAM_STR);                             //@COD_ESTADO=1, 
                $stmt->bindParam(97, $cod_usuario_registro  ,PDO::PARAM_STR);                   //@COD_USUARIO_REGISTRO='PHORNALL',
                $stmt->bindParam(98, $cod_periodo  ,PDO::PARAM_STR);                            //@COD_PERIODO='',
                $stmt->bindParam(99, $vacio  ,PDO::PARAM_STR);                                  //@COD_CUENTA_CONTABLE='',
                $stmt->bindParam(100, $valor_cero ,PDO::PARAM_STR);                             //@CAN_NO_GRAVADAS=0,

                $stmt->bindParam(101, $vacio ,PDO::PARAM_STR);                                  //@COD_EMPR_TRANS='',
                $stmt->bindParam(102, $vacio  ,PDO::PARAM_STR);                                 //@TXT_EMPR_TRANS='',
                $stmt->bindParam(103, $valor_cero  ,PDO::PARAM_STR);                            //@IND_ENTREGADO=0,
                $stmt->bindParam(104, $vacio  ,PDO::PARAM_STR);                                 //@TXT_ENTREGADO='',
                $stmt->bindParam(105, $valor_cero  ,PDO::PARAM_STR);                            //@IND_RECP_ALTERNO=0,
                $stmt->bindParam(106, $valor_cero  ,PDO::PARAM_STR);                            //@IND_EXTORNO=0, 
                $stmt->bindParam(107, $vacio  ,PDO::PARAM_STR);                                 //@NRO_CTA_CTBLE='',
                $stmt->bindParam(108, $vacio  ,PDO::PARAM_STR);                                 //@TXT_ORIGEN='',
                $stmt->bindParam(109, $COD_CTA_GASTO_FUNCION ,PDO::PARAM_STR);                  //@COD_CTA_GASTO_FUNCION='',
                $stmt->bindParam(110, $NRO_CTA_GASTO_FUNCION ,PDO::PARAM_STR);                  //@NRO_CTA_GASTO_FUNCION='',


                $stmt->bindParam(111, $valor_cero  ,PDO::PARAM_STR);                            //@IND_SUSTENTO=0, 
                $stmt->bindParam(112, $vacio  ,PDO::PARAM_STR);                                 //@COD_TIPO_DOCUMENTO_ASOC_ELEC='TDO0000000000001',
                $stmt->bindParam(113, $valor_cero ,PDO::PARAM_STR);                             //@IND_ENVIADO_ELEC=0,
                $stmt->bindParam(114, $vacio ,PDO::PARAM_STR);                                  //@NRO_SERIE_ELEC='',
                $stmt->bindParam(115, $valor_cero  ,PDO::PARAM_STR);                            //@IND_ELECTRONICO=1,
                $stmt->bindParam(116, $valor_cero  ,PDO::PARAM_STR);                            //@IND_AFECTO_IVAP=0, 
                $stmt->bindParam(117, $vacio ,PDO::PARAM_STR);                                  //@COD_CATEGORIA_SELLO='',
                $stmt->bindParam(118, $vacio  ,PDO::PARAM_STR);                                 //@TXT_INFO_ADICIONAL='',
                $stmt->bindParam(119, $valor_cero  ,PDO::PARAM_STR);                            //@IND_GEN_AUTO=0,
                $stmt->bindParam(120, $vacio  ,PDO::PARAM_STR);                                 //@COD_CATEGORIA_REG_CTBLE='',

                $stmt->bindParam(121, $COD_FLUJO_CAJA  ,PDO::PARAM_STR);                        //@COD_FLUJO_CAJA='', 
                $stmt->bindParam(122, $COD_ITEM_MOVIMIENTO  ,PDO::PARAM_STR);                   //@COD_ITEM_MOVIMIENTO='',
                $stmt->bindParam(123, $vacio ,PDO::PARAM_STR);                                  //@ESTADO_ELEC='',
                $stmt->bindParam(124, $fecha_ilimitada ,PDO::PARAM_STR);                        //@FEC_DETRAC='1901-01-01 00:00:00',
                $stmt->bindParam(125, $cod_trabajador  ,PDO::PARAM_STR);                        //@COD_EMPR_DOC='IACHEM0000000513',
                $stmt->bindParam(126, $nom_trabajador  ,PDO::PARAM_STR);                        //@TXT_EMPR_DOC='HIPERMERCADOS TOTTUS S.A.', 
                $stmt->bindParam(127, $cod_contrato_receptor ,PDO::PARAM_STR);                  //@COD_CONTRATO_DOC='IILMRC0000000795',
                $stmt->bindParam(128, $cod_cultivo_origen  ,PDO::PARAM_STR);                    //@COD_CULTIVO_DOC='CCU0000000000001',
                $stmt->bindParam(129, $vacio  ,PDO::PARAM_STR);                                 //@COD_DIRECCION_DOC='IACHDI0000000445',
                $stmt->bindParam(130, $vacio  ,PDO::PARAM_STR);                                 //@COD_DIRECCION_EMPR_SIST='',

                $stmt->bindParam(131, $vacio  ,PDO::PARAM_STR);                                 //@TXT_ORDEN_DEVOLUCION='', 
                $stmt->bindParam(132, $vacio  ,PDO::PARAM_STR);                                 //@COD_EMPR_ALTERNATIVA='',
                $stmt->bindParam(133, $vacio ,PDO::PARAM_STR);                                  //@TXT_EMPR_ALTERNATIVA='',
                $stmt->bindParam(134, $vacio ,PDO::PARAM_STR);                                  //@COD_CONTRATO_ALTERNATIVA='',
                $stmt->bindParam(135, $vacio  ,PDO::PARAM_STR);                                 //@COD_CULTIVO_ALTERNATIVA='',
                $stmt->bindParam(136, $vacio  ,PDO::PARAM_STR);                                 //@COD_DIRECCION_ALTERNATIVA='', 
                $stmt->bindParam(137, $vacio ,PDO::PARAM_STR);                                  //@TXT_DIRECCION_ALTERNATIVA='',
                $stmt->bindParam(138, $vacio  ,PDO::PARAM_STR);                                 //@COD_MOTIVO_EXTORNO='',
                $stmt->bindParam(139, $vacio  ,PDO::PARAM_STR);                                 //@GLOSA_EXTORNO='',
                $stmt->bindParam(140, $vacio  ,PDO::PARAM_STR);                                 //@COD_TIPO_LIQUIDACION='',

                $stmt->bindParam(141, $vacio  ,PDO::PARAM_STR);                                 //@TXT_TIPO_LIQUIDACION='', 
                $stmt->bindParam(142, $ind_notificacion_cliente  ,PDO::PARAM_STR);              //@IND_NOTIFICACION_CLIENTE='False',
                $stmt->bindParam(143, $valor_cero  ,PDO::PARAM_STR);                            //@IND_GRATUITO=0,
                $stmt->bindParam(144, $valor_cero  ,PDO::PARAM_STR);                            //@IND_EXPORTACION=0,
                $stmt->execute();
                $coddocumentodet = $stmt->fetch();


                $TXT_TABLA              =       'CMP.DOCUMENTO_CTBLE';
                $TXT_GLOSA              =       'LIQUIDACION GASTOS';

                $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.REFERENCIA_ASOC_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?');
                $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                   //@IND_TIPO_OPERACION='I',
                $stmt->bindParam(2, $coddocumentodet[0]  ,PDO::PARAM_STR);                      //@COD_TABLA='IILMNC0000000495',
                $stmt->bindParam(3, $coddocumento[0] ,PDO::PARAM_STR);                          //@COD_TABLA_ASOC='IILMFC0000005728',
                $stmt->bindParam(4, $TXT_TABLA ,PDO::PARAM_STR);                                //@TXT_TABLA='CMP.DOCUMENTO_CTBLE', 
                $stmt->bindParam(5, $TXT_TABLA ,PDO::PARAM_STR);                                //@TXT_TABLA_ASOC='CMP.DOCUMENTO_CTBLE', 
                $stmt->bindParam(6, $TXT_GLOSA  ,PDO::PARAM_STR);                               //@TXT_GLOSA='NOTA DE CREDITO F005-00000420 / ',
                $stmt->bindParam(7, $vacio  ,PDO::PARAM_STR);                                   //@TXT_TIPO_REFERENCIA='',
                $stmt->bindParam(8, $vacio  ,PDO::PARAM_STR);                                   //@TXT_REFERENCIA='',
                $stmt->bindParam(9, $cod_estado  ,PDO::PARAM_STR);                              //@COD_ESTADO=1,
                $stmt->bindParam(10, $cod_usuario_registro  ,PDO::PARAM_STR);                   //@COD_USUARIO_REGISTRO='PHORNALL',
                $stmt->bindParam(11, $vacio  ,PDO::PARAM_STR);                                  //@TXT_DESCRIPCION='',
                $stmt->bindParam(12, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_AUX1=0,
                $stmt->bindParam(13, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_AUX2=0,
                $stmt->bindParam(14, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_AUX3=0,
                $stmt->execute();

                $TXT_TABLA              =       'CMP.DOCUMENTO_CTBLE';
                $TXT_GLOSA              =       'LIQUIDACION GASTOS';

                $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.REFERENCIA_ASOC_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?');
                $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                   //@IND_TIPO_OPERACION='I',
                $stmt->bindParam(2, $coddocumento[0]  ,PDO::PARAM_STR);                      //@COD_TABLA='IILMNC0000000495',
                $stmt->bindParam(3, $coddocumentodet[0] ,PDO::PARAM_STR);                          //@COD_TABLA_ASOC='IILMFC0000005728',
                $stmt->bindParam(4, $TXT_TABLA ,PDO::PARAM_STR);                                //@TXT_TABLA='CMP.DOCUMENTO_CTBLE', 
                $stmt->bindParam(5, $TXT_TABLA ,PDO::PARAM_STR);                                //@TXT_TABLA_ASOC='CMP.DOCUMENTO_CTBLE', 
                $stmt->bindParam(6, $TXT_GLOSA  ,PDO::PARAM_STR);                               //@TXT_GLOSA='NOTA DE CREDITO F005-00000420 / ',
                $stmt->bindParam(7, $vacio  ,PDO::PARAM_STR);                                   //@TXT_TIPO_REFERENCIA='',
                $stmt->bindParam(8, $vacio  ,PDO::PARAM_STR);                                   //@TXT_REFERENCIA='',
                $stmt->bindParam(9, $cod_estado  ,PDO::PARAM_STR);                              //@COD_ESTADO=1,
                $stmt->bindParam(10, $cod_usuario_registro  ,PDO::PARAM_STR);                   //@COD_USUARIO_REGISTRO='PHORNALL',
                $stmt->bindParam(11, $vacio  ,PDO::PARAM_STR);                                  //@TXT_DESCRIPCION='',
                $stmt->bindParam(12, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_AUX1=0,
                $stmt->bindParam(13, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_AUX2=0,
                $stmt->bindParam(14, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_AUX3=0,
                $stmt->execute();


                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                            ->where('ITEM','=',$item->ITEM)
                                            ->where('ACTIVO','=','1')->get();
                                            
                foreach($detdocumentolg as $indexdoc => $itemdoc){

                        $IND_MATERIAL_SERVICIO                  =       'S';                  
                        $COD_PRODUCTO                           =       $itemdoc->COD_PRODUCTO;
                        $TXT_NOMBRE_PRODUCTO                    =       $itemdoc->TXT_PRODUCTO;
                        $NRO_LINEA                              =       (string)($indexdoc+1);
                        $CAN_PRODUCTO                           =       $itemdoc->CANTIDAD; 
                        $CAN_PRECIO_UNIT_IGV                    =       (string)$itemdoc->TOTAL;
                        $CAN_PRECIO_UNIT                        =       (string)$itemdoc->SUBTOTAL;
                        $COD_ESTADO                             =       '1';
                        $COD_USUARIO_REGISTRO                   =       Session::get('usuario')->name;


                        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.DETALLE_PRODUCTO_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
                        $stmt->bindParam(1, $accion ,PDO::PARAM_STR);                                   //@IND_TIPO_OPERACION='I',
                        $stmt->bindParam(2, $coddocumentodet[0]  ,PDO::PARAM_STR);                      //@COD_TABLA='IILMVR0000002923',
                        $stmt->bindParam(3, $COD_PRODUCTO ,PDO::PARAM_STR);                             //@COD_PRODUCTO='PRD0000000016186',
                        $stmt->bindParam(4, $vacio ,PDO::PARAM_STR);                                    //@COD_LOTE='0000000000000000', 
                        $stmt->bindParam(5, $NRO_LINEA ,PDO::PARAM_STR);                                //@NRO_LINEA=1, 
                        $stmt->bindParam(6, $TXT_NOMBRE_PRODUCTO  ,PDO::PARAM_STR);                     //@TXT_NOMBRE_PRODUCTO='ARROCILLO DE ARROZ AÑEJO X 50 KG',
                        $stmt->bindParam(7, $vacio  ,PDO::PARAM_STR);                                   //@TXT_DETALLE_PRODUCTO='',
                        $stmt->bindParam(8, $CAN_PRODUCTO  ,PDO::PARAM_STR);                            //@CAN_PRODUCTO=1.0000,
                        $stmt->bindParam(9, $valor_cero  ,PDO::PARAM_STR);                              //@CAN_PRODUCTO_ENVIADO=0,
                        $stmt->bindParam(10, $valor_cero  ,PDO::PARAM_STR);                               //@CAN_PESO=50.0000,



                        $stmt->bindParam(11, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PESO_PRODUCTO=50.0000,
                        $stmt->bindParam(12, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PESO_ENVIADO=0,
                        $stmt->bindParam(13, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PESO_INGRESO=0, 
                        $stmt->bindParam(14, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PESO_SALIDA=0, 
                        $stmt->bindParam(15, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PESO_BRUTO=0, 
                        $stmt->bindParam(16, $valor_cero  ,PDO::PARAM_STR);                             //@CAM_PESO_TARA=0,
                        $stmt->bindParam(17, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PESO_NETO=0,
                        $stmt->bindParam(18, $valor_cero  ,PDO::PARAM_STR);                           //@CAN_TASA_IGV=0.1800,
                        $stmt->bindParam(19, $CAN_PRECIO_UNIT_IGV  ,PDO::PARAM_STR);                    //@CAN_PRECIO_UNIT_IGV=2.0000,
                        $stmt->bindParam(20, $CAN_PRECIO_UNIT  ,PDO::PARAM_STR);                        //@CAN_PRECIO_UNIT=2.0000,


                        $stmt->bindParam(21, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PRECIO_ORIGEN=0,
                        $stmt->bindParam(22, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PRECIO_COSTO=2.0000,
                        $stmt->bindParam(23, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PRECIO_BRUTO=0, 
                        $stmt->bindParam(24, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PRECIO_KILOS=0,
                        $stmt->bindParam(25, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PRECIO_SACOS=0, 
                        $stmt->bindParam(26, $CAN_PRECIO_UNIT  ,PDO::PARAM_STR);                        //@CAN_VALOR_VTA=2.0000, 
                        $stmt->bindParam(27, $CAN_PRECIO_UNIT_IGV  ,PDO::PARAM_STR);                    //@CAN_VALOR_VENTA_IGV=2.0000,
                        $stmt->bindParam(28, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_KILOS=0,
                        $stmt->bindParam(29, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_SACOS=0,
                        $stmt->bindParam(30, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PENDIENTE=1.0000,



                        $stmt->bindParam(31, $valor_cero ,PDO::PARAM_STR);                              //@CAN_PORCENTAJE_DESCUENTO=0,
                        $stmt->bindParam(32, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_DESCUENTO=0,
                        $stmt->bindParam(33, $valor_cero ,PDO::PARAM_STR);                              //@CAN_ADELANTO=0, 
                        $stmt->bindParam(34, $vacio ,PDO::PARAM_STR);                                   //@TXT_DESCRIPCION='', 
                        $stmt->bindParam(35, $IND_MATERIAL_SERVICIO ,PDO::PARAM_STR);                   //@IND_MATERIAL_SERVICIO='M' 
                        $stmt->bindParam(36, $valor_cero  ,PDO::PARAM_STR);                             //@IND_IGV=0, 
                        $stmt->bindParam(37, $vacio  ,PDO::PARAM_STR);                                  //@COD_ALMACEN='',
                        $stmt->bindParam(38, $vacio  ,PDO::PARAM_STR);                                  //@TXT_ALMACEN='',
                        $stmt->bindParam(39, $vacio  ,PDO::PARAM_STR);                                  //@COD_OPERACION='',
                        $stmt->bindParam(40, $vacio  ,PDO::PARAM_STR);                                  //@COD_OPERACION_AUX='',

                        $stmt->bindParam(41, $vacio ,PDO::PARAM_STR);                                   //@COD_EMPR_SERV='',
                        $stmt->bindParam(42, $vacio  ,PDO::PARAM_STR);                                  //@TXT_EMPR_SERV='',
                        $stmt->bindParam(43, $vacio ,PDO::PARAM_STR);                                   //@NRO_CONTRATO_SERV='', 
                        $stmt->bindParam(44, $vacio ,PDO::PARAM_STR);                                   //@NRO_CONTRATO_CULTIVO_SERV='', 
                        $stmt->bindParam(45, $vacio ,PDO::PARAM_STR);                                   //@NRO_HABILITACION_SERV='', 
                        $stmt->bindParam(46, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PRECIO_EMPR_SERV=0, 
                        $stmt->bindParam(47, $vacio  ,PDO::PARAM_STR);                                  //@NRO_CONTRATO_GRUPO='',
                        $stmt->bindParam(48, $vacio  ,PDO::PARAM_STR);                                  //@NRO_CONTRATO_CULTIVO_GRUPO='',
                        $stmt->bindParam(49, $vacio  ,PDO::PARAM_STR);                                  //@NRO_HABILITACION_GRUPO='',
                        $stmt->bindParam(50, $vacio  ,PDO::PARAM_STR);                                  //@COD_CATEGORIA_TIPO_PAGO='',

                        $stmt->bindParam(51, $vacio ,PDO::PARAM_STR);                                   //@COD_USUARIO_INGRESO='',
                        $stmt->bindParam(52, $vacio  ,PDO::PARAM_STR);                                  //@COD_USUARIO_SALIDA='',
                        $stmt->bindParam(53, $vacio ,PDO::PARAM_STR);                                   //@TXT_GLOSA_PESO_IN='', 
                        $stmt->bindParam(54, $vacio ,PDO::PARAM_STR);                                   //@TXT_GLOSA_PESO_OUT='', 
                        $stmt->bindParam(55, $vacio ,PDO::PARAM_STR);                                   //@COD_CONCEPTO_CENTRO_COSTO='IICHCC0000000002', 
                        $stmt->bindParam(56, $vacio  ,PDO::PARAM_STR);                                  //@TXT_CONCEPTO_CENTRO_COSTO='ACOPIO', 
                        $stmt->bindParam(57, $TXT_TABLA  ,PDO::PARAM_STR);                                  //@TXT_REFERENCIA='',
                        $stmt->bindParam(58, $coddocumentodet[0]  ,PDO::PARAM_STR);                                  //@TXT_TIPO_REFERENCIA='',
                        $stmt->bindParam(59, $vacio  ,PDO::PARAM_STR);                                  //@IND_COSTO_ARBITRARIO='',
                        $stmt->bindParam(60, $COD_ESTADO  ,PDO::PARAM_STR);                             //@COD_ESTADO=1,

                        $stmt->bindParam(61, $COD_USUARIO_REGISTRO ,PDO::PARAM_STR);                     //@COD_USUARIO_REGISTRO='PHORNALL',
                        $stmt->bindParam(62, $vacio  ,PDO::PARAM_STR);                                  //@COD_TIPO_ESTADO='',
                        $stmt->bindParam(63, $vacio ,PDO::PARAM_STR);                                   //@TXT_TIPO_ESTADO='', 
                        $stmt->bindParam(64, $vacio ,PDO::PARAM_STR);                                   //@TXT_GLOSA_ASIENTO='', 
                        $stmt->bindParam(65, $vacio ,PDO::PARAM_STR);                                   //@TXT_CUENTA_CONTABLE='', 
                        $stmt->bindParam(66, $vacio  ,PDO::PARAM_STR);                                  //@COD_ASIENTO_PROVISION='',
                        $stmt->bindParam(67, $vacio  ,PDO::PARAM_STR);                                  //@COD_ASIENTO_EXTORNO='',
                        $stmt->bindParam(68, $vacio  ,PDO::PARAM_STR);                                  //@COD_ASIENTO_CANJE='',
                        $stmt->bindParam(69, $vacio  ,PDO::PARAM_STR);                                  //@COD_TIPO_DOCUMENTO='',
                        $stmt->bindParam(70, $vacio  ,PDO::PARAM_STR);                                  //@COD_DOCUMENTO_CTBLE='',

                        $stmt->bindParam(71, $vacio ,PDO::PARAM_STR);                                   //@TXT_SERIE_DOCUMENTO='',
                        $stmt->bindParam(72, $vacio  ,PDO::PARAM_STR);                                  //@TXT_NUMERO_DOCUMENTO='',
                        $stmt->bindParam(73, $vacio ,PDO::PARAM_STR);                                   //@COD_GASTO_FUNCION='', 
                        $stmt->bindParam(74, $vacio ,PDO::PARAM_STR);                                   //@COD_CENTRO_COSTO='', 
                        $stmt->bindParam(75, $vacio ,PDO::PARAM_STR);                                   //@COD_ORDEN_COMPRA='', 
                        $stmt->bindParam(76, $fecha_ilimitada  ,PDO::PARAM_STR);                        //@FEC_FECHA_SERV='1901-01-01', 
                        $stmt->bindParam(77, $vacio  ,PDO::PARAM_STR);                                  //@COD_CATEGORIA_TIPO_SERV_ORDEN='',
                        $stmt->bindParam(78, $vacio  ,PDO::PARAM_STR);                                  //@IND_GASTO_COSTO=' ',
                        $stmt->bindParam(79, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_PORCENTAJE_PERCEPCION=0,
                        $stmt->bindParam(80, $valor_cero  ,PDO::PARAM_STR);                             //@CAN_VALOR_PERCEPCION=0
                        $stmt->execute();

                }
        }
        return  $coddocumento[0];
    }

    private function lg_combo_trabajador_fe_documento($todo) {
            
        $array                      =   LqgLiquidacionGasto::select(DB::raw('COD_EMPRESA_TRABAJADOR,TXT_EMPRESA_TRABAJADOR'))
                                        ->groupBy('TXT_EMPRESA_TRABAJADOR')
                                        ->groupBy('COD_EMPRESA_TRABAJADOR')
                                        ->pluck('TXT_EMPRESA_TRABAJADOR','COD_EMPRESA_TRABAJADOR')
                                        ->toArray();


        if($todo=='TODO'){
            $combo                  =   array($todo => $todo) + $array;
        }else{
            $combo                  =   $array;
        }
        return  $combo;                             
    }


    private function lg_lista_cabecera_comprobante_total_validado($fecha_inicio,$fecha_fin,$proveedor_id,$estado_id) {

        $listadatos         =   LqgLiquidacionGasto::where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                ->whereRaw("CAST(FECHA_EMI AS DATE) >= ? and CAST(FECHA_EMI AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->ProveedorLG($proveedor_id)
                                ->EstadoLG($estado_id)
                                ->orderby('FECHA_EMI','ASC')
                                ->get();

        return  $listadatos;
    }


    private function lg_lista_cabecera_comprobante_total_obs_le_administracion() {

        $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                ->where('IND_OBSERVACION','=',0)
                                ->where('AREA_OBSERVACION','=','ADM')
                                ->where('COD_ESTADO','=','ETM0000000000004')
                                ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                ->orderby('FECHA_EMI','ASC')
                                ->get();

        return  $listadatos;
    }

    private function lg_lista_cabecera_comprobante_total_obs_administracion() {

        $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                ->where('IND_OBSERVACION','=',1)
                                ->where('COD_ESTADO','=','ETM0000000000004')
                                ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                ->orderby('FECHA_EMI','ASC')
                                ->get();

        return  $listadatos;
    }


    private function lg_lista_cabecera_comprobante_total_administracion() {

        $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                ->where(function ($query) {
                                    $query->where('IND_OBSERVACION', '<>', 1)
                                          ->orWhereNull('IND_OBSERVACION');
                                })
                                ->where(function ($query) {
                                    $query->where('AREA_OBSERVACION', '=', '')
                                          ->orWhere('AREA_OBSERVACION', '=', 'CONT')
                                          ->orWhereNull('AREA_OBSERVACION');
                                })
                                ->where('COD_ESTADO','=','ETM0000000000004')
                                ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                ->orderby('FECHA_EMI','ASC')
                                ->get();

        return  $listadatos;
    }

    private function lg_lista_cabecera_comprobante_total_jefe() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where(function ($query) {
                                        $query->where('IND_OBSERVACION', '<>', 1)
                                              ->orWhereNull('IND_OBSERVACION');
                                    })
                                    ->where(function ($query) {
                                        $query->where('AREA_OBSERVACION', '=', '')
                                              ->orWhereNull('AREA_OBSERVACION');
                                    })
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }else{

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where(function ($query) {
                                        $query->where('IND_OBSERVACION', '<>', 1)
                                              ->orWhereNull('IND_OBSERVACION');
                                    })
                                    ->where(function ($query) {
                                        $query->where('AREA_OBSERVACION', '=', '')
                                              ->orWhereNull('AREA_OBSERVACION');
                                    })
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }

        return  $listadatos;
    }


    private function lg_lista_cabecera_comprobante_total_contabilidad() {

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where(function ($query) {
                                        $query->where('IND_OBSERVACION', '<>', 1)
                                              ->orWhereNull('IND_OBSERVACION');
                                    })
                                    ->where(function ($query) {
                                        $query->where('AREA_OBSERVACION', '=', '')
                                              ->orWhere('AREA_OBSERVACION', '=', 'JEFE')
                                              ->orWhereNull('AREA_OBSERVACION');
                                    })
                                    ->where('COD_ESTADO','=','ETM0000000000003')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }else{

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where(function ($query) {
                                        $query->where('IND_OBSERVACION', '<>', 1)
                                              ->orWhereNull('IND_OBSERVACION');
                                    })
                                    ->where(function ($query) {
                                        $query->where('AREA_OBSERVACION', '=', '')
                                              ->orWhere('AREA_OBSERVACION', '=', 'JEFE')
                                              ->orWhereNull('AREA_OBSERVACION');
                                    })
                                    //->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000003')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }

        return  $listadatos;
    }



    private function lg_lista_cabecera_comprobante_total_obs_le_jefe() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',0)
                                    ->where('AREA_OBSERVACION','=','JEFE')
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }else{

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',0)
                                    ->where('AREA_OBSERVACION','=','JEFE')
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }

        return  $listadatos;
    }
    private function lg_lista_cabecera_comprobante_total_obs_le_contabilidad() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',0)
                                    ->where('AREA_OBSERVACION','=','CONT')
                                    ->where('COD_ESTADO','=','ETM0000000000003')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }else{

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',0)
                                    ->where('AREA_OBSERVACION','=','CONT')
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000003')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }

        return  $listadatos;
    }

    private function lg_lista_cabecera_comprobante_total_obs_jefe() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',1)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }else{

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',1)
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }

        return  $listadatos;
    }


    private function lg_lista_cabecera_comprobante_total_obs_contabilidad() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',1)
                                    ->where('COD_ESTADO','=','ETM0000000000003')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }else{

            $listadatos         =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',1)
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000003')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }

        return  $listadatos;
    }



    private function lg_calcular_total_observar($iddocumento) {

        $detdocumentolg                     =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                                                ->where('ACTIVO','=',1)
                                                ->get();

        LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                    ->update(
                            [
                                'TOTAL'=> $detdocumentolg->SUM('TOTAL'),
                                'SUBTOTAL'=> $detdocumentolg->SUM('SUBTOTAL'),
                                'IGV'=> $detdocumentolg->SUM('IGV')
                            ]);                   
    }

    private function lg_calcular_total($iddocumento,$item) {

         $detdocumentolg                     =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                                                ->where('ITEM','=',$item)
                                                ->where('ACTIVO','=',1)
                                                ->get();

        LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$item)
                    ->update(
                            [
                                'TOTAL'=> $detdocumentolg->SUM('TOTAL'),
                                'SUBTOTAL'=> $detdocumentolg->SUM('SUBTOTAL'),
                                'IGV'=> $detdocumentolg->SUM('IGV')
                            ]);

        $detdocumentolg                     =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                                                ->where('ACTIVO','=',1)
                                                ->get();

        LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                    ->update(
                            [
                                'TOTAL'=> $detdocumentolg->SUM('TOTAL'),
                                'SUBTOTAL'=> $detdocumentolg->SUM('SUBTOTAL'),
                                'IGV'=> $detdocumentolg->SUM('IGV')
                            ]);                   
    }


    private function lg_calcular_total_cabecera($iddocumento) {

        $detdocumentolg                     =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                                                ->where('ACTIVO','=',1)
                                                ->get();

        LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                    ->update(
                            [
                                'TOTAL'=> $detdocumentolg->SUM('TOTAL'),
                                'SUBTOTAL'=> $detdocumentolg->SUM('SUBTOTAL'),
                                'IGV'=> $detdocumentolg->SUM('IGV')
                            ]);                   
    }


    private function lg_combo_costo_xtrabajador($titulo,$txt_referencia) {

        $array =        DB::table('CON.CENTRO_COSTO')
                        ->where('COD_ESTADO', 1)
                        ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                        ->where('TXT_REFERENCIA_PLANILLA' ,'LIKE', '%'.$txt_referencia.'%')
                        //->where('TXT_REFERENCIA_PLANILLA', $txt_referencia)
                        ->where('IND_MOVIMIENTO', 1)
                        ->orderBy('TXT_NOMBRE')
                        ->pluck('TXT_NOMBRE','COD_CENTRO_COSTO')
                        ->toArray();

        $combo      =       array('' => $titulo) + $array;
        return  $combo;                    
    }


    private function lg_combo_costo($titulo) {

        $array =     DB::table('CON.CENTRO_COSTO')
                            ->where('COD_ESTADO', 1)
                            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                            ->where('IND_MOVIMIENTO', 1)
                            ->orderBy('TXT_NOMBRE')
                            ->pluck('TXT_NOMBRE','COD_CENTRO_COSTO')
                            ->toArray();

        $combo      =       array('' => $titulo) + $array;
        return  $combo;                    
    }

    private function lg_combo_gasto($titulo) {

        $array    =       DB::table('CON.CUENTA_CONTABLE')
                            ->where('COD_ESTADO', 1)
                            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                            ->where('COD_ANIO', date("Y"))
                            ->where('NRO_CUENTA', 'like', '9%') // LIKE en Laravel
                            ->orderBy('COD_CUENTA_CONTABLE')
                            ->pluck('TXT_DESCRIPCION','COD_CUENTA_CONTABLE')
                            ->toArray();

        $combo      =       array('' => $titulo) + $array;
        return  $combo;                    
    }

    private function lg_combo_flujo($titulo) {

        $array      =       DB::table('CON.FLUJO_CAJA')
                            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                            ->where('IND_INGRESO_EGRESO', -1)
                            ->where('COD_ESTADO', 1)
                            ->where('IND_ACTIVO', 1)
                            ->pluck('TXT_NOMBRE','COD_FLUJO_CAJA')
                            ->toArray();

        $combo      =       array('' => $titulo) + $array;
        return  $combo;                    
    }



    private function lg_combo_tipodocumento($titulo) {
        $array      =       STDTipoDocumento::whereIn('COD_TIPO_DOCUMENTO',['TDO0000000000001','TDO0000000000003','TDO0000000000010','TDO0000000000070','TDO0000000000106'])
                            ->pluck('TXT_TIPO_DOCUMENTO','COD_TIPO_DOCUMENTO')
                            ->toArray();
        $combo      =       array('' => $titulo) + $array;
        return  $combo;                    
    }


    private function lg_combo_cuenta($titulo,$todo,$tipocontrato,$centro_id,$empresa_id) {

        $array                          = DB::table('CMP.CONTRATO as TBL')
                                            ->selectRaw("
                                                TBL.COD_CONTRATO,
                                                LEFT(TBL.COD_CONTRATO, 6) + '-0' + CAST(CAST(RIGHT(TBL.COD_CONTRATO, 10) AS INT) AS VARCHAR(10)) + ' -- ' 
                                                + IIF(TBL.COD_CATEGORIA_MONEDA = 'MON0000000000001', 'S/', '$') + ' ' + TBL.TXT_CATEGORIA_TIPO_CONTRATO AS CONTRATO,
                                                TBL.TXT_EMPR_CLIENTE,
                                                TBL.COD_CATEGORIA_TIPO_CONTRATO,
                                                TBL.TXT_CATEGORIA_TIPO_CONTRATO,
                                                TBL.*
                                            ")
                                            ->where('TBL.COD_ESTADO', 1)
                                            ->where('TBL.COD_CATEGORIA_TIPO_CONTRATO', $tipocontrato)
                                            ->where('TBL.COD_EMPR', Session::get('empresas')->COD_EMPR)
                                            ->where('TBL.COD_CENTRO', $centro_id)
                                            ->where('TBL.COD_EMPR_CLIENTE', $empresa_id)
                                            ->whereNotIn('TBL.COD_CATEGORIA_ESTADO_CONTRATO', ['ECO0000000000005', 'ECO0000000000006'])
                                            ->pluck('CONTRATO','COD_CONTRATO')
                                            ->toArray();

        $combo                  =   array('' => $titulo) + $array;

        return  $combo;                    
    }

    private function lg_cuenta_top_1($titulo,$todo,$tipocontrato,$centro_id,$empresa_id) {

        $valor                          = '';
        $array                          = DB::table('CMP.CONTRATO as TBL')
                                            ->selectRaw("
                                                TBL.COD_CONTRATO,
                                                LEFT(TBL.COD_CONTRATO, 6) + '-0' + CAST(CAST(RIGHT(TBL.COD_CONTRATO, 10) AS INT) AS VARCHAR(10)) + ' -- ' 
                                                + IIF(TBL.COD_CATEGORIA_MONEDA = 'MON0000000000001', 'S/', '$') + ' ' + TBL.TXT_CATEGORIA_TIPO_CONTRATO AS CONTRATO,
                                                TBL.TXT_EMPR_CLIENTE,
                                                TBL.COD_CATEGORIA_TIPO_CONTRATO,
                                                TBL.TXT_CATEGORIA_TIPO_CONTRATO,
                                                TBL.*
                                            ")
                                            ->where('TBL.COD_ESTADO', 1)
                                            ->where('TBL.COD_CATEGORIA_TIPO_CONTRATO', $tipocontrato)
                                            ->where('TBL.COD_EMPR', Session::get('empresas')->COD_EMPR)
                                            ->where('TBL.COD_CENTRO', $centro_id)
                                            ->where('TBL.COD_EMPR_CLIENTE', $empresa_id)
                                            ->whereNotIn('TBL.COD_CATEGORIA_ESTADO_CONTRATO', ['ECO0000000000005', 'ECO0000000000006'])
                                            ->first();

        if(count($array)>0){
            $valor                          = $array->COD_CONTRATO;
        }

        return  $valor;                    
    }


    private function lg_combo_cuenta_lg($titulo,$todo,$tipocontrato,$centro_id,$empresa_id) {


        $array                          = DB::table('CMP.CONTRATO as TBL')
                                            ->selectRaw("
                                                TBL.COD_CONTRATO,
                                                LEFT(TBL.COD_CONTRATO, 6) + '-0' + CAST(CAST(RIGHT(TBL.COD_CONTRATO, 10) AS INT) AS VARCHAR(10)) + ' -- ' 
                                                + IIF(TBL.COD_CATEGORIA_MONEDA = 'MON0000000000001', 'S/', '$') + ' ' + TBL.TXT_CATEGORIA_TIPO_CONTRATO AS CONTRATO
                                            ")
                                            ->where('TBL.COD_ESTADO', 1)
                                            //->where('TBL.COD_CATEGORIA_TIPO_CONTRATO', $tipocontrato)
                                            ->where('TBL.COD_EMPR', Session::get('empresas')->COD_EMPR)
                                            ->where('TBL.COD_CENTRO', $centro_id)
                                            ->where('TBL.TXT_EMPR_CLIENTE', $empresa_id)
                                            ->whereNotIn('TBL.COD_CATEGORIA_ESTADO_CONTRATO', ['ECO0000000000005', 'ECO0000000000006'])
                                            ->pluck('CONTRATO','COD_CONTRATO')
                                            ->toArray();

        $combo                  =   array('' => $titulo) + $array;

        return  $combo;                    
    }




    private function lg_subcuenta_top1($titulo,$cod_contrato) {

        $valor = '';
        $array      =       DB::table('CMP.CONTRATO_CULTIVO')
                            ->selectRaw("
                                COD_CONTRATO,
                                TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                            ")
                            ->where('COD_CONTRATO', $cod_contrato)
                            ->first();

        if(count($array)>0){
            $valor = $array->COD_CONTRATO;
        }

        return  $valor;                    
    }



    private function lg_combo_subcuenta($titulo,$cod_contrato) {


        $array      =       DB::table('CMP.CONTRATO_CULTIVO')
                            ->selectRaw("
                                COD_CONTRATO,
                                TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                            ")
                            ->where('COD_CONTRATO', $cod_contrato)
                            ->pluck('TXT_CULTIVO','COD_CONTRATO')
                            ->toArray();

        $combo      =   array('' => $titulo) + $array;

        return  $combo;                    
    }


    private function lg_combo_item($titulo,$flujo_id) {


        $array      =   DB::table('CON.FLUJO_CAJA_ITEM_MOV')
                        ->select('COD_ITEM_MOV', 'TXT_ITEM_MOV', '*') // Seleccionar columnas
                        ->where('COD_ESTADO', 1)
                        ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                        ->where('COD_FLUJO_CAJA', $flujo_id)
                        ->pluck('TXT_ITEM_MOV','COD_ITEM_MOV')
                        ->toArray();

        $combo      =   array('' => $titulo) + $array;

        return  $combo;                    
    }


    private function lg_cuenta($titulo,$todo,$tipocontrato,$centro_id,$empresa_id) {

        $cuenta                          = DB::table('CMP.CONTRATO as TBL')
                                            ->selectRaw("
                                                TBL.COD_CONTRATO,
                                                LEFT(TBL.COD_CONTRATO, 6) + '-0' + CAST(CAST(RIGHT(TBL.COD_CONTRATO, 10) AS INT) AS VARCHAR(10)) + ' -- ' 
                                                + IIF(TBL.COD_CATEGORIA_MONEDA = 'MON0000000000001', 'S/', '$') + ' ' + TBL.TXT_CATEGORIA_TIPO_CONTRATO AS CONTRATO,
                                                TBL.TXT_EMPR_CLIENTE,
                                                TBL.COD_CATEGORIA_TIPO_CONTRATO,
                                                TBL.TXT_CATEGORIA_TIPO_CONTRATO,
                                                TBL.*
                                            ")
                                            ->where('TBL.COD_ESTADO', 1)
                                            ->where('TBL.COD_CATEGORIA_TIPO_CONTRATO', $tipocontrato)
                                            ->where('TBL.COD_EMPR', Session::get('empresas')->COD_EMPR)
                                            ->where('TBL.COD_CENTRO', $centro_id)
                                            ->where('TBL.COD_EMPR_CLIENTE', $empresa_id)
                                            ->whereNotIn('TBL.COD_CATEGORIA_ESTADO_CONTRATO', ['ECO0000000000005', 'ECO0000000000006'])
                                            ->first();

        return  $cuenta;                    
    }






}