<div class="form-group">
    <label class="col-sm-12 control-label labelleft negrita">FAMILIA :</label>
    <div class="col-sm-12 abajocaja">
        {!! Form::select( 'familia', $combo_familia, $familia_defecto,
                          [
                            'class'       => 'select3 form-control control input-xs' ,
                            'id'          => 'familia',
                            'data-aw'     => '4'
                          ]) !!}
    </div>
</div>

@if(isset($ajax))
    <script type="text/javascript">
        $(".select3").select2(); //reasignacion de estilos de clase
    </script>
@endif
