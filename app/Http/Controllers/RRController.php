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
use App\Modelos\CONPeriodo;

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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use Stdclass;
use App\Traits\UserTraits;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;
use App\Traits\RRTraits;


class RRController extends Controller {

    use UserTraits;
    use GeneralesTraits;
    use ComprobanteTraits;
    use RRTraits;

    public function actionAjaxModalValidarRRIs(Request $request)
    {
    	$data_cliente 	 		= 	$request['data_cliente'];
		$fechaInicio = $request['fechainicio'].' 00:00:00';
		$fechaFin = $request['fechafin'].' 00:00:00';
        $anio        = 2024;
        $mes         = 10;
        $codCentro   = 'CEN0000000000001';
        $usuario     = 'JSALDANR';
        $codEmpr     = Session::get('empresas')->COD_EMPR;

        $this->rr_listavalidacion_comercial($fechaInicio,$fechaFin,$anio,$mes,$codCentro,$usuario,$codEmpr);
		$primerCliente = 'INTERNACIONAL MANUEL GUARNIZ S.A.C.';
		$sql = "
		SELECT TT.*
		FROM (
		    SELECT 'OTROS' AS RESULTADO, *
		    FROM TempValidacionRR
		    WHERE ANEXO NOT IN ('R17','R18') AND CLIENTE = :cliente
		    UNION
		    SELECT 'RR' AS RESULTADO, *
		    FROM TempValidacionRR
		    WHERE ANEXO IN ('R17','R18') AND CLIENTE = :cliente
		) TT
		WHERE TT.CLIENTE IN (
		    SELECT OTROS.CLIENTE
		    FROM (
		        SELECT CLIENTE, SUM(IMPORTE) AS SUMA
		        FROM TempValidacionRR
		        WHERE ANEXO IN ('R17','R18')
		        GROUP BY CLIENTE
		    ) OTROS
		    INNER JOIN (
		        SELECT CLIENTE, SUM(IMPORTE) AS SUMA
		        FROM TempValidacionRR
		        WHERE ANEXO NOT IN ('R17','R18')
		        GROUP BY CLIENTE
		    ) RR ON RR.CLIENTE = OTROS.CLIENTE
		    AND ABS(ABS(RR.SUMA) - ABS(OTROS.SUMA)) > 0.0001
		)
		ORDER BY TT.CLIENTE, TT.CODIGO
		";

		$resultado = DB::select(DB::raw($sql), ['cliente' => $primerCliente]);

		dd($resultado);

		$sql = "
		SELECT * FROM (
		    SELECT 'OTROS' AS RESULTADO, *
		    FROM TempGastosVentas
		    WHERE ANEXO NOT IN ('R17','R18') AND CLIENTE = :cliente
		) OTROS
		FULL OUTER JOIN (
		    SELECT 'RR' AS RESULTADO, *
		    FROM TempGastosVentas
		    WHERE ANEXO IN ('R17','R18') AND CLIENTE = :cliente
		) RR
		ON RR.CODIGO = OTROS.CODIGO AND RR.IMPORTE = OTROS.IMPORTE AND RR.MES = OTROS.MES
		WHERE RR.CODIGO IS NULL
		   OR RR.IMPORTE IS NULL
		   OR RR.MES IS NULL
		   OR OTROS.CODIGO IS NULL
		   OR OTROS.IMPORTE IS NULL
		   OR OTROS.MES IS NULL
		";

		$resultado02 = DB::select(DB::raw($sql), ['cliente' => $primerCliente]);



    	dd($resultado01);


    }



    public function actionGestionValidarRR($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Validar Reporte Resultado');
        $funcion        =   $this;
        $inicio 		=	$this->inicioanio;
        $hoy 			=	$this->fin;

		$fechaInicio = $inicio.' 00:00:00';
		$fechaFin = $hoy.' 00:00:00';
        $anio        = 2024;
        $mes         = 10;
        $codCentro   = 'CEN0000000000001';
        $usuario     = 'JSALDANR';
        $codEmpr     = Session::get('empresas')->COD_EMPR;


        $this->rr_listavalidacion_comercial($fechaInicio,$fechaFin,$anio,$mes,$codCentro,$usuario,$codEmpr);


        // 4. Comparar RR vs OTROS
        $diferencias = DB::select("
            SELECT RR.CLIENTE AS CLIENTERR,RR.SUMA AS SUMARR,RR.TIPO AS TIPORR,OTROS.CLIENTE AS CLIENTEO,OTROS.SUMA AS SUMAO,OTROS.TIPO AS TIPOO, ABS(ABS(OTROS.SUMA)-ABS(RR.SUMA)) AS diferencia FROM (
                SELECT CLIENTE, SUM(IMPORTE) AS SUMA, 'RR' AS TIPO
                FROM TempValidacionRR
                WHERE ANEXO IN ('R17','R18') 
                GROUP BY CLIENTE
            ) OTROS
            INNER JOIN (
                SELECT CLIENTE, SUM(IMPORTE) AS SUMA, 'OTROS' AS TIPO
                FROM TempValidacionRR
                WHERE ANEXO NOT IN ('R17','R18')
                GROUP BY CLIENTE
            ) RR ON RR.CLIENTE = OTROS.CLIENTE
            WHERE ABS(ABS(RR.SUMA) - ABS(OTROS.SUMA)) > 0.0001
            ORDER BY ABS(ABS(OTROS.SUMA) - ABS(RR.SUMA)) DESC
        ");

        // 5. Clientes únicos entre RR y OTROS
        $solo_uno = DB::select("
            SELECT RR.CLIENTE AS CLIENTERR,RR.SUMA AS SUMARR,RR.TIPO AS TIPORR,OTROS.CLIENTE AS CLIENTEO,OTROS.SUMA AS SUMAO,OTROS.TIPO AS TIPOO FROM (
                SELECT CLIENTE, SUM(IMPORTE) AS SUMA, 'RR' AS TIPO
                FROM TempValidacionRR
                WHERE ANEXO IN ('R17','R18')
                GROUP BY CLIENTE
            ) OTROS
            FULL OUTER JOIN (
                SELECT CLIENTE, SUM(IMPORTE) AS SUMA, 'OTROS' AS TIPO
                FROM TempValidacionRR
                WHERE ANEXO NOT IN ('R17','R18')
                GROUP BY CLIENTE
            ) RR ON RR.CLIENTE = OTROS.CLIENTE
            WHERE RR.CLIENTE IS NULL OR OTROS.CLIENTE IS NULL
        ");

		return View::make('rr/listareporteresultado',
						 [
						 	'idopcion' 					=> $idopcion,
						 	'diferencias' 				=> $diferencias,
						 	'solo_uno' 					=> $solo_uno,
							'inicio'					=> $inicio,
							'hoy'						=> $hoy,
						 ]);


    }




}
