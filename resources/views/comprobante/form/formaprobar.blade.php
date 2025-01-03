<input type="hidden" name="rutaorden" id='rutaorden' value = '{{$rutaorden}}'>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.comparar')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.sunat')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.seguimiento')
  </div> 
</div>



<div class="row">


  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Nro</th>
              <th>Nombre</th>      
              <th>Archivo</th>       
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
              @foreach($archivos as $index => $item)  
                <tr>
                  <td>{{$index + 1}}</td>
                  <td>{{$item->DESCRIPCION_ARCHIVO}}</td>
                  <td>{{$item->NOMBRE_ARCHIVO}}</td>

                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a href="{{ url('/descargar-archivo-requerimiento/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}">
                            Descargar
                          </a>  
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @endforeach
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
                              <li class="active"><a href="#oc" data-toggle="tab">ORDEN COMPRA</a></li>
                              <li><a href="#xml" data-toggle="tab">XML</a></li>
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
                                            <td>{{$ordencompra->COD_ORDEN}}</td>
                                            <td>{{$ordencompra->FEC_ORDEN}}</td>
                                            <td>{{$ordencompra->TXT_EMPR_CLIENTE}}</td>
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
    @include('comprobante.form.ordencompra.verarchivopdf')
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
                        <div><b>LA ORDEN DE COMPRA SE CARGARA DESPUES DE GUARDAR</b></div>
                      @else
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                          <div class="form-group sectioncargarimagen">
                              <label class="col-sm-12 control-label" style="text-align: left;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
                                @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else <br><br> @endif
                              </label>
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
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
                              @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else <br><br> @endif
                            </label>
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

              </div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    @include('comprobante.form.ordencompra.archivosobservados')
  </div>


  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">RECOMENDACION
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group sectioncargarimagen">
                      <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA RECOMENDCION</b> <br><br></label>
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


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cajareporte @if((float)$monto_anticipo<=0) ocultar @endif">
                    <div class="form-group">
                      <label class="col-sm-12 control-label labelleft" style="text-align: left;">
                        <div class="tooltipfr" style="text-align: left;"><b>Aplicar Anticipo </b>
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
      </div>
    </div>



  </div>




</div>




<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="{{ url('/gestion-de-comprobante-us/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      @if($fedocumento->COD_ESTADO != 'ETM0000000000007')
            <button type="submit" class="btn btn-space btn-primary btnaprobarcomporbatnte">Guardar</button>
      @endif
    </p>
  </div>
</div>