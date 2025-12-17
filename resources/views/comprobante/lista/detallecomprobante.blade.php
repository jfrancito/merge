<div class="listadatos">  


    <form method="POST" action="{{ url('subir-xml-cargar-datos/'.$idopcion.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
       {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >

                    
                    <fieldset >
                        <legend>Cargar Documento XML</legend>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                                        <input name="inputxml" id='inputxml' class="form-control inputxml" type="file" accept="text/xml" />
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                        <button  type="submit" style="height:48px;" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos"><i class="icon icon-left mdi mdi-upload"></i> Subir</button>
                                    </div>
                                    
                                </div>
                            </div>
                    </fieldset>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" > 
                    <fieldset style="height: 125px;">
                        <legend style="margin-bottom: 0px;">CONSULTA API SUNAT</legend>

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
                                </div>
                            @endif


                    </fieldset>
                </div>

            </div>
        </div>
    </form>
</div>

@if(count($fedocumento)>0)


    <div class="formulariomatch">  
        <form method="POST" action="{{ url('validar-xml-oc/'.$idopcion.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
           {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>
            <div class="container">
                <div class="row justify-content-md-center">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >

                        <fieldset style="border: 2px solid #5885d1 !important;">
                            <legend style="color: #5885d1 !important;">Datos de la factura</legend>

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <p class='titulomerge'>Serie : </p>
                                    <p class='subtitulomerge'>{{$fedocumento->SERIE}}</p>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <p class='titulomerge'>Numero : </p>
                                    <p class='subtitulomerge'>{{$fedocumento->NUMERO}}</p>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <p class='titulomerge'>Fecha Emision : </p>
                                    <p class='subtitulomerge'>{{$fedocumento->FEC_VENTA}}</p>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <p class='titulomerge'>Forma Pago : </p>
                                    <p class='subtitulomerge'>{{$fedocumento->FORMA_PAGO}}</p>
                                </div>
                        
                        </fieldset>


                        <fieldset style="border: 2px solid #5885d1 !important;">
                            <legend style="color: #5885d1 !important;">Comparar (XML - Orden Compra)</legend>

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                                    <p class='titulomerge'>RUC : </p>
                                    <p class='subtitulomerge'><b>oc&nbsp;&nbsp; =></b> {{$ordencompra->NRO_DOCUMENTO_CLIENTE}}</p>
                                    <div class='subtitulomerge @if($fedocumento->ind_ruc == 1) msjexitoso @else msjerror @endif'><b>xml =></b> {{$fedocumento->RUC_PROVEEDOR}}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                                    <p class='titulomerge'>Moneda : </p>
                                    <p class='subtitulomerge'><b>oc&nbsp;&nbsp; =></b> {{$ordencompra->TXT_CATEGORIA_MONEDA}}</p>
                                    <div class='subtitulomerge @if($fedocumento->ind_moneda == 1) msjexitoso @else msjerror @endif'><b>xml =></b> 
                                        @if($fedocumento->MONEDA == 'PEN')
                                            SOLES
                                        @else
                                            {{$fedocumento->MONEDA}}
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                                    <p class='titulomerge'>Total : </p>
                                    <p class='subtitulomerge'><b>oc&nbsp;&nbsp; =></b> {{number_format($ordencompra->CAN_TOTAL+$ordencompra->CAN_PERCEPCION, 4, '.', ',')}}</p>
                                    <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                                        <!-- <b>xml =></b> {{number_format($fedocumento->TOTAL_VENTA_ORIG+$fedocumento->PERCEPCION+$fedocumento->MONTO_RETENCION, 4, '.', ',')}} -->

                                        <b>xml =></b> {{number_format($fedocumento->TOTAL_VENTA_XML+$fedocumento->PERCEPCION, 4, '.', ',')}}

                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                                    <p class='titulomerge'>Cantidad item : </p>
                                    <p class='subtitulomerge'><b>oc&nbsp;&nbsp; =></b> {{count($detalleordencompra)}}</p>
                                    <div class='subtitulomerge @if($fedocumento->ind_cantidaditem == 1) msjexitoso @else msjerror @endif'><b>xml =></b> {{count($detallefedocumento)}} 
                                    </div>
                                </div>



                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                                    <p class='titulomerge'>Forma Pago : </p>
                                    <p class='subtitulomerge'><b>oc&nbsp;&nbsp; =></b> {{$tp->NOM_CATEGORIA}}</p>
                                    <div class='subtitulomerge @if($fedocumento->ind_cantidaditem == 1) msjexitoso @else msjerror @endif'><b>xml =></b> {{$fedocumento->FORMA_PAGO}} 
                                    </div>
                                </div>


                                <br><br><br><br>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                                    <div class="tab-container">
                                      <ul class="nav nav-tabs">
                                        <li class="active"><a href="#xml" data-toggle="tab">XML</a></li>
                                        <li><a href="#oc" data-toggle="tab">OC</a></li>
                                      </ul>
                                      <div class="tab-content">
                                        <div id="xml" class="tab-pane active cont">
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
                                        <div id="oc" class="tab-pane cont">
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
                        </fieldset>




                        <fieldset style="border: 2px solid #5885d1 !important;">
                            <legend style="color: #5885d1 !important;">Subir archivos</legend>

                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                  <div class="form-group sectioncargarimagen">
                                      <label class="col-sm-12 control-label"><b>CDR</b> (Comprobante de Recepción)</label>
                                      <div class="col-sm-12">
                                          <div class="file-loading">
                                              <input id="file-cdr" name="cdm[]" class="file-es" required='' type="file" multiple data-max-file-count="1">
                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                  <div class="form-group sectioncargarimagen">
                                      <label class="col-sm-12 control-label"><b>PDF </b>(Formato de Documento) </label>
                                      <div class="col-sm-12">
                                          <div class="file-loading">
                                              <input id="file-pdf" name="pdf[]" class="file-es" required='' type="file" multiple data-max-file-count="1">
                                          </div>
                                      </div>
                                  </div>
                                </div>

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



                        </fieldset>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endif
