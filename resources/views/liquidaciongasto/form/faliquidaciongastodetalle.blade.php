<div class="control-group">
  <div class="row">

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">TIPO DOCUMENTO :</label>
          <div class="col-sm-12 abajocaja" >
            {!! Form::select( 'tipodoc_id', $combo_tipodoc, array($tipodoc_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'tipodoc_id',
                                'required'    => ''
                              ]) !!}
          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorplanilla ocultar">
      <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">BUSCAR : </label>
          <div class="col-sm-12 abajocaja" >
              <button type="button" data-dismiss="modal" class="btn btn-success btn-buscar-planilla"
              data_iddocumento="{{$liquidaciongastos->ID_DOCUMENTO}}"
              >BUSCAR PLANILLA</button>
              <input type="text" name="cod_planila" id ='cod_planila'>
          </div>
        </div>
    </div>


  </div>

  <div class="row" style="margin-top:10px;">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">SERIE :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="serie" name='serie' 
                    value="@if(count($tdetliquidacionitem)>0){{old('serie' ,$tdetliquidacionitem->SERIE)}}@else{{old('serie')}}@endif"                         
                    placeholder="SERIE"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>

        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">NUMERO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="numero" name='numero' 
                    value="@if(count($tdetliquidacionitem)>0){{old('numero' ,$tdetliquidacionitem->NUMERO)}}@else{{old('numero')}}@endif"                         
                    placeholder="NUMERO"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>


        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">FECHA EMISION :</label>
        <div class="col-sm-12">
            <div data-min-view="2" 
                   data-date-format="dd-mm-yyyy"  
                   class="input-group date datetimepicker pickerfecha pickerfechadet" style = 'padding: 0px 0;margin-top: -3px;'>
                   <input size="16" type="text" 
                          placeholder="FECHA DE EMISION"
                          id='fecha_emision' 
                          name='fecha_emision' 
                          required = ""
                          value="@if(count($tdetliquidacionitem)>0){{old('fecha_emision' ,$tdetliquidacionitem->FECHA_EMISION)}}@else{{old('fecha_emision')}}@endif" 
                          class="form-control input-sm"/>
                    <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
              </div>

        </div>
      </div>
    </div>
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">TOTAL :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="totaldetalle" name='totaldetalle' 
                    value="@if(count($tdetliquidacionitem)>0){{old('totaldetalle' ,$tdetliquidacionitem->TOTAL)}}@else{{old('totaldetalle')}}@endif"                     
                    placeholder="TOTAL"
                    readonly = "readonly"
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>


  </div>
  <div class="row" style="margin-top:10px;">

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">EMPRESA :</label>
          <div class="col-sm-12 abajocaja" >
              {!! Form::select( 'empresa_id', $combo_empresa, array($empresa_id),
                                [
                                  'class'       => 'select2 form-control control ' ,
                                  'id'          => 'empresa_id',
                                  'required'    => ''
                                ]) !!}
          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_cuenta">
        @include('general.ajax.combocuenta')
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_subcuenta">
        @include('general.ajax.combosubcuenta')
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">GLOSA :</label>
          <div class="col-sm-12">
              <textarea 
              name="glosadet"
              id = "glosadet"
              class="form-control input-sm validarmayusculas"
              rows="2">@if(count($tdetliquidacionitem)>0){{old('glosadet' ,$tdetliquidacionitem->TXT_GLOSA)}}@else{{old('glosadet')}}@endif</textarea>
          </div>
      </div>
    </div>


  </div>
  <div class="row" style="margin-top:10px;">
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">FLUJO :</label>
          <div class="col-sm-12 abajocaja" >
            {!! Form::select( 'flujo_id', $combo_flujo, array($flujo_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'flujo_id',
                                'required'    => '',
                              ]) !!}
          </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_item">
        @include('general.ajax.comboitem')
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">GASTO :</label>
          <div class="col-sm-12 abajocaja" >
            {!! Form::select( 'gasto_id', $combo_gasto, array($gasto_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'gasto_id',
                                'required'    => '',
                              ]) !!}
          </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">COSTO :</label>
          <div class="col-sm-12 abajocaja" >
            {!! Form::select( 'costo_id', $combo_costo, array($costo_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'costo_id',
                                'required'    => '',
                              ]) !!}
          </div>
        </div>
    </div>
  </div>

  <br>
  @if(count($tdetliquidacionitem)>0)

    @if(rtrim(ltrim($tdetliquidacionitem->COD_PLA_MOVILIDAD))=='')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;margin-top: 13px;margin-bottom: 13px;">
      <button 
            type="button" 
            data-dismiss="modal" 
            class="btn btn-success btn-agregar-detalle-factura"
            data_iddocumento="{{$tdetliquidacionitem->ID_DOCUMENTO}}"
            data_item="{{$tdetliquidacionitem->ITEM}}"
      >AGREGAR DETALLE</button>
    </div>
    @endif

  @else
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;margin-top: 13px;margin-bottom: 13px;">
      <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-detalle-factura">GUARDAR PARA AGREGAR DETALLE</button>
    </div>
  @endif



  <table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
    <thead>
      <tr>
        <th>DETALLE DEL DOCUMENTO</th> 
      </tr>
    </thead>
    <tbody>
      @foreach($tdetdocliquidacionitem as $index=>$item)
        <tr>
          <td class="cell-detail" style="position: relative;">
            <span style="display: block;"><b>COD_PRODUCTO : </b> {{$item->COD_PRODUCTO}}</span>
            <span style="display: block;"><b>PRODUCTO : </b> {{$item->TXT_PRODUCTO}}</span>
            <span style="display: block;"><b>CANTIDAD : </b> {{$item->CANTIDAD}}</span>
            <span style="display: block;"><b>PRECIO : </b> {{$item->PRECIO}}</span>
            <span style="display: block;"><b>IGV : </b> @if($item->IND_IGV==1) SI @else NO @endif</span>
            <span style="display: block;"><b>SUBTOTAL : </b> {{$item->SUBTOTAL}}</span>
            <span style="display: block;"><b>IGV : </b> {{$item->IGV}}</span>

            <span style="display: block;"><b>TOTAL : </b> {{$item->TOTAL}}</span>

            @if(rtrim(ltrim($tdetliquidacionitem->COD_PLA_MOVILIDAD))=='')
              <button type="button" data_iddocumento = "{{$item->ID_DOCUMENTO}}" data_item = "{{$item->ITEM}}" data_item_documento = "{{$item->ITEMDOCUMENTO}}" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm modificardetalledocumentolg">MODIFICAR</button>
            @endif

          </td>
        </tr>                    
      @endforeach
    </tbody>
  </table>


@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif









</div>



