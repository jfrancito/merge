<div class="listadatos">  
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML
                </div>
                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="{{ url('subir-xml-cargar-datos-comision-administrator/'.$idopcion.'/'.$idoc) }}" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                     {{ csrf_field() }}

                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 cajareporte">

                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft" >Documento :</label>
                            <div class="col-sm-12 abajocaja" >
                              {!! Form::select( 'documento_id', $combodocumento, array($documento_id),
                                                [
                                                  'class'       => 'select2 form-control control input-sm' ,
                                                  'id'          => 'documento_id',
                                                  'required'    => '',
                                                  'data-aw'     => '1',
                                                ]) !!}
                            </div>
                          </div>
                      </div> 

                      <input type="hidden" name="operacion_id" id="operacion_id" value="{{$fereftop1->OPERACION}}">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" >Archivo :</label>
                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                                  <input name="inputxml" id='inputxml' class="form-control inputxml" type="file" accept="text/xml" />
                              </div>
                              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                  <button  type="submit" style="height:48px;" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos"><i class="icon icon-left mdi mdi-upload"></i> Subir</button>
                              </div>
                          
                          </div>
                      </div>

                  </form>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
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
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DOCUMENTOS ASOCIADOS 
                  {{number_format($documento_asociados->sum('MONTO'), 2, '.', ',')}}
                </div>
                <div class="panel-body panel-body-contrast">

                <table class="table table-condensed table-striped">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>ID</th>
                        <th>BANCO</th>      
                        <th>CUENTA</th>
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                       @foreach($documento_asociados as $index => $item)  
                          <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$item->COD_OPERACION_CAJA}}</td>
                            <td>{{$item->NOMBRE_BANCO_CAJA}}</td>
                            <td>{{$item->NRO_CUENTA_BANCARIA}}</td>
                            <td>@if($item->MONEDA=='SOLES') {{$item->MONTO_SOLES}} @else {{$item->MONTO_DOLARES}} @endif</td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>


          @if(count($fedocumento)>0)
            <form method="POST" action="{{ url('validar-xml-oc-comision-administrator/'.$idopcion.'/'.$idoc) }}" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             {{ csrf_field() }}
              <input type="hidden" name="rutaorden" id='rutaorden' value = '{{$rutaorden}}'>
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">{{$fereftop1->OPERACION}}
                    </div>
                    <div class="panel-body panel-body-contrast">
                      <table class="table table-condensed table-striped">
                        <thead>
                          <tr>
                            <th>Valor</th>
                            <th>DOCUMENTO</th>      
                            <th>XML</th>       
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td><b>Moneda</b></td>
                              <td><p class='subtitulomerge'>{{$documento_top->MONEDA}}</p></td>
                              <td>
                                <div class='subtitulomerge @if($fedocumento->ind_moneda == 1) msjexitoso @else msjerror @endif'> <b>
                                    @if($fedocumento->MONEDA == 'PEN')
                                        SOLES
                                    @else
                                        {{$fedocumento->MONEDA}}
                                    @endif</b>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td><b>Total</b></td>
                              <td><p class='subtitulomerge'>{{number_format($documento_asociados->sum('MONTO'), 4, '.', ',')}}</p></td>
                              <td>
                                <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                                    <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')}}</b>
                                </div>
                              </td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL XML
                    </div>
                    <div class="panel-body panel-body-contrast">

                                        <div class="tab-container">
                                          <ul class="nav nav-tabs">
                                            <li class="active"><a href="#xml" data-toggle="tab">XML</a></li>
                                          </ul>
                                          <div class="tab-content">
                                            <div id="xml" class="tab-pane active cont">
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
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
                    </div>
                    <div class="panel-body panel-body-contrast">

                            <div class="row">
                                  @if($rutaorden != '')
                                    <div><b>LOS ARCHIVOS DE CONTRATOS Y GUIAS RELACIONADAS SE CARGARAN DESPUES DE GUARDAR</b></div><br>
                                  @endif
                                  @foreach($tarchivos as $index => $item) 
                                    @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000026')
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                            <label class="col-sm-12 control-label" style="text-align: left; height: 50px;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
                                              @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>)@endif </label>
                                          <div class="form-group sectioncargarimagen">


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
                                    @else
                                      @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000009')

                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 autodetraccion" style="margin-top:15px;">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;height: 50px;">
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
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                            <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
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
                                              <input type="text" name="contacto_nombre" id='contacto_nombre' class="form-control control input-sm" 
                                              value = '{{$usuario->NOM_TRABAJADOR}}' readonly>
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
                                          <input type="hidden" name="te" id='te' value = '{{$fedocumento->ind_errototal}}'>
                                          <input type="hidden" name="valor_igv" id='valor_igv' value = '{{(float)$fedocumento->VALOR_IGV_ORIG}}'>
                                          <input type="hidden" name="empresa_id" id='empresa_id' value = '{{$empresa->COD_EMPR}}'>
                                          <input type="hidden" name="monto_total" id='monto_total' value = '{{$fedocumento->TOTAL_VENTA_ORIG}}'>
                                          <input type="hidden" name="tipo_documento_id" id='tipo_documento_id' value = '{{$fedocumento->ID_TIPO_DOC}}'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '{{$idoc}}'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '{{$usuario->COD_TRABAJADOR}}'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-xml-comision">Guardar</button>
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


