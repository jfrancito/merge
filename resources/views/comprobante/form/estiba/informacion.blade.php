<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
  </div>
<div class="panel-body panel-body-contrast">
                          <div class="tab-container">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#oc" data-toggle="tab">ESTIBA</a></li>
                              <li><a href="#xml" data-toggle="tab">XML</a></li>
                            </ul>
                                          <div class="tab-content">
                                            <div id="oc" class="tab-pane active cont">
                                             <table class="table table-condensed table-striped">
                                                <thead>
                                                  <tr>
                                                    <th>Codigo</th>
                                                    <th>Documento</th>      
                                                    <th>Proveedor</th>
                                                    <th>Total</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach($documento_asociados as $index => $item)  
                                                      <tr>
                                                        <td>{{$item->COD_DOCUMENTO_CTBLE}}</td>
                                                        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
                                                        <td>{{$item->TXT_EMPR_EMISOR}}</td>
                                                        <td>{{number_format($item->CAN_TOTAL, 4, '.', ',')}}</td>
                                                      </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfooter>
                                                  <tr>
                                                    <th></th>
                                                    <th></th>      
                                                    <th></th>
                                                    <th>{{$documento_asociados->sum('CAN_TOTAL')}}</th>
                                                  </tr>

                                                </tfooter>
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