<td>
  @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000001') 
      <span class="badge badge-default">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span> 
  @else
    @if(is_null($item->COD_CATEGORIA_ESTADO_VALE)) 
        <span class="badge badge-default">GENERADO</span>
    @else
      @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000002') 
          <span class="badge badge-warning">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
      @else
        @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000005') 
            <span class="badge badge-warning">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
        @else
          @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000004') 
              <span class="badge badge-warning">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
          @else
            @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000003') 
                <span class="badge badge-primary">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
            @else
              @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000006') 
                  <span class="badge badge-danger">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
              @else
                @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000008') 
                    <span class="badge badge-warning">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
                @else
                  @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000007') 
                      <span class="badge badge-success">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
                  @else
                    @if($item->COD_CATEGORIA_ESTADO_VALE == 'ETM0000000000009') 
                        <span class="badge badge-warning">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
                    @else
                        <span class="badge badge-default">{{$item->TXT_CATEGORIA_ESTADO_VALE}}</span>
                    @endif
                  @endif
                @endif
              @endif
            @endif
          @endif
        @endif
      @endif
    @endif
  @endif

</td>