<div class="form-group">
    <label class="col-sm-12 control-label labelleft negrita">PRODUCTO :</label>
    <div class="col-sm-12 abajocaja">
        {!! Form::select( 'producto', $combo_producto, $producto_defecto,
                          [
                            'class'       => 'select2 select5 form-control control input-xs' ,
                            'id'          => 'producto',
                            'data-aw'     => '6'
                          ]) !!}
    </div>
</div>

@if(isset($ajax))
    <script type="text/javascript">
        $(".select5").select2(); //reasignacion de estilos de clase
        $(".select2").select2({
            width: '100%'
        });
    </script>
@endif
