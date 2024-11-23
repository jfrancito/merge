<div class="listadatos">  
        <div class="container">
          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML ({{$xmlfactura}})
                </div>


                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="{{ url('subir-xml-cargar-datos-contrato-proveedor/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                     {{ csrf_field() }}

                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 cajareporte">

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

          </div>


          @if(count($fedocumento)>0)
            <form method="POST" action="{{ url('validar-xml-contrato-proveedor/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             {{ csrf_field() }}
              <input type="hidden" name="procedencia" id='procedencia' value = '{{$procedencia}}'>

              <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
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
                              <td><p class='subtitulomerge'>{{number_format($ordencompra->CAN_TOTAL+$ordencompra->CAN_PERCEPCION, 4, '.', ',')}}</p></td>
                              <td>
                                <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                                    <!-- <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG+$fedocumento->PERCEPCION+$fedocumento->MONTO_RETENCION, 4, '.', ',')}}</b> -->
                                    <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG+$fedocumento->PERCEPCION, 4, '.', ',')}}</b>

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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
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
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA PAGOS

                      <div class="tools ver_cuenta_bancaria select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success">Ver Cuenta</span></div>
                      <div class="tools agregar_cuenta_bancaria select" style="cursor: pointer;"> <span class="label label-success">Agregar Cuenta</span></div>

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
                                                                  'class'       => 'select2 form-control control input-xs entidadbanco' ,
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


              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">
                      <div><h4>DETRACION DE LA FACTURACION : {{round($fedocumento->TOTAL_VENTA_ORIG,2)}} x 4% = {{$fedocumento->TOTAL_VENTA_ORIG * 0.04}}</h4> </div>
                      <div><h6>* Solo llenar para montos mayores a 401</h6> </div>
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


                                      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" >
                                              <div class="tooltipfr"><b>Valor Detraccion (*)</b>
                                                <span class="tooltiptext">Si la detraccion corresponde a la factura o aun monto referencial</span>
                                              </div>
                                            </label>
                                            <div class="col-sm-12 abajocaja" >
                                              {!! Form::select( 'tipo_detraccion_id', $combotipodetraccion, array(),
                                                                [
                                                                  'class'       => 'select2 form-control control input-xs' ,
                                                                  'id'          => 'tipo_detraccion_id',
                                                                  'data-aw'     => '1',
                                                                ]) !!}
                                            </div>
                                          </div>
                                      </div>

                         

                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" ><b>Monto de Detracion (*):</b></label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="monto_detraccion" id='monto_detraccion' class="form-control control input-sm importe" value = '{{$fedocumento->MONTO_DETRACCION}}'>
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

                                    @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000009')

                                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 autodetraccion" >
                                        <div class="form-group sectioncargarimagen">
                                          <label class="col-sm-12 control-label" >
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


                                    @ELSE
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                      <div class="form-group sectioncargarimagen">
                                          <label class="col-sm-12 control-label"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b></label>
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
                                          
                                          <input type="hidden" name="idopcion" id='idopcion' value = '{{$idopcion}}'>
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '{{substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7)}}'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '{{Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))}}'>
                                          <input type="hidden" name="monto_total" id='monto_total' value = '{{$fedocumento->TOTAL_VENTA_ORIG}}'>
                                          <input type="hidden" name="empresa_id" id='empresa_id' value = '{{$ordencompra_f->COD_EMPR}}'>
                                          <input type="hidden" name="te" id='te' value = '{{$fedocumento->ind_errototal}}'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '{{$usuario->COD_TRABAJADOR}}'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-xml-contrato">Guardar</button>
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


