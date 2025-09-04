<div class="panel panel-default panel-contrast">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE DOCUMENTOS
    </div>
    <div class="panel-body panel-body-contrast">

        @foreach($tdetliquidaciongastos as $index => $item)
            <div class="dtlg {{$item->ID_DOCUMENTO}}{{$item->ITEM}} @if($index!=0) ocultar @endif">
                <table class="table table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>RESPUESTA SUNAT</th>
                        <th>ESTADO COMPROBANTE</th>
                        <th>ESTADO RUC</th>
                        <th>ESTADO DOMICILIO</th>
                        <th>RESPUESTA CDR</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$item->MESSAGE}}</td>
                        <td>{{$item->NESTADOCP}}</td>
                        <td>{{$item->NESTADORUC}}</td>
                        <td>{{$item->NCONDDOMIRUC}}</td>
                        <td>{{$item->RESPUESTA_CDR}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach


        @foreach($tdetliquidaciongastos as $index => $item)
            <div class="dtlg {{$item->ID_DOCUMENTO}}{{$item->ITEM}} @if($index!=0) ocultar @endif">
                <table class="table table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>FECHA EMISION</th>
                        <th>DOCUMENTO</th>
                        <th>TIPO DOCUMENTO</th>
                        <th>PROVEEDOR</th>
                        <th>TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</td>
                        <td>{{$item->SERIE}} - {{$item->NUMERO}} </td>
                        <td>{{$item->TXT_TIPODOCUMENTO}}</td>
                        <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>
                        <td>{{$item->TOTAL}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach

        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>PRODUCTO</th>
                <th>PRODUCTO XML</th>
                <th>CANTIDAD</th>
                <th>PRECIO</th>
                <th>IGV</th>
                <th>SUB TOTAL</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            @foreach($detdocumentolg as $index => $item)
                <tr class="dtlg {{$item->ID_DOCUMENTO}}{{$item->ITEM}}  @if($item->ITEM!=1) ocultar @endif">
                    <td>{{$item->TXT_PRODUCTO}}</td>
                    <td>{{$item->TXT_PRODUCTO_XML}}</td>
                    <td>{{$item->CANTIDAD}}</td>
                    <td>{{$item->PRECIO}}</td>
                    <td>{{$item->IGV}}</td>
                    <td>{{$item->SUBTOTAL}}</td>
                    <td>{{$item->TOTAL}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('liquidaciongasto.form.liquidaciongasto.verpdfmultiple')

            {{--@include('comprobante.asiento.contenedorasientolg')--}}

        @foreach($tdetliquidaciongastos as $index => $item)
            <div class="dtlg {{$item->ID_DOCUMENTO}}{{$item->ITEM}} @if($index!=0) ocultar @endif">
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
                                    @foreach($archivos as $indexa => $itema)
                                        @if($itema->DOCUMENTO_ITEM == $item->ITEM)
                                            <tr>
                                                <td>{{$indexa + 1}}</td>
                                                <td>{{$itema->DESCRIPCION_ARCHIVO}}</td>
                                                <td>{{$itema->NOMBRE_ARCHIVO}}</td>
                                                <td class="rigth">
                                                    <div class="btn-group btn-hspace">
                                                        <button type="button" data-toggle="dropdown"
                                                                class="btn btn-default dropdown-toggle">Acción <span
                                                                    class="icon-dropdown mdi mdi-chevron-down"></span>
                                                        </button>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="{{ url('/descargar-archivo-requerimiento-lg/'.$itema->TIPO_ARCHIVO.'/'.$idopcion.'/'.$itema->DOCUMENTO_ITEM.'/'.$itema->ID_DOCUMENTO) }}">
                                                                    Descargar
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>
