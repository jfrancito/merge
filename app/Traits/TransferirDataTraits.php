<?php

namespace App\Traits;

use App\Models\FeToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


trait TransferirDataTraits
{

	private function tdventasatendidas() {

		set_time_limit(0);
		DB::connection('pgsqla')->table('ventas')->delete();
	    // 1. Obtener datos desde SQL Server
	    $datos = DB::table('viewVentaSalidas2024 as vvs')
	        ->leftJoin(DB::raw("(SELECT ALM.PRODUCTO.*, STD.EMPRESA.NOM_EMPR FROM ALM.PRODUCTO
	                            INNER JOIN STD.EMPRESA ON ALM.PRODUCTO.COD_EMPR = STD.EMPRESA.COD_EMPR) AS p"),
	                    function ($join) {
	                        $join->on('p.NOM_PRODUCTO', '=', 'vvs.NombreProducto')
	                             ->on('p.NOM_EMPR', '=', 'vvs.Empresa');
	                    })
	        ->leftJoin('CMP.CATEGORIA as MARCA', 'MARCA.COD_CATEGORIA', '=', 'p.COD_CATEGORIA_MARCA')
	        ->leftJoin('CMP.CATEGORIA as TIPOMARCA', 'TIPOMARCA.COD_CATEGORIA', '=', 'p.COD_CATEGORIA_PRODUCTO_SUPERMERCADOS')
	        ->whereRaw("ISNULL(vvs.NombreProducto, '') <> ''")
	        ->select('vvs.*', 
	                 'MARCA.NOM_CATEGORIA as Marca', 
	                 'TIPOMARCA.NOM_CATEGORIA as TipoMarca',
	             	 DB::raw('CantidadProducto2 * PrecioVentaIGV as Venta'))
	        ->get();

	    // 2. Insertar en PostgreSQL
	    foreach ($datos as $dato) {
			$empresa = $dato->Empresa;
	    	if($dato->Empresa == 'INDUAMERICA COMERCIAL SAC'){
	    		$empresa = 'INDUAMERICA COMERCIAL SOCIEDAD ANONIMA CERRADA';
	    	}

	        DB::connection('pgsqla')->table('ventas')->insert([
	            'empresa' => $empresa,
	            'centro' => $dato->Centro,
	            'fecha'  => $dato->Fecha,
	            'orden' => $dato->Orden,

	            'cliente' => $dato->Cliente,
	            'tipo_venta' => $dato->TipoVenta,
	            'sub_canal' => $dato->SubCanal,
	            'jefe_venta' => $dato->JefeVenta,
	            'total_venta' => $dato->Venta,
	            'unidad_medida' => $dato->UnidadMedida,
	            'estado' => $dato->Estado,
	            'nombre_producto' => $dato->NombreProducto,
	            'familia' => $dato->Familia,
	            'sub_familia' => $dato->SubFamilia,

	            'cantidad_producto' => $dato->CantidadProducto,
	            'kg' => $dato->Kg,
	            'cant_50kg' => $dato->Cant50kg,
	            'precio_venta' => $dato->PrecioVenta,
	            'precio_venta_igv' => $dato->PrecioVentaIGV,
	            'subtotal' => $dato->Subtotal,
	            'fecha_orden' => $dato->FechaOrden,
	            'fecha_ejecuta' => $dato->FechaEjecuta,
	            'orden_1' => $dato->Orden_1,
	            'cantidad_producto2' => $dato->CantidadProducto2,


	            'costo_unitario' => $dato->CostoUnitario,
	            'costo_extendido' => $dato->CostoExtendido,
	            'tipo_cliente' => $dato->TIPOCLIENTE,
	            'canal' => $dato->Canal,
	            'p50kg' => $dato->P50Kg,
	            'c50kg' => $dato->C50Kg,
	            'descuent_reglas' => $dato->DescuentReglas,
	            'descuento_ivap' => $dato->DescuentoIvap,
	            'comision' => $dato->Comision,
	            'tipo_descuento' => $dato->TipoDescuento,
	            'cantidad_descuento' => $dato->CantidadDescuento,
	            'marca' => $dato->Marca,
	            'tipo_marca' => $dato->TipoMarca
	        ]);
	    }





	    return "Transferencia completada con éxito.";



























        $FeToken = FeToken::get();
        $results = DB::connection('pgsqla')->select('SELECT * FROM ventas');
        dd($results);
        dd($FeToken);

	}

}