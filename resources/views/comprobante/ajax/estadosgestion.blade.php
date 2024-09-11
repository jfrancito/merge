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
                <span class="badge badge-primary">{{$item->TXT_ESTADO}}</span>
            @else
              @if($item->COD_ESTADO_FE == 'ETM0000000000006') 
                  <span class="badge badge-danger">{{$item->TXT_ESTADO}}</span>
              @else
                @if($item->COD_ESTADO_FE == 'ETM0000000000007') 
                    <span class="badge badge-warning">{{$item->TXT_ESTADO}}</span>
                @else
                  @if($item->COD_ESTADO_FE == 'ETM0000000000008') 
                      <span class="badge badge-success">{{$item->TXT_ESTADO}}</span>
                  @else
                    @if($item->COD_ESTADO_FE == 'ETM0000000000009') 
                        <span class="badge badge-warning">{{$item->TXT_ESTADO}}</span>
                    @else
                        <span class="badge badge-default">{{$item->TXT_ESTADO}}</span>
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
  <br>
  <span><b>ORSERVACION : </b>               
      @if($item->ind_observacion == 1) 
          <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
      @else
        @if($item->ind_observacion == 0) 
            <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
        @else
            <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
        @endif
      @endif
  </span>
  <br>
  <span><b>REPARABLE : </b>               
      @if($item->IND_REPARABLE == 1) 
          <span class="badge badge-warning" style="display: inline-block;">EN PROCESO</span>
      @else
        @if($item->IND_REPARABLE == 0) 
            <span class="badge badge-default" style="display: inline-block;">SIN REPARABLE</span>
        @else
            <span class="badge badge-default" style="display: inline-block;">SIN REPARABLE</span>
        @endif
      @endif
  </span>
</td>