@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
@stop

@section('section')
<div class="be-content">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-border-color panel-border-color-success">
                    <div class="panel-heading">{{ $titulo }}
                      <div class="tools tooltiptop">
                      </div>
                    </div>
                    <hr width="100%" style="border-color: green;">
                    <div class="panel-body">

                        <div class="listadatos">  
                            <form method="POST" action="{{ url('subir-excel-cargar-datos/'.$idopcion) }}" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                               {{ csrf_field() }}
                                <div class="container text-center">
                                    <div class="row justify-content-md-center">                  
                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 " >                  

                                            <div class="panel panel-contrast" style="border-style: solid;border-width: 2px;border-radius: 20px;border-color: green;">
                                                <div class="panel-heading panel-heading-contrast" 
                                                      style ="border-top-right-radius: 20px;border-top-left-radius: 20px;">
                                                    Cargar Datos Institucion y Docente
                                                    <div class="imagenpanel" style="position: absolute; top: 15px; left: 30px;">
                                                        <img src="{{ asset('/public/img/uploadfiles.png') }}" class="img-fluid" width="60px" height="60px">
                                                    </div>
                                                    <span class="panel-subtitle">Formato Excel </span>

                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 negrita">
                                                              <span style="color:#000000;font-size:14px">Decargar Formatos Carga</span>
                                                            </div>

                                                            <div class="col-sm-8" align="left" style="padding-bottom: 20px;">
                                                                <a 
                                                                  href="{{url('/formato-excel-cargar-datos-institucion-docente/'.$idopcion)}}"  
                                                                  title="Descargar Formato Carga" 
                                                                  class="btn btn-secondary botoncabecera btn-lg" 
                                                                  id="btndescargarexcel" 
                                                                  class="btndescargarexcel"
                                                                  data-href="{{url('/formato-excel-cargar-datos-institucion-docente/'.$idopcion)}}"  
                                                                  style="
                                                                  border-style: solid;
                                                                  background-color: #3BCB20;
                                                                  border-color: #23B208;
                                                                  border-width: 2px;
                                                                  "
                                                                  >
                                                                     <span style="color:white;"></span> <i class="icon mdi mdi-download" style="color:white;"></i>
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 negrita">
                                                                <span style="color:#000000;font-size:14px">Archivo Excel</span>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 negrita" align="left">
                                                                <input name="inputdatosexcel" id='inputdatosexcel' class="form-control inputdatosexcel" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                                            </div>
                                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                                                <button  type="submit" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos"><i class="icon icon-left mdi mdi-upload"></i></button>
                                                            </div>
                                                            
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
              
                </div>

            </div>
        </div>
    </div>
</div>


@stop

@section('script')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('public/css/portal/calendario.css?v='.$version) }} "/> --}}

    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/js/file/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/general.js') }}" type="text/javascript"></script>

 
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });

      $('#file-es').fileinput({
            theme: 'fa5',
            language: 'es',
            allowedFileExtensions: ['png'],
      });

    $('#cargardatosliq').on('click', function(event){
        abrircargando();
    });


    </script> 
    


    @stop

