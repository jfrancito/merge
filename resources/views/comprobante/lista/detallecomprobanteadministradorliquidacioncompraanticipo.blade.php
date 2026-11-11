<div class="listadatos">  
        <div class="container">
<!--           <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS DOCUMENTO
                </div>
                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="{{ url('subir-xml-cargar-datos-liquidacion-compra-anticipo-administrator/'.$idopcion.'/'.substr($ordenpago->COD_AUTORIZACION, 0,6).'/'.Hashids::encode(substr($ordenpago->COD_AUTORIZACION, -10))) }}" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                     {{ csrf_field() }}
                      <input type="hidden" name="device_info" id='device_info'>


                      <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 cajareporte">

                          <div class="form-group">
                            <label class="col-sm-10 control-label labelleft" >Tipo Ingreso :</label>
                            <div class="col-sm-10 abajocaja" >
                              {!! Form::select( 'ingresoliq_id', $comboingresoliq, array($ingresoliq_id),
                                                [
                                                  'class'       => 'select2 form-control control input-sm' ,
                                                  'id'          => 'ingresoliq_id',
                                                  'required'    => '',
                                                  'data-aw'     => '1',
                                                ]) !!}
                            </div>
                            <input type="hidden" name="procedencia" id='procedencia' value = '{{$procedencia}}'>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
							  <button  type="submit" style="height:48px;" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos">Aceptar</button>
							</div>
                          </div>
                      </div>                    

                  </form>
                </div>
              </div>
            </div>
            
          </div> -->


          @if(count($fedocumento)>0)          
            <form method="POST" action="{{ url('validar-xml-oc-liquidacion-compra-anticipo-administrator/'.$idopcion.'/'.substr($ordenpago->COD_AUTORIZACION, 0,6).'/'.Hashids::encode(substr($ordenpago->COD_AUTORIZACION, -10))) }}" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             {{ csrf_field() }}
              <input type="hidden" name="device_info" id='device_info'>

              <input type="hidden" name="procedencia" id='procedencia' value = '{{$procedencia}}'>
              
                           
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ORDEN DE PAGO
                    </div>
                    <div class="panel-body panel-body-contrast">
                      <table class="table table-condensed table-striped">
                        <thead>
                          <tr>
                            <th>Valor</th>
                            <th>Orden Pago</th>                                       
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td><b>RUC</b></td>
                              <td><p class='subtitulomerge'>{{$ordenpago->NRO_DOC}}</p></td>                              
                            </tr>

                            <tr>
                              <td><b>RAZON SOCIAL</b></td>
                              <td><p class='subtitulomerge'>{{$ordenpago->TXT_EMPRESA}}</p></td>                              
                            </tr>

                            <tr>
                              <td><b>Moneda</b></td>
                              <td><p class='subtitulomerge'>{{$ordenpago->TXT_CATEGORIA_MONEDA}}</p></td>                              
                            </tr>

                            <tr>
                              <td><b>Total</b></td>
                              <td><p class='subtitulomerge'>{{number_format($ordenpago->CAN_TOTAL, 4, '.', ',')}}</p></td>                              
                            </tr>                           

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
                    </div>
                    <div class="panel-body panel-body-contrast">

                                        <div class="tab-container">
                                          <ul class="nav nav-tabs">
                                            <li class="active"><a href="#oc" data-toggle="tab">LIQUIDACION COMPRA</a></li>
                                            <li><a href="#xml" data-toggle="tab">XML</a></li>
                                          </ul>
                                          <div class="tab-content">
                                            <div id="oc" class="tab-pane active cont">

                                                  <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Liquidacion</th>
                                                        <th>Fecha Liquidacion</th>      
                                                        <th>Proveedor</th>       
                                                        <th>Total</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                          <td>{{$ordencompra->COD_DOCUMENTO_CTBLE}}</td>
                                                          <td>{{$ordencompra->FEC_EMISION}}</td>
                                                          <td>{{$ordencompra->TXT_EMPR_EMISOR}}</td>
                                                          <td>{{$ordencompra->CAN_TOTAL}}</td>
                                                        </tr>
                                                    </tbody>
                                                  </table>


                                                
                                                <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Producto</th>
                                                        <th>Nombre Producto</th>
                                                        <th>Unidad</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Total</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>

                                                       @foreach($detalleordencompra as $index => $item)  
                                                          <tr>
                                                            <td>{{$item->COD_PRODUCTO}}</td>
                                                            <td>{{$item->TXT_NOMBRE_PRODUCTO}}</td>
                                                            <td>{{$item->producto->unidadmedida->TXT_ABREVIATURA}}</td>

                                                            <td>{{number_format($item->CAN_PRODUCTO, 4, '.', ',')}}</td>
                                                            <td>{{number_format($item->CAN_PRECIO_UNIT_IGV, 4, '.', ',')}}</td>
                                                            <td>{{number_format($item->CAN_VALOR_VENTA_IGV, 4, '.', ',')}}</td>

                                                          </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                            </div>
                                            <div id="xml" class="tab-pane cont">

                                                  <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Serie</th>
                                                        <th>Numero</th>      
                                                        <th>Fecha Emision</th>       
                                                        <th>Forma Pago</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                          <td>{{$fedocumento->SERIE}}</td>
                                                          <td>{{$fedocumento->NUMERO}}</td>
                                                          <td>{{$fedocumento->FEC_VENTA}}</td>
                                                          <td>{{$fedocumento->FORMA_PAGO}}</td>
                                                        </tr>
                                                    </tbody>
                                                  </table>


                                                <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Producto</th>
                                                        <th>Nombre Producto</th>
                                                        <th>Unidad</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Total</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                       @foreach($detallefedocumento as $index => $item)  
                                                          <tr>
                                                            <td>{{$item->CODPROD}}</td>
                                                            <td>{{$item->PRODUCTO}}</td>
                                                            <td>{{$item->UND_PROD}}</td>
                                                            <td>{{number_format($item->CANTIDAD, 4, '.', ',')}}</td>
                                                            <td>{{number_format($item->PRECIO_ORIG, 4, '.', ',')}}</td>
                                                            <td>{{number_format($item->VAL_VENTA_ORIG, 4, '.', ',')}}</td>
                                                          </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>


                                            </div>

                                          </div>
                                        </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA PAGOS

                      <div class="tools ver_cuenta_bancaria_liq_com_an select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success">Ver Cuenta</span></div>
                      <div class="tools agregar_cuenta_bancaria_liq_com_an select" style="cursor: pointer;"> <span class="label label-success">Agregar Cuenta</span></div>

                    </div>
                    <div class="panel-body panel-body-contrast">
                            <div class="row">

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" ><b>Entidad Bancaria que se le va a pagar al proveedor :</b></label>
                                            <div class="col-sm-12 abajocaja" >

                                              @if($banco_id=='BAM0000000000011')
                                                <input type="hidden" name="entidadbanco_id" value ='{{$banco_id}}'>
                                                {!! Form::select( 'entidadbanco_id', $combobancos, array($banco_id),
                                                                  [
                                                                    'class'       => 'select2 form-control control input-xs entidadbancoliquidacioncompraanticipo' ,
                                                                    'id'          => 'entidadbanco_id',
                                                                    'required'    => '',
                                                                    'data-aw'     => '1',
                                                                    'disabled' => 'disabled'
                                                                  ]) !!}
                                              @else
                                                {!! Form::select( 'entidadbanco_id', $combobancos, array($banco_id),
                                                                  [
                                                                    'class'       => 'select2 form-control control input-xs entidadbancoliquidacioncompraanticipo' ,
                                                                    'id'          => 'entidadbanco_id',
                                                                    'required'    => '',
                                                                    'data-aw'     => '1',
                                                                  ]) !!}
                                              @endif
                                            </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte ajax_cb">
                                        @include('comprobante.combo.combo_cuenta_bancaria')
                                      </div>




                                  </div>



                            </div>


                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
                    </div>
                    <div class="panel-body panel-body-contrast">

                            <div class="row">    
                                  @if($rutaorden != '')
                                    <div><b>EL PDF DE ANTICIPO AGRARIO SUBIRA AUTOMATICO</b></div><br>
                                  @endif                              
                                  @foreach($tarchivos as $index => $item)

                                    @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000049')
                                      @if($rutaorden != '')
    
                                      @else
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                            <label class="col-sm-12 control-label" style="text-align: left;height: 50px;">
                                              <b>
                                                {{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})
                                                @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000040')
                                                  <span class='msjerror'>(OPCIONAL)</span>
                                                @endif
                                              </b> 
                                              @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else @endif </label>
                                          <div class="form-group sectioncargarimagen">

                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-{{$item->COD_CATEGORIA_DOCUMENTO}}" 
                                                      name="{{$item->COD_CATEGORIA_DOCUMENTO}}[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1"
                                                      @if($item->COD_CATEGORIA_DOCUMENTO != 'DCC0000000000040') required @endif >
                                                  </div>
                                              </div>
                                          </div>
                                        </div>  
                                      @endif
                                    @else
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                            <label class="col-sm-12 control-label" style="text-align: left;height: 50px;">
                                              <b>
                                                {{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})
                                                @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000040')
                                                  <span class='msjerror'>(OPCIONAL)</span>
                                                @endif
                                              </b> 
                                              @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else @endif </label>
                                          <div class="form-group sectioncargarimagen">

                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-{{$item->COD_CATEGORIA_DOCUMENTO}}" 
                                                      name="{{$item->COD_CATEGORIA_DOCUMENTO}}[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1"
                                                      @if($item->COD_CATEGORIA_DOCUMENTO != 'DCC0000000000040') required @endif >
                                                  </div>
                                              </div>
                                          </div>
                                        </div>  
                                    @endif


                                  @endforeach                                
                            </div>
                            <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" ><b>Usuario Contacto :</b></label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="contacto_nombre" id='contacto_nombre' class="form-control control input-sm" value = '{{$usuario->NOM_TRABAJADOR}}' readonly>
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                                   @if(isset($contrato_anticipo) && $contrato_anticipo)
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                          <div class="panel panel-default panel-contrast" style="border-left: 5px solid #2563eb; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                                            <div class="panel-heading" style="background: #f8fafc; color: #1e293b; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                                                <i class="mdi mdi-file-document-outline" style="color: #2563eb; margin-right: 8px;"></i>
                                                RESUMEN DEL CONTRATO ANTICIPO: {{ $contrato_anticipo->NRO_CONTRATO }}
                                            </div>
                                            <div class="panel-body" style="padding: 20px;">
                                                <div class="row" style="margin-bottom: 25px;">
                                                    <div class="col-md-3">
                                                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Variedad</div>
                                                        <div style="font-weight: 600; color: #334155;">{{ $contrato_anticipo->TXT_VARIEDAD }}</div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Hectáreas</div>
                                                        <div style="font-weight: 600; color: #334155;">{{ number_format($contrato_anticipo->HECTAREAS, 2) }} ha</div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Total KG</div>
                                                        <div style="font-weight: 600; color: #334155;">{{ number_format($contrato_anticipo->TOTAL_KG, 2) }} kg</div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Importe Total Habilitar</div>
                                                        <div style="font-weight: 700; color: #2563eb; font-size: 16px;">S/ {{ number_format($contrato_anticipo->IMPORTE_HABILITAR, 2) }}</div>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover" style="font-size: 12px; border: 1px solid #e2e8f0;">
                                                      <thead>
                                                        <tr style="background: #f1f5f9;">
                                                          <th style="width: 60px; text-align: center;">Item</th>
                                                          <th>Fecha Pago Prog.</th>      
                                                          <th class="text-right">Importe Cuota</th>
                                                          <th class="text-center">Estado</th>
                                                          <th>Referencia / Pago Asoc.</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                          @foreach($detalles_contrato as $det)
                                                            @php 
                                                                $pago = null;
                                                                $itemp = 0;
                                                                foreach($pagos_contrato as $p) {
                                                                    if ((int)trim($p->ITEM_CUOTA) == (int)trim($det->ITEM)) {
                                                                        $pago = $p;
                                                                        $itemp = $p->ITEM_CUOTA;
                                                                        break;
                                                                    }
                                                                }
                                                            @endphp
                                                            <!-- Cruce ITEM {{ $det->ITEM }}: {{ $pago ? 'PAGO ENCONTRADO' : 'NO ENCONTRADO' }} (Pagos en total: {{ count($pagos_contrato) }}) -->
                                                            <tr @if($pago) style="background: #f0fdf4;" @endif>
                                                              <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $det->ITEM }}</td>
                                                              <td style="font-weight: 500;">
                                                                  <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                                                      <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 13px; border: 1px solid #e2e8f0;">
                                                                          {{ date_format(date_create($det->FECHA), 'd-m-Y') }}
                                                                      </span>
                                                                  </div>
                                                                  <div style="font-size: 10px; font-weight: 600; color: #64748b; padding-left: 4px;">
                                                                      <i class="mdi mdi-clock-fast" style="color: #3b82f6;"></i> Ventana: <span style="color: #2563eb;">-2 / +2 días</span>
                                                                  </div>
                                                              </td>
                                                              @php 
                                                                  $monto_det = isset($det->IMPORTE) ? $det->IMPORTE : (isset($det->importe) ? $det->importe : 0);
                                                              @endphp
                                                              <td class="text-right" style="font-weight: 700; color: #1e293b; font-size: 14px;">S/ {{ number_format($monto_det, 2, '.', ',') }}</td>
                                                              <td class="text-center">
                                                                  @if($pago)
                                                                      <span class="label label-success" style="border-radius: 12px; padding: 4px 12px; font-weight: 700; border: 1px solid #bbf7d0;">EN PROCESO</span>
                                                                  @else
                                                                      <span class="label label-warning" style="border-radius: 12px; padding: 4px 12px; font-weight: 700; border: 1px solid #fed7aa;">PENDIENTE</span>
                                                                  @endif
                                                              </td>

                                                              <td>
                                                                  @if($pago)
                                                                      @php 
                                                                        $monto_pago = isset($pago->IMPORTE) ? $pago->IMPORTE : (isset($pago->importe) ? $pago->importe : 0);
                                                                      @endphp
                                                                      <div style="font-weight: 700; color: #166534; display: flex; align-items: center; gap: 4px;">
                                                                          <i class="mdi mdi-check-circle" style="font-size: 14px;"></i>
                                                                          {{ $pago->ID_AUTORIZACION }}
                                                                      </div>
                                                                  @else
                                                                      <span style="color: #cbd5e1; font-style: italic; font-size: 11px;">Esperando liquidación...</span>
                                                                  @endif
                                                              </td>
                                                            </tr>
                                                          @endforeach
                                                      </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                   @endif
                                   @if(isset($fecha_entrega_c) && $fecha_entrega_c != '')
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px; margin-bottom: 10px;">
                                          <div style="background: #fdf2f2; border-left: 5px solid #ef4444; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px;">
                                              <div style="background: #fee2e2; color: #ef4444; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                  <i class="mdi mdi-truck-delivery" style="font-size: 24px;"></i>
                                              </div>
                                              <div>
                                                  <div style="font-size: 12px; color: #991b1b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Entrega Estimada</div>
                                                  <div style="font-size: 1.8em; color: #7f1d1d; font-weight: 900; line-height: 1; display: flex; gap: 20px; align-items: baseline;">
                                                      {{ date_format(date_create($fecha_entrega_c), 'd-m-Y') }}
                                                      @if(isset($peso_entrega_c))
                                                        <span style="font-size: 0.6em; background: #ef4444; color: white; padding: 2px 10px; border-radius: 20px;">
                                                            PESO: {{ number_format($peso_entrega_c, 2) }} KG
                                                        </span>
                                                      @endif
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                   @endif

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">

                                      </div>
                                      <div class="col-xs-6">
                                        <p class="text-right">
                                          <input type="hidden" name="idopcion" id='idopcion' value = '{{$idopcion}}'>
                                          <input type="hidden" name="te" id='te' value = '{{$fedocumento->ind_errototal}}'>
                                          <input type="hidden" name="valor_igv" id='valor_igv' value = '{{(float)$fedocumento->VALOR_IGV_ORIG}}'>
                                          <input type="hidden" name="empresa_id" id='empresa_id' value = '{{$ordencompra_f->COD_EMPR}}'>
                                          <input type="hidden" name="monto_total" id='monto_total' value = '{{$fedocumento->TOTAL_VENTA_ORIG}}'>
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '{{substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,6)}}'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '{{Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -10))}}'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '{{$usuario->COD_TRABAJADOR}}'>
                                                        <input type="hidden" name="rutaorden" id='rutaorden' value = '{{$rutaorden}}'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-xml-liquidacion-compra-anticipo">Guardar</button>
                                        </p>
                                      </div>
                                  </div>


                            </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          @endif
        </div>
        </div>
</div>