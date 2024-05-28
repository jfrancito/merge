
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - ORDEN COMPRA)
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Valor</th>
              <th>Orden de Compra</th>      
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
                  <div class='subtitulomerge @if($fedocumento->ind_cantidaditem == 1) msjexitoso @else msjerror @endif'>{{$fedocumento->FORMA_PAGO}} 
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
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SEGUIMIENTO DE DOCUMENTO
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Usuario</th>      
              <th>Tipo</th>
              <th>Mensaje</th>

            </tr>
          </thead>
          <tbody>

              @foreach($documentohistorial as $index => $item)  
                <tr>
                  <td>{{date_format(date_create($item->FECHA), 'd-m-Y H:i:s')}}</td>
                  <td>{{$item->USUARIO_NOMBRE}}</td>
                  <td><b>{{$item->TIPO}}</</b></td>
                  <td>{{$item->MENSAJE}}</td>

                </tr>
              @endforeach

          </tbody>
        </table>

      </div>
    </div>
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
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <div class="form-group sectioncargarimagen">
                      <label class="col-sm-12 control-label" style="text-align: left;"><b>OTROS DOCUMENTOS</b> <br><br></label>
                      <div class="col-sm-12">
                          <div class="file-loading">
                              <input 
                              id="file-otros" 
                              name="otros[]" 
                              class="file-es"  
                              type="file" 
                              multiple data-max-file-count="1"
                              >
                          </div>
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
      <a href="{{ url('/gestion-de-comprobante-contabilidad/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
    </p>
  </div>
</div>