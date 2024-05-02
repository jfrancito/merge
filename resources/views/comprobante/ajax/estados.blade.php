<td>
  @if($item->COD_ESTADO_FE == 'ETM0000000000001') 
      <span class="badge badge-default">{{$item->TXT_ESTADO}}</span> 
  @else
    @if(is_null($item->COD_ESTADO_FE)) 
        <span class="badge badge-default">GENERADO</span>
    @else
      @if($item->COD_ESTADO_FE == 'ETM0000000000002') 
          <span class="badge badge-warning">{{$item->TXT_ESTADO}}</span>
      @else
        @if($item->COD_ESTADO_FE == 'ETM0000000000003') 
            <span class="badge badge-warning">{{$item->TXT_ESTADO}}</span>
        @else
          @if($item->COD_ESTADO_FE == 'ETM0000000000004') 
              <span class="badge badge-warning">{{$item->TXT_ESTADO}}</span>
          @else
            @if($item->COD_ESTADO_FE == 'ETM0000000000005') 
                <span class="badge badge-success">{{$item->TXT_ESTADO}}</span>
            @else
              @if($item->COD_ESTADO_FE == 'ETM0000000000006') 
                  <span class="badge badge-success">{{$item->TXT_ESTADO}}</span>
              @else
                  <span class="badge badge-default">{{$item->TXT_ESTADO}}</span>
              @endif
            @endif
          @endif
        @endif
      @endif
    @endif
  @endif
</td>