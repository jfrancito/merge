<div class="form-group">
  <label class="col-sm-12 control-label labelleft" ><b>Cuenta Bancaria :</b> <strong class='moneda_ajax'></strong></label>
  <div class="col-sm-12 abajocaja" >

  @php
      $atributos = [
          'class' => 'select8 form-control control input-xs',
          'id'    => 'cb_id',
          'data-aw' => '1',
      ];

      if (isset($entidadbanco_id)) {
          $atributos['data_entidadbanco_id'] = $entidadbanco_id;
      }

      if (isset($empresa_cliente_id)) {
          $atributos['data_empresa_cliente_id'] = $empresa_cliente_id;
      }
  @endphp
  {!! Form::select('cb_id', $combocb, $cuentaco_id, $atributos) !!}

  </div>
</div>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
      $('.select8').select2();
    });
  </script>
@endif