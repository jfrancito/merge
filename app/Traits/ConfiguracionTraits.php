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

trait ConfiguracionTraits
{
	
	private function getTipoCambio($fecha){
		$monto =	1;
		$tipo = TipoCambio::where('fecha','=',$fecha)->first();
		if($tipo!=='' && !empty($tipo))
		{	
			$monto = $tipo->venta;
		}
		else{
			$monto = TipoCambio::where('activo',1)->orderby('fecha','desc')->first()->venta;
		}
		return $monto;
	}
	
	private function con_lista_categoria($tipo_categoria) {
		$categoria 	= 	Categoria::where('tipo_categoria','=',$tipo_categoria)
						->get();
	 	return  $categoria;
	}

	private function con_lista_clientes() {
		$cliente 	= 	Cliente::get();
	 	return  $cliente;
	}

	private function con_combo_clientes() {
		$array 						= 	Cliente::where('activo','=',1)
										->select(DB::raw("
										  id,
										  numerodocumento +' - '+ nombre_razonsocial as descripcion")
										)
		        						->pluck('descripcion','id')
										->toArray();
		$combo  					= 	array('' => 'Seleccione Cliente') + $array;
	 	return  $combo;
	}

	private function con_combo_monedas() {
		$array 						= 	Moneda::where('activo','=',1)
										->pluck('descripcionabreviada','id')
										->toArray();
		$combo  					= 	array('' => 'Seleccione Moneda') + $array;
	 	return  $combo;
	}

	private function con_generacion_combo($tipo_categoria,$titulo,$todo) 
	{
	
		$array 						= 	DB::table('categorias')
        								->where('activo','=',1)
		        						->where('tipo_categoria','=',$tipo_categoria)
		        						->pluck('descripcion','id')
										->toArray();

		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}

	 	return  $combo;					 			
	}

	private function con_lista_proveedores() {
		$proveedor 	= 	Proveedor::get();
	 	return  $proveedor;
	}

	private function con_lista_productos() {
		$producto 	= 	Producto::get();
	 	return  $producto;
	}

	private function con_lista_compras() {
		$compra 	= 	Compra::get();
	 	return  $compra;
	}

	private function con_lista_detallecompras() {
		$detallecompra 	= 	DetalleCompra::get();
	 	return  $detallecompra;
	}

	private function gn_combo_tipocategoria() {
	 	return  [1=>'CATEGORIA',0=>'SERVICIO'];
	}

	private function con_combo_entidades_financieras() 
	{
		$array 						= 	EntidadFinanciera::where('activo','=',1)
		        						->pluck('entidad','id')
										->toArray();
		$combo  					= 	array('' => 'Seleccione Entidad Financiera') + $array;
	 	return  $combo;
	}

}