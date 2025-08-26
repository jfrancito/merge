<?php

namespace App\Traits;

use App\Modelos\STDEmpresa;
use App\Modelos\WEBAsiento;
use App\Modelos\WEBAsientoMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\WEBCuentaContable;
use App\Modelos\ALMProducto;
use App\Modelos\Categoria;
use App\Modelos\Estado;
use App\Modelos\Conei;
use App\Modelos\FeDocumento;
use App\Modelos\CONPeriodo;
use App\Modelos\Requerimiento;
use App\Modelos\Archivo;
use App\Modelos\PlaSerie;
use App\Modelos\PlaMovilidad;
use App\Modelos\FePlanillaEntregable;


use App\User;


use View;
use Session;
use Hashids;
use Nexmo;
use Keygen;
use Storage;
use File;
use ZipArchive;
use PDO;

trait GeneralesTraits
{

    public function generarAsientoComprasFeDocumento($anio, $empresa, $cod_contable, $ind_anulado, $igv, $ind_recalcular, $centro_costo, $ind_igv, $cod_usuario_registra)
    {
        $pdo = DB::connection()->getPdo();

        // Preparar la llamada con parámetros nombrados
        $sql = "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO] 
                    @anio = :anio,
                    @empresa = :empresa,
                    @cod_contable = :cod_contable,
                    @ind_anulado = :ind_anulado,
                    @igv = :igv,
                    @ind_recalcular = :ind_recalcular,
                    @centro_costo = :centro_costo,
                    @ind_igv = :ind_igv,
                    @cod_usuario_registra = :cod_usuario_registra";

        $stmt = $pdo->prepare($sql);

        // Asignar parámetros
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':cod_contable', $cod_contable);
        $stmt->bindParam(':ind_anulado', $ind_anulado);
        $stmt->bindParam(':igv', $igv);
        $stmt->bindParam(':ind_recalcular', $ind_recalcular);
        $stmt->bindParam(':centro_costo', $centro_costo);
        $stmt->bindParam(':ind_igv', $ind_igv);
        $stmt->bindParam(':cod_usuario_registra', $cod_usuario_registra);

        $stmt->execute();

        // Recoger los 3 result sets
        $resultados = [];
        do {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                $resultados[] = $rows;
            }
        } while ($stmt->nextRowset());

        return $resultados; // Array con 3 tablas
    }

    public function generarAsientoReparableFeDocumento($anio, $empresa, $cod_contable, $ind_anulado, $ind_recalcular, $ind_reversion, $cod_usuario_registra)
    {
        $pdo = DB::connection()->getPdo();

        $sql = "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO] 
                    @anio = :anio,
                    @empresa = :empresa,
                    @cod_contable = :cod_contable,
                    @ind_anulado = :ind_anulado,
                    @ind_recalcular = :ind_recalcular,
                    @ind_reversion = :ind_reversion,
                    @cod_usuario_registra = :cod_usuario_registra";

        $stmt = $pdo->prepare($sql);

        // Enlazar parámetros
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':cod_contable', $cod_contable);
        $stmt->bindParam(':ind_anulado', $ind_anulado);
        $stmt->bindParam(':ind_recalcular', $ind_recalcular);
        $stmt->bindParam(':ind_reversion', $ind_reversion);
        $stmt->bindParam(':cod_usuario_registra', $cod_usuario_registra);

        $stmt->execute();

        // Capturar múltiples tablas que devuelva el SP
        $resultados = [];
        do {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                $resultados[] = $rows;
            }
        } while ($stmt->nextRowset());

        return $resultados; // array con todas las tablas
    }

    /**
     * Ejecuta un procedimiento almacenado que devuelve múltiples tablas
     */
    public static function ejecutarSP($sql, $params = [])
    {
        $pdo = DB::connection()->getPdo();

        $stmt = $pdo->prepare($sql);

        // Vincular parámetros dinámicamente
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        $resultados = [];
        do {
//            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//            if ($rows) {
//                $resultados[] = $rows;
//            }
            // consumir aunque no tenga columnas
            if ($stmt->columnCount() > 0) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($rows) {
                    $resultados[] = $rows;
                }
            }
        } while ($stmt->nextRowset());

        return $resultados; // Array de tablas
    }

    public function gn_numero_pl($serie, $centro_id)
    {

        $dserie = FePlanillaEntregable::where('COD_CENTRO', '=', $centro_id)
            ->where('COD_EMPRESA', '=', Session::get('empresas')->COD_EMPR)
            ->where('SERIE', '=', $serie)
            ->select(DB::raw('max(NUMERO) as numero'))
            ->orderBy('NUMERO', 'desc')
            ->first();

        //conversion a string y suma uno para el siguiente id
        $idsuma = (int)$dserie->numero + 1;
        //concatenar con ceros
        $idopcioncompleta = str_pad($idsuma, 10, "0", STR_PAD_LEFT);
        $idopcioncompleta = $idopcioncompleta;
        return $idopcioncompleta;

    }


    public function gn_numero($serie, $centro_id)
    {

        $dserie = PlaMovilidad::where('COD_CENTRO', '=', $centro_id)
            ->where('COD_EMPRESA', '=', Session::get('empresas')->COD_EMPR)
            ->where('SERIE', '=', $serie)
            ->select(DB::raw('max(NUMERO) as numero'))
            ->orderBy('NUMERO', 'desc')
            ->first();

        //conversion a string y suma uno para el siguiente id
        $idsuma = (int)$dserie->numero + 1;
        //concatenar con ceros
        $idopcioncompleta = str_pad($idsuma, 10, "0", STR_PAD_LEFT);
        $idopcioncompleta = $idopcioncompleta;
        return $idopcioncompleta;

    }

    private function co_generacion_combo_detraccion($txt_grupo, $titulo, $todo)
    {

        $array = DB::table('CMP.CATEGORIA')
            ->where('COD_ESTADO', '=', 1)
            ->where('TXT_GRUPO', '=', $txt_grupo)
            ->where('COD_CATEGORIA', '=', 'DCT0000000000002')
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    public function gn_serie($anio, $mes, $centro_id)
    {

        $serie = '';
        $dserie = PlaSerie::where('activo', '=', 1)
            ->where('COD_CENTRO', '=', $centro_id)
            ->where('COD_EMPRESA', '=', Session::get('empresas')->COD_EMPR)
            ->first();
        if (count($dserie) > 0) {
            $serie = $dserie->SERIE;
        }
        return $serie;
    }

    public function gn_combo_periodo_xempresa($cod_empresa, $todo, $titulo)
    {
        $array = CONPeriodo::where('COD_ESTADO', '=', 1)
            ->where('COD_EMPR', '=', $cod_empresa)
            ->orderBy('TXT_CODIGO', 'DESC')
            ->pluck('TXT_CODIGO', 'COD_PERIODO')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;


    }


    public function gn_combo_periodo_xanio_xempresa($anio, $cod_empresa, $todo, $titulo)
    {
        $array = CONPeriodo::where('COD_ESTADO', '=', 1)
            ->where('COD_ANIO', '=', $anio)
            ->where('COD_EMPR', '=', $cod_empresa)
            ->orderBy('COD_MES', 'DESC')
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;


    }

    public function gn_combo_usuarios()
    {

        $array = User::where('activo', '=', 1)
            ->where('id', '<>', '1CIX00000001')
            ->where('rol_id', '<>', '1CIX00000024')
            ->orderBy('nombre', 'asc')
            ->pluck('nombre', 'id')
            ->toArray();
        $combo = array('' => 'Seleccione quien autorizara') + $array;
        return $combo;
    }

    public function gn_combo_usuarios_id($usuario_id)
    {

        $array = User::where('activo', '=', 1)
            ->where('id', '<>', '1CIX00000001')
            ->where('id', '=', $usuario_id)
            ->where('rol_id', '<>', '1CIX00000024')
            ->orderBy('nombre', 'asc')
            ->pluck('nombre', 'id')
            ->toArray();
        $combo = array('' => 'Seleccione quien autorizara') + $array;
        return $combo;
    }


    public function gn_combo_arendir()
    {

        $array = DB::table('WEB.VALE_RENDIR')
            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
            ->where('COD_USUARIO_CREA_AUD', Session::get('usuario')->id)
            ->where('COD_CATEGORIA_ESTADO_VALE', 'ETM0000000000007')
            ->select(
                'ID',
                DB::raw("ID_OSIRIS + ' - ' + CAST(CAN_TOTAL_IMPORTE AS VARCHAR) AS MONTO")
            )
            ->orderBy('ID', 'asc')
            ->pluck('MONTO', 'ID')
            ->toArray();

        $combo = array('' => 'Seleccione un arendir') + $array;
        return $combo;
    }

    public function gn_arendir_top()
    {

        $arendir_id = '';
        $vale = DB::table('WEB.VALE_RENDIR')
            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
            ->where('COD_USUARIO_CREA_AUD', Session::get('usuario')->id)
            ->where('COD_CATEGORIA_ESTADO_VALE', 'ETM0000000000007')
            ->first();

        if (count($vale) > 0) {
            $arendir_id = $vale->ID;
        }

        return $arendir_id;
    }


    public function gn_direccion_fiscal()
    {
        $direccion = DB::table('STD.EMPRESA as EMP')
            ->join('STD.EMPRESA_DIRECCION as EMD', 'EMP.COD_EMPR', '=', 'EMD.COD_EMPR')
            ->leftJoin('CMP.CATEGORIA as DEP', 'EMD.COD_DEPARTAMENTO', '=', 'DEP.COD_CATEGORIA')
            ->leftJoin('CMP.CATEGORIA as PRO', 'EMD.COD_PROVINCIA', '=', 'PRO.COD_CATEGORIA')
            ->leftJoin('CMP.CATEGORIA as DIS', 'EMD.COD_DISTRITO', '=', 'DIS.COD_CATEGORIA')
            ->where('EMP.COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
            ->where(function ($query) {
                $query->where('EMD.COD_ESTABLECIMIENTO_SUNAT', '<>', '')
                    ->orWhere('EMD.IND_DIRECCION_FISCAL', '=', 1);
            })
            ->where('EMD.IND_DIRECCION_FISCAL', '=', 1)
            ->where('EMD.COD_ESTADO', '=', 1)
            ->select(
                'EMD.COD_DIRECCION',
                DB::raw("EMD.NOM_DIRECCION + ' - ' + DEP.NOM_CATEGORIA + ' - ' + PRO.NOM_CATEGORIA + ' - ' + DIS.NOM_CATEGORIA AS DIRECCION"),
                'EMD.IND_DIRECCION_FISCAL'
            )
            ->first();
        return $direccion;
    }

    private function pc_array_anio_cuentas_contable($empresa_id)
    {
        $array_anio_pc = WEBCuentaContable::where('empresa_id', '=', $empresa_id)
            ->where('activo', '=', 1)
            ->groupBy('anio')
            ->pluck('anio', 'anio')
            ->toArray();

        return $array_anio_pc;

    }

    public function gn_periodo_actual_xanio_xempresa($anio, $mes, $cod_empresa)
    {


        $periodo = CONPeriodo::where('COD_ESTADO', '=', 1)
            ->where('COD_ANIO', '=', $anio)
            ->where('COD_MES', '=', $mes)
            ->where('COD_EMPR', '=', $cod_empresa)
            ->first();


        return $periodo;


    }


    private function buscar_archivo_sunat_local($urlxml)
    {

        $url = '';
        if (file_exists($urlxml)) {
            $url = $urlxml;
        } else {
            $url = '';
        }
        return $url;

    }

    private function buscar_archivo_sunat_td($urlxml)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Cookie: ITMRCONSRUCSESSION=6kQkyY2K12JgySwpdyFvyvXlQGTb2tGwqv5cmkbbTTD2h8hXQ0nJQypQpxs1QB44WRx0hYknLNTpbRTRm16th1bykQPlPyGhLxMQ4yyKnfwdfv7yqty8J2HzJBzBrydVP6kvGTsNNyNFF2pM1kcXN7X0RF7cBQfLlT1TpDjfM5ncB1FJBdfsBrWrJD1Tpgsfy8G0JydRnyyy5Qp3nPNLrpNSLJ8c2n9QTHpNpXPTCnX4vSQq2yMjG2vNGGVGnWJv!637287358!-336427344; TS01fda901=014dc399cb02c7e99dabe548e899a665fcfab9f294b2d2b8c00d75f74ce28e127857a7d560ff80f24bf801a58569542299cd5ae803ddffbd003798123ef9e33a4f9ede5c78'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    }


    private function buscar_ruc_sunat_lg($urlxml)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    }


    private function buscar_archivo_sunat_lg_indicador($urlxml, $fetoken, $pathFiles, $prefijocarperta, $ID_DOCUMENTO, $IND)
    {

        $array_nombre_archivo = array();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,

            CURLOPT_TIMEOUT => 15, // 👈 máximo 10 segundos para la respuesta
            CURLOPT_CONNECTTIMEOUT => 10, // 👈 máximo 5 segundos para conectar

            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $fetoken->TOKEN
            ),
        ));


        $response = curl_exec($curl);
        curl_close($curl);
        $response_array = json_decode($response, true);
        if (!isset($response_array['nomArchivo'])) {
            $array_nombre_archivo = [
                'cod_error' => 1,
                'nombre_archivo' => '',
                'mensaje' => 'Hubo un problema de sunat buscar nuevamente'
            ];
        } else {
            $fileName = $response_array['nomArchivo'];
            $base64File = $response_array['valArchivo'];
            $fileData = base64_decode($base64File);
            $rutafile = $pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ID_DOCUMENTO;
            $rutacompleta = $rutafile . '\\' . $fileName;
            file_put_contents($rutacompleta, $fileData);
            // Descomprimir el ZIP
            $zip = new ZipArchive;
            if ($zip->open($rutacompleta) === TRUE) {
                if ($zip->numFiles > 0) {
                    // Obtener el primer archivo dentro del ZIP (puedes adaptarlo si hay más)
                    $archivoDescomprimido = $zip->getNameIndex(0); // nombre relativo dentro del zip
                    if ($IND == 'IND_XML') {
                        if (substr($archivoDescomprimido, 0, 1) == 'R') {
                            $archivoDescomprimido = $zip->getNameIndex(1); // nombre relativo dentro del zip
                        }
                    }

                }
                $zip->extractTo($rutafile); // descomprime todo
                $zip->close();
                $rutacompleta = $rutafile . '\\' . $archivoDescomprimido;
                $array_nombre_archivo = [
                    'cod_error' => 0,
                    'nombre_archivo' => $response_array['nomArchivo'],
                    'ruta_completa' => $rutacompleta,
                    'nombre_archivo' => $archivoDescomprimido,
                    'mensaje' => 'encontrado con exito'
                ];
            } else {
                $array_nombre_archivo = [
                    'cod_error' => 1,
                    'nombre_archivo' => '',
                    'mensaje' => 'Error al abrir el archivo ZIP'
                ];
            }
        }

        return $array_nombre_archivo;

    }


    private function buscar_archivo_sunat_lg($urlxml, $fetoken, $pathFiles, $prefijocarperta, $ID_DOCUMENTO)
    {

        $array_nombre_archivo = array();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15, // 👈 máximo 10 segundos para la respuesta
            CURLOPT_CONNECTTIMEOUT => 10, // 👈 máximo 5 segundos para conectar
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $fetoken->TOKEN
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_array = json_decode($response, true);
        if (!isset($response_array['nomArchivo'])) {
            $array_nombre_archivo = [
                'cod_error' => 1,
                'nombre_archivo' => '',
                'mensaje' => 'Hubo un problema de sunat buscar nuevamente'
            ];
        } else {
            $fileName = $response_array['nomArchivo'];
            $base64File = $response_array['valArchivo'];
            $fileData = base64_decode($base64File);
            $rutafile = $pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ID_DOCUMENTO;
            $rutacompleta = $rutafile . '\\' . $fileName;
            file_put_contents($rutacompleta, $fileData);
            // Descomprimir el ZIP
            $zip = new ZipArchive;
            if ($zip->open($rutacompleta) === TRUE) {
                if ($zip->numFiles > 0) {
                    // Obtener el primer archivo dentro del ZIP (puedes adaptarlo si hay más)
                    $archivoDescomprimido = $zip->getNameIndex(0); // nombre relativo dentro del zip
                }
                $zip->extractTo($rutafile); // descomprime todo
                $zip->close();
                $rutacompleta = $rutafile . '\\' . $archivoDescomprimido;
                $array_nombre_archivo = [
                    'cod_error' => 0,
                    'nombre_archivo' => $response_array['nomArchivo'],
                    'ruta_completa' => $rutacompleta,
                    'nombre_archivo' => $archivoDescomprimido,
                    'mensaje' => 'encontrado con exito'
                ];
            } else {
                $array_nombre_archivo = [
                    'cod_error' => 1,
                    'nombre_archivo' => '',
                    'mensaje' => 'Error al abrir el archivo ZIP'
                ];
            }
        }

        return $array_nombre_archivo;

    }


    private function buscar_archivo_sunat($urlxml, $fetoken)
    {

        $array_nombre_archivo = array();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15, // 👈 máximo 10 segundos para la respuesta
            CURLOPT_CONNECTTIMEOUT => 10, // 👈 máximo 5 segundos para conectar

            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $fetoken->TOKEN
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_array = json_decode($response, true);

        if (!isset($response_array['nomArchivo'])) {
            $array_nombre_archivo = [
                'cod_error' => 1,
                'nombre_archivo' => '',
                'mensaje' => 'Hubo un problema de sunat buscar nuevamente'
            ];
        } else {
            $fileName = $response_array['nomArchivo'];
            $base64File = $response_array['valArchivo'];
            $array_nombre_archivo = [
                'cod_error' => 0,
                'nombre_archivo' => $response_array['nomArchivo'],
                'mensaje' => 'encontrado con exito'
            ];
            $fileData = base64_decode($base64File);
            $filePath = storage_path('app/sunat/' . $fileName); // Reemplaza 'app/public/' con tu ruta deseada dentro del almacenamiento
            File::put($filePath, $fileData);
        }

        return $array_nombre_archivo;

    }


    private function buscar_archivo_sunat_compra_sire($urlxml, $fetoken)
    {

        $array_nombre_archivo = array();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $fetoken->TOKEN,
                'Cookie: TS012c881c=019edc9eb884f3c173126afd7e374f7b898ce93149f5bce8305ea2963908fce398ac58444d0515e03eda2d885198343181ec82ed38'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response_array = json_decode($response, true);


        return $response_array;

    }


    private function buscar_archivo_sunat_compra($urlxml, $fetoken)
    {

        $array_nombre_archivo = array();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $fetoken->TOKEN
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_array = json_decode($response, true);


        return $response_array;

    }


    private function gn_combo_categoria_array($titulo, $todo, $array)
    {

        $array_t = DB::table('CMP.CATEGORIA')
            ->whereIn('COD_CATEGORIA', $array)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();
        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array_t;
        } else {
            $combo = array('' => $titulo) + $array_t;
        }
        return $combo;
    }


    private function gn_combo_centro($titulo, $todo)
    {

        $array_t = DB::table('ALM.CENTRO')
            ->where('COD_ESTADO', '=', '1')
            ->pluck('NOM_CENTRO', 'COD_CENTRO')
            ->toArray();
        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array_t;
        } else {
            $combo = array('' => $titulo) + $array_t;
        }
        return $combo;
    }


    public function ge_linea_documento($orden_id)
    {
        $item = 1;

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $orden_id)->get();

        if (count($fedocumento) > 0) {
            $item = count($fedocumento) + 1;
        }

        return $item;
    }


    public function ge_validarArchivoDuplicado($nombrearchivo, $registrodestino_id)
    {
        $valor = true;
        $larchivos = Archivo::where('referencia_id', '=', $registrodestino_id)->where('activo', 1)->get();
        foreach ($larchivos as $key => $archivo) {
            if ($nombrearchivo == $archivo->nombre_archivo) {
                $valor = false;
                break;
            }
        }
        return $valor;
    }

    public function getIdEstado($descripcion)
    {
        $id = ($descripcion !== '') ? Categoria::where('tipo_categoria', 'ESTADO_GENERAL')->where('descripcion', $descripcion)->first()->id : '';
        return $id;
    }

    public function getIdTipoMovimiento($descripcion)
    {
        $id = ($descripcion !== '') ? Categoria::where('tipo_categoria', 'TIPO_MOVIMIENTO')->where('descripcion', $descripcion)->first()->id : '';
        return $id;
    }

    public function getIdCompraVenta($descripcion)
    {
        $id = ($descripcion !== '') ? Categoria::where('tipo_categoria', 'COMPRAVENTA')->where('descripcion', $descripcion)->first()->id : '';
        return $id;
    }

    public function getIdMotivoDocumento($descripcion)
    {
        $id = ($descripcion !== '') ? Categoria::where('tipo_categoria', 'MOTIVO_DOCUMENTO')->where('descripcion', $descripcion)->first()->id : '';
        return $id;
    }

    public function getIdTipoCompra($descripcion)
    {
        $id = ($descripcion !== '') ? Categoria::where('tipo_categoria', 'TIPO_COMPRA')->where('descripcion', $descripcion)->first()->id : '';
        return $id;
    }


    public function ge_validarSizeArchivos($files, $arr_archivos, $lote, $limite, $unidad)
    {
        $sw = true;
        $sizerestante = 0;
        $sizefileslote = (float)DB::table('archivos')
            ->where('activo', '=', 1)
            ->where('lote', '=', $lote)
            ->sum('size'); ///en bytes  //1024^2 para ser megas
        $sizefiles = 0;
        foreach ($files as $file) {
            $nombreoriginal = $file->getClientOriginalName();
            if (in_array($nombreoriginal, $arr_archivos)) {
                $sizefiles = $sizefiles + filesize($file);
            }
        }

        if ($limite >= ($sizefileslote + $sizefiles)) {
            //no supera el limite
            $sw = false;
            $sizerestante = $limite - ($sizefileslote + $sizefiles);
        }
        // $sizeusado = $sizefiles + $sizefileslote;
        $sizeusado = $sizefileslote;

        $sizefiles = round(($sizefiles / pow(1024, $unidad)), 2);
        $sizeusado = round(($sizeusado / pow(1024, $unidad)), 2);
        $sizerestante = round(($sizerestante / pow(1024, $unidad)), 2);
        $sizefileslote = round(($sizefileslote / pow(1024, $unidad)), 2);
        $limitesize = round(($limite / pow(1024, $unidad)), 2);

        // dd(compact('sw','sizefiles','sizefileslote','sizeusado','sizerestante','limitesize'));
        return compact('sw', 'sizefiles', 'sizefileslote', 'sizeusado', 'sizerestante', 'limitesize');
    }

    public function ge_isUsuarioAdmin()
    {
        $valor = false;
        if (Session::get('usuario')->id == '1CIX00000001') {
            $valor = true;
        }
        return $valor;
    }

    public function mostrarValor($dato)
    {
        if ($this->ge_isUsuarioAdmin()) {
            dd($dato);
        }
    }

    public function ge_getMensajeError($error, $sw = true)
    {
        $mensaje = ($sw == true) ? 'Ocurrio un error Inesperado' : '';
        if ($this->ge_isUsuarioAdmin()) {
            if (isset($error)) {
                $mensaje = $mensaje . ': ' . $error;
            }
        }
        return $mensaje;
    }

    public function ge_crearCarpetaSiNoExiste($ruta)
    {
        $valor = false;

        if (!file_exists($ruta)) {
            mkdir($ruta, 0777, true);
            $valor = true;
        }
        return $valor;
    }

    private function gn_combo_departamentos()
    {
        $datos = [];
        $datos = DB::table('departamentos')
            ->where('activo', 1)
            ->pluck('descripcion', 'id')
            ->toArray();
        return ['' => 'SELECCIONE DEPARTAMENTO'] + $datos;
    }

    private function gn_generacion_combo_tabla($tabla, $atributo1, $atributo2, $titulo, $todo, $tipoestado)
    {

        $array = DB::table($tabla)
            ->where('activo', '=', 1)
            ->where('tipoestado', '=', $tipoestado)
            ->pluck($atributo2, $atributo1)
            ->toArray();
        if ($titulo == '') {
            $combo = $array;
        } else {
            if ($todo == 'TODO') {
                $combo = array('' => $titulo, $todo => $todo) + $array;
            } else {
                $combo = array('' => $titulo) + $array;
            }
        }

        return $combo;
    }


    private function gn_generacion_combo_tabla_not_array($tabla, $atributo1, $atributo2, $titulo, $todo, $tipoestado, $array)
    {

        $array = DB::table($tabla)
            ->where('activo', '=', 1)
            ->whereNotIn('id', $array)
            ->where('tipoestado', '=', $tipoestado)
            ->pluck($atributo2, $atributo1)
            ->toArray();
        if ($titulo == '') {
            $combo = $array;
        } else {
            if ($todo == 'TODO') {
                $combo = array('' => $titulo, $todo => $todo) + $array;
            } else {
                $combo = array('' => $titulo) + $array;
            }
        }

        return $combo;
    }


    private function gn_generacion_estados_sobrantes($tabla, $atributo1, $atributo2, $titulo, $todo, $tipoestado)
    {

        $periodo_array = Conei::where('institucion_id', '=', Session::get('usuario')->institucion_id)
            ->where('periodo_id', '<>', 'ESRE00000003')
            ->pluck('periodo_id')
            ->toArray();

        $array = DB::table($tabla)
            ->whereNotIn('id', $periodo_array)
            ->where('activo', '=', 1)
            ->where('tipoestado', '=', $tipoestado)
            ->pluck($atributo2, $atributo1)
            ->toArray();
        if ($titulo == '') {
            $combo = $array;
        } else {
            if ($todo == 'TODO') {
                $combo = array('' => $titulo, $todo => $todo) + $array;
            } else {
                $combo = array('' => $titulo) + $array;
            }
        }

        return $combo;
    }


    private function gn_combo_provincias($departamento_id)
    {
        $datos = [];
        $datos = DB::table('provincias')
            ->where('departamento_id', '=', $departamento_id)
            ->where('activo', 1)
            ->pluck('descripcion', 'id')
            ->toArray();
        return ['' => 'SELECCIONE PROVINCIA'] + $datos;
    }

    private function gn_combo_distritos($provincia_id)
    {
        $datos = [];
        $datos = DB::table('distritos')
            ->where('provincia_id', '=', $provincia_id)
            ->where('activo', 1)
            ->pluck('descripcion', 'id')
            ->toArray();
        return ['' => 'SELECCIONE DISTRITO'] + $datos;
    }

    private function gn_combo_categoria($tipocategoria, $titulo, $todo)
    {
        $array = DB::table('categorias')
            ->where('activo', '=', 1)
            ->where('tipo_categoria', '=', $tipocategoria)
            ->pluck('descripcion', 'id')
            ->toArray();
        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }
        return $combo;
    }

    private function gn_combo_estadoscompras($titulo, $todo)
    {
        $array = DB::table('categorias')
            ->where('activo', '=', 1)
            ->where('tipo_categoria', '=', 'ESTADO_GENERAL')
            ->whereIn('descripcion', ['GENERADO', 'EMITIDO', 'EXTORNADO'])
            ->pluck('descripcion', 'id')
            ->toArray();
        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }
        return $combo;
    }

    private function gn_generacion_combo_array($titulo, $todo, $array)
    {
        if ($todo == 'TODO') {
            $combo_anio_pc = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo_anio_pc = array('' => $titulo) + $array;
        }
        return $combo_anio_pc;
    }

    private function gn_generacion_combo($tabla, $atributo1, $atributo2, $titulo, $todo)
    {

        $array = DB::table($tabla)
            ->where('activo', '=', 1)
            ->pluck($atributo2, $atributo1)
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    private function gn_generacion_combo_tabla_osiris($tabla, $atributo1, $atributo2, $titulo, $todo)
    {

        $array = DB::table($tabla)
            ->where('COD_ESTADO', '=', 1)
            ->pluck($atributo2, $atributo1)
            ->toArray();
        if ($titulo == '') {
            $combo = $array;
        } else {
            if ($todo == 'TODO') {
                $combo = array('' => $titulo, $todo => $todo) + $array;
            } else {
                $combo = array('' => $titulo) + $array;
            }
        }

        return $combo;
    }


    private function gn_generacion_combo_direccion($txt_grupo, $titulo, $todo, $id)
    {

        $array = DB::table('CMP.CATEGORIA')
            ->where('COD_ESTADO', '=', 1)
            ->where('TXT_GRUPO', '=', $txt_grupo)
            ->where('COD_CATEGORIA_SUP', '=', $id)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }


    private function gn_generacion_combo_categoria_xid($txt_grupo, $titulo, $todo, $id)
    {

        $array = DB::table('CMP.CATEGORIA')
            ->where('COD_ESTADO', '=', 1)
            ->where('TXT_GRUPO', '=', $txt_grupo)
            ->where('COD_CATEGORIA_SUP', '=', $id)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }


    private function gn_generacion_combo_direccion_lg($titulo, $todo)
    {

        $array = DB::table('STD.EMPRESA as EMP')
            ->join('STD.EMPRESA_DIRECCION as EMD', 'EMP.COD_EMPR', '=', 'EMD.COD_EMPR')
            ->leftJoin('CMP.CATEGORIA as DEP', 'EMD.COD_DEPARTAMENTO', '=', 'DEP.COD_CATEGORIA')
            ->leftJoin('CMP.CATEGORIA as PRO', 'EMD.COD_PROVINCIA', '=', 'PRO.COD_CATEGORIA')
            ->leftJoin('CMP.CATEGORIA as DIS', 'EMD.COD_DISTRITO', '=', 'DIS.COD_CATEGORIA')
            ->where('EMP.COD_EMPR', Session::get('empresas')->COD_EMPR)
            ->where('EMD.COD_ESTADO', 1)
            ->where(function ($query) {
                $query->where('EMD.COD_ESTABLECIMIENTO_SUNAT', '<>', '')
                    ->orWhere('EMD.IND_DIRECCION_FISCAL', 1);
            })
            ->select(
                'EMD.COD_DIRECCION',
                DB::raw("EMD.NOM_DIRECCION + ' - ' + DEP.NOM_CATEGORIA + ' - ' + PRO.NOM_CATEGORIA + ' - ' + DIS.NOM_CATEGORIA AS DIRECCION")
            )
            ->pluck('DIRECCION', 'COD_DIRECCION')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }


    private function gn_generacion_combo_direccion_lg_top($direcion_id)
    {

        $direccion = DB::table('STD.EMPRESA as EMP')
            ->join('STD.EMPRESA_DIRECCION as EMD', 'EMP.COD_EMPR', '=', 'EMD.COD_EMPR')
            ->leftJoin('CMP.CATEGORIA as DEP', 'EMD.COD_DEPARTAMENTO', '=', 'DEP.COD_CATEGORIA')
            ->leftJoin('CMP.CATEGORIA as PRO', 'EMD.COD_PROVINCIA', '=', 'PRO.COD_CATEGORIA')
            ->leftJoin('CMP.CATEGORIA as DIS', 'EMD.COD_DISTRITO', '=', 'DIS.COD_CATEGORIA')
            ->where('EMP.COD_EMPR', Session::get('empresas')->COD_EMPR)
            ->where('EMD.COD_DIRECCION', $direcion_id)
            ->where('EMD.COD_ESTADO', 1)
            ->where(function ($query) {
                $query->where('EMD.COD_ESTABLECIMIENTO_SUNAT', '<>', '')
                    ->orWhere('EMD.IND_DIRECCION_FISCAL', 1);
            })
            ->select(
                'EMD.COD_DIRECCION',
                DB::raw("EMD.NOM_DIRECCION + ' - ' + DEP.NOM_CATEGORIA + ' - ' + PRO.NOM_CATEGORIA + ' - ' + DIS.NOM_CATEGORIA AS DIRECCION")
            )
            ->first();

        return $direccion;
    }


    public function gn_combo_empresa_xcliprov($titulo, $todo, $cliprov)
    {
        $array = [];
        if ($cliprov == 'C') {
            $array = STDEmpresa::where('COD_ESTADO', '=', 1)
                ->where('IND_CLIENTE', '=', 1)
                ->select(DB::raw("NRO_DOCUMENTO + ' ' + NOM_EMPR as NOM_EMPR, COD_EMPR"))
                ->pluck('NOM_EMPR', 'COD_EMPR')
                ->toArray();
        } else {
            $array = STDEmpresa::where('COD_ESTADO', '=', 1)
                ->where('IND_PROVEEDOR', '=', 1)
                ->select(DB::raw("NRO_DOCUMENTO + ' ' + NOM_EMPR as NOM_EMPR, COD_EMPR"))
                ->pluck('NOM_EMPR', 'COD_EMPR')
                ->toArray();
        }

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;

    }

    private function pc_array_nro_cuentas_nombre_xnivel($empresa_id, $nivel, $anio)
    {

        $array_nro_cuenta_pc = WEBCuentaContable::where('empresa_id', '=', $empresa_id)
            ->where('anio', '=', $anio)
            ->where('nivel', '=', $nivel)
            ->where('activo', '=', 1)
            ->orderBy('id', 'asc')
            ->select(DB::raw("nro_cuenta + ' - ' + nombre as nro_cuenta_nombre, id"))
            ->pluck('nro_cuenta_nombre', 'id')
            ->toArray();

        return $array_nro_cuenta_pc;

    }

    private function pc_array_nivel_cuentas_contable($empresa_id, $anio)
    {

        $array_nivel_pc = WEBCuentaContable::where('empresa_id', '=', $empresa_id)
            ->where('activo', '=', 1)
            ->orderBy('WEB.cuentacontables.nivel', 'asc')
            ->groupBy('nivel')
            ->pluck('nivel', 'nivel')
            ->toArray();

        return $array_nivel_pc;

    }

    private function gn_generacion_combo_categoria($txt_grupo, $titulo, $todo)
    {

        $array = DB::table('CMP.CATEGORIA')
            ->where('COD_ESTADO', '=', 1)
            ->where('TXT_GRUPO', '=', $txt_grupo)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }


    public function gn_background_fila_activo($activo)
    {
        $background = '';
        if ($activo == 0) {
            $background = 'fila-desactivada';
        }
        return $background;
    }


    public function gn_combo_tipo_cliente()
    {
        $combo = array('' => 'Seleccione tipo de cliente', '0' => 'Tercero', '1' => 'Relacionada');
        return $combo;
    }

    public function rp_generacion_combo_resultado_control($titulo)
    {
        $combo = array('' => $titulo, '1' => 'Nueva Cita', '2' => 'Resultado');
        return $combo;
    }

    public function rp_sexo_paciente($sexo_letra)
    {
        $sexo = 'Femenino';
        if ($sexo_letra == 'M') {
            $sexo = 'Maculino';
        }
        return $sexo;
    }

    public function rp_tipo_cita($ind_tipo_cita)
    {
        $tipo_cita = 'Nueva Cita';
        if ($ind_tipo_cita == 2) {
            $tipo_cita = 'Resultado';
        }
        return $tipo_cita;
    }

    public function rp_estado_control($ind_atendido)
    {
        $estado = 'Atendido';
        if ($ind_atendido == 0) {
            $estado = 'Sin atender';
        }
        return $estado;
    }


    private function gn_generacion_combo_productos($titulo, $todo)
    {


        $array = ALMProducto::where('COD_ESTADO', '=', 1)
            ->whereIn('IND_MATERIAL_SERVICIO', ['M', 'S'])
            ->pluck('NOM_PRODUCTO', 'COD_PRODUCTO')
            ->take(10)
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    public function gn_generar_total_asientos($COD_ASIENTO)
    {

        $asiento = WEBAsiento::where('COD_ASIENTO', '=', $COD_ASIENTO)->first();
        $total_debe = 0;
        $total_haber = 0;
        $listaasientomovimiento = WEBAsientoMovimiento::where('COD_ASIENTO', '=', $COD_ASIENTO)
            ->where('COD_ESTADO', '=', '1')
            ->where('IND_PRODUCTO', '<>', '2')
            ->orderBy('NRO_LINEA', 'ASC')
            ->get();

        foreach ($listaasientomovimiento as $key => $item) {
            $total_debe = $total_debe + $item->CAN_DEBE_MN;
            $total_haber = $total_haber + $item->CAN_HABER_MN;
        }

        $asiento->CAN_TOTAL_DEBE = $total_debe;
        $asiento->CAN_TOTAL_HABER = $total_haber;
        $asiento->FEC_USUARIO_MODIF_AUD = $this->fechaactual;
        $asiento->COD_USUARIO_MODIF_AUD = Session::get('usuario')->id;
        $asiento->save();

    }

    private function generar_destinos_compras($anio, $empresa, $cod_asiento, $cod_asiento_movimiento, $cod_usuario)
    {

        $stmt2 = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.APLICAR_ASIENTO_DESTINO_RECALCULAR_COMPRAS 
											@ANIO = ?,
											@EMPRESA = ?,
											@COD_ASIENTO_R = ?,
											@COD_ASIENTO_MOVIMIENTO_R = ?,
											@COD_USUARIO = ?');

        $stmt2->bindParam(1, $anio, PDO::PARAM_STR);
        $stmt2->bindParam(2, $empresa, PDO::PARAM_STR);
        $stmt2->bindParam(3, $cod_asiento, PDO::PARAM_STR);
        $stmt2->bindParam(4, $cod_asiento_movimiento, PDO::PARAM_STR);
        $stmt2->bindParam(5, $cod_usuario, PDO::PARAM_STR);
        $stmt2->execute();

    }

    private function calcular_totales_compras($cod_asiento)
    {

        $stmt2 = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ACTUALIZAR_ASIENTO_COMPRAS_TOTALES 
											@COD_ASIENTO = ?');

        $stmt2->bindParam(1, $cod_asiento, PDO::PARAM_STR);
        $stmt2->execute();

    }

    private function ejecutarAsientosIUDConSalida(
        $IND_TIPO_OPERACION = 'I',
        $COD_EMPR = '',
        $COD_CENTRO = '',
        $COD_PERIODO = '',
        $COD_CATEGORIA_TIPO_ASIENTO = '',
        $TXT_CATEGORIA_TIPO_ASIENTO = '',
        $NRO_ASIENTO = '',
        $FEC_ASIENTO = '1901-01-01',
        $TXT_GLOSA = '',
        $COD_CATEGORIA_ESTADO_ASIENTO = '',
        $TXT_CATEGORIA_ESTADO_ASIENTO = '',
        $COD_CATEGORIA_MONEDA = '',
        $TXT_CATEGORIA_MONEDA = '',
        $CAN_TIPO_CAMBIO = 0,
        $CAN_TOTAL_DEBE = 0,
        $CAN_TOTAL_HABER = 0,
        $COD_ASIENTO_EXTORNO = '',
        $COD_ASIENTO_EXTORNADO = '',
        $IND_EXTORNO = 0,
        $COD_ASIENTO_MODELO = '',
        $TXT_TIPO_REFERENCIA = '',
        $TXT_REFERENCIA = '',
        $COD_ESTADO = 0,
        $COD_USUARIO_REGISTRO = '',
        $COD_MOTIVO_EXTORNO = '',
        $GLOSA_EXTORNO = '',
        $COD_EMPR_CLI = '',
        $TXT_EMPR_CLI = '',
        $COD_CATEGORIA_TIPO_DOCUMENTO = '',
        $TXT_CATEGORIA_TIPO_DOCUMENTO = '',
        $NRO_SERIE = '',
        $NRO_DOC = '',
        $FEC_DETRACCION = '1901-01-01',
        $NRO_DETRACCION = '',
        $CAN_DESCUENTO_DETRACCION = 0,
        $CAN_TOTAL_DETRACCION = 0,
        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = '',
        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = '',
        $NRO_SERIE_REF = '',
        $NRO_DOC_REF = '',
        $FEC_VENCIMIENTO = '1901-01-01',
        $IND_AFECTO = 0,
        $COD_CATEGORIA_MONEDA_CONVERSION = '',
        $TXT_CATEGORIA_MONEDA_CONVERSION = ''
    ) {
        $pdo = DB::connection()->getPdo();

        // OJO: ejecutamos el proc y capturamos la salida
        $sql = "
        DECLARE @COD_ASIENTO_OUT CHAR(16);

        EXEC [WEB].[ASIENTOS_IUD]
            @IND_TIPO_OPERACION = :IND_TIPO_OPERACION,
            @COD_ASIENTO = @COD_ASIENTO_OUT OUTPUT,
            @COD_EMPR = :COD_EMPR,
            @COD_CENTRO = :COD_CENTRO,
            @COD_PERIODO = :COD_PERIODO,
            @COD_CATEGORIA_TIPO_ASIENTO = :COD_CATEGORIA_TIPO_ASIENTO,
            @TXT_CATEGORIA_TIPO_ASIENTO = :TXT_CATEGORIA_TIPO_ASIENTO,
            @NRO_ASIENTO = :NRO_ASIENTO,
            @FEC_ASIENTO = :FEC_ASIENTO,
            @TXT_GLOSA = :TXT_GLOSA,
            @COD_CATEGORIA_ESTADO_ASIENTO = :COD_CATEGORIA_ESTADO_ASIENTO,
            @TXT_CATEGORIA_ESTADO_ASIENTO = :TXT_CATEGORIA_ESTADO_ASIENTO,
            @COD_CATEGORIA_MONEDA = :COD_CATEGORIA_MONEDA,
            @TXT_CATEGORIA_MONEDA = :TXT_CATEGORIA_MONEDA,
            @CAN_TIPO_CAMBIO = :CAN_TIPO_CAMBIO,
            @CAN_TOTAL_DEBE = :CAN_TOTAL_DEBE,
            @CAN_TOTAL_HABER = :CAN_TOTAL_HABER,
            @COD_ASIENTO_EXTORNO = :COD_ASIENTO_EXTORNO,
            @COD_ASIENTO_EXTORNADO = :COD_ASIENTO_EXTORNADO,
            @IND_EXTORNO = :IND_EXTORNO,
            @COD_ASIENTO_MODELO = :COD_ASIENTO_MODELO,
            @TXT_TIPO_REFERENCIA = :TXT_TIPO_REFERENCIA,
            @TXT_REFERENCIA = :TXT_REFERENCIA,
            @COD_ESTADO = :COD_ESTADO,
            @COD_USUARIO_REGISTRO = :COD_USUARIO_REGISTRO,
            @COD_MOTIVO_EXTORNO = :COD_MOTIVO_EXTORNO,
            @GLOSA_EXTORNO = :GLOSA_EXTORNO,
            @COD_EMPR_CLI = :COD_EMPR_CLI,
            @TXT_EMPR_CLI = :TXT_EMPR_CLI,
            @COD_CATEGORIA_TIPO_DOCUMENTO = :COD_CATEGORIA_TIPO_DOCUMENTO,
            @TXT_CATEGORIA_TIPO_DOCUMENTO = :TXT_CATEGORIA_TIPO_DOCUMENTO,
            @NRO_SERIE = :NRO_SERIE,
            @NRO_DOC = :NRO_DOC,
            @FEC_DETRACCION = :FEC_DETRACCION,
            @NRO_DETRACCION = :NRO_DETRACCION,
            @CAN_DESCUENTO_DETRACCION = :CAN_DESCUENTO_DETRACCION,
            @CAN_TOTAL_DETRACCION = :CAN_TOTAL_DETRACCION,
            @COD_CATEGORIA_TIPO_DOCUMENTO_REF = :COD_CATEGORIA_TIPO_DOCUMENTO_REF,
            @TXT_CATEGORIA_TIPO_DOCUMENTO_REF = :TXT_CATEGORIA_TIPO_DOCUMENTO_REF,
            @NRO_SERIE_REF = :NRO_SERIE_REF,
            @NRO_DOC_REF = :NRO_DOC_REF,
            @FEC_VENCIMIENTO = :FEC_VENCIMIENTO,
            @IND_AFECTO = :IND_AFECTO,
            @COD_CATEGORIA_MONEDA_CONVERSION = :COD_CATEGORIA_MONEDA_CONVERSION,
            @TXT_CATEGORIA_MONEDA_CONVERSION = :TXT_CATEGORIA_MONEDA_CONVERSION;

        SELECT @COD_ASIENTO_OUT AS COD_ASIENTO;
    ";

        $stmt = $pdo->prepare($sql);

        // Bind de parámetros (los mismos que ya tienes)
        $stmt->bindValue(':IND_TIPO_OPERACION', $IND_TIPO_OPERACION);
        $stmt->bindValue(':COD_EMPR', $COD_EMPR);
        $stmt->bindValue(':COD_CENTRO', $COD_CENTRO);
        $stmt->bindValue(':COD_PERIODO', $COD_PERIODO);
        $stmt->bindValue(':COD_CATEGORIA_TIPO_ASIENTO', $COD_CATEGORIA_TIPO_ASIENTO);
        $stmt->bindValue(':TXT_CATEGORIA_TIPO_ASIENTO', $TXT_CATEGORIA_TIPO_ASIENTO);
        $stmt->bindValue(':NRO_ASIENTO', $NRO_ASIENTO);
        $stmt->bindValue(':FEC_ASIENTO', $FEC_ASIENTO);
        $stmt->bindValue(':TXT_GLOSA', $TXT_GLOSA);
        $stmt->bindValue(':COD_CATEGORIA_ESTADO_ASIENTO', $COD_CATEGORIA_ESTADO_ASIENTO);
        $stmt->bindValue(':TXT_CATEGORIA_ESTADO_ASIENTO', $TXT_CATEGORIA_ESTADO_ASIENTO);
        $stmt->bindValue(':COD_CATEGORIA_MONEDA', $COD_CATEGORIA_MONEDA);
        $stmt->bindValue(':TXT_CATEGORIA_MONEDA', $TXT_CATEGORIA_MONEDA);
        $stmt->bindValue(':CAN_TIPO_CAMBIO', $CAN_TIPO_CAMBIO);
        $stmt->bindValue(':CAN_TOTAL_DEBE', $CAN_TOTAL_DEBE);
        $stmt->bindValue(':CAN_TOTAL_HABER', $CAN_TOTAL_HABER);
        $stmt->bindValue(':COD_ASIENTO_EXTORNO', $COD_ASIENTO_EXTORNO);
        $stmt->bindValue(':COD_ASIENTO_EXTORNADO', $COD_ASIENTO_EXTORNADO);
        $stmt->bindValue(':IND_EXTORNO', $IND_EXTORNO);
        $stmt->bindValue(':COD_ASIENTO_MODELO', $COD_ASIENTO_MODELO);
        $stmt->bindValue(':TXT_TIPO_REFERENCIA', $TXT_TIPO_REFERENCIA);
        $stmt->bindValue(':TXT_REFERENCIA', $TXT_REFERENCIA);
        $stmt->bindValue(':COD_ESTADO', $COD_ESTADO);
        $stmt->bindValue(':COD_USUARIO_REGISTRO', $COD_USUARIO_REGISTRO);
        $stmt->bindValue(':COD_MOTIVO_EXTORNO', $COD_MOTIVO_EXTORNO);
        $stmt->bindValue(':GLOSA_EXTORNO', $GLOSA_EXTORNO);
        $stmt->bindValue(':COD_EMPR_CLI', $COD_EMPR_CLI);
        $stmt->bindValue(':TXT_EMPR_CLI', $TXT_EMPR_CLI);
        $stmt->bindValue(':COD_CATEGORIA_TIPO_DOCUMENTO', $COD_CATEGORIA_TIPO_DOCUMENTO);
        $stmt->bindValue(':TXT_CATEGORIA_TIPO_DOCUMENTO', $TXT_CATEGORIA_TIPO_DOCUMENTO);
        $stmt->bindValue(':NRO_SERIE', $NRO_SERIE);
        $stmt->bindValue(':NRO_DOC', $NRO_DOC);
        $stmt->bindValue(':FEC_DETRACCION', $FEC_DETRACCION);
        $stmt->bindValue(':NRO_DETRACCION', $NRO_DETRACCION);
        $stmt->bindValue(':CAN_DESCUENTO_DETRACCION', $CAN_DESCUENTO_DETRACCION);
        $stmt->bindValue(':CAN_TOTAL_DETRACCION', $CAN_TOTAL_DETRACCION);
        $stmt->bindValue(':COD_CATEGORIA_TIPO_DOCUMENTO_REF', $COD_CATEGORIA_TIPO_DOCUMENTO_REF);
        $stmt->bindValue(':TXT_CATEGORIA_TIPO_DOCUMENTO_REF', $TXT_CATEGORIA_TIPO_DOCUMENTO_REF);
        $stmt->bindValue(':NRO_SERIE_REF', $NRO_SERIE_REF);
        $stmt->bindValue(':NRO_DOC_REF', $NRO_DOC_REF);
        $stmt->bindValue(':FEC_VENCIMIENTO', $FEC_VENCIMIENTO);
        $stmt->bindValue(':IND_AFECTO', $IND_AFECTO);
        $stmt->bindValue(':COD_CATEGORIA_MONEDA_CONVERSION', $COD_CATEGORIA_MONEDA_CONVERSION);
        $stmt->bindValue(':TXT_CATEGORIA_MONEDA_CONVERSION', $TXT_CATEGORIA_MONEDA_CONVERSION);

        // Ejecutamos
        $stmt->execute();

        while ($stmt->columnCount() === 0 && $stmt->nextRowset()) {}

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolvemos el código generado
        return $row ? $row['COD_ASIENTO'] : null;
    }

    private function ejecutarAsientosMovimientosIUDConSalida(array $params)
    {
        $pdo = DB::connection()->getPdo();

        $sql = "
    DECLARE @COD_ASIENTO_MOVIMIENTO_OUT CHAR(16);

    EXEC [WEB].[ASIENTO_MOVIMIENTOS_IUD]
        @IND_TIPO_OPERACION       = :op,
        @COD_ASIENTO_MOVIMIENTO   = @COD_ASIENTO_MOVIMIENTO_OUT OUTPUT,
        @COD_EMPR                 = :empresa,
        @COD_CENTRO               = :centro,
        @COD_ASIENTO              = :asiento,
        @COD_CUENTA_CONTABLE      = :cuenta,
        @TXT_CUENTA_CONTABLE      = :txtCuenta,
        @TXT_GLOSA                = :glosa,
        @CAN_DEBE_MN              = :debeMN,
        @CAN_HABER_MN             = :haberMN,
        @CAN_DEBE_ME              = :debeME,
        @CAN_HABER_ME             = :haberME,
        @NRO_LINEA                = :linea,
        @COD_CUO                  = :codCuo,
        @IND_EXTORNO              = :indExtorno,
        @TXT_TIPO_REFERENCIA      = :txtTipoReferencia,
        @TXT_REFERENCIA           = :txtReferencia,
        @COD_ESTADO               = :codEstado,
        @COD_USUARIO_REGISTRO     = :codUsuario,
        @COD_DOC_CTBLE_REF        = :codDocCtableRef,
        @COD_ORDEN_REF            = :codOrdenRef,
        @IND_PRODUCTO             = :indProducto,
        @COD_PRODUCTO             = :codProducto,
        @TXT_NOMBRE_PRODUCTO      = :txtNombreProducto,
        @COD_LOTE                 = :codLote,
        @NRO_LINEA_PRODUCTO       = :nroLineaProducto;

    SELECT @COD_ASIENTO_MOVIMIENTO_OUT AS COD_ASIENTO_MOVIMIENTO;
    ";

        $stmt = $pdo->prepare($sql);

        // Bind automático usando foreach
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        // Avanzar hasta obtener el SELECT final
        while ($stmt->columnCount() === 0 && $stmt->nextRowset()) {}

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row['COD_ASIENTO_MOVIMIENTO'] : null;

    }


}
