<h5 class='mensaje'>{{$mensaje}}</h5>
<input type="hidden" name="idactivo" id='idactivo' value = '{{$idactivo}}'>
<div class='inputr'>
  <div class="control-label">Razón Social <span class='requerido'>*</span>:</div>
  <div class="abajocaja">
    <input  type="text"
            id="razonsocial" name='razonsocial' 
            value="@if(isset($empresa)){{old('razonsocial' ,$empresa->NOM_EMPR)}}@else{{old('razonsocial')}}@endif"
            placeholder="Razón Social"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="4" readonly/>

  </div>
</div>
<div class='inputr'>
  <div class="control-label">Local de Establecimiento <span class='requerido'>*</span>:</div>
  <div class="abajocaja">

    <input  type="text"
            id="direccion" name='direccion' 
            value="@if(isset($empresa)){{old('direccion' ,$direccion)}}@else{{old('direccion')}}@endif"
            placeholder="Dirección Fiscal"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="4"/>

  </div>
</div>



<input type="hidden" name="cod_empresa"  value="@if(isset($empresa)){{old('cod_empresa' ,$empresa->COD_EMPR)}}@else{{old('cod_empresa')}}@endif">