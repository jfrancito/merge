@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/confirm/jquery-confirm.min.css') }} "/>

@stop
@section('section')
<div class="be-content planillamovilidad">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">PLANILLA DE MOVILIDAD 
            <div class="tools tooltiptop">
              <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones agregardetalle"
                data_planilla_movilidad_id = '{{$planillamovilidad->ID_DOCUMENTO}}'>
                <span class="tooltiptext">Agregar Detalle</span>
                <span class="icon mdi mdi-plus-circle-o"></span>              
              </a>
            </div>
            <span class="panel-subtitle">Crear un nueva nueva planilla de movilidad</span>
            <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>
          </div>
          <div class="panel-body">

            <form method="POST" action="{{ url('/agregar-planilla-movilidad/'.$idopcion) }}" style="border-radius: 0px;" id ='frmpmemitir'>
                  {{ csrf_field() }}
                <div class='formconsulta'>
                  @include('planillamovilidad.form.faplanillamovilidad')
                </div>
                <div class='detallemovilidad' style="margin-top:15px;">
                  @include('planillamovilidad.ajax.amdetalleplanillamovilidad')
                </div>

                <div class="row xs-pt-15">
                  <div class="col-xs-6">
                      <div class="be-checkbox">
                      </div>
                  </div>
                  <div class="col-xs-6">
                    <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary btnemitirplanillamovilidad">Emitir Planilla de Movilidad</button>     
                    </p>
                  </div>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
  @include('planillamovilidad.modal.mregistrorequerimiento')
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
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/confirm/jquery-confirm.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">


      $.fn.niftyModal('setDefaults',{
        overlaySelector: '.modal-overlay',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show',
      });

      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();


        $('.importe').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});


        
      });
    </script> 

    <script src="{{ asset('public/js/comprobante/planilla.js?v='.$version) }}" type="text/javascript"></script>

@stop