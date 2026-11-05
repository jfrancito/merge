<div class="form-group">
  <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">ITEM :</label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'item_id', $combo_item, array($item_id),
                      [
                        'class'       => 'select5 form-control control input-sm' ,
                        'id'          => 'item_id',
                        'required' => ''
                      ]) !!}
  </div>
</div>
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
        $(".select5").select2({
            width: '100%'
        });
    });
  </script>
@endif
