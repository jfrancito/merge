<div class="form-group">
    <label class="col-sm-12 control-label labelleft negrita">Periodo
        :</label>
    <div class="col-sm-12 abajocaja">
        {!! Form::select( 'periodo_asiento_reparable', $array_periodo, $defecto_periodo,
                          [
                            'class'       => 'slim' ,
                            'id'          => 'periodo_asiento_reparable',
                            'data-aw'     => '2',
                          ]) !!}
    </div>
</div>


@if(isset($ajax))
    <script>
        window.selects['periodo_asiento_reparable'] = new SlimSelect({
            select: '#periodo_asiento_reparable'
        })
    </script>
@endif
