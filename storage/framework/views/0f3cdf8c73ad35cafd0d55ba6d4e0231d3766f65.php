<div class="form-field">
    <label class="form-label">CUENTA <span class="text-danger">(*)</span></label>
    <?php echo Form::select('cuenta_id', $combo_cuenta, array($cuenta_id), ['class' => 'select2 form-control', 'id' => 'cuenta_id', 'required' => '']); ?>

</div>

<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
        $(".cuenta_id").select2({
            width: '100%'
        });
    });
  </script>
<?php endif; ?>


