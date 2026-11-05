<div class="col-md-3">
    <label>Periodo</label>
    {!! Form::select('mes_pedido', $combo_mes, $mes_pedido,
        ['class'=>'select2 select3 form-control','id'=>'mes_pedido']) !!}
</div>

<script type="text/javascript">
    $(".select3").select2({
        width: '100%'
    });
</script>
