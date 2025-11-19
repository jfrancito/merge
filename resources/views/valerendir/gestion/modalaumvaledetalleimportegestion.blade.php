<div class="scroll_text scroll_text_heigth_aler" style="display:flex; justify-content:center; width:100%; margin:0 auto;">
  <table class="table table-bordered table-striped table-hover align-middle"
         style="width:95%; max-width:1100px; margin:auto; table-layout:fixed;">
    <thead class="table-primary text-center align-middle" style="font-size: 14px;">
  <tr>
    <th style="width:22%; text-align:center;">DESTINO Y FECHAS</th>
    <th style="width:26%; text-align:center;">DESCRIPCIÓN</th>
    <th style="width:20%; text-align:center;">COSTO UNIT. (S/)</th>
    <th style="width:23%; text-align:center;">IMPORTE (S/)</th>
    <th style="width:19%; text-align:center;">TOTAL</th>
  </tr>
</thead>
    <tbody>
      @php $totalGeneral = 0; @endphp

      @foreach($detalles as $detalle)
        @php
          $totalGeneral += $detalle->CAN_TOTAL_IMPORTE;
          $tipos = preg_split('/<br>|\n/', trim($detalle->NOM_TIPOS));
          $unitarios = preg_split('/<br>|\n/', trim($detalle->CAN_UNITARIO));
          $totales = explode('<br>', $detalle->CAN_UNITARIO_TOTAL);
          $numLineas = max(count($tipos), count($unitarios), count($totales));
        @endphp

        @for ($i = 0; $i < $numLineas; $i++)
          <tr class="text-center align-middle">
            {{-- DESTINO Y FECHAS --}}
            @if ($i === 0)
              <td rowspan="{{ $numLineas }}" class="align-top">
                <strong class="text-uppercase">{{ $detalle->NOM_DESTINO }}</strong><br>
                <small class="text-muted fst-italic">
                  {{ \Carbon\Carbon::parse($detalle->FEC_INICIO)->format('d/m/Y H:i') ?? '' }}
                  <br> al <br>
                  {{ \Carbon\Carbon::parse($detalle->FEC_FIN)->format('d/m/Y H:i') ?? '' }}<br>
                  ({{ $detalle->DIAS ?? '0' }} día(s))
                </small>
              </td>
            @endif

            {{-- DESCRIPCIÓN --}}
            <td class="text-start"
                style="font-family: monospace; white-space:normal; word-wrap:break-word;">
              {{ trim($tipos[$i] ?? '') }}
            </td>

            {{-- COSTO UNITARIO --}}
            <td class="text-primary fw-semibold text-end"
                style="font-family: monospace; white-space:nowrap;">
              {{ trim($unitarios[$i] ?? '') }}
            </td>

            {{-- IMPORTE EDITABLE --}}
             <td class="text-primary fw-semibold text-end">
              <input type="text"
               name="can_unitario_total[]"
               value="{{ trim($totales[$i]) }}"
               class="form-control text-end input-importe"
               style="height:30px; font-size:13px; border:1px solid #ccc; border-radius:6px;"
               data-detalle-id="{{ $detalle->ID }}"
               data-destino="{{ $detalle->COD_DESTINO }}"
               data-nomtipo="{{ trim($tipos[$i] ?? '') }}"
               data-nomdestino="{{ $detalle->NOM_DESTINO }}"
               data-linea="{{ $i }}"
               oninput="soloNumeros(this)">
              </td>
            {{-- TOTAL --}}
            @if ($i === 0)
              <td rowspan="{{ $numLineas }}" class="align-middle">
                <span class="badge bg-dark fs-6">
                  S/ {{ number_format($detalle->CAN_TOTAL_IMPORTE, 2) }}
                </span>
              </td>
            @endif
          </tr>
        @endfor
      @endforeach

      <tr class="text-center bg-light">
        <td colspan="4" class="text-end"><strong>TOTAL GENERAL (S/)</strong></td>
        <td>
          <span class="badge bg-primary fs-6">
            S/ {{ number_format($totalGeneral, 2) }}
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class="modal-footer justify-content-center bg-light" 
     style="border-top:1px solid #dee2e6;">
    <button type="button" id="btn_guardar" class="btn btn-success btn-space">
        Guardar
    </button>
</div>


<script>
function soloNumeros(input) {
    let valor = input.value;
}
</script>
