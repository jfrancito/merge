<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use PDO;

class ReporteInventarioController extends Controller
{
	public function actionListarReporteInventario()
    {
        $fecha_hasta = date('Y-m-d');

 		$combo_empresa        	=   array('' => 'Seleccionar' , 'IACHEM0000007086' => 'INDUAMERICA COMERCIAL S.A.C.', 
 																'IACHEM0000010394' => 'INDUAMERICA INTERNACIONAL S.A.C.');
   
		$combo_emp_sel 			=   Session::get('empresas')->COD_EMPR;

        View::share('titulo', 'Gestión Inventario');

        return View::make('inventario/listaresumeninventario',
            [
                'fecha_hasta' 			=> $fecha_hasta,
				'combo_empresa'			=> $combo_empresa,
				'combo_emp_sel'			=> $combo_emp_sel,
                'listacascara' 			=> [],
                'listapilado'			=> [],
                'listapilado_fisico' 	=> [],
                'listapaca'				=> [],
                'listaenvase' 			=> [],
                'listaenvase_fisico' => [],
                'listabobina' 			=> [],
                'listasuministro' 		=> [],  
                'listaenvaseprod' 		=> [],      
                'listaenvasedesp'		=> [],     
                'listaenvasedesp_fisico'		=> [],      
                'listaenvasecose'		=> [],      
                'listafertilizante'		=> [],          
                'codempr_filtro' 		=> '',
                'tipo'					=> '',
                'funcion' 				=> $this,
                'ajax' 					=> true
            ]);
    }	


    public function actionAjaxListarReporteInventario(Request $request)
    {
        $fecha_hasta  	= $request['fecha_hasta'];
        $cod_empr  	  	= $request['cod_empr'];

        $listacascara 	=  $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000046', 'SFM0000000000025','',''); 
        $listapilado  	=   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000008', '','',''); 
        $listatransito 	=   $this->ListarOrdenesTransito($fecha_hasta, $cod_empr, 'FAM0000000000008',''); 
        $listapaca  	=   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000062', '','',''); 
        $listaenvase  	=   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','',''); 
        $listabobina  	=   $this->ListarInventario($fecha_hasta, $cod_empr, '', '','','TPR0000000000004'); 
        $listasuministro	=   $this->ListarInventario($fecha_hasta, $cod_empr, '', '','','TPR0000000000005'); 
        $listamercaderia	=   $this->ListarInventario($fecha_hasta, $cod_empr, '', '','','TPR0000000000001'); 
        $listaenvaseprod	=   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','AXI0000000000001',''); 
        $listaenvasedesp	=   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','AXI0000000000002',''); 
        $listaenvasecose	=   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','AXI0000000000003','');
        $listafertilizante	=   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000036', '','',''); 
 		
        foreach ($listacascara as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_cascara[$cod_pro][$cod_cen][] = $item;
        } 
        
        foreach ($listapilado as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_pilado[$cod_pro][$cod_cen][] = $item;

            if($cod_cen == 'CEN0000000000002' ){
            	$item['NOM_CENTRO'] = $item['NOM_ALMACEN_FISICO'];
            	$data_pilado_fisico[$cod_pro][$cod_cen][] = $item;
            }else{
            	$data_pilado_fisico[$cod_pro][$cod_cen][] = $item;            	
            }
        }

        foreach ($listatransito as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $tipo = $item['NOM_CENTRO'];

            $data_pilado[$cod_pro][$tipo][] = $item;            
            $data_pilado_fisico[$cod_pro][$tipo][] = $item;
        }    


        $data_paca 		= [];
        foreach ($listapaca as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_paca[$cod_pro][$cod_cen][] = $item;
        }  

        $data_envase 	= [];
        $data_envase_fisico	= [];

        foreach ($listaenvase as $item) {
        	if($item['COD_CATEGORIA_AREA_INV']==''){
        		$cod_pro = $item['COD_PRODUCTO'];
	            $cod_cen = $item['COD_CENTRO'];

	            if($cod_cen == 'CEN0000000000002' ){	
	            	if($item['NOM_ALMACEN_FISICO']<> "") {	
	            		$data_envase[$cod_pro][$cod_cen][] = $item;

	            		$item['NOM_CENTRO'] = $item['NOM_ALMACEN_FISICO'];           		
	            		$data_envase_fisico[$cod_pro][$cod_cen][] = $item;
	            	}
	            }else{
	            	$data_envase[$cod_pro][$cod_cen][] = $item;		            	
	            	$data_envase_fisico[$cod_pro][$cod_cen][] = $item;            	
	            }            
        	}            
        } 

      	$data_bobina 	= [];
        foreach ($listabobina as $item) {
        	if($item['COD_FAMILIA'] <> 'FAM0000000000026'){ // quitamos los envases
	        	$cod_pro = $item['COD_PRODUCTO'];
	            $cod_cen = $item['COD_CENTRO'];
	            $data_bobina[$cod_pro][$cod_cen][] = $item;	
        	}            
        }
        
        //*********** Demas suministro
      	$data_suministro 	= [];
        foreach ($listasuministro as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_suministro[$cod_pro][$cod_cen][] = $item;
        }
		foreach ($listamercaderia as $item) {            
        	if($item['COD_FAMILIA'] <> 'FAM0000000000036'){ // quitamos los fertilizantes
                $cod_pro = $item['COD_PRODUCTO'];
                $cod_cen = $item['COD_CENTRO'];
                $data_suministro[$cod_pro][$cod_cen][] = $item;
            }
		}
        //*************************

      	$data_envaseprod 	= [];
        foreach ($listaenvaseprod as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_envaseprod[$cod_pro][$cod_cen][] = $item;
        }

        $data_envasedesp 	= [];
        $data_envasedesp_fisico	= [];

        foreach ($listaenvasedesp as $item) {
    		$cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];

            if($cod_cen == 'CEN0000000000002' ){	
            	if($item['NOM_ALMACEN_FISICO']<> "") {	
            		$data_envasedesp[$cod_pro][$cod_cen][] = $item;

            		$item['NOM_CENTRO'] = $item['NOM_ALMACEN_FISICO'];           		
            		$data_envasedesp_fisico[$cod_pro][$cod_cen][] = $item;
            	}
            }else{
            	$data_envasedesp[$cod_pro][$cod_cen][] = $item;		            	
            	$data_envasedesp_fisico[$cod_pro][$cod_cen][] = $item;            	
            }            
        } 

      	$data_envasecose 	= [];
        foreach ($listaenvasecose as $item) {
            $cod_pro = $item['COD_ALMACEN'];
            $cod_cen = $item['COD_CENTRO'];
            $data_envasecose[$cod_pro][$cod_cen][] = $item;
        }
      	$data_fertilizante 	= [];
        foreach ($listafertilizante as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_fertilizante[$cod_pro][$cod_cen][] = $item;
        }

        $funcion 	  = $this;

        return View::make('inventario/ajax/alistainventario',
            [
                'listacascara' 	=> $data_cascara,
                'listapilado' 	=> $data_pilado,
                'listapilado_fisico' 	=> $data_pilado_fisico,
                'listapaca' 	=> $data_paca,
                'listaenvase' 	=> $data_envase,
                'listaenvase_fisico' 	=> $data_envase_fisico,
                'listabobina' 	=> $data_bobina,
                'listasuministro'	=> $data_suministro,
                'listaenvaseprod'	=> $data_envaseprod,
                'listaenvasedesp'	=> $data_envasedesp,
                'listaenvasedesp_fisico'	=> $data_envasedesp_fisico,
                'listaenvasecose'	=> $data_envasecose,   
                'listafertilizante'	=> $data_fertilizante,  
                'tipo'					=> '',
                'funcion' 		=> $funcion,
                'codempr_filtro'=> $cod_empr,
                'ajax' 			=> true
            ]);
    }

    public function ListarInventario($fecha_hasta, $cod_empr, $familia, $subfamilia,$area_inv,$tipoproducto){   
    	$vacio = '';

        $stmt   =   DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC [WEB].[ALM_INVENTARIO_PRODUCTO_CONSOLIDAR]  
        						@TIPO = ?,
							    @EMPRESA  = ? ,
							    @CENTRO  = ? ,
							    @TIPO_INV  = ? ,
								@EMPR_PROPIETARIO  = ?,
								@EMPR_SERVICIO  = ?,
								@COD_PRODUCTO  = ?,
							    @FECHA = ?,
								@ALMACEN = ?,
								@COD_FAMILIA = ?,
								@COD_SUB_FAMILIA = ?,
								@COD_TIPO_PRODUCTO = ?,
								@COD_AREA_INVENTARIO = ? ');
                
        $stmt->bindParam(1, $vacio,PDO::PARAM_STR);
        $stmt->bindParam(2, $cod_empr ,PDO::PARAM_STR);
        $stmt->bindParam(3, $vacio ,PDO::PARAM_STR);
        $stmt->bindParam(4, $vacio ,PDO::PARAM_STR);   
        $stmt->bindParam(5, $vacio  ,PDO::PARAM_STR);
        $stmt->bindParam(6, $vacio ,PDO::PARAM_STR);
        $stmt->bindParam(7, $tipo ,PDO::PARAM_STR);
        $stmt->bindParam(8, $fecha_hasta ,PDO::PARAM_STR);    
        $stmt->bindParam(9, $vacio  ,PDO::PARAM_STR);
        $stmt->bindParam(10, $familia ,PDO::PARAM_STR);
        $stmt->bindParam(11, $subfamilia ,PDO::PARAM_STR);   
        $stmt->bindParam(12, $tipoproducto ,PDO::PARAM_STR);  
        $stmt->bindParam(13, $area_inv ,PDO::PARAM_STR);      
        $stmt->execute();
        return $stmt;
    }

    public function ListarOrdenesTransito($fecha_hasta, $cod_empr, $familia){   

        $stmt   =   DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDENES_TRANSITO  
							    @FECHA = ?,
								@COD_EMPR = ?,
								@COD_FAMILIA = ?');                
        $stmt->bindParam(1, $fecha_hasta,PDO::PARAM_STR);
        $stmt->bindParam(2, $cod_empr ,PDO::PARAM_STR);
        $stmt->bindParam(3, $familia ,PDO::PARAM_STR);     
        $stmt->execute();
        return $stmt;
    }

    public function obtenerCantidad($data,$cod_empr){
    	$flatArray = [];
		foreach ($data as $row) {
		    foreach ($row as $centros) {
		        $flatArray = array_merge($flatArray, $centros);
		    }
		}
		$filtradas = array_filter($flatArray, function ($item) use ($cod_empr) {
		    return isset($item['COD_EMPR_PROPIETARIA']) && $item['COD_EMPR_PROPIETARIA'] == $cod_empr;
		});
		$productosUnicos = [];
		$distinct = [];
		foreach ($filtradas as $item) {
		    $codProd = $item['COD_PRODUCTO'];
		    if (!isset($productosUnicos[$codProd])) {
		        $productosUnicos[$codProd] = true;
		        $distinct[] = $item;
		    }
		}

		$cantidad = count($distinct);
		return $cantidad;
    }

     public function obtenerCantidadAlmacen($data,$cod_empr){
    	$flatArray = [];
		foreach ($data as $row) {
		    foreach ($row as $centros) {
		        $flatArray = array_merge($flatArray, $centros);
		    }
		}
		$filtradas = array_filter($flatArray, function ($item) use ($cod_empr) {
		    return isset($item['COD_EMPR_PROPIETARIA']) && $item['COD_EMPR_PROPIETARIA'] == $cod_empr;
		});
		$productosUnicos = [];
		$distinct = [];
		foreach ($filtradas as $item) {
		    $codProd = $item['COD_ALMACEN'];
		    if (!isset($productosUnicos[$codProd])) {
		        $productosUnicos[$codProd] = true;
		        $distinct[] = $item;
		    }
		}

		$cantidad = count($distinct);
		return $cantidad;
    }

    public function actionAjaxListarReporteInventarioExcel(Request $request)
    {
        $fecha_hasta 	= $request['fecha_hasta'];
        $cod_empr 		= $request['cod_empr'];
  
        $titulo_tm 		= 'RESUMEN_INVENTARIOS_'.$cod_empr.'_(' . $fecha_hasta . ')';

        $listacascara   =  $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000046', 'SFM0000000000025','',''); 
        $listapilado    =   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000008', '','',''); 
        $listatransito  =   $this->ListarOrdenesTransito($fecha_hasta, $cod_empr, 'FAM0000000000008',''); 
        $listapaca      =   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000062', '','',''); 
        $listaenvase    =   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','',''); 
        $listabobina    =   $this->ListarInventario($fecha_hasta, $cod_empr, '', '','','TPR0000000000004'); 
        $listasuministro	=   $this->ListarInventario($fecha_hasta, $cod_empr, '', '','','TPR0000000000005'); 
        $listamercaderia	=   $this->ListarInventario($fecha_hasta, $cod_empr, '', '','','TPR0000000000001'); 
        $listaenvaseprod    =   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','AXI0000000000001',''); 
        $listaenvasedesp    =   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','AXI0000000000002',''); 
        $listaenvasecose    =   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000026', '','AXI0000000000003','');
        $listafertilizante  =   $this->ListarInventario($fecha_hasta, $cod_empr, 'FAM0000000000036', '','',''); 
        
        foreach ($listacascara as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_cascara[$cod_pro][$cod_cen][] = $item;
        } 
        
        foreach ($listapilado as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_pilado[$cod_pro][$cod_cen][] = $item;

            if($cod_cen == 'CEN0000000000002' ){
                $item['NOM_CENTRO'] = $item['NOM_ALMACEN_FISICO'];
                $data_pilado_fisico[$cod_pro][$cod_cen][] = $item;
            }else{
                $data_pilado_fisico[$cod_pro][$cod_cen][] = $item;              
            }
        }

        foreach ($listatransito as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $tipo = $item['NOM_CENTRO'];

            $data_pilado[$cod_pro][$tipo][] = $item;            
            $data_pilado_fisico[$cod_pro][$tipo][] = $item;
        }    


        $data_paca      = [];
        foreach ($listapaca as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_paca[$cod_pro][$cod_cen][] = $item;
        }  

        $data_envase    = [];
        $data_envase_fisico = [];

        foreach ($listaenvase as $item) {
            if($item['COD_CATEGORIA_AREA_INV']==''){
                $cod_pro = $item['COD_PRODUCTO'];
                $cod_cen = $item['COD_CENTRO'];

                if($cod_cen == 'CEN0000000000002' ){    
                    if($item['NOM_ALMACEN_FISICO']<> "") {  
                        $data_envase[$cod_pro][$cod_cen][] = $item;

                        $item['NOM_CENTRO'] = $item['NOM_ALMACEN_FISICO'];                  
                        $data_envase_fisico[$cod_pro][$cod_cen][] = $item;
                    }
                }else{
                    $data_envase[$cod_pro][$cod_cen][] = $item;                     
                    $data_envase_fisico[$cod_pro][$cod_cen][] = $item;              
                }            
            }            
        } 

        $data_bobina    = [];
        foreach ($listabobina as $item) {
            if($item['COD_FAMILIA'] <> 'FAM0000000000026'){ // quitamos los envases
                $cod_pro = $item['COD_PRODUCTO'];
                $cod_cen = $item['COD_CENTRO'];
                $data_bobina[$cod_pro][$cod_cen][] = $item; 
            }            
        }
        
        //*********** Demas suministro
        $data_suministro    = [];
        foreach ($listasuministro as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_suministro[$cod_pro][$cod_cen][] = $item;
        }
        foreach ($listamercaderia as $item) {
            if($item['COD_FAMILIA'] <> 'FAM0000000000036'){ // quitamos los fertilizantes
                $cod_pro = $item['COD_PRODUCTO'];
                $cod_cen = $item['COD_CENTRO'];
                $data_suministro[$cod_pro][$cod_cen][] = $item;
            }
        }
        //*************************

        $data_envaseprod    = [];
        foreach ($listaenvaseprod as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_envaseprod[$cod_pro][$cod_cen][] = $item;
        }

        $data_envasedesp    = [];
        $data_envasedesp_fisico = [];

        foreach ($listaenvasedesp as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];

            if($cod_cen == 'CEN0000000000002' ){    
                if($item['NOM_ALMACEN_FISICO']<> "") {  
                    $data_envasedesp[$cod_pro][$cod_cen][] = $item;

                    $item['NOM_CENTRO'] = $item['NOM_ALMACEN_FISICO'];                  
                    $data_envasedesp_fisico[$cod_pro][$cod_cen][] = $item;
                }
            }else{
                $data_envasedesp[$cod_pro][$cod_cen][] = $item;                     
                $data_envasedesp_fisico[$cod_pro][$cod_cen][] = $item;              
            }            
        } 

        $data_envasecose    = [];
        foreach ($listaenvasecose as $item) {
            $cod_pro = $item['COD_ALMACEN'];
            $cod_cen = $item['COD_CENTRO'];
            $data_envasecose[$cod_pro][$cod_cen][] = $item;
        }
        $data_fertilizante  = [];
        foreach ($listafertilizante as $item) {
            $cod_pro = $item['COD_PRODUCTO'];
            $cod_cen = $item['COD_CENTRO'];
            $data_fertilizante[$cod_pro][$cod_cen][] = $item;
        }

        // buscamos la cantidad de productos, para buscar la posicion
		$pos_cascara = $this->obtenerCantidad($data_cascara,$cod_empr);
		$pos_pilado = $this->obtenerCantidad($data_pilado_fisico,$cod_empr);
		$pos_paca = $this->obtenerCantidad($data_paca,$cod_empr);
		$pos_envase = $this->obtenerCantidad($data_envase_fisico,$cod_empr);
		$pos_bobina = $this->obtenerCantidad($data_bobina,$cod_empr);
		$pos_suministro = $this->obtenerCantidad($data_suministro,$cod_empr);
		$pos_envaseprod = $this->obtenerCantidad($data_envaseprod,$cod_empr);
		$pos_envasedesp = $this->obtenerCantidad($data_envasedesp_fisico,$cod_empr);
		$pos_envasecose = $this->obtenerCantidadAlmacen($data_envasecose,$cod_empr);
		$pos_fertilizante = $this->obtenerCantidad($data_fertilizante,$cod_empr);

        Excel::create($titulo_tm, function ($excel) use ( 
        	 $cod_empr, $data_cascara,$data_pilado,$data_pilado_fisico, $data_paca,$data_envase,
			 $data_envase_fisico, $data_bobina, $data_suministro, $data_envaseprod, $data_envasedesp,
			 $data_envasedesp_fisico, $data_envasecose, $data_fertilizante,$pos_cascara,$pos_pilado,$pos_paca,
			 $pos_envase,$pos_bobina,$pos_suministro,$pos_envaseprod,$pos_envasedesp,$pos_envasecose,$pos_fertilizante  
        ){

        	    $excel->sheet('Inventarios Consolidados', function ($sheet) use ($cod_empr,
        	    		 $data_cascara,$data_pilado,$data_pilado_fisico, $data_paca,$data_envase,
						 $data_envase_fisico, $data_bobina, $data_suministro, $data_envaseprod, $data_envasedesp,
						 $data_envasedesp_fisico, $data_envasecose, $data_fertilizante  ) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 15);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 15);
    				$sheet->setWidth('L', 15);
    				$sheet->setWidth('M', 15);
    				$sheet->setWidth('N', 15);
    				$sheet->setWidth('O', 15);
    				$sheet->setWidth('P', 15);
    				$sheet->setWidth('Q', 15);
    				$sheet->setWidth('R', 15);
    				$sheet->setWidth('S', 15);
    				$sheet->setWidth('T', 15);
    				$sheet->setWidth('U', 25);

                 	$sheet->setColumnFormat(array('B:U' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(8, function ($row) { $row->setFont(['bold' => true]); });

                    for ($i = 1; $i <= 8; $i++) {
                        $sheet->cell("A{$i}", function($cell) {
                            $cell->setFont(['bold' => true]);
                        });
                        $sheet->cell("U{$i}", function($cell) {
                            $cell->setFont(['bold' => true]);
                        });
                    }

                    $sheet->loadView('inventario/ajax/aconsolidado')->with(['listacascara' 	=> $data_cascara,
															                'listapilado' 	=> $data_pilado,
															                'listapilado_fisico' 	=> $data_pilado_fisico,
															                'listapaca' 	=> $data_paca,
															                'listaenvase' 	=> $data_envase,
															                'listaenvase_fisico' 	=> $data_envase_fisico,
															                'listabobina' 	=> $data_bobina,
															                'listasuministro'	=> $data_suministro,
															                'listaenvaseprod'	=> $data_envaseprod,
															                'listaenvasedesp'	=> $data_envasedesp,
															                'listaenvasedesp_fisico'	=> $data_envasedesp_fisico,
															                'listaenvasecose'	=> $data_envasecose,   
															                'listafertilizante'	=> $data_fertilizante,  
															                'tipo'				=> 'EXC',
                                    										'codempr_filtro'=>$cod_empr]);
                });

                $excel->sheet('Cascara', function ($sheet) use ($cod_empr,$data_cascara,$pos_cascara) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 25);
    				$sheet->setWidth('J', 25);

                 	$sheet->setColumnFormat(array('C:J' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    
                    $sheet->row($pos_cascara+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_cascara+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->loadView('inventario/ajax/acascara')->with(['listacascara'=>$data_cascara,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 
                $excel->sheet('Pilado', function ($sheet) use ($cod_empr,$data_pilado,$data_pilado_fisico,$pos_pilado) {  
					$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 60);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 15);
    				$sheet->setWidth('L', 15);
    				$sheet->setWidth('M', 15);
    				$sheet->setWidth('N', 15);
    				$sheet->setWidth('O', 15);
    				$sheet->setWidth('P', 15);
    				$sheet->setWidth('Q', 25);
    				$sheet->setWidth('R', 25);

    				$sheet->setColumnFormat(array('C:R' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_pilado+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_pilado+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/apilado')->with(['listapilado'=>$data_pilado,
                    							'listapilado_fisico'=>$data_pilado_fisico,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

                $excel->sheet('Pacas', function ($sheet) use ($cod_empr,$data_paca,$pos_paca) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 25);
    				$sheet->setWidth('J', 25);

                 	$sheet->setColumnFormat(array('C:J' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_paca+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_paca+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/apacas')->with(['listapaca'=>$data_paca,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

				$excel->sheet('Envases', function ($sheet) use ($cod_empr,$data_envase,$data_envase_fisico,$pos_envase) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 15);
    				$sheet->setWidth('L', 15);
    				$sheet->setWidth('M', 25);
    				$sheet->setWidth('N', 25);

                 	$sheet->setColumnFormat(array('C:N' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_envase+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_envase+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/aenvases')->with(['listaenvase'=>$data_envase,
                    													'listaenvase_fisico'=>$data_envase_fisico,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

                $excel->sheet('Bobinas', function ($sheet) use ($cod_empr,$data_bobina,$pos_bobina) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 25);
    				$sheet->setWidth('L', 25);

                 	$sheet->setColumnFormat(array('C:L' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_bobina+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_bobina+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/abobinas')->with(['listabobina'=>$data_bobina,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

			    $excel->sheet('Demás Suministros', function ($sheet) use ($cod_empr,$data_suministro,$pos_suministro) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 25);
    				$sheet->setWidth('L', 25);

                 	$sheet->setColumnFormat(array('C:L' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_suministro+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_suministro+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/ademassuministros')->with(['listasuministro'=>$data_suministro,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

                $excel->sheet('Envases de Producción', function ($sheet) use ($cod_empr,$data_envaseprod,$pos_envaseprod) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 18);
    				$sheet->setWidth('D', 18);
    				$sheet->setWidth('E', 18);
    				$sheet->setWidth('F', 18);
    				$sheet->setWidth('G', 18);
    				$sheet->setWidth('H', 18);
    				$sheet->setWidth('I', 18);
    				$sheet->setWidth('J', 18);
    				$sheet->setWidth('K', 25);
    				$sheet->setWidth('L', 25);

                 	$sheet->setColumnFormat(array('C:L' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_envaseprod+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_envaseprod+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/aenvasesprod')->with(['listaenvaseprod'=>$data_envaseprod,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

                $excel->sheet('Envases de Despachos', function ($sheet) use ($cod_empr,$data_envasedesp,$data_envasedesp_fisico,$pos_envasedesp) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 15);
    				$sheet->setWidth('L', 15);
    				$sheet->setWidth('M', 25);
    				$sheet->setWidth('N', 25);

                 	$sheet->setColumnFormat(array('C:N' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_envasedesp+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_envasedesp+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/aenvasesdesp')->with(['listaenvasedesp'=>$data_envasedesp,
                    													'listaenvasedesp_fisico'=>$data_envasedesp_fisico,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

    			$excel->sheet('Envases Cosecheros', function ($sheet) use ($cod_empr,$data_envasecose,$pos_envasecose) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 25);
    				$sheet->setWidth('L', 25);

                 	$sheet->setColumnFormat(array('C:L' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_envasecose+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_envasecose+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/aenvasescose')->with(['listaenvasecose'=>$data_envasecose,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 


    			$excel->sheet('Fertilizantes', function ($sheet) use ($cod_empr,$data_fertilizante,$pos_fertilizante) {   
    				$sheet->setWidth('A', 20);
    				$sheet->setWidth('B', 50);
    				$sheet->setWidth('C', 15);
    				$sheet->setWidth('D', 15);
    				$sheet->setWidth('E', 15);
    				$sheet->setWidth('F', 15);
    				$sheet->setWidth('G', 15);
    				$sheet->setWidth('I', 15);
    				$sheet->setWidth('H', 15);
    				$sheet->setWidth('J', 15);
    				$sheet->setWidth('K', 25);
    				$sheet->setWidth('L', 25);

                 	$sheet->setColumnFormat(array('C:L' => '0.00'));
                    $sheet->row(1, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row(2, function ($row) { $row->setBackground('#1D3A6D'); $row->setFontColor('#FFFFFF'); });
				    
                    $sheet->row($pos_fertilizante+6, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });
                    $sheet->row($pos_fertilizante+7, function ($row) { $row->setBackground('#0D99E1'); $row->setFontColor('#FFFFFF'); });

                    $sheet->loadView('inventario/ajax/afertilizante')->with(['listafertilizante'=>$data_fertilizante,
                                    									'codempr_filtro'=>$cod_empr]);
                }); 

        })->download('xlsx');

    }


    public function actionListarReportePiladoTransito()
    {
        $fecha_hasta = date('Y-m-d');
        $combo_empresa          =   array('' => 'Seleccionar' , 'IACHEM0000007086' => 'INDUAMERICA COMERCIAL S.A.C.', 
                                                                'IACHEM0000010394' => 'INDUAMERICA INTERNACIONAL S.A.C.');   
        $combo_emp_sel          =   Session::get('empresas')->COD_EMPR;

        View::share('titulo', 'Arroz Pilado Tránsito');
        
        return View::make('inventario/listaresumeninventario',
            [
                'fecha_hasta'           => $fecha_hasta,
                'combo_empresa'         => $combo_empresa,
                'combo_emp_sel'         => $combo_emp_sel,
                'listadata'             => [],
                'codempr_filtro'        => '',
                'tipo'                  => '',
                'funcion'               => $this,
                'ajax'                  => true
            ]);
    }   


}
