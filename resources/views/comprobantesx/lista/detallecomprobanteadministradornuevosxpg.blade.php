<div class="listadatos">  
        <div class="container">
          @if(count($fedocumento)>0)
            <form method="POST" action="{{ url('validar-xml-oc-administrator-sx-pg/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>
              <input type="hidden" name="procedencia" id='procedencia' value = '{{$procedencia}}'>
              <input type="hidden" name="rutaorden" id='rutaorden' value = '{{$rutaorden}}'>
              
              
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  @include('comprobante.form.ordencompra.compararsxpg')
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
                    </div>
                    <div class="panel-body panel-body-contrast">
                                        <div class="tab-container">
                                          <ul class="nav nav-tabs">
                                            <li class="active"><a href="#oc" data-toggle="tab">PROVISION DE GASTOS</a></li>
                                          </ul>
                                          <div class="tab-content">
                                            <div id="oc" class="tab-pane active cont">

                                                  <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Orden</th>
                                                        <th>Fecha Orden</th>      
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
                                                            <td>{{$item->UNID_MED}}</td>

                                                            <td>{{number_format($item->CAN_PRODUCTO, 4, '.', ',')}}</td>
                                                            <td>{{number_format($item->CAN_PRECIO_UNIT_IGV, 4, '.', ',')}}</td>
                                                            <td>{{number_format($item->CAN_VALOR_VENTA_IGV, 4, '.', ',')}}</td>

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

                      <div class="tools ver_cuenta_bancaria_pg select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success">Ver Cuenta</span></div>
                      <div class="tools agregar_cuenta_bancaria_pg select" style="cursor: pointer;"> <span class="label label-success">Agregar Cuenta</span></div>

                    </div>
                    <div class="panel-body panel-body-contrast">
                            <div class="row">

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" ><b>Entidad Bancaria que se le va a pagar al proveedor :</b></label>
                                            <div class="col-sm-12 abajocaja" >
                                              {!! Form::select( 'entidadbanco_id', $combobancos, array(),
                                                                [
                                                                  'class'       => 'select2 form-control control input-xs entidadbancopg' ,
                                                                  'id'          => 'entidadbanco_id',
                                                                  'required'    => '',
                                                                  'data-aw'     => '1',
                                                                ]) !!}
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





              <div class="row @if((float)$ordencompra_f->CAN_DETRACCION<=0) ocultar @endif" >
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">
                      <div><h4>DETRACION DE LA FACTURACION : {{round($fedocumento->TOTAL_VENTA_ORIG,2)}} x 4% = {{$ordencompra_f->CAN_DETRACCION}}</h4></div>
                    </div>
                    <div class="panel-body panel-body-contrast">
                            <div class="row">

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">

                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" >
                                              <div class="tooltipfr"><b>Cuenta Detracción (*)</b>
                                                <span class="tooltiptext">Solo numeros</span>
                                              </div>
                                          </label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="ctadetraccion" id='ctadetraccion' class="form-control control input-sm cuentanumero" 
                                              value = '{{$empresa->TXT_DETRACCION}}'>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" ><b>Monto de Detracion (*):</b></label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="monto_detraccion" id='monto_detraccion' class="form-control control input-sm importe" 
                                              value = '{{$ordencompra_f->CAN_DETRACCION}}' readonly>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" >
                                              <div class="tooltipfr"><b>Pago Detraccion (*)</b>
                                                <span class="tooltiptext">Seleccione quien va hacer el pago de la detraccion</span>
                                              </div>
                                            </label>
                                            <div class="col-sm-12 abajocaja" >
                                              {!! Form::select( 'pago_detraccion', $combopagodetraccion, array(),
                                                                [
                                                                  'class'       => 'select2 form-control control input-xs' ,
                                                                  'id'          => 'pago_detraccion',
                                                                  'data-aw'     => '1',
                                                                ]) !!}
                                            </div>
                                          </div>
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
                                  @foreach($tarchivos as $index => $item) 
                                    @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000001')
                                      @if($rutaorden != '')
                                        <div><b>LA ORDEN DE COMPRA SE CARGARA DESPUES DE GUARDAR</b></div><br>
                                      @else
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} (@if($item->TXT_FORMATO == 'ZIP') XML @else {{$item->TXT_FORMATO}} @endif)</b> 
                                              @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else <br><br> @endif
                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-{{$item->COD_CATEGORIA_DOCUMENTO}}" 
                                                      name="{{$item->COD_CATEGORIA_DOCUMENTO}}[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1"
                                                      required>
                                                  </div>
                                              </div>
                                          </div>
                                        </div> 
                                      @endif
                                    @else
                                      @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000009')
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 autodetraccion">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;">
                                              <div class="tooltipfr"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} {{$item->TXT_FORMATO}}</b>
                                                <span class="tooltiptext">Solo subir si selecciono que usted pagara la detracion</span>
                                              </div>
                                            </label>
                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-{{$item->COD_CATEGORIA_DOCUMENTO}}" 
                                                      name="{{$item->COD_CATEGORIA_DOCUMENTO}}[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1">
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                      @ELSE
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} (@if($item->TXT_FORMATO == 'ZIP') XML @else {{$item->TXT_FORMATO}} @endif)</b> 
                                              @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else <br><br> @endif
                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-{{$item->COD_CATEGORIA_DOCUMENTO}}" 
                                                      name="{{$item->COD_CATEGORIA_DOCUMENTO}}[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1"
                                                      required>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                      @ENDIF


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


                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte @if((float)$monto_anticipo<=0) ocultar @endif">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" >
                                              <div class="tooltipfr"><b>Aplicar Anticipo </b>
                                                <span class="tooltiptext">¿Se le aplicara el anticipo a esta factura?</span>
                                              </div>
                                            :</label>
                                            <div class="col-sm-12 abajocaja" >
                                              {!! Form::select( 'monto_anticipo', $comboant, array(),
                                                                [
                                                                  'class'       => 'select2 form-control control input-sm' ,
                                                                  'id'          => 'monto_anticipo',
                                                                  'data-aw'     => '1',
                                                                ]) !!}
                                            </div>
                                          </div>
                                      </div>
                                      
                                  </div>

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">

                                      </div>
                                      <div class="col-xs-6">
                                        <p class="text-right">

                                          <input type="hidden" name="idopcion" id='idopcion' value = '{{$idopcion}}'>
                                          <input type="hidden" name="empresa_id" id='empresa_id' value = '{{$ordencompra_f->COD_EMPR}}'>
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '{{substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7)}}'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '{{Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))}}'>
                                          <input type="hidden" name="detraccion" id='detraccion' value = '{{(float)$ordencompra_f->CAN_DETRACCION}}'>
                                          <input type="hidden" name="te" id='te' value = '{{$fedocumento->ind_errototal}}'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '{{$usuario->COD_TRABAJADOR}}'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-sin-xml">Guardar</button>
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


