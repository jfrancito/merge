<table id="aconsolidado"        
       class="{{ $tipo == 'EXC' ? '' : 'table table-bordered table-hover td-color-borde td-padding-7 display nowrap' }}">
    <thead class="background-th-azul">
    <tr>
        <th style="text-align: center;">Producto</th>
        <th colspan="2" style="text-align: center;">1- Arroz cáscara</th>
        <th colspan="2" style="text-align: center;">2- Arroz pilado</th>
        <th colspan="2" style="text-align: center;">3- Pacas</th>
        <th colspan="2" style="text-align: center;">4- Envases</th>
        <th colspan="2" style="text-align: center;">5- Bobinas</th>
        <th style="text-align: center;">6- Demás Suministros</th>
        <th colspan="2" style="text-align: center;">7- Envases de Producción</th>
        <th colspan="2" style="text-align: center;">8- Envases de Despachos</th>
        <th colspan="2" style="text-align: center;">9- Sacos cosecheros</th>
        <th colspan="2" style="text-align: center;">10- Fertilizantes</th>
        <th rowspan="2" style="text-align: center;">Total Soles</th>
    </tr>
    <tr>        
        <th style="text-align: center;">Sede</th>
        <th style="text-align: center;">Kilos</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Sacos de 50 kg</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Soles</th>
        <th style="text-align: center;">Kilos</th>
        <th style="text-align: center;">Soles</th>
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
            $tot_cen = [];

            $tot_cascara = [];
            foreach ($listacascara as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {                       
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_cascara[$centro])) {
                                $tot_cascara[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_cascara[$centro]["STOCK"] += $item["STOCK"];
                            $tot_cascara[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_pilado = [];
            foreach ($listapilado as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {                        
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_pilado[$centro])) {
                                $tot_pilado[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_pilado[$centro]["STOCK"] += $item["STK_50"];
                            $tot_pilado[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_paca = [];
            foreach ($listapaca as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {                        
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_paca[$centro])) {
                                $tot_paca[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_paca[$centro]["STOCK"] += $item["STOCK"];
                            $tot_paca[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_enva = [];
            foreach ($listaenvase as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_enva[$centro])) {
                                $tot_enva[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_enva[$centro]["STOCK"] += $item["STOCK"];
                            $tot_enva[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_bobi = [];
            foreach ($listabobina as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_bobi[$centro])) {
                                $tot_bobi[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_bobi[$centro]["STOCK"] += $item["STOCK"];
                            $tot_bobi[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_sumi = [];
            foreach ($listasuministro as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_sumi[$centro])) {
                                $tot_sumi[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_sumi[$centro]["STOCK"] += $item["STOCK"];
                            $tot_sumi[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_env_pro = [];
            foreach ($listaenvaseprod as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_env_pro[$centro])) {
                                $tot_env_pro[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_env_pro[$centro]["STOCK"] += $item["STOCK"];
                            $tot_env_pro[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_env_desp = [];
            foreach ($listaenvasedesp as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_env_desp[$centro])) {
                                $tot_env_desp[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_env_desp[$centro]["STOCK"] += $item["STOCK"];
                            $tot_env_desp[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_env_cose = [];
            foreach ($listaenvasecose as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_env_cose[$centro])) {
                                $tot_env_cose[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_env_cose[$centro]["STOCK"] += $item["STOCK"];
                            $tot_env_cose[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
            $tot_ferti = [];
            foreach ($listafertilizante as $row) {
                foreach ($row as $centros) {            
                    foreach ($centros as $item) {
                        if ($item['COD_EMPR_PROPIETARIA'] == $codempr_filtro) {
                            $centro = $item["NOM_CENTRO"];                      
                            if (!isset($tot_ferti[$centro])) {
                                $tot_ferti[$centro] = ["NOM_CENTRO" => $centro, "STOCK" => 0, "COSTO_TOTAL" => 0];
                            }
                            $tot_ferti[$centro]["STOCK"] += $item["STOCK"];
                            $tot_ferti[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 

                            if (!isset($tot_cen[$centro])) { $tot_cen[$centro] = ["NOM_CENTRO" => $centro, "COSTO_TOTAL" => 0]; }
                            $tot_cen[$centro]["COSTO_TOTAL"] += $item["COSTO_TOTAL"]; 
                        }                
                    }
                }
            }
        @endphp
        <tr>
            <td style="text-align: left;" class="negrita">Chiclayo</td>
            <td style="text-align: right;">{{isset($tot_cascara["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_cascara["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_cascara["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cascara["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_pilado["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_pilado["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_paca["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_paca["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_enva["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_enva["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_bobi["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_bobi["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_sumi["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_sumi["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_env_pro["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_pro["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_env_desp["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_desp["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_env_cose["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_cose["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["CHICLAYO"]["STOCK"]) ? 
                                            number_format($tot_ferti["CHICLAYO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_ferti["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;" class="negrita">{{isset($tot_cen["CHICLAYO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cen["CHICLAYO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
        </tr>
        <tr>
            <td style="text-align: left;" class="negrita">Rioja</td>
            <td style="text-align: right;">{{isset($tot_cascara["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_cascara["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_cascara["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cascara["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_pilado["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_pilado["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_paca["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_paca["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_enva["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_enva["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_bobi["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_bobi["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_sumi["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_sumi["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_env_pro["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_pro["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_env_desp["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_desp["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_env_cose["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_cose["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["RIOJA"]["STOCK"]) ? 
                                            number_format($tot_ferti["RIOJA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_ferti["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;" class="negrita">{{isset($tot_cen["RIOJA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cen["RIOJA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
        </tr>
        <tr>
            <td style="text-align: left;" class="negrita">Bellavista</td>
            <td style="text-align: right;">{{isset($tot_cascara["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_cascara["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_cascara["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cascara["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_pilado["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_pilado["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_paca["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_paca["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_enva["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_enva["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_bobi["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_bobi["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_sumi["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_sumi["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_env_pro["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_pro["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_env_desp["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_desp["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_env_cose["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_cose["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["BELLAVISTA"]["STOCK"]) ? 
                                            number_format($tot_ferti["BELLAVISTA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_ferti["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;" class="negrita">{{isset($tot_cen["BELLAVISTA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cen["BELLAVISTA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
        </tr>
        <tr>
            <td style="text-align: left;" class="negrita">Lima</td>
            <td style="text-align: right;">{{isset($tot_cascara["LIMA"]["STOCK"]) ? 
                                            number_format($tot_cascara["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_cascara["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cascara["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["LIMA"]["STOCK"]) ? 
                                            number_format($tot_pilado["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_pilado["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["LIMA"]["STOCK"]) ? 
                                            number_format($tot_paca["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_paca["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_paca["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["LIMA"]["STOCK"]) ? 
                                            number_format($tot_enva["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_enva["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_enva["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["LIMA"]["STOCK"]) ? 
                                            number_format($tot_bobi["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_bobi["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_bobi["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_sumi["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_sumi["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["LIMA"]["STOCK"]) ? 
                                            number_format($tot_env_pro["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_pro["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_pro["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["LIMA"]["STOCK"]) ? 
                                            number_format($tot_env_desp["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_desp["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_desp["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["LIMA"]["STOCK"]) ? 
                                            number_format($tot_env_cose["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_env_cose["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_env_cose["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["LIMA"]["STOCK"]) ? 
                                            number_format($tot_ferti["LIMA"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_ferti["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_ferti["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;" class="negrita">{{isset($tot_cen["LIMA"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cen["LIMA"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
        </tr>
        <tr>
            <td style="text-align: left;" class="negrita">En Tránsito</td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;">{{isset($tot_pilado["EN TRANSITO"]["STOCK"]) ? 
                                            number_format($tot_pilado["EN TRANSITO"]["STOCK"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;">{{isset($tot_pilado["EN TRANSITO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_pilado["EN TRANSITO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td> 
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;" class="negrita">{{isset($tot_cen["EN TRANSITO"]["COSTO_TOTAL"]) ? 
                                            number_format($tot_cen["EN TRANSITO"]["COSTO_TOTAL"], 2, '.', '') : '0.00' }}</td>
        </tr>
         <tr>
            <td style="text-align: right;" class="negrita">Total</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_cascara, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_cascara, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_pilado, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_pilado, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_paca, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_paca, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_enva, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_enva, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_bobi, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_bobi, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_sumi, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_env_pro, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_env_pro, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_env_desp, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_env_desp, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_env_cose, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_env_cose, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_ferti, 'STOCK')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_ferti, 'COSTO_TOTAL')), 2, '.', '') }}</td>
            <td style="text-align: right;" class="negrita">{{ number_format(array_sum(array_column($tot_cen, 'COSTO_TOTAL')), 2, '.', '') }}</td>
        </tr>

    </tbody>
</table>
