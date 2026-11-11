<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>OPERACION</th>
      <th>CODIGO</th>
      <th>DOCUMENTO</th>
      <th>EXTORNO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>USUARIO CREACION</th>
      <th>ESTADO</th>
     {{-- <th>ESTADO FIRMA</th> --}}
      <th>OPCION</th>
    {{--  <th>PDF</th> --}}
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->id}}">

        <td><b>CONTRATO</b></td>
        <td>{{$item->COD_DOCUMENTO_CTBLE}}</td>

        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
        <td>{{$funcion->funciones->estorno_referencia($item->COD_DOCUMENTO_CTBLE)}}</td>
        <td>{{$item->FEC_EMISION}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        <td>{{$item->TXT_EMPR_EMISOR}}</td>
        <td>{{$item->CAN_TOTAL}}</td>
        <td>{{$item->COD_USUARIO_CREA_AUD}}</td>
        @include('comprobante.ajax.estados')
     {{--  <td class="estado-firma"
            id="estado-firma-{{ $item->COD_DOCUMENTO_CTBLE }}"
            data-contrato="{{ $item->COD_DOCUMENTO_CTBLE }}">

            @if($item->ESTADO_FIRMA == 1)
                <span class="badge badge-success">FIRMADO</span>
            @else
                <span class="badge badge-warning">PENDIENTE</span>
            @endif
       </td> --}}

        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                @if(ltrim(rtrim($item->COD_ESTADO)) == '') 
                    <a href="{{ url('/detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($item->COD_DOCUMENTO_CTBLE, -9))) }}">
                      Registro XML
                    </a>
                @else
                  @if(is_null($item->COD_ESTADO)) 
                      <a href="{{ url('/detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($item->COD_DOCUMENTO_CTBLE, -9))) }}">
                        Registro XML
                      </a>
                  @else
                    @if($item->COD_ESTADO != 'ETM0000000000001')
                      @if($item->COD_ESTADO != 'ETM0000000000006')
                        <a href="{{ url('/detalle-comprobante-contrato-validado/'.$idopcion.'/'.substr($item->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($item->COD_DOCUMENTO_CTBLE, -9))) }}">
                          Detalle de Registro
                        </a>
                      @else
                        <a href="{{ url('/detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($item->COD_DOCUMENTO_CTBLE, -9))) }}">
                          Registro XML
                        </a>
                      @endif
                    @else
                        <a href="{{ url('/detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($item->COD_DOCUMENTO_CTBLE, -9))) }}">
                          Registro XML
                        </a>
                    @endif
                  @endif
                @endif
              </li>


              <li>
                <a href="{{ url('/agregar-archivo-uc-contrato/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($item->COD_DOCUMENTO_CTBLE, -9))) }}">
                  Agregar Archivos
                </a>  
              </li>

            </ul>
          </div>
        </td>

     {{--   <td>
                <a href="{{ route('contrato.pdf', $item['COD_DOCUMENTO_CTBLE']) }}" class="btn-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         width="16" height="16" viewBox="0 0 24 24" 
                         fill="white" class="icon">
                        <path d="M6 2a2 2 0 0 0-2 2v16c0 
                                 1.1.9 2 2 2h12a2 2 0 0 
                                 0 2-2V8l-6-6H6zm7 7V3.5L18.5 
                                 9H13z"/>
                        <text x="5" y="20" 
                              font-size="7" 
                              font-weight="bold" 
                              fill="white">PDF</text>
                    </svg>
                    <span>PDF</span>
                </a>
        </td>  --}}


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


<style>
    .btn-pdf {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: bold;
        color: white !important;        
        background-color: #e3342f;      
        border-radius: 20px;
        text-decoration: none !important; 
        transition: 0.2s ease-in-out;
    }

    .btn-pdf .icon {
        flex-shrink: 0;  
    }

    .btn-pdf:hover {
        background-color: #cc1f1a;   
        transform: scale(1.05);
        color: white !important;    
        text-decoration: none !important; 
    }
</style>

<script>
let contratoAbierto = null;

// Detecta qué contrato se abrió
$(document).on("click", ".btn-pdf", function () {

    contratoAbierto = $(this)
        .closest('tr')
        .find('.estado-firma')
        .data('contrato');
});

// Cuando el usuario vuelve del visor PDF
document.addEventListener("visibilitychange", function () {

    if (!document.hidden && contratoAbierto) {

        $.ajax({
            url: "{{ route('verificar.firma.contrato') }}",
            type: "POST",
            data: {
                cod_contrato: contratoAbierto,
                _token: "{{ csrf_token() }}"
            },
            success: function (resp) {

                if (resp.firmado) {
                    $('#estado-firma-' + contratoAbierto).html(
                        '<span class="badge badge-success">FIRMADO</span>'
                    );
                }

                contratoAbierto = null;
            }
        });
    }
});
</script>

