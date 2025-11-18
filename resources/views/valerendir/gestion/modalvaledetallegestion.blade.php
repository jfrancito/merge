<div class="modal-header bg-primary text-white" style="padding: 14px 16px; border-radius: 4px 4px 0 0;">
    <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close text-white">
        <span class="mdi mdi-close"></span>
    </button>
    <h5 class="modal-title text-center w-100" 
        style="font-size: 1.5em; font-family: 'Times New Roman', serif; font-weight: bold; letter-spacing: 0.5px;">
        DETALLE DEL VALE A RENDIR
    </h5>
</div>

<div class="modal-body" style="font-family: 'Times New Roman', serif; font-size: 15px; padding: 18px;">
    <input type="hidden" id="vale_id" value="{{ $vale->ID }}">
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th style="width: 45%; background-color: #f7f7f7; color: #333; font-weight: bold;">
                    FECHA INICIO VIAJE
                </th>
                <td style="width: 55%;">
                    <span class="text-black">
                        {{ $fecha_inicio ? \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') : '' }}
                    </span>
                </td>
            </tr>
           <tr>
                <th style="background-color: #f7f7f7; color: #333; font-weight: bold;">
                    FECHA FIN VIAJE
                </th>
                <td>
                    <span class="text-black">
                        {{ $fecha_fin ? \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') : '' }}
                    </span>
                </td>
            </tr>

            <tr>
                <th style="background-color: #f7f7f7; color: #333; font-weight: bold;">
                    RUTA DE VIAJE
                </th>
                <td>
                    <span class="text-black">{{ $ruta_viaje ?? '—' }}</span>
                </td>
            </tr>

            <tr>
                <th style="background-color: #f7f7f7; color: #333; font-weight: bold;">
                    GLOSA
                </th>
                <td>
                    <span class="text-black">{{ $txt_glosa ?? '—' }}</span>
                </td>
            </tr>

            <tr>
                <th style="background-color: #f7f7f7; color: #333; font-weight: bold;">
                    AMPLIACIÓN DE FECHA
                </th>
                <td>
                    <input type="number" 
                           name="aumento_dias" 
                           id="aumento_dias" 
                           class="form-control text-primary" 
                           placeholder="Ingrese número de días"
                           min="0" 
                           value="{{ $vale->AUMENTO_DIAS ?? '' }}"
                           style="font-family: 'Times New Roman', serif; font-size: 15px;">
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-center mt-3">
    <button type="button" 
            id="btn_guardar_aumento_dias" 
            class="btn btn-success" 
            style="font-family: 'Times New Roman', serif; font-size: 15px; font-weight: bold; padding: 6px 18px; border-radius: 6px;">
        <i class="mdi mdi-content-save"></i> Guardar
    </button>
</div>
</div>
