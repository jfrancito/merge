<table id="p_tablaPropio" 
       class="{{ $tipo == 'EXC' ? '' : 'table table-bordered table-hover td-color-borde td-padding-7 display nowrap' }}">
    <thead class="background-th-azul">
    <tr>
        <th style="text-align: center;">Propio</th>
        <th style="text-align: center;">Producto/Sede</th>
        <th colspan="2" style="text-align: center;">Envases Chiclayo</th>
        <th colspan="2" style="text-align: center;">Envases Rioja</th>
        <th colspan="2" style="text-align: center;">Envases Bellavista</th>
        <th colspan="2" style="text-align: center;">Envases MPSA</th>
        <th colspan="2" style="text-align: center;">Envases VES</th>
        <th rowspan="2" style="text-align: center;">Total Unidades</th>
        <th rowspan="2" style="text-align: center;">Total Soles</th>
    </tr>
    <tr>
        <th style="text-align: center;">Código</th>
        <th style="text-align: center;">Producto</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
    </tr>
    </thead>
    <tbody>
    @php
        if (!is_array($listaenvase_fisico) || empty($listaenvase_fisico)) {
            $listaenvase_fisico = []; // Asegurar que sea un array vacío si no es válido
        }

        $totales = [];
        $totales_kg = 0;
        $totales_sl = 0;

        foreach ($listaenvase_fisico as $row) {
            $nombre = '';
            $codProducto = '';
            $result = [];
            $tot_kg = 0;
            $tot_sl = 0;

            foreach ($row as $centros) {            
                foreach ($centros as $item) {

                    if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {

                        $nombre = $item['NOM_PRODUCTO'];
                        $codProducto = $item['COD_PRODUCTO'];
                        $centro = $item["NOM_CENTRO"];
        
                        if (!isset($result[$centro])) {
                            $result[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                        }

                        $result[$centro]["STOCK"] += $item["STOCK"];
                        $result[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"];    

                        $tot_kg += $item["STOCK"];
                        $tot_sl += $item["COSTO_TOTAL"];  

                        // totales de todos los centros                        
                        if (!isset($totales[$centro])) {
                            $totales[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                        }
                        $totales[$centro]["STOCK"] += $item["STOCK"];
                        $totales[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                        $totales_kg += $item["STOCK"];
                        $totales_sl += $item["COSTO_TOTAL"];  

                    }
            
                }

            }
            if($nombre != ''){    
    @endphp
        <tr>
            <td style="text-align: left;">{{$codProducto}}</td>
            <td style="text-align: left;">{{$nombre}}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["STOCK"]) ? 
                                            number_format($result["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($result["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["STOCK"]) ? 
                                            number_format($result["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($result["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($result["MPSA"]["STOCK"]) ? 
                                            number_format($result["MPSA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["MPSA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["MPSA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($result["VES"]["STOCK"]) ? 
                                            number_format($result["VES"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["VES"]["COSTO_TOTAL"]) ? 
                                            number_format($result["VES"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{number_format($tot_kg, 2, '.', '')}}</td>
            <td style="text-align: right;">{{number_format($tot_sl, 2, '.', '')}}</td>
        </tr>
    @php   
            }   
        }
    @endphp    

         <tr>
            <td  colspan="2" style="text-align: right;">TOTAL</td>
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["STOCK"]) ? 
                                            number_format($totales["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["STOCK"]) ? 
                                            number_format($totales["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($totales["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($totales["MPSA"]["STOCK"]) ? 
                                            number_format($totales["MPSA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["MPSA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["MPSA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($totales["VES"]["STOCK"]) ? 
                                            number_format($totales["VES"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["VES"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["VES"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{number_format($totales_kg, 2, '.', '')}}</td>
            <td style="text-align: right;">{{number_format($totales_sl, 2, '.', '')}}</td>
        </tr>
    
        
    </tbody>

</table>
<br>
<table id="p_tablaTercero" 
       class="{{ $tipo == 'EXC' ? '' : 'table table-bordered table-hover td-color-borde td-padding-7 display nowrap' }}">
    <thead class="background-th-azul">
    <tr>
        <th style="text-align: center;">Tercero</th>
        <th style="text-align: center;">Producto/Sede</th>
        <th colspan="2" style="text-align: center;">Envases Chiclayo</th>
        <th colspan="2" style="text-align: center;">Envases Rioja</th>
        <th colspan="2" style="text-align: center;">Envases Bellavista</th>
        <th colspan="2" style="text-align: center;">Envases Lima</th>
        <th rowspan="2" style="text-align: center;">Total Unidades</th>
        <th rowspan="2" style="text-align: center;">Total Soles</th>
    </tr>
    <tr>
        <th style="text-align: center;">Código</th>
        <th style="text-align: center;">Producto</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totales = [];
        $totales_kg = 0;
        $totales_sl = 0;

        foreach($listaenvase_fisico as $row) {
            $nombre = '';
            $result = [];
            $tot_kg = 0;
            $tot_sl = 0;

            foreach ($row as $centros) {            
                foreach ($centros as $item) {
                    if ($item['COD_EMPR_PROPIETARIA'] != $codempr_filtro) {

                        $nombre = $item['NOM_PRODUCTO'];
                        $codProducto = $item['COD_PRODUCTO'];
                        $centro = $item["NOM_CENTRO"];
        
                        if (!isset($result[$centro])) {
                            $result[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                        }

                        $result[$centro]["STOCK"] += $item["STOCK"];
                        $result[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"];    

                        $tot_kg += $item["STOCK"];
                        $tot_sl += $item["COSTO_TOTAL"];  

                        // totales de todos los centros                        
                        if (!isset($totales[$centro])) {
                            $totales[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                        }
                        $totales[$centro]["STOCK"] += $item["STOCK"];
                        $totales[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                        $totales_kg += $item["STOCK"];
                        $totales_sl += $item["COSTO_TOTAL"];  

                    }
            
                }

            }
            if($nombre != ''){     
    @endphp
        <tr>
            <td style="text-align: left;">{{$codProducto}}</td>
            <td style="text-align: left;">{{$nombre}}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["STOCK"]) ? 
                                            number_format($result["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($result["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["STOCK"]) ? 
                                            number_format($result["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($result["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($result["LIMA"]["STOCK"]) ? 
                                            number_format($result["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{number_format($tot_kg, 2, '.', '')}}</td>
            <td style="text-align: right;">{{number_format($tot_sl, 2, '.', '')}}</td>
        </tr>
    @php  
            }    
        }
    @endphp    

         <tr>
            <td  colspan="2" style="text-align: right;">TOTAL</td>
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["STOCK"]) ? 
                                            number_format($totales["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["STOCK"]) ? 
                                            number_format($totales["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($totales["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($totales["LIMA"]["STOCK"]) ? 
                                            number_format($totales["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  

            <td style="text-align: right;">{{number_format($totales_kg, 2, '.', '')}}</td>
            <td style="text-align: right;">{{number_format($totales_sl, 2, '.', '')}}</td>
        </tr>
    
        
    </tbody>

</table>