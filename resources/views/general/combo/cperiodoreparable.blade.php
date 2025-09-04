<div class="form-group">
    <label class="col-sm-12 control-label labelleft negrita">Periodo
        :</label>
    <div class="col-sm-12 abajocaja">
        {!! Form::select( 'periodo_asiento_reparable', $array_periodo, $defecto_periodo,
                          [
                            'class'       => 'select3 form-control control input-sm' ,
                            'id'          => 'periodo_asiento_reparable',
                            'data-aw'     => '2',
                          ]) !!}
    </div>
</div>


@if(isset($ajax))
    <script type="text/javascript">
        $(".select3").select2(); //reasignacion de estilos de clase
        $(".select2").select2({
            width: '100%'
        });
    </script>
@endif
