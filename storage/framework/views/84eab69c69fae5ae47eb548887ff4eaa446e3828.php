<label class="col-sm-12 control-label labelleft negrita" >PROVINCIA PARTIDA<span class="obligatorio">(*)</span> :</label>
<div class="col-sm-12">
  <?php echo Form::select( 'provinciapartida_id', $comboprovincia, $provincia_id,
                  [
                    'class'       => 'form-control control input-xs' ,
                    'id'          => 'provinciapartida_id',        
                  ]); ?>

</div>


<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    
    $("#provinciapartida_id").select2({
      width: '100%'
    });
  </script> 
<?php endif; ?>