<div class="listadatos">  
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML
                </div>
                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="{{ url('subir-xml-cargar-datos-contrato-administrator/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
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

                      <div class="col-sm-12">
                          <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" >Archivo :</label>
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
            <form method="POST" action="{{ url('validar-xml-oc-contrato-administrator/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             {{ csrf_field() }}
              <input type="hidden" name="procedencia" id='procedencia' value = '{{$procedencia}}'>
              <input type="hidden" name="rutaorden" id='rutaorden' value = '{{$rutaorden}}'>
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - CONTRATO)
                    </div>
                    <div class="panel-body panel-body-contrast">
                      <table class="table table-condensed table-striped">
                        <thead>
                          <tr>
                            <th>Valor</th>
                            <th>Contrato</th>      
                            <th>XML</th>       
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td><b>RUC</b></td>
                              <td><p class='subtitulomerge'>{{$ordencompra->NRO_DOCUMENTO_CLIENTE}}</p></td>
                              <td>
                                <div class='subtitulomerge @if($fedocumento->ind_ruc == 1) msjexitoso @else msjerror @endif'><b>{{$fedocumento->RUC_PROVEEDOR}}</b>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td><b>RAZON SOCIAL</b></td>
                              <td><p class='subtitulomerge'>{{$ordencompra->TXT_EMPR_EMISOR}}</p></td>
                              <td>
                                <div class='subtitulomerge @if($fedocumento->ind_rz == 1) msjexitoso @else msjerror @endif'><b>{{$fedocumento->RZ_PROVEEDOR}}</b>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td><b>Moneda</b></td>
                              <td><p class='subtitulomerge'>{{$ordencompra->TXT_CATEGORIA_MONEDA}}</p></td>
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
                              <td><p class='subtitulomerge'>{{number_format($ordencompra->CAN_TOTAL, 4, '.', ',')}}</p></td>
                              <td>
                                <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                                    <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')}}</b>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td><b>Forma Pago</b></td>
                              <td><p class='subtitulomerge'>{{$tp->NOM_CATEGORIA}}</p></td>
                              <td>
                                <div class='subtitulomerge @if($fedocumento->ind_formapago == 1) msjexitoso @else msjerror @endif'>
                                  {{$fedocumento->FORMA_PAGO}}
<!--                                   @if($tp->CODIGO_SUNAT == 'CRE')
                                    A {{$fedocumento->FORMA_PAGO_DIAS}} DIAS
                                  @endif -->
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td><b>Cantidad item</b></td>
                              <td><p class='subtitulomerge'>{{count($detalleordencompra)}}</p></td>
                              <td>
                                 <div class='subtitulomerge @if($fedocumento->ind_cantidaditem == 1) msjexitoso @else msjerror @endif'><b>{{count($detallefedocumento)}}</b>
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
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
                    </div>
                    <div class="panel-body panel-body-contrast">

                                        <div class="tab-container">
                                          <ul class="nav nav-tabs">
                                            <li class="active"><a href="#oc" data-toggle="tab">Contrato</a></li>
                                            <li><a href="#xml" data-toggle="tab">XML</a></li>
                                          </ul>
                                          <div class="tab-content">
                                            <div id="oc" class="tab-pane active cont">

                                                  <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Contrato</th>
                                                        <th>Fecha Contrato</th>      
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
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
                    </div>
                    <div class="panel-body panel-body-contrast">

                            <div class="row">
                                  @if($rutaorden != '')
                                    <div><b>LOS ARCHIVOS DE CONTRATOS Y GUIAS RELACIONADAS SE CARGARAN DESPUES DE GUARDAR</b></div><br>
                                  @endif
                                  @foreach($tarchivos as $index => $item) 
                                    @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000026')
                                      @if($rutaorden != '')
                                        
                                      @else
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
                                      @endif
                                    @else
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
                                    @endif
                                  @endforeach

                                  @foreach($array_guias as $index => $item)
                                    @if($item['rutaordenguia'] == '')
                                      <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                        <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>GUIA REMITENTE {{$item['NRO_SERIE']}} - {{$item['NRO_DOC']}} (PDF)</b></label>
                                        <div class="form-group sectioncargarimagen">
                                          
                                            <div class="col-sm-12">
                                                <div class="file-loading">
                                                    <input 
                                                    id="file-{{$item['COD_DOCUMENTO_CTBLE']}}" 
                                                    name="{{$item['COD_DOCUMENTO_CTBLE']}}[]" 
                                                    class="file-es"  
                                                    type="file" 
                                                    multiple data-max-file-count="1"
                                                    required>
                                                </div>
                                            </div>
                                        </div>
                                      </div> 
                                    @endif
                                  @endforeach
                            </div>
                            <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" ><b>Usuario Contacto :</b></label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="contacto_nombre" id='contacto_nombre' class="form-control control input-sm" value = '{{$usuario->NOM_TRABAJADOR}}' readonly>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-xs-6">
                                      </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">

                                      </div>
                                      <div class="col-xs-6">
                                        <p class="text-right">
                                          <input type="hidden" name="te" id='te' value = '{{$fedocumento->ind_errototal}}'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '{{$usuario->COD_TRABAJADOR}}'>
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


