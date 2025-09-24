@extends('template_lateral')

@section('style')
    <link rel="stylesheet" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/lib/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }}">
@endsection

@section('section')
<div class="be-content valerendirprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel panel-default panel-border-color panel-border-color-success">
                        <div class="panel-heading">
                            Lista Vale a Rendir - Firma
                        </div>
                    </div>
                    
                    <div class="listajax">
                            @include('valerendir.firma.listamodalfirmaprincipal')
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




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

    <script>
function abrirPdoc(id) {
    fetch(`/valerendir/exportarpdf/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'ok') {
                let win = window.open(data.url, "_blank");

                let check = setInterval(() => {
                    if (win.closed) {
                        clearInterval(check);
                        verificarFirma(id);
                    }
                }, 1000);
            }
        })
        .catch(err => console.error(err));
}

function verificarFirma(id) {
    let intentos = 0;
    let intervalo = setInterval(() => {
        fetch(`/valerendir/verificarfirma/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.firmado) {
                    clearInterval(intervalo);
                    location.reload();
                } else if (intentos++ > 10) { 
                    // ❗ Timeout: después de 10 intentos (~10s) recarga igual
                    clearInterval(intervalo);
                    location.reload();
                }
            });
    }, 1000);
}
</script>

<script>
</script>
<script src="{{ asset('public/js/vale/valefirma.js?v='.$version) }}" type="text/javascript"></script>
<script src="https://www.topazsystems.com/software/download/sigweb.js"></script>
@stop

