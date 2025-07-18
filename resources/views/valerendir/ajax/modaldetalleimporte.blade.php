
<div class="modal-header bg-primary text-white py-2" style="font-family: 'Times New Roman', serif;">
    <h5 class="modal-title w-50 text-center fw-bold" style="font-size: 1.5em;">
        DETALLE VIÁTICOS DE VIAJE
    </h5>
</div>

<!-- Tabla Detalle -->
<div class="modal-body p-3" style="font-family: 'Segoe UI', sans-serif;">
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle shadow-sm">
      <thead class="table-primary text-center">
        <tr>
          <th style="width: 50%; text-align: center;">DESTINO Y FECHAS</th>
          <th style="width: 30%; text-align: center;">DESCRIPCIÓN</th>
          <th style="width: 17%; text-align: center;">COSTO UNIT. (S/)</th>
          <th style="width: 15%; text-align: center;">IMPORTE (S/)</th>
          <th style="width: 18%; text-align: center;">TOTAL</th>
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
            {{ \Carbon\Carbon::parse($detalle->FEC_INICIO)->format('d/m/Y') ?? '' }}
              al
              {{ \Carbon\Carbon::parse($detalle->FEC_FIN)->format('d/m/Y') ?? '' }}
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
  <td colspan="4" class="text-end fw-bold">TOTAL GENERAL (S/)</td>
  <td>
    <span class="badge bg-primary fs-6">
      S/ {{ number_format($totalGeneral, 2) }}
    </span>
  </td>
</tr>

      </tbody>

    </table>
        <div class="modal-footer justify-content-center"> 
             <button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Cerrar</button> 
        </div>
  </div>
</div>
