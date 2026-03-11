@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/mergeantigravity.css?v='.$version) }} " />
    <style>
        .review-label { font-weight: bold; color: #4a5568; text-transform: uppercase; font-size: 11px; margin-bottom: 2px; }
        .review-value { color: #2d3748; font-size: 14px; margin-bottom: 15px; border-bottom: 1px solid #edf2f7; padding-bottom: 5px; min-height: 25px; }
        .section-header { background: #f8fafc; padding: 10px 15px; border-left: 4px solid #3498db; margin-bottom: 20px; font-weight: bold; color: #2c3e50; font-size: 13px; }
        .amount-highlight { font-weight: bold; color: #2b6cb0; font-size: 16px; }
        .table-detalles thead th { background: #f1f5f9; color: #475569; font-size: 11px; text-transform: uppercase; }
    </style>
@stop
@section('section')
<div class="be-content">
  <div class="main-content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary modern-panel">
          <div class="panel-heading panel-heading-divider">
            <div class="title-container">
                <span class="main-title">REVISAR CONTRATO ACOPIO</span>
                <span class="panel-subtitle">Visualización detallada del contrato de acopio seleccionado</span>
            </div>
            <div class="header-actions">
                <span class="badge badge-primary">{{$contrato->TXT_ESTADO}}</span>
            </div>
          </div>
          <div class="panel-body">
            
            <div class="section-header"><i class="bi bi-info-square"></i> INFORMACIÓN GENERAL</div>
            <div class="row">
                <div class="col-md-3">
                    <div class="review-label">ID Documento</div>
                    <div class="review-value">{{$contrato->ID_DOCUMENTO}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Nro Contrato</div>
                    <div class="review-value">{{$contrato->NRO_CONTRATO}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Fecha Contrato</div>
                    <div class="review-value">{{date_format(date_create($contrato->FECHA_CONTRATO), 'd/m/Y')}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Empresa</div>
                    <div class="review-value">{{$contrato->TXT_EMPRESA}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="review-label">Centro / Sede</div>
                    <div class="review-value">{{$contrato->TXT_CENTRO}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Proveedor</div>
                    <div class="review-value">{{$contrato->TXT_PROVEEDOR}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Cuenta</div>
                    <div class="review-value">{{$contrato->TXT_CUENTA}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Sub Cuenta</div>
                    <div class="review-value">{{$contrato->TXT_SUB_CUENTA}}</div>
                </div>
            </div>

            <div class="section-header"><i class="bi bi-geo"></i> DATOS TÉCNICOS Y PRODUCCIÓN</div>
            <div class="row">
                <div class="col-md-3">
                    <div class="review-label">Variedad</div>
                    <div class="review-value">{{$contrato->TXT_VARIEDAD}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Fecha Cosecha</div>
                    <div class="review-value">{{date_format(date_create($contrato->FECHA_COSECHA), 'd/m/Y')}}</div>
                </div>
                <div class="col-md-2">
                    <div class="review-label">Hectáreas</div>
                    <div class="review-value">{{number_format($contrato->HECTAREAS, 2, '.', ',')}}</div>
                </div>
                <div class="col-md-2">
                    <div class="review-label">Total KG</div>
                    <div class="review-value">{{number_format($contrato->TOTAL_KG, 2, '.', ',')}}</div>
                </div>
                <div class="col-md-2">
                    <div class="review-label">Precio Ref.</div>
                    <div class="review-value">{{number_format($contrato->PRECIO_REFERENCIA, 4, '.', ',')}}</div>
                </div>
            </div>

            <div class="section-header"><i class="bi bi-cash-stack"></i> PROYECCIÓN FINANCIERA</div>
            <div class="row">
                <div class="col-md-3">
                    <div class="review-label">Proyección Total</div>
                    <div class="review-value amount-highlight">{{number_format($contrato->PROYECCION, 2, '.', ',')}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Importe a Habilitar</div>
                    <div class="review-value amount-highlight text-primary-dark">{{number_format($contrato->IMPORTE_HABILITAR, 2, '.', ',')}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Usuario Aprueba</div>
                    <div class="review-value">{{$contrato->TXT_USUARIO_CON_APRUEBA ?: 'PENDIENTE'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="review-label">Estado</div>
                    <div class="review-value">{{$contrato->TXT_ESTADO}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="review-label">Observación / Glosa</div>
                    <div class="review-value">{{$contrato->GLOSA ?: 'SIN OBSERVACIONES'}}</div>
                </div>
            </div>

            <div class="section-header"><i class="bi bi-list-check"></i> DETALLE DE ANTICIPOS (PROYECCIÓN)</div>
            <div class="table-container" style="margin-bottom: 30px;">
                <table class="table table-bordered table-striped table-hover table-detalles">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>FECHA ENTREGA</th>
                            <th>TERCERO / BENEFICIARIO</th>
                            <th class="text-right">IMPORTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detalles as $index => $detalle)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{date_format(date_create($detalle->FECHA), 'd/m/Y')}}</td>
                            <td>{{$detalle->TXT_PROVEEDOR}}</td>
                            <td class="text-right"><b>{{number_format($detalle->IMPORTE, 2, '.', ',')}}</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">TOTAL DETALLE:</th>
                            <th class="text-right text-primary-dark">{{number_format($detalles->sum('IMPORTE'), 2, '.', ',')}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if(count($archivos) > 0)
            <div class="section-header"><i class="bi bi-file-earmark-arrow-up"></i> ARCHIVOS ADJUNTOS</div>
            <div class="row">
                @foreach($archivos as $archivo)
                <div class="col-md-4">
                    <div class="file-box" style="padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                            <i class="bi bi-file-earmark-text"></i> {{$archivo->NOMBRE_ARCHIVO}}
                        </span>
                        <a href="{{ url('/descargar-archivo/'.$archivo->NOMBRE_ARCHIVO) }}" class="btn btn-xs btn-primary">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="form-footer" style="padding-top: 20px; border-top: 1px solid #edf2f7; margin-top: 20px;">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <a href="{{ url('/gestion-de-contrato-acopio/'.$idopcion) }}" class="btn btn-space btn-default btn-xl">
                            <i class="bi bi-arrow-left"></i> Regresar
                        </a>
                        <!-- Aquí se pueden agregar acciones de aprobación si el usuario tiene el permiso -->
                    </div>
                </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('script')
    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        App.init();
      });
    </script>
@stop
