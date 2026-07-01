<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.comision.comparar')
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 @if($fedocumento->OPERACION_DET == 'SIN_XML') ocultar @endif">
        @include('comprobante.form.comision.consultaapisunat')
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.contrato.seguimiento')
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.comision.archivos')
    </div>
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
        @include('comprobante.form.comision.informacion')
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('comprobante.form.ordencompra.verarchivopdf')
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.estiba.archivosobservados')
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
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES
            </div>
            <div class="panel-body panel-body-contrast">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA
                                    OBSERVACION</b> <br><br></label>
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
                        <div class="form-group">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor-asientos-async">
        <div class="panel panel-default" style="border-left: 5px solid #2563eb; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            <div class="panel-body text-center" style="padding: 40px;">
                <div style="font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 10px;">
                    <i class="fa fa-spinner fa-spin fa-2x" style="color: #2563eb; margin-right: 10px; vertical-align: middle;"></i>
                    Generando pre-asientos contables...
                </div>
                <div style="color: #64748b; font-size: 13px;">
                    Este proceso ejecuta validaciones contables y simula los asientos en tiempo real.
                </div>
            </div>
        </div>
    </div>
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
            <button type="button" class="btn btn-space btn-primary btnaprobarcomporbatntenuevocomision">Guardar</button>
        </p>
    </div>
</div>
