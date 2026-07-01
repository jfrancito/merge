<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.ordencompra.comparar')
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @if($fedocumento->OPERACION_DET == 'SIN_XML')
            @include('comprobante.form.ordencompra.datosfactura')
        @endif
        @if($fedocumento->OPERACION_DET != 'SIN_XML')
            @include('comprobante.form.ordencompra.sunatconta')
        @endif
        @include('comprobante.form.ordencompra.infodetraccion')
        @include('comprobante.form.ordencompra.ordeningreso')
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.ordencompra.seguimientocontabilidad')
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.ordencompra.archivos')
    </div>

    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">

        @include('comprobante.form.ordencompra.informacionoccont')
        @if(count($lista_anticipo_merge)>0)
          @include('comprobante.form.ordencompra.anticipomerge')
        @endif
        
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('comprobante.form.ordencompra.verarchivopdf')
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.ordencompra.archivosobservados')
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


                        <div id="div_cuenta_contable" class="form-group" style="display: none">
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
    @if($fedocumento->OPERACION !== 'ORDEN_COMPRA_ANTICIPO')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor-asientos-async">
        <div class="panel panel-default" style="text-align: center; padding: 30px; border: 1px dashed #ccc;">
            <div class="panel-body">
                <i class="fa fa-spinner fa-spin fa-2x" style="color: #1d3a6d;"></i>
                <h4 style="margin-top: 15px; color: #1d3a6d; font-weight: bold;">Generando simulación de asientos...</h4>
                <p class="text-muted">Por favor, espere mientras se ejecutan los cálculos contables.</p>
            </div>
        </div>
    </div>
    @endif
    {{--
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('comprobante.asiento.contenedorasiento')
    </div>
    --}}
</div>
