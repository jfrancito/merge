<div class="form-group">
    <label class="col-sm-12 control-label labelleft negrita">Periodo
        :</label>
    <div class="col-sm-12 abajocaja">
        {!! Form::select( 'periodo_asiento', $array_periodo, $defecto_periodo,
                          [
                            'class'       => 'slim' ,
                            'id'          => 'periodo_asiento',
                            'data-aw'     => '2',
                          ]) !!}
    </div>
</div>


@if(isset($ajax))
    <script>
        new SlimSelect({
            select: '#periodo_asiento'
        })
    </script>
@endif
