<div class="listadatos">  
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML ({{$xmlfactura}})
                </div>
                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="{{ url('subir-xml-cargar-datos-administrator/'.$idopcion.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                     {{ csrf_field() }}
                            <input type="hidden" name="device_info" id='device_info'>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                                        <input name="inputxml" id='inputxml' class="form-control inputxml" type="file" accept="text/xml" />
                                    </div>
                                    <input type="hidden" name="procedencia" id='procedencia' value = '{{$procedencia}}'>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                        <button  type="submit" style="height:48px;" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos"><i class="icon icon-left mdi mdi-upload"></i> Subir</button>
                                    </div>
                                </div>
                            </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-8">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CONSULTA API SUNAT
                </div>
                <div class="panel-body panel-body-contrast">
                    @if(count($fedocumento)<=0)
                        <div class="col-sm-12">
                            <b>CARGAR XML</b>
                        </div>
                    @else
                        <div class="col-sm-12">
                            <p style="margin:0px;"><b>Respuesta Sunat</b> : {{$fedocumento->message}}</p>
                            <p style="margin:0px;" class='@if($fedocumento->estadoCp == 1) msjexitoso @else msjerror @endif'><b>Estado Comprobante</b> : 
                                {{$fedocumento->nestadoCp}}
                            </p>
                            <p style="margin:0px;"><b>Estado Ruc</b> : {{$fedocumento->nestadoRuc}}</p>
                            <p style="margin:0px;"><b>Estado Domicilio</b> : {{$fedocumento->ncondDomiRuc}}</p>


                            <p style="margin:0px;"><b>Respuesta CDR</b> : {{$fedocumento->RESPUESTA_CDR}}</p>


                        </div>
                    @endif
                </div>
              </div>
            </div>
          </div>


          @if(count($fedocumento)>0)
            <form method="POST" action="{{ url('validar-xml-oc-administrator/'.$idopcion.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             {{ csrf_field() }}
             <input type="hidden" name="device_info" id='device_info'>

              <input type="hidden" name="procedencia" id='procedencia' value = '{{$procedencia}}'>
              <input type="hidden" name="rutaorden" id='rutaorden' value = '{{$rutaorden}}'>
              <input type="hidden" name="rutasuspencion" id='rutasuspencion' value = '{{$rutasuspencion}}'>
              
              
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  @include('comprobante.form.ordencompra.comparar')
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                  @include('comprobante.form.ordencompra.informacion')
                  @if(count($lista_anticipo_merge)>0)
                    @include('comprobante.form.ordencompra.anticipomerge')
                  @endif
                  

                </div>
              </div>


              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA PAGOS

                      <div class="tools ver_cuenta_bancaria_oc select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success">Ver Cuenta</span></div>
                      <div class="tools agregar_cuenta_bancaria_oc select" style="cursor: pointer;"> <span class="label label-success">Agregar Cuenta</span></div>

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
                                                                    'class'       => 'select2 form-control control input-xs entidadbancooc' ,
                                                                    'id'          => 'entidadbanco_id',
                                                                    'required'    => '',
                                                                    'data-aw'     => '1',
                                                                    'disabled' => 'disabled'
                                                                  ]) !!}
                                              @else
                                                {!! Form::select( 'entidadbanco_id', $combobancos, array($banco_id),
                                                                  [
                                                                    'class'       => 'select2 form-control control input-xs entidadbancooc' ,
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

              @if(count($area_mkt)>0)
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default panel-contrast">
                      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">GRUPO MARKETING
                        <div class="tools agregar_grupo_marketing_oc select" style="cursor: pointer;"> <span class="label label-success">Agregar Grupo</span></div>
                      </div>
                      <div class="panel-body panel-body-contrast">
                              <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                                            <div class="form-group">
                                              <label class="col-sm-12 control-label labelleft" ><b>Grupo :</b></label>
                                              <div class="col-sm-12 abajocaja" >
                                                  {!! Form::select( 'grupo_id', $combogrupo, array(''),
                                                                    [
                                                                      'class'       => 'select2 form-control control input-xs' ,
                                                                      'id'          => 'grupo_id',
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
              @endif


              <div class="row @if((float)$ordencompra_f->CAN_DETRACCION<=0) ocultar @endif" >
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">
                      <!-- <div><h4>DETRACION DE LA FACTURACION : {{round($fedocumento->TOTAL_VENTA_ORIG,2)}} x 4% = {{$ordencompra_f->CAN_DETRACCION}}</h4></div> -->
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
                                              <input type="text" name="ctadetraccion" id='ctadetraccion' class="form-control control input-sm cuentanumero" value = '{{$empresa->TXT_DETRACCION}}'>
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
                        @if(count($eliminadodoc) > 0)
                          <small style="color:#fff;font-size: 18px;font-weight: bold;">(Tiene que cargar la orden de compra porque elimino un item de ella)</small>
                        @endif
                    </div>
                    <div class="panel-body panel-body-contrast">

                            <div class="row">

                                  @if($rutasuspencion != '')
                                    <div><b style="color: #4285f4;">LA SUSPENSION DE 4TA CATEGORIA SE CARGARA DESPUES DE GUARDAR</b></div><br>
                                  @endif

                                  @foreach($tarchivos as $index => $item) 
                                    @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000001')
                                      @if($rutaorden != '')
                                        <div><b>LA ORDEN DE COMPRA SE CARGARA DESPUES DE GUARDAR</b></div><br>
                                      @else
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
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
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 autodetraccion">
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
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
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
                                        <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;margin-top:20px;"><b>REALIZAR UNA OBSERVACION :</b> <br><br></label>
                                            <div class="col-sm-12">
                                                <textarea 
                                                name="descripcion"
                                                id = "descripcion"
                                                class="form-control input-sm validarmayusculas"
                                                rows="12" 
                                                cols="200"    
                                                data-aw="2"></textarea>
                                            </div>
                                        </div>
                                      </div>



                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte 
                                                    @if((float)$monto_anticipo<=0) ocultar @endif
                                                    @if(count($lista_anticipo_merge)>0) ocultar @endif
                                                    ">
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
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '{{substr($ordencompra->COD_ORDEN, 0,6)}}'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '{{Hashids::encode(substr($ordencompra->COD_ORDEN, -10))}}'>
                                          <input type="hidden" name="detraccion" id='detraccion' value = '{{(float)$ordencompra_f->CAN_DETRACCION}}'>
                                          <input type="hidden" name="te" id='te' value = '{{$fedocumento->ind_errototal}}'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '{{$usuario->COD_TRABAJADOR}}'>
                                          <input type="hidden" name="grupo_data" id='grupo_data' value = '{{count($area_mkt)}}'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-xml">Guardar</button>
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


