@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')
    <div class="be-content valerendirprincipal">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">Lista Vale a Rendir - Aprueba
                        </div>
                            <div class='filtrotabla row'>
                                  
                                @include('valerendir.ajax.listamodalvalerendiraprueba')
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="text" id="vale_rendir_id" hidden>
         @include('valerendir.modal.detallerendir')
    </div>

      <div class="modal fade" id="rechazoModal" tabindex="-1" role="dialog" aria-labelledby="rechazoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0 rounded-3" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px;">
                    <div class="modal-header py-2" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        <h5 class="modal-title d-flex align-items-center" id="rechazoModalLabel" style="font-size: 1.4rem;">
                            <i class="mdi mdi-close-circle-outline mr-2"></i> Motivo de Rechazo
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; font-size: 1.5rem;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-2 px-3">
                        <div class="form-group mb-2">
                            <label for="motivoRechazo" class="font-weight-bold text-dark" style="font-size: 1.4rem;">¿Por qué rechazar?</label>
                            <textarea id="motivoRechazo" class="form-control shadow-sm p-2" rows="4" placeholder="Ingrese el motivo de rechazo..." 
                                style="border-radius: 8px; font-size: 1.2rem; background-color: #fff; border: 1px solid #ccc;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer py-2 d-flex border-0 justify-content-between">
                        <button type="button" class="btn btn-light shadow-sm" data-dismiss="modal" 
                                style="border-radius: 20px; padding: 6px 15px; font-weight: 600; font-size: 1.1rem; border: 1px solid #ddd;">
                                Cerrar
                        </button>
                        <button type="button" class="btn btn-danger shadow-sm" id="confirmRechazo" 
                                style="border-radius: 20px; padding: 6px 15px; font-weight: 600; font-size: 1.1rem; background-color: #dc3545; border-color: #c82333;">
                                <i class="mdi mdi-close"></i> Rechazar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    
    <div class="modal fade" id="glosaModal" tabindex="-1" role="dialog" aria-labelledby="glosaModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn" style="background-color: #007bff; color: white;" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="autorizaModal" tabindex="-1" role="dialog" aria-labelledby="autorizaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg border-0 rounded-3" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px;">
                <div class="modal-header py-2" style="background: linear-gradient(135deg, #28a745, #218838); color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title d-flex align-items-center" id="autorizaModalLabel" style="font-size: 1.4rem;">
                        <i class="mdi mdi-check-circle-outline mr-2"></i> Motivo de Autorización
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; font-size: 1.5rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-2 px-3">
                    <div class="form-group mb-2">
                        <label for="motivoAutoriza" class="font-weight-bold text-dark" style="font-size: 1.4rem;">¿Por qué autorizar?</label>
                        <textarea id="motivoAutoriza" class="form-control shadow-sm p-2" rows="4" placeholder="Escribe el motivo de autorización aquí..." 
                            style="border-radius: 8px; font-size: 1.2rem; background-color: #fff; border: 1px solid #ccc;"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2 d-flex border-0 justify-content-between">
                    <button type="button" class="btn btn-light shadow-sm" data-dismiss="modal" 
                            style="border-radius: 20px; padding: 6px 15px; font-weight: 600; font-size: 1.1rem; border: 1px solid #ddd;">
                            Cerrar
                    </button>
                    <button type="button" class="btn btn-success shadow-sm" id="confirmAutoriza" 
                            style="border-radius: 20px; padding: 6px 15px; font-weight: 600; font-size: 1.1rem; background-color: #28a745; border-color: #218838;">
                            <i class="mdi mdi-check-all"></i> Autorizar
                    </button>
                </div>
            </div>
        </div>
    </div>


    


    <div class="modal fade" id="glosaModal1" tabindex="-1" role="dialog" aria-labelledby="glosaModalLabel1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0 rounded-3" 
             style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px; font-family: 'Times New Roman', Times, serif;">
          
          <div class="modal-header py-2" 
               style="background: linear-gradient(135deg, #28a745, #218838); color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h5 class="modal-title d-flex align-items-center" id="glosaModalLabel1" style="font-size: 1.9rem;">
              <i class="mdi mdi-check-circle-outline mr-2"></i> Motivo de Autorización 
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" 
                    style="opacity: 0.8; font-size: 1.5rem;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body pb-2 px-3">
            <div class="alert shadow-sm p-3 mb-0" 
                 style="background-color: #ffffff; color: #155724; border-left: 4px solid #28a745; border-radius: 8px;">
              <strong class="d-block mb-2">Motivo:</strong>
              <p id="glosaAutorizaMessage" class="mb-0" 
                 style="white-space: normal; font-size: 1.1rem;"></p>
            </div>
          </div>
          
          <div class="modal-footer py-2 d-flex border-0 justify-content-end">
            <button type="button" class="btn btn-success shadow-sm" data-dismiss="modal"
                    style="border-radius: 20px; padding: 6px 15px; font-weight: 600; font-size: 1.1rem; background-color: #28a745; border-color: #218838;">
              <i class="mdi mdi-check-bold"></i> Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>



    

@stop

@section('script')

    <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

      <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/i18n/es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/raphael/raphael-min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('public/lib//chartjs/Chart.min.js')}}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>


    <script type="text/javascript">

      $.fn.niftyModal('setDefaults',{
        overlaySelector: '.modal-overlay',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show',
      });
      
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        App.formElements();
        $('form').parsley();

        $('.importe').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 4, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});

      });
    </script> 

     <script src="{{ asset('public/js/vale/valerendir.js?v='.$version) }}" type="text/javascript"></script>

@stop



