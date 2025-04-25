
  @if($item->COD_ESTADO == 'ETM0000000000001') 
      <span class="badge badge-default" style="display: inline-block;">{{$item->TXT_ESTADO}}</span> 
  @else
    @if(is_null($item->COD_ESTADO)) 
        <span class="badge badge-default" style="display: inline-block;">GENERADO</span>
    @else
      @if($item->COD_ESTADO == 'ETM0000000000002') 
          <span class="badge badge-warning" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
      @else
        @if($item->COD_ESTADO == 'ETM0000000000003') 
            <span class="badge badge-warning" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
        @else
          @if($item->COD_ESTADO == 'ETM0000000000004') 
              <span class="badge badge-warning" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
          @else
            @if($item->COD_ESTADO == 'ETM0000000000005') 
                <span class="badge badge-primary" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
            @else
              @if($item->COD_ESTADO == 'ETM0000000000006') 
                  <span class="badge badge-danger" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
              @else
                @if($item->COD_ESTADO == 'ETM0000000000007') 
                    <span class="badge badge-warning" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
                @else
                  @if($item->COD_ESTADO == 'ETM0000000000008') 
                      <span class="badge badge-success" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
                  @else
                    @if($item->COD_ESTADO == 'ETM0000000000009') 
                        <span class="badge badge-warning" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
                    @else
                        <span class="badge badge-warning" style="display: inline-block;">{{$item->TXT_ESTADO}}</span>
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