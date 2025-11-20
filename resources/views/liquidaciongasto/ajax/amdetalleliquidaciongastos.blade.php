    <div class="panel panel-default">
      <div class="tab-container">
        <ul class="nav nav-tabs">
          <li class="@if($active=='documentos') active @endif"><a href="#documentos" data-toggle="tab">DOCUMENTOS</a></li>
          <li class="disabled @if($active=='registro') active @endif"><a href="#registro" data-toggle="tab">REGISTRO</a></li>
          <li><a href="#observados" data-toggle="tab">OBSERVADOS</a></li>  
        </ul>
        <div class="tab-content">
          <div id="documentos" class="tab-pane @if($active=='documentos') active @endif cont">
            <div class="panel-heading">
              <div class="tools tooltiptop" style="text-align:right;">
                <a href="{{ url('/modificar-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($liquidaciongastos->ID_DOCUMENTO, -8)).'/-1') }}" class="btn btn-rounded btn-space btn-success btn-sm"
                  data_planilla_movilidad_id = '{{$liquidaciongastos->ID_DOCUMENTO}}'>
                  AGREGAR DOCUMENTO            
                </a>
              </div>
            </div>

                  <div class="row" style="margin-top:15px;">
                    <div class="col-xs-12">
                      <table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
                        <thead>
                          <tr>
                            <th>DETALLE DE LIQUIDACION GASTO</th> 
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($tdetliquidaciongastos as $index=>$item)
                            <tr>
                              <td class="cell-detail" style="position: relative;">
                                <span style="display: block;"><b>FECHA EMISION : {{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</b></span>
                                <span style="display: block;"><b>FECHA CREA : {{date_format(date_create($item->FECHA_CREA), 'd/m/Y h:i:s')}}</b></span>
                                <span style="display: block;"><b>DOCUMENTO : </b> {{$item->SERIE}} - {{$item->NUMERO}}</span>
                                <span style="display: block;"><b>TIPO DOCUMENTO : </b> {{$item->TXT_TIPODOCUMENTO}}</span>
                                <span style="display: block;"><b>PROVEEDOR : </b> {{$item->TXT_EMPRESA_PROVEEDOR}}</span>                  
                                <span style="display: block;"><b>CUENTA : </b> {{$item->TXT_CUENTA}}</span>
                                <span style="display: block;"><b>SUBCUENTA : </b> {{$item->TXT_SUBCUENTA}}</span>
                                <span style="display: block;"><b>FLUJO : </b> {{$item->TXT_FLUJO}}</span>
                                <span style="display: block;"><b>ITEM : </b> {{$item->TXT_ITEM}}</span>
                                <span style="display: block;"><b>GASTO : </b> {{$item->TXT_GASTO}}</span>
                                <span style="display: block;"><b>COSTO : </b> {{$item->TXT_COSTO}}</span>
                                <span style="display: block;"><b>SUBTOTAL : </b> {{$item->SUBTOTAL}}</span>
                                <span style="display: block;"><b>IGV : </b> {{$item->IGV}}</span>
                                <span style="display: block;font-size: 16px;"><b>TOTAL :  {{$item->TOTAL}}</b></span>

                                <form method="POST" id='forextornardetallelq{{$item->ITEM}}' action="{{ url('/extonar-liquidacion-gastos-detalle/'.$idopcion.'/'.$item->ITEM.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                                      {{ csrf_field() }}
                                      <button type= 'submit' style="margin-top: 5px;float: right;" data_item = '{{$item->ITEM}}' class="btn btn-rounded btn-space btn-danger btn-sm btn-extonar-detalle-lg">EXTORNAR</button>
                                </form>
                                <a href="{{ url('/modificar-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)).'/'.$item->ITEM) }}" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm">MODIFICAR</a>
                              </td>
                            </tr>                 
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                <form method="POST" action="{{ url('/emitir-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($liquidaciongastos->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" id ='frmpmemitir'>
                      {{ csrf_field() }}


                      <input type="hidden" name="ID_DOCUMENTO" id = "ID_DOCUMENTO" value = "{{$liquidaciongastos->ID_DOCUMENTO}}">
                      <input type="hidden" name="PRIMERA_FECHA_RENDICION" id = "PRIMERA_FECHA_RENDICION" value = "{{$primerafechaar}}">
                      <input type="hidden" name="ULTIMA_FECHA_RENDICION" id = "ULTIMA_FECHA_RENDICION" value = "{{$ultimafecha}}">
                      <div class="panel panel-default panel-contrast">
                        <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA EMITIR LA LIQUIDACION
<!-- 
                          <div class="tools ver_cuenta_bancaria select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success" style="font-size: 13px !important;">Ver Cuenta</span></div>
                          <div class="tools agregar_cuenta_bancaria select" style="cursor: pointer;"> <span class="label label-success" style="font-size: 13px !important;">Agregar Cuenta</span></div> -->

                        </div>
                        <div class="panel-body panel-body-contrast">

                          <div class="row @if(count($tdetliquidaciongastos)<=0) ocultar @endif" >


                          <div class="row @if(count($tdetliquidaciongastos)<=0) ocultar @endif @if($liquidaciongastos->ARENDIR != 'REEMBOLSO') ocultar @endif" >

                              <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 cajareporte">
                                  <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft" ><b>Tipo de Pago:</b></label>
                                    <div class="col-sm-12 abajocaja" >
                                      {!! Form::select( 'tipopago_id', $combo_tp, array($tipopago_id),
                                                        [
                                                          'class'       => 'select2 form-control control input-xs' ,
                                                          'id'          => 'tipopago_id',
                                                          'required'    => '',
                                                          'data-aw'     => '1',
                                                        ]) !!}
                                    </div>
                                  </div>
                              </div>

                            
                              <div class='@if($tipopago_id != "MPC0000000000002") ocultar @endif  detallecuenta'>


                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ocultar">
                                  <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft negrita">Entidad Bancaria:</label>
                                    <div class="col-sm-12">
                                        <input  type="text"
                                                id="banco_e_id" name='banco_e_id' 
                                                value="{{$banco_e_id}}"                         
                                                placeholder="Entidad Bancaria"
                                                readonly = "readonly"
                                                autocomplete="off" class="form-control input-sm"/>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                  <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft negrita">Entidad Bancaria:</label>
                                    <div class="col-sm-12">
                                        <input  type="text"
                                                id="entidadbanco_id" name='entidadbanco_id' 
                                                value="{{$banco_nombre}}"                         
                                                placeholder="Entidad Bancaria"
                                                readonly = "readonly"
                                                autocomplete="off" class="form-control input-sm"/>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                  <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft negrita">Numero Cuenta:</label>
                                    <div class="col-sm-12">
                                        <input  type="text"
                                                id="cuentaco_id" name='cuentaco_id' 
                                                value="{{$numero_cuenta}}"                         
                                                placeholder="NUMERO CUENTA"
                                                readonly = "readonly"
                                                autocomplete="off" class="form-control input-sm"/>
                                    </div>
                                  </div>
                                </div>

                              </div>

                          </div>

                              <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                <div class="form-group">
                                  <label class="col-sm-12 control-label labelleft negrita">GLOSA :</label>
                                    <div class="col-sm-12">
                                        <textarea 
                                        name="glosa"
                                        id = "glosa"
                                        required = ""
                                        class="form-control input-sm validarmayusculas"
                                        rows="2">{{$liquidaciongastos->TXT_GLOSA}}</textarea>
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
                                      <button type="submit" class="btn btn-space btn-primary btnemitirliquidaciongasto">EMITIR LIQUIDACION DE GASTOS</button>     
                                  </p>
                                </div>
                              </div>

                        </div>
                      </div>




       
                      

                </form>
          </div>

          <div id="observados" class="tab-pane cont">
            <div class="panel-heading" style="text-align:left;">
            </div>
            <div class="row" style="margin-top:15px;">
              <div class="col-xs-6 col-sm-6 col-md-9 col-lg-9">
                <table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
                  <thead>
                    <tr>
                      <th>DETALLE DE LIQUIDACION GASTO OBSERVADOS</th> 
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tdetliquidaciongastosobs as $index=>$item)
                      <tr>
                        <td class="cell-detail" style="position: relative;">
                          <span style="display: block;"><b>FECHA EMISION : {{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</b></span>
                          <span style="display: block;"><b>DOCUMENTO : </b> {{$item->SERIE}} - {{$item->NUMERO}}</span>
                          <span style="display: block;"><b>TIPO DOCUMENTO : </b> {{$item->TXT_TIPODOCUMENTO}}</span>
                          <span style="display: block;"><b>PROVEEDOR : </b> {{$item->TXT_EMPRESA_PROVEEDOR}}</span>                  
                          <span style="display: block;"><b>CUENTA : </b> {{$item->TXT_CUENTA}}</span>
                          <span style="display: block;"><b>SUBCUENTA : </b> {{$item->TXT_SUBCUENTA}}</span>
                          <span style="display: block;"><b>FLUJO : </b> {{$item->TXT_FLUJO}}</span>
                          <span style="display: block;"><b>ITEM : </b> {{$item->TXT_ITEM}}</span>
                          <span style="display: block;"><b>GASTO : </b> {{$item->TXT_GASTO}}</span>
                          <span style="display: block;"><b>COSTO : </b> {{$item->TXT_COSTO}}</span>
                          <span style="display: block;"><b>SUBTOTAL : </b> {{$item->SUBTOTAL}}</span>
                          <span style="display: block;"><b>IGV : </b> {{$item->IGV}}</span>
                          <span style="display: block;"><b>TOTAL : </b> {{$item->TOTAL}}</span>
                        </td>
                      </tr>                 
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                @include('liquidaciongasto.form.liquidaciongasto.seguimiento')
              </div>
            </div>
          </div>
          <div id="registro" class="tab-pane @if($active=='registro') active @endif cont">
            <form method="POST" id="frmdetallelg" action="{{ url('/guardar-detalle-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($liquidaciongastos->ID_DOCUMENTO, -8))) }}" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  @include('liquidaciongasto.form.faliquidaciongastodetalle')
            </form>
          </div>

        </div>
      </div>
    </div>







