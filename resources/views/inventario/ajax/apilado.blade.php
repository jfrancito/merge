<table id="p_tablaPropio" 
       class="{{ $tipo == 'EXC' ? '' : 'table table-bordered table-hover td-color-borde td-padding-7 display nowrap' }}">
    <thead class="background-th-azul">
    <tr>
        <th style="text-align: center;">Propio</th>
        <th style="text-align: center;">Producto/Sede</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado Chiclayo</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado Rioja</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado Bellavista</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado MPSA</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado VES</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado ADUANAS</th>
        <th colspan="2" style="text-align: center;">En Tránsito</th>
        <th rowspan="2" style="text-align: center;">Total Sacos x 50 Kg</th>
        <th rowspan="2" style="text-align: center;">Total Soles</th>
    </tr>
    <tr>
        <th style="text-align: center;">Código</th>
        <th style="text-align: center;">Producto</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
    </tr>
    </thead>
    <tbody>
    @php
        if (!is_array($listapilado_fisico) || empty($listapilado_fisico)) {
            $listapilado_fisico = []; // Asegurar que sea un array vacío si no es válido
        }

        $totales = [];
        $totales_kg = 0;
        $totales_sl = 0;

        foreach ($listapilado_fisico as $row) {
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
                            $result[$centro] = ["NOM_CENTRO" => $centro, "STK_50" => 0, "COSTO_TOTAL" => 0];
                        }

                        $result[$centro]["STK_50"] += $item["STK_50"];
                        $result[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"];    

                        $tot_kg += $item["STK_50"];
                        $tot_sl += $item["COSTO_TOTAL"];  

                        // totales de todos los centros                        
                        if (!isset($totales[$centro])) {
                            $totales[$centro] = ["NOM_CENTRO" => $centro, "STK_50" => 0, "COSTO_TOTAL" => 0];
                        }
                        $totales[$centro]["STK_50"] += $item["STK_50"];
                        $totales[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                        $totales_kg += $item["STK_50"];
                        $totales_sl += $item["COSTO_TOTAL"];  

                    }
            
                }

            }
            if($nombre != ''){    
    @endphp
        <tr>
            <td style="text-align: left;">{{$codProducto}}</td>
            <td style="text-align: left;">{{$nombre}}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["STK_50"]) ? 
                                            number_format($result["CHICLAYO"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($result["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["STK_50"]) ? 
                                            number_format($result["RIOJA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["STK_50"]) ? 
                                            number_format($result["BELLAVISTA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($result["MPSA"]["STK_50"]) ? 
                                            number_format($result["MPSA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["MPSA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["MPSA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($result["VES"]["STK_50"]) ? 
                                            number_format($result["VES"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["VES"]["COSTO_TOTAL"]) ? 
                                            number_format($result["VES"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($result["ADUANAS"]["STK_50"]) ? 
                                            number_format($result["ADUANAS"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["ADUANAS"]["COSTO_TOTAL"]) ? 
                                            number_format($result["ADUANAS"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($result["EN TRANSITO"]["STK_50"]) ? 
                                            number_format($result["EN TRANSITO"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["EN TRANSITO"]["COSTO_TOTAL"]) ? 
                                            number_format($result["EN TRANSITO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{number_format($tot_kg, 2, '.', '')}}</td>
            <td style="text-align: right;">{{number_format($tot_sl, 2, '.', '')}}</td>
        </tr>
    @php   
            }   
        }
    @endphp    

         <tr>
            <td  colspan="2" style="text-align: right;">TOTAL</td>
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["STK_50"]) ? 
                                            number_format($totales["CHICLAYO"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["STK_50"]) ? 
                                            number_format($totales["RIOJA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["STK_50"]) ? 
                                            number_format($totales["BELLAVISTA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($totales["MPSA"]["STK_50"]) ? 
                                            number_format($totales["MPSA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["MPSA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["MPSA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($totales["VES"]["STK_50"]) ? 
                                            number_format($totales["VES"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["VES"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["VES"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($totales["ADUANAS"]["STK_50"]) ? 
                                            number_format($totales["ADUANAS"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["ADUANAS"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["ADUANAS"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
            <td style="text-align: right;">{{isset($totales["EN TRANSITO"]["STK_50"]) ? 
                                            number_format($totales["EN TRANSITO"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["EN TRANSITO"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["EN TRANSITO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td> 
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
        <th colspan="2" style="text-align: center;">Arroz Pilado Chiclayo</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado Rioja</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado Bellavista</th>
        <th colspan="2" style="text-align: center;">Arroz Pilado Lima</th>

        <th rowspan="2" style="text-align: center;">Total Sacos x 50 Kg</th>
        <th rowspan="2" style="text-align: center;">Total Soles</th>
    </tr>
    <tr>
        <th style="text-align: center;">Código</th>
        <th style="text-align: center;">Producto</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Saco x 50 Kg</th>
        <th style="text-align: center;">Soles</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totales = [];
        $totales_kg = 0;
        $totales_sl = 0;

        foreach($listapilado_fisico as $row) {
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
                            $result[$centro] = ["NOM_CENTRO" => $centro, "STK_50" => 0, "COSTO_TOTAL" => 0];
                        }

                        $result[$centro]["STK_50"] += $item["STK_50"];
                        $result[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"];    

                        $tot_kg += $item["STK_50"];
                        $tot_sl += $item["COSTO_TOTAL"];  

                        // totales de todos los centros                        
                        if (!isset($totales[$centro])) {
                            $totales[$centro] = ["NOM_CENTRO" => $centro, "STK_50" => 0, "COSTO_TOTAL" => 0];
                        }
                        $totales[$centro]["STK_50"] += $item["STK_50"];
                        $totales[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                        $totales_kg += $item["STK_50"];
                        $totales_sl += $item["COSTO_TOTAL"];  

                    }
            
                }

            }
            if($nombre != ''){     
    @endphp
        <tr>
            <td style="text-align: left;">{{$codProducto}}</td>
            <td style="text-align: left;">{{$nombre}}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["STK_50"]) ? 
                                            number_format($result["CHICLAYO"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($result["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["STK_50"]) ? 
                                            number_format($result["RIOJA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["STK_50"]) ? 
                                            number_format($result["BELLAVISTA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($result["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($result["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($result["LIMA"]["STK_50"]) ? 
                                            number_format($result["LIMA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
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
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["STK_50"]) ? 
                                            number_format($totales["CHICLAYO"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["STK_50"]) ? 
                                            number_format($totales["RIOJA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["STK_50"]) ? 
                                            number_format($totales["BELLAVISTA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  
            <td style="text-align: right;">{{isset($totales["LIMA"]["STK_50"]) ? 
                                            number_format($totales["LIMA"]["STK_50"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($totales["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($totales["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>  

            <td style="text-align: right;">{{number_format($totales_kg, 2, '.', '')}}</td>
            <td style="text-align: right;">{{number_format($totales_sl, 2, '.', '')}}</td>
        </tr>
    
        
    </tbody>

</table>