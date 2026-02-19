<div class="form-group">
    <label class="col-sm-3 control-label">Cliente:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm" value="{{ $ordencompra->TXT_EMPR_EMISOR }}">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Codigo Orden:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm" value="{{ $fedocumento->ID_DOCUMENTO }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Documento:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm"
               value="{{ $fedocumento->SERIE }}-{{ $fedocumento->NUMERO }}">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label">Usario Contacto:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm"
               value="{{$trabajador->TXT_APE_PATERNO}} {{$trabajador->TXT_APE_MATERNO}} {{$trabajador->TXT_NOMBRES}}">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label labelleft negrita">Reparable :</label>
    <div class="col-sm-6 abajocaja">
        {!! Form::select( 'reparable', $comboreparable, array(),
                          [
                            'class'       => 'select2 form-control control input-xs combo comboreparable' ,
                            'id'          => 'reparable',
                            'data-aw'     => '1',
                            'required'    => '',
                          ]) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Archivos Reparable:</label>
    <div class="col-sm-6">
        @foreach($documentoscomprarepable as $index => $item)
            <div class="be-checkbox">
                <input id="{{$item->COD_CATEGORIA}}R" value="{{$item->COD_CATEGORIA}}" type="checkbox"
                       name="archivore[]">
                <label for="{{$item->COD_CATEGORIA}}R">{{$item->NOM_CATEGORIA}} ({{$item->COD_CTBLE}})</label>
            </div>
        @endforeach
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Descripcion de Reparar Comprobante<span class="obligatorio">(*)</span>
        :</label>
    <div class="col-sm-6">
        <textarea
                name="descripcion"
                id="descripcion"
                class="form-control input-sm validarmayusculas"
                rows="5"
                cols="50"
                required=""
                data-aw="2"></textarea>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include('comprobante.asiento.contenedorasientoreparable')
</div>

<div class="row xs-pt-15">
    <div class="col-xs-6">
        <div class="be-checkbox">

        </div>
    </div>
    <div class="col-xs-6">
        <p class="text-right">
            <a href="{{ url('/gestion-de-contabilidad-aprobar/'.$idopcion) }}">
                <button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button>
            </a>
            <button type="button" class="btn btn-space btn-primary btnreparablecomporbatntenc">Guardar</button>
        </p>
    </div>
</div>

