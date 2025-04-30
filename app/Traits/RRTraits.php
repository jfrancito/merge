<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;

use App\Modelos\Cliente;
use App\Modelos\Categoria;
use App\Modelos\Proveedor;
use App\Modelos\Producto;
use App\Modelos\Compra;
use App\Modelos\DetalleCompra;
use App\Modelos\Moneda;
use App\Modelos\TipoCambio;
use App\Modelos\EntidadFinanciera;
use App\Modelos\CuentasEmpresa;

use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;

trait RRTraits
{
	  public function rr_listavalidacion_comercial($fechaInicio,$fechaFin,$anio,$mes,$codCentro,$usuario,$codEmpr) {

		DB::statement("DELETE FROM TempValidacionRR");

	    $consultas = [

	        // R17
	        "
	        INSERT INTO TempValidacionRR (ANEXO, CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO)
	        SELECT 'R17', CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO
	        FROM OPENQUERY([SVRJIREH\\JIREH], '
	            EXEC [pOSCH2024].RPS.ARG_GASTOS_VENTAS_DETALLADO_VAL
	                @IND_TIPO_OPERACION=N''GEN'',
	                @COD_EMPR=N''{$codEmpr}'',
	                @COD_CENTRO=N''CEN0000000000001'',
	                @FEC_INICIO=N''{$fechaInicio}'',
	                @FEC_FIN=N''{$fechaFin}'',
	                @COD_TABLA=N'''',
	                @COD_EMPR_CLIENTE=N'''',
	                @TXT_EMPR_CLIENTE=N'''',
	                @TXT_BUSCADO=N'''',
	                @NRO_ANIO=2024,
	                @NRO_MES=10,
	                @TXT_ESTADO=N'''',
	                @EMPRESA=N''INDUAMERICA INTERNACIONAL S.A.C.'',
	                @USUARIO=N''JSALDANR'',
	                @BASE=N''pOSCH2024''
	        ')
	        ",

	        // R18
	        "
	        INSERT INTO TempValidacionRR (ANEXO, CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO)
	        SELECT 'R18', NOM_CENTRO, MES, FECHA, COD_TIPO, TIPO, CLIENTE, CAN_VALOR_VENTA_IGV, CENTRO_COSTO
	        FROM OPENQUERY([SVRJIREH\\JIREH], '
	            EXEC [pOSCH2024].RPS.ARG_SALIDAS_LOGISTICA_DETALLADO_VAL
	                @IND_TIPO_OPERACION=N''GEN'',
	                @COD_EMPR=N''{$codEmpr}'',
	                @COD_CENTRO=N''CEN0000000000001'',
	                @FEC_INICIO=N''{$fechaInicio}'',
	                @FEC_FIN=N''{$fechaFin}'',
	                @COD_TABLA=N'''',
	                @COD_EMPR_CLIENTE=N'''',
	                @TXT_EMPR_CLIENTE=N'''',
	                @TXT_BUSCADO=N'''',
	                @NRO_ANIO=2024,
	                @NRO_MES=10,
	                @TXT_ESTADO=N'''',
	                @EMPRESA=N''INDUAMERICA INTERNACIONAL S.A.C.'',
	                @USUARIO=N''JSALDANR'',
	                @BASE=N''pOSCH2024''
	        ')
	        ",

	        // RC17
	        "
	        INSERT INTO TempValidacionRR (ANEXO, CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO)
	        SELECT 'RC17', CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO
	        FROM OPENQUERY([SVRJIREH\\JIREH], '
	            EXEC [pOSCH2024].RPS.ARG_GASTOS_OPERATIVOS_DETALLADO_IAIN
	                @IND_TIPO_OPERACION=N''GEN'',
	                @COD_EMPR=N''{$codEmpr}'',
	                @COD_CENTRO=N''CEN0000000000001'',
	                @FEC_INICIO=N''{$fechaInicio}'',
	                @FEC_FIN=N''{$fechaFin}'',
	                @COD_TABLA=N'''',
	                @COD_EMPR_CLIENTE=N'''',
	                @TXT_EMPR_CLIENTE=N'''',
	                @TXT_BUSCADO=N'''',
	                @NRO_ANIO=2024,
	                @NRO_MES=10,
	                @TXT_ESTADO=N'''',
	                @EMPRESA=N''INDUAMERICA INTERNACIONAL S.A.C.'',
	                @USUARIO=N''JSALDANR'',
	                @BASE=N''pOSCH2024''
	        ')
	        ",

	        // RC18
	        "
	        INSERT INTO TempValidacionRR (ANEXO, CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO)
	        SELECT 'RC18', NOM_CENTRO, MES, FECHA, COD_TIPO, TIPO, CLIENTE, CAN_VALOR_VENTA_IGV, CENTRO_COSTO
	        FROM OPENQUERY([SVRJIREH\\JIREH], '
	            EXEC [pOSCH2024].RPS.ARG_GASTOS_ADMINISTRATIVOS_DETALLADO_IAIN
	                @IND_TIPO_OPERACION=N''GEN'',
	                @COD_EMPR=N''{$codEmpr}'',
	                @COD_CENTRO=N''CEN0000000000001'',
	                @FEC_INICIO=N''{$fechaInicio}'',
	                @FEC_FIN=N''{$fechaFin}'',
	                @COD_TABLA=N'''',
	                @COD_EMPR_CLIENTE=N'''',
	                @TXT_EMPR_CLIENTE=N'''',
	                @TXT_BUSCADO=N'''',
	                @NRO_ANIO=2024,
	                @NRO_MES=10,
	                @TXT_ESTADO=N'''',
	                @EMPRESA=N''INDUAMERICA INTERNACIONAL S.A.C.'',
	                @USUARIO=N''JSALDANR'',
	                @BASE=N''pOSCH2024''
	        ')
	        ",

	        // RS12
	        "
	        INSERT INTO TempValidacionRR (ANEXO, CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO)
	        SELECT 'RS12', CENTRO, MES, FECHA, ID, TIPO, CLIENTE, IMPORTE, CENTRO_COSTO
	        FROM OPENQUERY([SVRJIREH\\JIREH], '
	            EXEC [pOSCH2024].RPS.ERG_COSTO_VENTAS_DETALLADO_IAIN_RS
	                @IND_TIPO_OPERACION=N''GEN'',
	                @COD_EMPR=N''{$codEmpr}'',
	                @COD_CENTRO=N''CEN0000000000001'',
	                @FEC_INICIO=N''{$fechaInicio}'',
	                @FEC_FIN=N''{$fechaFin}'',
	                @COD_TABLA=N'''',
	                @COD_EMPR_CLIENTE=N'''',
	                @TXT_EMPR_CLIENTE=N'''',
	                @TXT_BUSCADO=N'''',
	                @NRO_ANIO=2024,
	                @NRO_MES=10,
	                @TXT_ESTADO=N'''',
	                @EMPRESA=N''INDUAMERICA INTERNACIONAL S.A.C.'',
	                @USUARIO=N''JSALDANR'',
	                @BASE=N''pOSCH2024''
	        ') 
	        WHERE NOM_TIPO_OPER NOT IN ('CONSUMO POR PRODUCCION', 'COMPRAS DE SERVICIOS - MAQUILA')  
	        AND CENTRO_COSTO NOT IN ('ENERGIA ELECTRICA')
	        ",

	        // RS13
	        "
	        INSERT INTO TempValidacionRR (ANEXO, CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO)
	        SELECT 'RS13', CENTRO, MES, FECHA, ID, TIPO_ORDEN, EMPRESA, IMPORTE, CENTRO_COSTO
	        FROM OPENQUERY([SVRJIREH\\JIREH], '
	            EXEC [pOSCH2024].RPS.ERG_GASTOS_OPERATIVOS_DETALLADO_IAIN_RS
	                @IND_TIPO_OPERACION=N''GEN'',
	                @COD_EMPR=N''{$codEmpr}'',
	                @COD_CENTRO=N''CEN0000000000001'',
	                @FEC_INICIO=N''{$fechaInicio}'',
	                @FEC_FIN=N''{$fechaFin}'',
	                @COD_TABLA=N'''',
	                @COD_EMPR_CLIENTE=N'''',
	                @TXT_EMPR_CLIENTE=N'''',
	                @TXT_BUSCADO=N'''',
	                @NRO_ANIO=2024,
	                @NRO_MES=10,
	                @TXT_ESTADO=N'''',
	                @EMPRESA=N''INDUAMERICA INTERNACIONAL S.A.C.'',
	                @USUARIO=N''JSALDANR'',
	                @BASE=N''pOSCH2024''
	        ')
	        ",

	        // RS16
	        "
	        INSERT INTO TempValidacionRR (ANEXO, CENTRO, MES, FECHA, CODIGO, TIPO_VENTA, CLIENTE, IMPORTE, CONCEPTO_CENTRO_COSTO)
	        SELECT 'RS16', NOM_CENTRO, MES, FECHA, COD_TIPO, TIPO, CLIENTE, CAN_VALOR_VENTA_IGV, CENTRO_COSTO
	        FROM OPENQUERY([SVRJIREH\\JIREH], '
	            EXEC [pOSCH2024].RPS.ARG_SALIDAS_LOGISTICA_DETALLADO_RS
	                @IND_TIPO_OPERACION=N''GEN'',
	                @COD_EMPR=N''{$codEmpr}'',
	                @COD_CENTRO=N''CEN0000000000001'',
	                @FEC_INICIO=N''{$fechaInicio}'',
	                @FEC_FIN=N''{$fechaFin}'',
	                @COD_TABLA=N'''',
	                @COD_EMPR_CLIENTE=N'''',
	                @TXT_EMPR_CLIENTE=N'''',
	                @TXT_BUSCADO=N'''',
	                @NRO_ANIO=2024,
	                @NRO_MES=10,
	                @TXT_ESTADO=N'''',
	                @EMPRESA=N''INDUAMERICA INTERNACIONAL S.A.C.'',
	                @USUARIO=N''JSALDANR'',
	                @BASE=N''pOSCH2024''
	        ')
	        ",

	    ];

	    foreach ($consultas as $query) {
	        DB::statement($query);
	    }
    }    


}