<table class="table table-bordered table-striped table-hover align-middle">
      <thead class="table-primary text-center">
        <tr>
          <th style=" text-align: center;">DESTINO Y FECHAS</th>
          <th style=" text-align: center;">DESCRIPCIÓN</th>
          <th style="; text-align: center;">COSTO UNIT. (S/)</th>
          <th style=" text-align: center;">IMPORTE (S/)</th>
          <th style=" text-align: center;">TOTAL</th>
        </tr>
      </thead>
      <tbody>
            @php
                $totalGeneral = 0;
            @endphp
                
            @foreach($detalles as $detalle)
                 @php
                    $totalGeneral += $detalle->CAN_TOTAL_IMPORTE;
                  @endphp
                <tr class="text-center">
                 <td>
                  <strong class="text-uppercase">{{ $detalle->NOM_DESTINO }}</strong><br>
                  <small class="text-muted fst-italic">
                    {{ \Carbon\Carbon::parse($detalle->FEC_INICIO)->format('d/m/Y H:i') ?? '' }}
                     <br> al  <br>
                    {{ \Carbon\Carbon::parse($detalle->FEC_FIN)->format('d/m/Y H:i') ?? '' }}  <br>
                    ({{ $detalle->DIAS ?? '0' }} día(s))
                  </small>
                </td>

                  <td class="text-start">
                   {!! nl2br(e(str_replace('<br>', "\n", $detalle->NOM_TIPOS))) !!}

                  </td>
                  <td class="text-primary fw-semibold">
                     {!! nl2br(e(str_replace('<br>', "\n", $detalle->CAN_UNITARIO))) !!}
                 </td>
                <td class="text-success fw-semibold">
                    {!! nl2br(e(str_replace('<br>', "\n", $detalle->CAN_UNITARIO_TOTAL))) !!}
                </td>
                  <td>
                    <span class="badge bg-dark fs-6">
                      S/ {{ number_format($detalle->CAN_TOTAL_IMPORTE, 2) }}
                    </span>
                  </td>
                </tr>
            @endforeach
                <tr class="text-center bg-light">
                  <td colspan="4" class="text-end" style="font-weight: bold !important;">TOTAL GENERAL (S/)</td>
                  <td>
                    <span class="badge bg-primary fs-6">
                      S/ {{ number_format($totalGeneral, 2) }}
                    </span>
                  </td>
                </tr>
      </tbody>
</table>
  
 

