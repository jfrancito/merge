<div class="main-content container-fluid">
  <!--Tabs-->
  <div class="row">
    <!--Default Tabs-->
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="@if($tab_id=='oc') active @endif"><a href="#oc" data-toggle="tab">ORDEN COMPRA <span class="badge badge-success" style="font-size:16px">{{count($listadatos)}}</span></a></li>
            <li class="@if($tab_id=='observado') active @endif"><a href="#observado" data-toggle="tab">OBSERVADOS <span class="badge badge-danger" style="font-size:16px">{{count($listadatos_obs)}}</span></a></li>
            <li class="@if($tab_id=='observadole') active @endif"><a href="#observadole" data-toggle="tab">OBSERVACIONES LEVANTADAS <span class="badge badge-primary" style="font-size:16px">{{count($listadatos_obs_le)}}</span></a></li>
          </ul>
          <div class="tab-content">
            <div id="oc" class="tab-pane @if($tab_id=='oc') active @endif cont">
              <table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th>CONTRATO</th>
                    <th>FACTURA</th>
                    <th>REGISTRO</th>
                    <th>ESTADO</th>
                    <th>OPCION</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($listadatos as $index => $item)
                    <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
                      <td>{{$index+1}}</td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>CODIGO : {{$item->COD_DOCUMENTO_CTBLE}} </b> </span>
                        <span><b>FECHA  : {{$item->FEC_EMISION}}</b></span>
                        <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_EMISOR}}</span>
                        <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}</span>
                        <span><b>DOCUMENTO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</span>
                        
                        <span><b>ORSERVACION : </b>               
                            @if($item->ind_observacion == 1) 
                                <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
                            @else
                              @if($item->ind_observacion == 0) 
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              @else
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              @endif
                            @endif
                        </span>
                        
                        <span>
                          <b>DEUDA:
                            @IF($item->CAN_DEUDA > 0)
                             <span data_id_doc = '{{$item->COD_EMPR_EMISOR}}' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;">DEUDA</span>
                            @ELSE
                              <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
                            @ENDIF
                          </b>
                        </span>

                        @php
                          $transferencia    =   $funcion->con_transferencia($item->COD_DOCUMENTO_CTBLE);
                        @endphp
                        <span><b>TRANSFERENCIA:
                          @if(count($transferencia)<=0)
                              <span class="badge badge-default" style="width: 150px;display: inline-block;">SIN TRANSFERENCIA</span>
                          @else
                              @if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA')
                                <span class="badge badge-danger" style="width: 150px;display: inline-block;">NO RECEPCIONADO</span>
                              @else
                                <span class="badge badge-success" style="width: 150px;display: inline-block;">{{$transferencia->TXT_CATEGORIA_ESTADO_ORDEN}}</span>
                              @endif
                          @endif
                            </b>
                        </span>

                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>SERIE : {{$item->SERIE}} </b> </span>
                        <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
                        <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
                        <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
                        <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
                        <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
                        <span style="font-size: 18px;"><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>

                      </td>
                      @include('comprobante.ajax.estados')
                      <td class="rigth">
                        <div class="btn-group btn-hspace">
                          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                          <ul role="menu" class="dropdown-menu pull-right">
                            <li>
                              <a href="{{ url('/aprobar-comprobante-administracion-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9))) }}">
                                Revision Comprobante
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
            <div id="observado" class="tab-pane @if($tab_id=='observado') active @endif cont">
               <table id="nso_obs" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th>CONTRATO</th>
                    <th>FACTURA</th>
                    <th>REGISTRO</th>
                    <th>ESTADO</th>
                    <th>OPCION</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($listadatos_obs as $index => $item)
                    <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
                      <td>{{$index+1}}</td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>CODIGO : {{$item->COD_DOCUMENTO_CTBLE}} </b> </span>
                        <span><b>FECHA  : {{$item->FEC_EMISION}}</b></span>
                        <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_EMISOR}}</span>
                        <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}</span>
                        <span><b>DOCUMENTO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</span>
                        
                        <span><b>ORSERVACION : </b>               
                            @if($item->ind_observacion == 1) 
                                <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
                            @else
                              @if($item->ind_observacion == 0) 
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              @else
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              @endif
                            @endif
                        </span>
                        <span>
                          <b>DEUDA:
                            @IF($item->CAN_DEUDA > 0)
                             <span data_id_doc = '{{$item->COD_EMPR_EMISOR}}' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;display: inline-block;">DEUDA</span>
                            @ELSE
                              <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
                            @ENDIF
                          </b>
                        </span>

                        @php
                          $transferencia    =   $funcion->con_transferencia($item->COD_DOCUMENTO_CTBLE);
                        @endphp
                        <span><b>TRANSFERENCIA:
                          @if(count($transferencia)<=0)
                              <span class="badge badge-default" style="width: 150px;display: inline-block;">SIN TRANSFERENCIA</span>
                          @else
                              @if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA')
                                <span class="badge badge-danger" style="width: 150px;display: inline-block;">NO RECEPCIONADO</span>
                              @else
                                <span class="badge badge-success" style="width: 150px;display: inline-block;">{{$transferencia->TXT_CATEGORIA_ESTADO_ORDEN}}</span>
                              @endif
                          @endif
                            </b>
                        </span>

                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>SERIE : {{$item->SERIE}} </b> </span>
                        <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
                        <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
                        <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
                        <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
                      </td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
                        <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
                        <span style="font-size: 18px;"><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>

                      </td>

                      @include('comprobante.ajax.estados')
                      <td class="rigth">
                        <div class="btn-group btn-hspace">
                          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                          <ul role="menu" class="dropdown-menu pull-right">
                            <li>
                              <a href="{{ url('/aprobar-comprobante-administracion-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9))) }}">
                                Revision Comprobante
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

            <div id="observadole" class="tab-pane @if($tab_id=='observadole') active @endif cont">
               <table id="nso_obs_le" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th>CONTRATO</th>
                    <th>FACTURA</th>
                    <th>REGISTRO</th>
                    <th>ESTADO</th>
                    <th>OPCION</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($listadatos_obs_le as $index => $item)
                    <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
                      <td>{{$index+1}}</td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>CODIGO : {{$item->COD_DOCUMENTO_CTBLE}} </b> </span>
                        <span><b>FECHA  : {{$item->FEC_EMISION}}</b></span>
                        <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_EMISOR}}</span>
                        <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}</span>
                        <span><b>DOCUMENTO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</span>
                        
                        <span><b>ORSERVACION : </b>               
                            @if($item->ind_observacion == 1) 
                                <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
                            @else
                              @if($item->ind_observacion == 0) 
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              @else
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              @endif
                            @endif
                        </span>
                        <span>
                          <b>DEUDA:
                            @IF($item->CAN_DEUDA > 0)
                             <span data_id_doc = '{{$item->COD_EMPR_EMISOR}}' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;display: inline-block;">DEUDA</span>
                            @ELSE
                              <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
                            @ENDIF
                          </b>
                        </span>

                        @php
                          $transferencia    =   $funcion->con_transferencia($item->COD_DOCUMENTO_CTBLE);
                        @endphp
                        <span><b>TRANSFERENCIA:
                          @if(count($transferencia)<=0)
                              <span class="badge badge-default" style="width: 150px;display: inline-block;">SIN TRANSFERENCIA</span>
                          @else
                              @if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA')
                                <span class="badge badge-danger" style="width: 150px;display: inline-block;">NO RECEPCIONADO</span>
                              @else
                                <span class="badge badge-success" style="width: 150px;display: inline-block;">{{$transferencia->TXT_CATEGORIA_ESTADO_ORDEN}}</span>
                              @endif
                          @endif
                            </b>
                        </span>

                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>SERIE : {{$item->SERIE}} </b> </span>
                        <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
                        <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
                        <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
                        <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
                      </td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
                        <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
                        <span style="font-size: 18px;"><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>

                      </td>

                      @include('comprobante.ajax.estados')
                      <td class="rigth">
                        <div class="btn-group btn-hspace">
                          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                          <ul role="menu" class="dropdown-menu pull-right">
                            <li>
                              <a href="{{ url('/aprobar-comprobante-administracion-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9))) }}">
                                Revision Comprobante
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
      </div>
    </div>
  </div>
</div>



@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif





