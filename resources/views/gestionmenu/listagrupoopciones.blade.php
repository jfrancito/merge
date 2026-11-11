@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/buttons.dataTables.min.css') }} "/>
@stop
@section('section')
	<div class="be-content">
		<div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-border-color panel-border-color-success">
                <div class="panel-heading">Lista de Grupo Opciones
                  <div class="tools">
                    <a href="{{ url('/agregar-grupo-opcion/'.$idopcion) }}" data-toggle="tooltip" data-placement="top" title="Crear Grupo Opcion">
                      <span class="icon mdi mdi-plus-circle-o"></span>
                    </a>
                  </div>
                </div>

                <div class="panel-body">
                  <table id="table1" class="table table-striped table-hover table-fw-widget">

                    <thead>
                      <tr>
                        <th>Orden</th>
                        <th>Nombre</th>
                        <th>Icono</th>
                        <th>Activo</th>
                        <th>Opción</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($listadatos as $item)

                        <tr>

                          <td>{{$item->orden}}</td>
                          <td>{{$item->nombre}}</td>

                          <td>
                            <div class="icon-container sincontornoniespacio" >
                              <div class="icon">
                                <span class="mdi {{$item->icono}}"></span>   
                              </div>
                            </div>
                          </td>


                          <td> 

                            @if($item->activo == 1)  

                              <span class="icon mdi mdi-check"></span> 

                            @else 

                              <span class="icon mdi mdi-close"></span> 

                            @endif

                          </td>

                          <td class="rigth">

                            <div class="btn-group btn-hspace">

                              <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>

                              <ul role="menu" class="dropdown-menu pull-right">

                                <li>

                                  <a href="{{ url('/modificar-grupo-opcion/'.$idopcion.'/'.Hashids::encode(substr($item->id,-8))) }}">

                                    Modificar

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

@stop

@section('script')

	<script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      //initialize the javascript
      App.init();
      App.dataTables();
      $('[data-toggle="tooltip"]').tooltip(); 
    });
  </script> 
@stop