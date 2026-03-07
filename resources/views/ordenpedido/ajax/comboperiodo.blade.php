<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
    <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">Periodo Inicio :</label>
        <div class="col-sm-12 abajocaja">
            {!! Form::select( 'periodo', $combo_periodo, '',
                              [
                                'class'       => 'select2 select3 form-control control input-xs' ,
                                'id'          => 'periodo',
                                'data-aw'     => '3',
                              ]) !!}
        </div>
    </div>
</div>
@if(isset($ajax))
    <script type="text/javascript">
        $(".select3").select2({
            width: '100%'
        });
    </script>
@endif
