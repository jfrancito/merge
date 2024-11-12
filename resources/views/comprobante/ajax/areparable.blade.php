<span><b>REPARABLE : </b>               
    @if($item->IND_REPARABLE == 1) 
        <span class="badge badge-primary" style="display: inline-block;">EN PROCESO</span>
    @else
      @if($item->IND_REPARABLE == 2) 
          <span class="badge badge-warning" style="display: inline-block;">EN REVISION</span>
      @else
        @if($item->IND_REPARABLE == 0) 
            <span class="badge badge-default" style="display: inline-block;">-</span>
        @else
            <span class="badge badge-default" style="display: inline-block;">-</span>
        @endif
      @endif
    @endif
</span>

<span><b>OBSERVADO REPARABLE : </b>               
    @if($item->IND_OBSERVACION_REPARABLE == 1) 
        <span class="badge badge-danger" style="display: inline-block;">OBSERVADO</span>
    @endif
</span>
