@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@stop
@section('section')

    <div class="be-content valerendirprincipal">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">Solicitud de Vale 
                        </div>
                        <div class="panel-body selectfiltro">


                            <div class='filtrotabla row'>
                                <div class="col-xs-12">

                                    <input type="hidden" id="vale_rendir_id" value=""/>

                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Autoriza
                                                :</label>
                                            <div class="col-sm-12 abajocaja">
                                                {!! Form::select('cliente_select', $listausuarios, $usuario_autoriza_predeterminado,
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'cliente_select',
                                                     'data-aw'     => '1',
                                                     'disabled'    => 'disabled', 
                                                   ])
                                                !!}
                                            </div>
                                        </div>
                                    </div>

                                {{--    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Aprueba :</label>
                                            <div class="col-sm-12 abajocaja">

                                                {!! Form::select('cliente_select1', $listausuarios1, $usuario_aprueba_predeterminado,
                                                   [
                                                     'class'       => 'form-control control select2',
                                                     'id'          => 'cliente_select1',
                                                     'data-aw'     => '1',
                                                     'disabled'    => 'disabled', 
                                                   ])
                                                !!}

                                            </div>
                                        </div>
                                    </div>  --}}

                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Motivo :</label>
                                            <div class="col-sm-12 abajocaja">

                                                {!! Form::select('tipo_motivo', $listausuarios2, '',
                                                       [
                                                         'class'       => 'form-control control select2' ,
                                                         'id'          => 'tipo_motivo',
                                                         'data-aw'     => '1',
                                                       ])
                                                !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Moneda :</label>
                                            <div class="col-sm-12 abajocaja">

                                                {!! Form::select('cod_moneda', $listausuarios4, '',
                                                       [
                                                         'class'       => 'form-control control select2' ,
                                                         'id'          => 'cod_moneda',
                                                         'data-aw'     => '1',
                                                       ])
                                                !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Importe :</label>
                                            <div class="col-sm-12 input-group xs-mb-15">

                                                <input type="text"
                                                       id="can_total_importe" name='' value="" placeholder="Importe"
                                                       required=""
                                                       autocomplete="off" class="form-control input-md dinero_masivo"
                                                       data-aw="4"/>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Saldo :</label>
                                            <div class="col-sm-12 input-group xs-mb-15">

                                                <input type="text"
                                                       id="can_total_saldo" name='can_total_saldo' value=""
                                                       placeholder="Saldo"
                                                       required=""
                                                       autocomplete="off" class="form-control input-md dinero_masivo"
                                                       data-aw="4"/>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Glosa :</label>
                                            <div class="col-sm-12 input-group xs-mb-15">
                                                <textarea id="txt_glosa" name="" placeholder="Glosa" required=""
                                                          autocomplete="off" class="form-control custom-glosa-height"
                                                          data-aw="4"></textarea>
                                                <span class="input-group-btn">
                                                <button id="asignarvalerendir" type="button" class="btn btn-primary ">
                                                      <font style="vertical-align: inherit;"><font
                                                                  style="vertical-align: inherit;">Guardar</font></font>
                                                    </button>
                                               </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="listadetalleajax"></div>

                                <div class="ajaxvacio text-center fw-bold">
                                    COMPLETE LOS CAMPOS CORRECTAMENTE ...
                                </div>

                                <input type="text" id="vale_rendir_id" hidden>
                                @include('valerendir.modal.detallerendir')

                                <div id="vale_rendir_detalle" style="display: none;">


                                    <div class="panel-heading">Detalle a Rendir</div>

                                    <div class="row"
                                         style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">

                                        <!-- Fecha Inicio -->
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                            <label class="control-label labelleft">Fecha Inicio:</label>
                                            <input type="date"
                                                   id="fecha_inicio"
                                                   name="fecha_inicio"
                                                   class="form-control control"
                                                   data-aw="1">
                                        </div>


                                        <!-- Fecha Fin -->
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                                            <label class="control-label labelleft">Fecha Fin:</label>
                                            <input type="date"
                                                   id="fecha_fin"
                                                   name="fecha_fin"
                                                   class="form-control control"
                                                   data-aw="1">
                                        </div>

                                        <!-- Destino -->
                                        <div class="form-group" style="min-width: 250px;">
                                            <label class="control-label labelleft">Destino:</label>
                                            {!! Form::select('destino', $listausuarios3, '', [
                                                'class'   => 'form-control control select2',
                                                'id'      => 'destino',
                                                'data-aw' => '1',
                                            ]) !!}
                                        </div>

                                        <!-- Movilidad Propia -->
                                        <div class="form-group"
                                             style="display: flex; flex-direction: column; align-items: center;">
                                            <label for="ind_propio" style="font-size: 13px;">Movilidad Propia:</label>
                                            <input type="checkbox" id="ind_propio" name="ind_propio" value="1"
                                                   style="width: 18px; height: 18px;">
                                        </div>

                                        <!-- Movilidad Aérea -->
                                        <div class="form-group"
                                             style="display: flex; flex-direction: column; align-items: center;">
                                            <label for="ind_aereo" style="font-size: 13px;">Pasaje Aéreo:</label>
                                            <input type="checkbox" id="ind_aereo" name="ind_aereo" value="1"
                                                   style="width: 18px; height: 18px;">
                                        </div>

                                        <!-- Botón Agregar -->
                                        <div class="form-group" style="margin-left: 30px;">
                                            <input type="hidden" id="detalle_id" value=""/>
                                            <button id="agregarImporteGasto" type="button"
                                                    class="btn btn-success rounded-circle btn-icon"
                                                    style="width: 30px; height: 30px;" title="Agregar">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>

                                        <!-- Botón Ver Detalle -->
                                        <div class="form-group">
                                            <button type="button"
                                                    class="btn btn-primary verdetalleimportegastos-valerendir"
                                                    title="Ver detalle de importes">
                                                <i class="mdi mdi-eye mdi-24px"></i>
                                            </button>
                                        </div>

                                        <!-- Hidden Inputs -->
                                        <input type="hidden" id="nom_centro" value="{{ $nom_centro }}">
                                        <input type="hidden" id="importeDestinos"
                                               value="{{ json_encode($importeDestinos) }}">
                                    </div>


                                    @include('valerendir.ajax.modalverdetalleimportegastosvalerendir')


                                    <div class="col-xs-12">
                                        <div class='listacontratomasiva listajax reporteajax'>
                                        </div>
                                    </div>
                                    @include('valerendir.ajax.listamodaldetalleregistroimporte')

                                </div>

                                <div class="col-xs-12">
                                    <div class='listacontratomasiva listajax reporteajax'>
                                    </div>
                                </div>
                                <div class='listajax'>
                                    @include('valerendir.ajax.listamodalvalerendir')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="glosaModal" tabindex="-1" role="dialog" aria-labelledby="glosaModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-lg shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #6c757d; color: #fff;">
                    <h5 class="modal-title" id="glosaModalLabel">Motivo de Rechazo</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                    <div class="alert" style="background-color: #d6d8db; color: #212529; word-wrap: break-word;">
                        <strong>Motivo:</strong>
                        <p id="glosaRechazoMessage" class="text-dark" style="white-space: normal;"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #007bff; color: white;"
                            data-dismiss="modal">Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="glosaModal1" tabindex="-1" role="dialog" aria-labelledby="glosaModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-lg shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #6c757d; color: #fff;">
                    <h5 class="modal-title" id="glosaModalLabel1">Motivo de Aprobación</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                    <div class="alert" style="background-color: #d6d8db; color: #212529; word-wrap: break-word;">
                        <strong>Motivo:</strong>
                        <p id="glosaAutorizaMessage" class="text-dark" style="white-space: normal;"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #007bff; color: white;"
                            data-dismiss="modal">Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-glosa-height {
            height: 100px;
        }

        .row-deleted {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }
    </style>

@stop
@section('script')

    <script>
        var importeDestinos = {!! json_encode($importeDestinos, JSON_UNESCAPED_UNICODE) !!};
    </script>

    <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>


    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}"
            type="text/javascript"></script>
    <script type="text/javascript">

        $.fn.niftyModal('setDefaults', {
            overlaySelector: '.modal-overlay',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show',
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#can_total_importe').on('input', function () {
                var importe = $(this).val();
                $('#can_total_saldo').val(importe);
            });

            $('#can_total_saldo').on('input', function () {
                var saldo = $(this).val();
                $('#can_total_importe').val(saldo);
            });
            App.init();
            App.formElements();
            App.dataTables();
            $('[data-toggle="tooltip"]').tooltip();

            $('.dinero').inputmask({
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

            $('.dinero_masivo').inputmask({
                'alias': 'numeric',
                'groupSeparator': '',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

        });
    </script>


    <script src="{{ asset('public/js/vale/valerendir.js?v='.$version) }}" type="text/javascript"></script>
@stop
