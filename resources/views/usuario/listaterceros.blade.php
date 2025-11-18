@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
@stop
@section('section')


	<div class="be-content">
		<div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista de Terceros
                  <div class="tools">
                    <a href="{{ url('/agregar-tercero/'.$idopcion) }}" 
                     class="btn btn-success btn-sm d-flex align-items-center" 
                     data-toggle="tooltip" 
                     data-placement="top" 
                     title="Agregar Usuario">
                     <i class="mdi mdi-plus-circle-outline me-2"></i> Agregar Usuario
                     </a>
                  </div>
                </div>
                <div class="panel-body">
                  <table id="table1" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>Dni</th>
                        <th>Nombre</th>
                        <th>Area</th>
                        <th>Empresa</th>
                        <th>Centro</th>
                        <th>Activo</th>
                        <th>Opción</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($listaterceros as $item)
                        <tr>
                            <td>{{$item->DNI}}</td>
                            <td>{{$item->NOMBRE}}</td>
                            <td>{{$item->TXT_AREA}}</td>
                            <td>{{$item->TXT_EMPRESA}}</td>
                            <td>{{$item->TXT_CENTRO}}</td>

                            <td> 
                              @if($item->ACTIVO == 1)  
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
                                    <a href="{{ url('/modificar-tercero/'.$idopcion.'/'.Hashids::encode($item->DNI)) }}">
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
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script> 
@stop