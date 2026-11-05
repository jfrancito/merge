<div class="panel panel-default panel-contrast" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
  <div class="panel-heading" style="background: #1d3a6d; color: #fff; font-weight: bold; padding: 15px;">
    <i class="bi bi-file-earmark-text"></i> DATOS DEL CONTRATO ACOPIO
  </div>
  <div class="panel-body panel-body-contrast" style="padding: 0;">
    <table class="table table-condensed table-striped" style="margin-bottom: 0;">
      <thead>
        <tr style="background: #f8fafc;">
          <th style="padding: 12px 15px; font-size: 11px; text-transform: uppercase; color: #64748b;">Atributo</th>
          <th style="padding: 12px 15px; font-size: 11px; text-transform: uppercase; color: #64748b;">Valor Informativo</th>            
        </tr>
      </thead>
      <tbody>
          <tr>
            <td style="padding: 10px 15px;"><b>ID DOCUMENTO</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0; font-weight: 600; color: #2d3748;">{{$contratoanticipo->ID_DOCUMENTO}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>NRO CONTRATO</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{$contratoanticipo->NRO_CONTRATO}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>FECHA CONTRATO</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{date_format(date_create($contratoanticipo->FECHA_CONTRATO), 'd-m-Y')}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>EMPRESA</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{$contratoanticipo->TXT_EMPRESA}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>CENTRO / SEDE</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{$contratoanticipo->TXT_CENTRO}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>PROVEEDOR</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0; font-weight: 600;">{{$contratoanticipo->TXT_PROVEEDOR}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>CUENTA</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{$contratoanticipo->TXT_CUENTA}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>SUB CUENTA</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{$contratoanticipo->TXT_SUB_CUENTA}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>VARIEDAD</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{$contratoanticipo->TXT_VARIEDAD}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>FECHA COSECHA</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{date_format(date_create($contratoanticipo->FECHA_COSECHA), 'd-m-Y')}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>HECTÁREAS</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{number_format($contratoanticipo->HECTAREAS, 2, '.', ',')}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>TOTAL KG</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{number_format($contratoanticipo->TOTAL_KG, 2, '.', ',')}} KG</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>PRECIO REF.</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0;">{{number_format($contratoanticipo->PRECIO_REFERENCIA, 4, '.', ',')}}</p></td>
          </tr>
          <tr style="background: #ebf8ff;">
            <td style="padding: 10px 15px;"><b>PROYECCIÓN TOTAL</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0; font-weight: bold; color: #2b6cb0; font-size: 15px;">{{number_format($contratoanticipo->PROYECCION, 2, '.', ',')}}</p></td>
          </tr>
          <tr style="background: #ebf8ff;">
            <td style="padding: 10px 15px;"><b>IMPORTE HABILITAR</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0; font-weight: bold; color: #2b6cb0; font-size: 15px;">{{number_format($contratoanticipo->IMPORTE_HABILITAR, 2, '.', ',')}}</p></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>ESTADO</b></td>
            <td style="padding: 10px 15px;"><span class="badge badge-primary" style="font-size: 10px;">{{$contratoanticipo->TXT_ESTADO}}</span></td>
          </tr>
          <tr>
            <td style="padding: 10px 15px;"><b>GLOSA</b></td>
            <td style="padding: 10px 15px;"><p class='subtitulomerge' style="margin:0; font-style: italic; font-size: 12px;">{{$contratoanticipo->GLOSA ?: 'Sin observaciones'}}</p></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>