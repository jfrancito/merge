<table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th class="ocultar">ID</th>
      <th>PLANILLA MOVILIDAD</th> 
    </tr>
  </thead>
  <tbody>
    @foreach($planillamovilidad as $index=>$item)
      <tr>
        <td class="ocultar">
          {{$index+1}}
        </td>

        <td class="cell-detail" style="position: relative;">
          <span style="display: block;"><b>DOCUMENTO : </b> {{$item->SERIE}} - {{$item->NUMERO}}</span>
          <span style="display: block;"><b>TOTAL : </b> {{$item->TOTAL}}</span>
          <span style="display: block;"><b>FECHA EMISION : {{date_format(date_create($item->FECHA_EMI), 'd/m/Y')}}</b></span>
          <span style="display: block;"><b>FECHA CREACION : {{date_format(date_create($item->FECHA_CREA), 'd/m/Y')}}</b></span>
          <span style="display: block;"><b>PERIODO : </b> {{$item->TXT_PERIODO}}</span>
          <span style="display: block;"><b>TRABAJADOR : </b> {{$item->TXT_TRABAJADOR}}</span>
          <span style="display: block;"><b>CENTRO : </b> {{$item->TXT_CENTRO}}</span>
          <span><b>ESTADO : </b> @include('planillamovilidad.ajax.estados')</span>

          <a href="{{ url('/modificar-planilla-movilidad/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" 
            style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm">MODIFICAR</a>

          @if($item->COD_ESTADO != 'ETM0000000000001')
            <a href="{{ url('/pdf-planilla-movilidad/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" 
              style="color:#cb2027;font-size: 35px;position: absolute; top: 10px;right: 20px;"
             target="_blank"><i class="mdi mdi-collection-pdf"></i>
            </a>
          @endif

          @if($item->COD_ESTADO == 'ETM0000000000001')
            <form method="POST" id='forextornar' action="{{ url('/extonar-planilla-movilidad-masivo/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}
                  <button type= 'button' style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-danger btn-sm btn-extonar-pm">EXTORNAR</button>
            </form>
          @endif


        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif
