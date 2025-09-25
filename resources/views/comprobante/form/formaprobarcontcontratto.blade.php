<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.contrato.comparar')
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.contrato.consultaapi')
        @include('comprobante.form.contrato.infodetraccion')
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.contrato.seguimiento')
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
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
                                    <button type="button" data-toggle="dropdown"
                                            class="btn btn-default dropdown-toggle">Acción <span
                                                class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">

                                        <li>
                                            <a href="{{ url('/descargar-archivo-requerimiento-contrato/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}">
                                                Descargar
                                            </a>
                                        </li>

                                        @if(Session::get('usuario')->id == '1CIX00000001' or Session::get('usuario')->id == '1CIX00000049')
                                            <li>
                                                <a class="elimnaritem"
                                                   href="{{ url('/eliminar-archivo-item-contrato/'.$item->TIPO_ARCHIVO.'/'.$item->NOMBRE_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}">
                                                    Eliminar Item
                                                </a>
                                            </li>
                                        @endif

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
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
        @include('comprobante.form.contrato.informacion')
    </div>
</div>

<div class="row">
    @include('comprobante.form.contrato.pagobanco')
</div>

<div class="row">
    @include('comprobante.form.contrato.detraccion')
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('comprobante.form.ordencompra.verarchivopdf')
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.contrato.archivosobservados')
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
            </div>
            <div class="panel-body panel-body-contrast">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>OTROS DOCUMENTOS</b>
                                <br><br></label>
                            <div class="col-sm-12">
                                <div class="file-loading">
                                    <input
                                            id="file-otros"
                                            name="otros[]"
                                            class="file-es"
                                            type="file"
                                            multiple data-max-file-count="1"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">RECOMENDACION
            </div>
            <div class="panel-body panel-body-contrast">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA
                                    RECOMENDACIÓN</b> <br><br></label>
                            <div class="col-sm-12">
                          <textarea
                                  name="descripcion"
                                  id="descripcion"
                                  class="form-control input-sm validarmayusculas"
                                  rows="12"
                                  cols="200"
                                  data-aw="2"></textarea>
                            </div>
                        </div>

                        <div class="form-group" style="display: none">
                            <label class="col-sm-12 control-label izquierda" style="text-align: left;">Cuenta Contable
                                <b>(*)</b></label>
                            <div class="col-sm-12">
                                <input type="text"
                                       id="nro_cuenta_contable"
                                       name='nro_cuenta_contable'
                                       value=""
                                       placeholder="Cuenta Contable"
                                       required=""
                                       autocomplete="off" class="form-control input-sm"/>

                            </div>
                        </div>
{{--
                        <input type="text"
                               id="nro_cuenta_contable"
                               name="nro_cuenta_contable"
                               placeholder="Cuenta Contable"
                               required
                               pattern="\d{6}"
                               maxlength="6"
                               data-parsley-pattern-message="El código debe tener exactamente 6 números"
                               autocomplete="off"
                               class="form-control input-sm"/>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('comprobante.asiento.listaasientotabla')
        @include('comprobante.asiento.contenedorasientoorden')
    </div>
    {{--
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('comprobante.asiento.contenedorasiento')
    </div>
    --}}
</div>

<div class="row xs-pt-15">
    <div class="col-xs-6">
        <div class="be-checkbox">

        </div>
    </div>
    <div class="col-xs-6">
        <p class="text-right">
            <a href="{{ url('/gestion-de-comprobante-contabilidad/'.$idopcion) }}">
                <button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button>
            </a>
            <button type="button" class="btn btn-space btn-primary btnaprobarcomporbatnte">Guardar</button>
        </p>
    </div>
</div>
