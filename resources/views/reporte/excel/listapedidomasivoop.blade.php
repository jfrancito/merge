<table border="1">
@foreach($pedidos as $pedido)

@php $cab = $pedido->first(); @endphp

<tr>
    <td colspan="6"
        style="background-color:#1d3a6d; color:#ffffff !important; 
               text-align:center; font-weight:bold; border : 1px solid #000000;">
        PEDIDO DE COMPRA
    </td>
</tr>
<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000 ; text-align:center;"><b>N° PEDIDO</b></td>
    <td style="border : 1px solid #000000">{{ $cab->ID_PEDIDO }}</td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>ESTADO</b></td>
    <td colspan="2" style="border : 1px solid #000000" >{{ $cab->TXT_ESTADO }}</td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>FECHA</b></td>
    <td>{{ $cab->FEC_PEDIDO }}</td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>ÁREA</b></td>
    <td colspan="2" style="border : 1px solid #000000">{{ $cab->TXT_AREA }}</td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>AÑO</b></td>
    <td style="text-align:left; border : 1px solid #000000">{{ $cab->COD_ANIO }}</td>

    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>REALIZADO POR</b></td>
    <td colspan="2" style="border : 1px solid #000000">{{ $cab->TXT_TRABAJADOR_SOLICITA }}</td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>MES</b></td>
    <td style="border : 1px solid #000000">{{ $cab->TXT_NOMBRE }}</td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>AUTORIZA JEFE</b></td>
    <td colspan="2" style="border : 1px solid #000000">{{ $cab->TXT_TRABAJADOR_AUTORIZA }}</td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>EMPRESA</b></td>
    <td style="border : 1px solid #000000">{{ $cab->NOM_EMPR }}</td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>APRUEBA GERENCIA</b></td>
    <td colspan="2" style="border : 1px solid #000000">{{ $cab->TXT_TRABAJADOR_APRUEBA_GER }}</td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>SEDE</b></td>
    <td style="border : 1px solid #000000">{{ $cab->NOM_CENTRO }}</td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>APRUEBA ADMINISTRACIÓN</b></td>
    <td colspan="2" style="border : 1px solid #000000">{{ $cab->TXT_TRABAJADOR_APRUEBA_ADM }}</td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>TIPO</b></td>
    <td style="border : 1px solid #000000">{{ $cab->TXT_TIPO_PEDIDO }}</td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>OBSERVACIÓN</b></td>
    <td colspan="2" style="border : 1px solid #000000">{{ $cab->TXT_GLOSA }}</td>
</tr>


<tr>
    <th style="background-color:#1d3a6d; color:#ffffff !important ;  border : 1px solid #000000 ;
               text-align:center; font-weight:bold;">N°</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important; border : 1px solid #000000 ; 
               text-align:center; font-weight:bold;">CÓDIGO</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important;  border : 1px solid #000000 ;
               text-align:center; font-weight:bold;" colspan="2">PRODUCTO</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important; border : 1px solid #000000 ;
               text-align:center; font-weight:bold;">CANTIDAD</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important; border : 1px solid #000000 ;
               text-align:center; font-weight:bold;">OBSERVACIÓN</th>
</tr>

@foreach($pedido as $i => $det)
<tr>
    <td style="background-color:#d9edf7; border : 1px solid #000000 ; text-align:center">{{ $i + 1 }}</td>
    <td style="border : 1px solid #000000">{{ $det->COD_PRODUCTO }}</td>
    <td colspan="2" style="border : 1px solid #000000">{{ $det->NOM_PRODUCTO }}</td>
    <td style="background-color:#d9edf7; text-align:center ; border : 1px solid #000000">{{ $det->CANTIDAD }}</td>
    <td style="border : 1px solid #000000">{{ $det->TXT_OBSERVACION }}</td>
</tr>
@endforeach

<tr><td colspan="6"></td></tr>

@endforeach
</table>
