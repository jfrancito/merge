@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
    <style type="text/css">
        .btn-guardar-premium {
            height: 42px !important;
            min-width: 150px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            border-radius: 20px !important;
            box-shadow: 0 4px 10px rgba(52, 168, 83, 0.3) !important;
            transition: all 0.2s ease-in-out !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 5px !important;
        }
        .btn-guardar-premium:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 14px rgba(52, 168, 83, 0.4) !important;
            filter: brightness(1.08) !important;
            color: #fff !important;
            text-decoration: none !important;
        }
        .btn-guardar-premium:active {
            transform: translateY(0) !important;
            box-shadow: 0 3px 8px rgba(52, 168, 83, 0.3) !important;
        }
        .btn-guardar-premium:disabled {
            opacity: 0.55 !important;
            cursor: not-allowed !important;
            box-shadow: none !important;
            pointer-events: none !important;
        }
    </style>
@stop

@section('section')
    <div class="be-content registrocomprobante hextorno">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-border-color panel-border-color-success">
                        <div class="panel-heading">{{ $titulo }}
                        </div>
                        <div class="panel-body">
                            <div class="listadatos">
                                <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <div class="panel panel-default panel-contrast">
                                                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML
                                                </div>
                                                <div class="panel-body panel-body-contrast">
                                                    <form method="POST"
                                                          action="{{ url('subir-xml-cargar-datos-comision-administrator-masivo/'.$idopcion.'/'.$idoc) }}"
                                                          name="formcargardatos" id="formcargardatos" enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="device_info" id='device_info'>
                                                        <input type="hidden" name="idopcion" id="idopcion" value="{{$idopcion}}">
                                                        <input type="hidden" name="jsondocumenos" id='jsondocumenos' value="{{$jsondocumenos}}">
                                                        <input type="hidden" id="total_xml_masivo" value="{{ $fedocumentos->sum('TOTAL_VENTA_ORIG') }}">
                                                        
                                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 cajareporte">
                                                            <div class="form-group">
                                                                <label class="col-sm-12 control-label labelleft">Documento :</label>
                                                                <div class="col-sm-12 abajocaja">
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
                                                        <input type="hidden" name="operacion_id" id="operacion_id" value="COMISION">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-sm-12 control-label labelleft">Archivo :</label>
                                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                                                                    <input name="inputxml[]" id='inputxml' class="form-control inputxml" type="file"
                                                                           accept="text/xml" multiple />
                                                                </div>
                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                                                    <button type="submit" style="height:48px;"
                                                                            class="btn btn-space btn-success btn-lg cargardatosliq"
                                                                            id='cargardatosliq' title="Cargar Datos"><i
                                                                                class="icon icon-left mdi mdi-upload"></i> Subir
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- Panel Detalle de Facturas Cargadas -->
                                            <div id="panel-detalle-pdfs" class="panel panel-default panel-contrast" style="display: none; margin-top: 15px;">
                                                <div class="panel-heading" style="background: #1d3a6d; color: #fff;">DETALLE DE FACTURAS CARGADAS
                                                </div>
                                                <div class="panel-body panel-body-contrast">
                                                    <table class="table table-condensed table-striped" style="margin-bottom: 10px;">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Serie</th>
                                                                <th>Número</th>
                                                                <th>Total</th>
                                                                <th style="text-align: center;">Ver</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabla-detalle-pdfs-body">
                                                        </tbody>
                                                    </table>

                                                    <!-- Cuadro de Validación de Totales -->
                                                    <div id="validacion-totales-pdf" style="padding: 10px; border-radius: 4px; border: 1px solid #ddd; background: #fff; margin-top: 15px;">
                                                        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 13px;">
                                                            <span>Total Doc. Asociados:</span>
                                                            <span id="total-doc-asociados-val">0.00</span>
                                                        </div>
                                                        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 13px; margin-top: 5px;">
                                                            <span>Total PDFs Cargados:</span>
                                                            <span id="total-pdfs-val">0.00</span>
                                                        </div>
                                                        <div id="resultado-validacion-msg" style="margin-top: 10px; text-align: center; font-weight: bold; font-size: 12px; padding: 4px; border-radius: 3px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contenedor izquierdo para mover el panel de PDF -->
                                            <div id="col-pdf-left">
                                                @if($documento_id != 'DCC0000000000048')
                                                    <!-- Panel de carga de PDFs masivos -->
                                                    <div id="panel-pdf-masivo-container" class="panel panel-default panel-contrast" style="margin-top: 15px;">
                                                        <div class="panel-heading" style="background: #1d3a6d; color: #fff;">CARGAR ARCHIVOS PDF MASIVO
                                                        </div>
                                                        <div class="panel-body panel-body-contrast">
                                                            <form method="POST"
                                                                  action="{{ url('subir-pdf-masivo-comision-administrator/'.$idopcion.'/'.$idoc) }}"
                                                                  name="formcargarpdfmasivo" id="formcargarpdfmasivo" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="device_info" id='device_info_pdf'>
                                                                <input type="hidden" name="jsondocumenos" id='jsondocumenos_pdf' value="{{$jsondocumenos}}">
                                                                <input type="hidden" name="operacion_id" id="operacion_id_pdf" value="COMISION">
                                                                
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="col-sm-12 control-label labelleft">Archivos PDF :</label>
                                                                        <div class="col-sm-12" style="margin-bottom: 15px;">
                                                                            <input name="inputpdf[]" id='inputpdf' class="form-control inputpdf" type="file"
                                                                                   accept="application/pdf" multiple />
                                                                            <div id="errorBlock"></div>
                                                                            <input type="hidden" id="total_asociado_oc" value="{{ $documento_asociados->sum('MONTOATENDIDOREAL') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 text-center">
                                                                    <button type="submit" style="height:48px; width: 100%;"
                                                                            class="btn btn-space btn-primary btn-lg"
                                                                            id='btncargarpdfmasivo' title="Cargar PDFs"><i
                                                                                class="icon icon-left mdi mdi-upload"></i> Subir PDFs
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <!-- Contenedor medio para mover el panel de PDF -->
                                            <div id="col-pdf-mid">
                                                @if($documento_id == 'DCC0000000000048')
                                                    <!-- Panel de carga de PDFs masivos -->
                                                    <div id="panel-pdf-masivo-container" class="panel panel-default panel-contrast">
                                                        <div class="panel-heading" style="background: #1d3a6d; color: #fff;">CARGAR ARCHIVOS PDF MASIVO
                                                        </div>
                                                        <div class="panel-body panel-body-contrast">
                                                            <form method="POST"
                                                                  action="{{ url('subir-pdf-masivo-comision-administrator/'.$idopcion.'/'.$idoc) }}"
                                                                  name="formcargarpdfmasivo" id="formcargarpdfmasivo" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="device_info" id='device_info_pdf'>
                                                                <input type="hidden" name="jsondocumenos" id='jsondocumenos_pdf' value="{{$jsondocumenos}}">
                                                                <input type="hidden" name="operacion_id" id="operacion_id_pdf" value="COMISION">
                                                                
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="col-sm-12 control-label labelleft">Archivos PDF :</label>
                                                                        <div class="col-sm-12" style="margin-bottom: 15px;">
                                                                            <input name="inputpdf[]" id='inputpdf' class="form-control inputpdf" type="file"
                                                                                   accept="application/pdf" multiple />
                                                                            <div id="errorBlock"></div>
                                                                            <input type="hidden" id="total_asociado_oc" value="{{ $documento_asociados->sum('MONTOATENDIDOREAL') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 text-center">
                                                                    <button type="submit" style="height:48px; width: 100%;"
                                                                            class="btn btn-space btn-primary btn-lg"
                                                                            id='btncargarpdfmasivo' title="Cargar PDFs"><i
                                                                                class="icon icon-left mdi mdi-upload"></i> Subir PDFs
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Panel CONSULTA API SUNAT -->
                                             <div id="panel-api-sunat-container" class="panel panel-default panel-contrast" @if($documento_id == 'DCC0000000000048') style="display: none;" @endif>
                                                 <div class="panel-heading" style="background: #1d3a6d; color: #fff;">CONSULTA API SUNAT
                                                 </div>
                                                 <div class="panel-body panel-body-contrast">
                                                      @if(empty($fedocumentos) || $fedocumentos->isEmpty())
                                                          <div class="col-sm-12 text-center" style="padding: 20px 0;">
                                                              <i class="mdi mdi-cloud-search" style="font-size: 50px; color: #1d3a6d; display: block; margin-bottom: 10px;"></i>
                                                              <b style="font-size: 15px; color: #1d3a6d;">CARGAR XML</b>
                                                              <p style="color: #666; font-size: 12px; margin-top: 5px;">Se consultará el estado de validez del comprobante ante SUNAT.</p>
                                                          </div>
                                                      @else
                                                          @foreach($fedocumentos as $fedoc)
                                                              <div style="border-bottom: 1px dashed #ddd; padding-bottom: 10px; margin-bottom: 10px; font-size: 13px; line-height: 1.8;">
                                                                  <p style="margin:0px;"><b>Comprobante</b> : {{ $fedoc->SERIE }}-{{ $fedoc->NUMERO }}</p>
                                                                  <p style="margin:0px;"><b>Respuesta Sunat</b> : {{ $fedoc->message }}</p>
                                                                  <p style="margin:0px;" class="@if($fedoc->estadoCp == 1) msjexitoso @else msjerror @endif"><b>Estado Comprobante</b> : 
                                                                      {{ $fedoc->nestadoCp }}
                                                                  </p>
                                                                  <p style="margin:0px;"><b>Estado Ruc</b> : {{ $fedoc->nestadoRuc }}</p>
                                                                  <p style="margin:0px;"><b>Estado Domicilio</b> : {{ $fedoc->ncondDomiRuc }}</p>
                                                                  @if(!empty($fedoc->RESPUESTA_CDR))
                                                                      <p style="margin:0px;"><b>Respuesta CDR</b> : {{ $fedoc->RESPUESTA_CDR }}</p>
                                                                  @endif
                                                              </div>
                                                          @endforeach
                                                      @endif
                                                 </div>
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <div class="panel panel-default panel-contrast">
                                                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DOCUMENTOS ASOCIADOS
                                                    {{number_format($documento_asociados->sum('MONTOATENDIDOREAL'), 2, '.', ',')}}
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
                                                                <td>{{number_format($item->MONTOATENDIDOREAL, 4, '.', '')}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                     </div>

                                     <div id="panel-xml-detalle-container" @if(empty($fedocumentos) || $fedocumentos->isEmpty() || $documento_id == 'DCC0000000000048') style="display: none;" @endif>
                                         @if(!empty($fedocumentos) && !$fedocumentos->isEmpty() && $documento_id != 'DCC0000000000048')
                                             @foreach($fedocumentos as $indexFedoc => $fedoc)
                                                 @php
                                                     // Buscar una operación que coincida en monto con este XML
                                                     $matched_op = null;
                                                     foreach ($documento_asociados as $op) {
                                                         if (abs($op->MONTOATENDIDOREAL - $fedoc->TOTAL_VENTA_ORIG) <= 0.05) {
                                                             $matched_op = $op;
                                                             break;
                                                         }
                                                     }
                                                     $curr_op_total = $matched_op ? $matched_op->MONTOATENDIDOREAL : ($documento_asociados->first() ? $documento_asociados->first()->MONTOATENDIDOREAL : 0);
                                                     $curr_details = $detallefedocumento->where('ID_DOCUMENTO', $fedoc->ID_DOCUMENTO);
                                                 @endphp
                                                 <div class="row" style="margin-top: 20px; border-bottom: 2px dashed #ccc; padding-bottom: 20px; margin-bottom: 20px;">
                                                     <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                         <div class="panel panel-default panel-contrast">
                                                             <div class="panel-heading" style="background: #1d3a6d;color: #fff;">{{$fereftop1->OPERACION}} ({{$fedoc->SERIE}}-{{$fedoc->NUMERO}})
                                                             </div>
                                                             <div class="panel-body panel-body-contrast">
                                                                 <table class="table table-condensed table-striped">
                                                                     <thead>
                                                                     <tr>
                                                                         <th>VALOR</th>
                                                                         <th>DOCUMENTO</th>
                                                                         <th>XML</th>
                                                                     </tr>
                                                                     </thead>
                                                                     <tbody>

                                                                     <tr>
                                                                         <td><b>RUC</b></td>
                                                                         <td><p class='subtitulomerge'>{{$documento_top->RUC}}</p></td>
                                                                         <td class="">
                                                                             <div class='subtitulomerge @if($fedoc->ind_ruc == 1) msjexitoso @else msjerror @endif'>
                                                                                 <b>{{$fedoc->RUC_PROVEEDOR}}</b>
                                                                             </div>
                                                                         </td>
                                                                     </tr>

                                                                     <tr>
                                                                         <td><b>Moneda</b></td>
                                                                         <td><p class='subtitulomerge'>{{$documento_top->MONEDA}}</p></td>
                                                                         <td>
                                                                             <div class='subtitulomerge @if($fedoc->ind_moneda == 1) msjexitoso @else msjerror @endif'>
                                                                                 <b>
                                                                                     @if($fedoc->MONEDA == 'PEN' || $fedoc->MONEDA == 'SOLES')
                                                                                         SOLES
                                                                                     @else
                                                                                         {{$fedoc->MONEDA}}
                                                                                     @endif</b>
                                                                             </div>
                                                                         </td>
                                                                     </tr>
                                                                     <tr>
                                                                         <td><b>Total</b></td>
                                                                         <td>
                                                                             <p class='subtitulomerge'>{{number_format($curr_op_total, 4, '.', ',')}}</p>
                                                                         </td>
                                                                         <td>
                                                                             <div class='subtitulomerge @if($fedoc->ind_total == 1) msjexitoso @else msjerror @endif'>
                                                                                 <b>{{number_format($fedoc->TOTAL_VENTA_ORIG, 4, '.', ',')}}</b>
                                                                             </div>
                                                                         </td>
                                                                     </tr>
                                                                     </tbody>
                                                                 </table>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     
                                                     <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                         <div class="panel panel-default panel-contrast">
                                                             <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL XML
                                                             </div>
                                                             <div class="panel-body panel-body-contrast">
                                                                 <div class="tab-container">
                                                                     <ul class="nav nav-tabs">
                                                                         <li class="active"><a href="#xml-{{$indexFedoc}}" data-toggle="tab">XML</a></li>
                                                                     </ul>
                                                                     <div class="tab-content">
                                                                         <div id="xml-{{$indexFedoc}}" class="tab-pane active cont">
                                                                             <table class="table table-condensed table-striped" style="margin-bottom: 20px;">
                                                                                 <thead>
                                                                                 <tr>
                                                                                     <th>Serie</th>
                                                                                     <th>Numero</th>
                                                                                     <th>Fecha Emision</th>
                                                                                     <th>Forma Pago</th>
                                                                                     <th>PDF Asociado</th>
                                                                                 </tr>
                                                                                 </thead>
                                                                                 <tbody>
                                                                                 <tr>
                                                                                     <td>{{$fedoc->SERIE}}</td>
                                                                                     <td>{{$fedoc->NUMERO}}</td>
                                                                                     <td>{{$fedoc->FEC_VENTA}}</td>
                                                                                     <td>{{$fedoc->FORMA_PAGO}}</td>
                                                                                     <td>
                                                                                         <span class="pdf-asoc-badge label label-danger" 
                                                                                               data-serie="{{$fedoc->SERIE}}" 
                                                                                               data-numero="{{(int)$fedoc->NUMERO}}">
                                                                                             No cargado
                                                                                         </span>
                                                                                     </td>
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
                                                                                 @foreach($curr_details as $item)
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
                                             @endforeach
                                         @endif
                                     </div>

                                    <!-- Botón Guardar Global (fuera de los contenedores de las columnas) -->
                                    <div class="row" style="margin-top: 20px; margin-bottom: 10px;">
                                        <div class="col-xs-12 text-right" style="padding-right: 15px;">
                                            <button type="button" id="btn-guardar-comision-masivo" class="btn btn-success btn-guardar-premium" @if(($documento_id == 'DCC0000000000048' || empty($fedocumentos) || $fedocumentos->isEmpty())) disabled="disabled" @endif>
                                                <i class="icon icon-left mdi mdi-save"></i> Guardar Todo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('comision.modal.mregistrorequerimiento')
        
        <!-- Modal de Previsualización de PDF con Navegación Secuencial -->
        <div id="previewPdfModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" style="display: none; z-index: 9999;">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1200px; margin: 30px auto;">
                <div class="modal-content" style="border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.5); overflow: hidden; border: none;">
                    <div class="modal-header" style="background: #1d3a6d; color: #fff; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: none;">
                        <div style="display: flex; align-items: center; gap: 15px; width: 50%; overflow: hidden;">
                            <h4 class="modal-title" id="previewPdfTitle" style="margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 15px;">
                                Previsualización de Documento
                            </h4>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
                            <span id="previewPdfCounter" class="label label-default" style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 3px; font-weight: 600;">
                                Doc 0 de 0
                            </span>
                            <button type="button" class="btn btn-xs btn-warning" id="btnPrevPdf" style="font-weight: 600; border-radius: 3px; background: #ff5722; border-color: #ff5722; padding: 5px 12px; color: #fff; display: none;">
                                <i class="mdi mdi-chevron-left" style="font-size: 14px; vertical-align: middle;"></i> Anterior
                            </button>
                            <button type="button" class="btn btn-xs btn-warning" id="btnNextPdf" style="font-weight: 600; border-radius: 3px; background: #ff5722; border-color: #ff5722; padding: 5px 12px; color: #fff; display: none;">
                                Siguiente <i class="mdi mdi-chevron-right" style="font-size: 14px; vertical-align: middle;"></i>
                            </button>
                            <a href="#" id="btnDownloadPdf" download class="btn btn-xs btn-success" style="font-weight: 600; border-radius: 3px; padding: 5px 12px; background: #4caf50; border-color: #4caf50; color: #fff; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="mdi mdi-download" style="font-size: 14px;"></i> Descargar
                            </a>
                            <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px; line-height: 1; margin: 0; padding: 0; background: none; border: none; cursor: pointer;">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body" style="padding: 0; background: #f4f4f4; height: calc(85vh - 50px);">
                        <iframe id="pdfPreviewIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Éxito Premium -->
        <div class="modal fade" id="modal-exito-premium" tabindex="-1" role="dialog" aria-labelledby="modalExitoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 10000;">
            <div class="modal-dialog modal-sm" role="document" style="margin-top: 15vh; max-width: 400px;">
                <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); overflow: hidden;">
                    <div class="modal-body text-center" style="padding: 35px 25px;">
                        <!-- Icono animado de éxito -->
                        <div style="width: 70px; height: 70px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <span class="mdi mdi-check-all" style="font-size: 40px; color: #2e7d32; line-height: 1;"></span>
                        </div>
                        
                        <h4 class="modal-title" id="modalExitoLabel" style="font-weight: 700; color: #1d3a6d; font-size: 20px; margin-bottom: 10px;">¡Operación Exitosa!</h4>
                        
                        <p id="modal-exito-mensaje" style="color: #555; font-size: 14px; line-height: 1.5; margin-bottom: 25px;">
                            Los comprobantes de pago fueron guardados y asociados correctamente.
                        </p>
                        
                        <button type="button" id="btn-modal-exito-aceptar" class="btn btn-success" style="height: 40px; width: 100%; border-radius: 20px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3); border: none; background: #2e7d32; transition: all 0.2s;">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación Premium -->
        <div class="modal fade" id="modal-confirmacion-premium" tabindex="-1" role="dialog" aria-labelledby="modalConfirmacionLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 10000;">
            <div class="modal-dialog modal-sm" role="document" style="margin-top: 15vh; max-width: 400px;">
                <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); overflow: hidden;">
                    <div class="modal-body text-center" style="padding: 35px 25px;">
                        <!-- Icono de interrogación corporativo -->
                        <div style="width: 70px; height: 70px; background: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <span class="mdi mdi-help-outline" style="font-size: 40px; color: #1e88e5; line-height: 1;"></span>
                        </div>
                        
                        <h4 class="modal-title" id="modalConfirmacionLabel" style="font-weight: 700; color: #1d3a6d; font-size: 20px; margin-bottom: 10px;">¿Confirmar Operación?</h4>
                        
                        <p id="modal-confirmacion-mensaje" style="color: #555; font-size: 14px; line-height: 1.5; margin-bottom: 25px;">
                            Se procesarán y guardarán los comprobantes de pago.
                        </p>
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="button" id="btn-modal-confirmacion-cancelar" class="btn btn-default" style="height: 40px; flex: 1; border-radius: 20px; font-weight: 600; font-size: 14px; border: 1px solid #ddd; background: #fff; color: #555; transition: all 0.2s; margin-top: 0;">
                                Cancelar
                            </button>
                            <button type="button" id="btn-modal-confirmacion-aceptar" class="btn btn-primary" style="height: 40px; flex: 1; border-radius: 20px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(30, 136, 229, 0.3); border: none; background: #1e88e5; color: #fff; transition: all 0.2s; margin-top: 0; margin-left: 0;">
                                Confirmar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Advertencia Premium -->
        <div class="modal fade" id="modal-advertencia-premium" tabindex="-1" role="dialog" aria-labelledby="modalAdvertenciaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 10000;">
            <div class="modal-dialog modal-sm" role="document" style="margin-top: 15vh; max-width: 400px;">
                <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); overflow: hidden;">
                    <div class="modal-body text-center" style="padding: 35px 25px;">
                        <!-- Icono de advertencia corporativo -->
                        <div style="width: 70px; height: 70px; background: #fffde7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; border: 1px solid #fff59d;">
                            <span class="mdi mdi-alert-triangle" style="font-size: 40px; color: #fbc02d; line-height: 1;"></span>
                        </div>
                        
                        <h4 class="modal-title" id="modalAdvertenciaLabel" style="font-weight: 700; color: #1d3a6d; font-size: 20px; margin-bottom: 10px;">¡Advertencia!</h4>
                        
                        <p id="modal-advertencia-mensaje" style="color: #555; font-size: 14px; line-height: 1.5; margin-bottom: 25px;">
                            Seleccione Archivo XML a Importar.
                        </p>
                        
                        <button type="button" id="btn-modal-advertencia-aceptar" class="btn btn-warning" style="height: 40px; width: 100%; border-radius: 20px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(251, 192, 45, 0.3); border: none; background: #fbc02d; color: #fff; transition: all 0.2s;">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/general.js') }}" type="text/javascript"></script>
    
    <script src="{{ asset('public/js/comprobante/comisionmasivo_v2.js?v='.$version) }}" type="text/javascript"></script>
@stop
