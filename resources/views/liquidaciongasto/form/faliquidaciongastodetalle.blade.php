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
              <input type="hidden" name="cod_planila" id ='cod_planila'>
              <input type="hidden" name="rutacompleta" id ='rutacompleta'>
              <input type="hidden" name="nombrearchivo" id ='nombrearchivo'>
          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorxml ocultar">
      <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">(01) SUBIR XML : </label>
          <div class="col-sm-12 abajocaja" >
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                    <input name="inputxml" id='inputxml' class="form-control inputxml" type="file" accept="text/xml" />
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                    <button  type="button" style="height:48px;" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos"><i class="icon icon-left mdi mdi-upload"></i> Subir</button>
                </div>
                <input type="hidden" name="ID_DOCUMENTO" id="ID_DOCUMENTO" value="{{$liquidaciongastos->ID_DOCUMENTO}}">
          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorxml ocultar">
      <div class="form-group">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <label><b>(02) BUSCAR SUNAT :</b>  </label>
            <button  type="button" style="height:48px;" class="btn btn-space btn-success btn-md btnsunat"  title="Cargar Datos">BUSCAR SUNAT</button>
          </div>
          <input type="hidden" name="RUTAXML" id="RUTAXML" >
          <input type="hidden" name="RUTAPDF" id="RUTAPDF" >
          <input type="hidden" name="RUTACDR" id="RUTACDR" >

          <input type="hidden" name="NOMBREXML" id="NOMBREXML" >
          <input type="hidden" name="NOMBREPDF" id="NOMBREPDF" >
          <input type="hidden" name="NOMBRECDR" id="NOMBRECDR" >


          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <label><b>XML:</b> <span class='exml'></span></label><br>
            <label><b>PDF:</b> <span class='epdf'></span></label><br>
            <label><b>CDR:</b> <span class='ecdr'></span></label>
            <button  type="button" class="btn btn-space btn-primary btn-md btncargarsunat">CARGAR DOCUMENTOS</button>
          </div>


      </div>
    </div>


    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorxml ocultar">
      <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">RESPUESTA XML : </label>
          <div class="col-sm-12 abajocaja" >
              <p style="margin:0px;"><b>Respuesta Sunat</b> : <strong class="MESSAGE"></strong></p>
              <p style="margin:0px;"><b>Estado Comprobante</b> : <strong class="NESTADOCP"></strong></p>
              <p style="margin:0px;"><b>Estado Ruc</b> : <strong class="NESTADORUC"></strong></p>
              <p style="margin:0px;"><b>Estado Domicilio</b> :<strong class="NCONDDOMIRUC"></strong></p>
              <input type="hidden" name="SUCCESS" id="SUCCESS" >
              <input type="hidden" name="MESSAGE" id="MESSAGE" >
              <input type="hidden" name="ESTADOCP" id="ESTADOCP" >
              <input type="hidden" name="NESTADOCP" id="NESTADOCP" >
              <input type="hidden" name="ESTADORUC" id="ESTADORUC" >
              <input type="hidden" name="NESTADORUC" id="NESTADORUC" >
              <input type="hidden" name="CONDDOMIRUC" id="CONDDOMIRUC" >
              <input type="hidden" name="NCONDDOMIRUC" id="NCONDDOMIRUC" >
              <input type="hidden" name="EMPRESAID" id="EMPRESAID" >
              <input type="hidden" name="NOMBREFILE" id="NOMBREFILE" >
              <input type="hidden" name="RUTACOMPLETA" id="RUTACOMPLETA" >
              <input type="hidden" name="array_detalle_producto" id='array_detalle_producto' value=''>
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
                    maxlength="4"
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
                    maxlength="10"
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
<div class="row sectorxmlmodal ocultar" style="margin-top:25px;">
  <table id="tdxml" class="table table-striped table-hover" style='width: 100%;'>
    <thead>
      <tr>
        <th>DETALLE DEL DOCUMENTO</th> 
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>
<div class="row sectorxmlmodal ocultar" style="margin-top:25px;">
    @foreach($tarchivos as $index => $item) 
        @php
            $extension = $item->COD_CTBLE;
            if ($extension == 'ZIP') {
                $extension = 'XML';
            }
        @endphp
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 {{$item->COD_CATEGORIA}}">
          <div class="form-group sectioncargarimagen">
            <label class="col-sm-12 control-label" style="text-align: left;">
              <div class="tooltipfr"><b>{{$item->NOM_CATEGORIA}} ({{$extension}})</b>
              </div>
            </label>
              <div class="col-sm-12">
                  <div class="file-loading">
                      <input 
                      id="file-{{$item->COD_CATEGORIA}}" 
                      name="{{$item->COD_CATEGORIA}}[]" 
                      class="file-es"  
                      type="file" 
                      multiple data-max-file-count="1">
                  </div>
              </div>
          </div>
        </div>
    @endforeach
</div>

@if(count($tdetliquidacionitem)>0) 
  @if(!in_array($tdetliquidacionitem->COD_TIPODOCUMENTO, ['TDO0000000000070','TDO0000000000001']))
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
    <button type="button" data-dismiss="modal" class="btn btn-success btn-guardar-detalle-factura">GUARDAR PARA AGREGAR DETALLE</button>
  </div>
@endif
<div class="col-xs-12">
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
            <span style="display: block;"><b>IND IGV : </b> @if($item->IND_IGV==1) SI @else NO @endif</span>
            <span style="display: block;"><b>SUBTOTAL : </b> {{$item->SUBTOTAL}}</span>
            <span style="display: block;"><b>IGV : </b> {{$item->IGV}}</span>
            <span style="display: block;"><b>TOTAL : </b> {{$item->TOTAL}}</span>
            @if(!in_array($tdetliquidacionitem->COD_TIPODOCUMENTO, ['TDO0000000000070','TDO0000000000001']))
              <button type="button" data_iddocumento = "{{$item->ID_DOCUMENTO}}" data_item = "{{$item->ITEM}}" data_item_documento = "{{$item->ITEMDOCUMENTO}}" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm modificardetalledocumentolg">MODIFICAR</button>
            @endif
          </td>
        </tr>                    
      @endforeach
    </tbody>
  </table>
</div>
@if(count($tdetliquidacionitem)>0)
<div class="col-lg-12">

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Nro</th>
              <th>Nombre</th>      
              <th>Archivo</th>       
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
              @foreach($archivos as $index => $item)  
                <tr>
                  <td>{{$index + 1}}</td>
                  <td>{{$item->DESCRIPCION_ARCHIVO}}</td>
                  <td>{{$item->NOMBRE_ARCHIVO}}</td>
                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a href="{{ url('/descargar-archivo-requerimiento-lg/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.$item->ID_DOCUMENTO) }}">
                            Descargar
                          </a>  
                        </li>                       
                      </ul>
                    </div>
                  </td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif



@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif









</div>



