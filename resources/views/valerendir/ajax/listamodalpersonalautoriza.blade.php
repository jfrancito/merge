<div class="panel-contenedor-premium">

    <div class="table-responsive">
        <table id="personalautoriza" class="table table-bordered tabla-personal-premium display nowrap"
               cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Personal</th>
                    <th data-searchable="false">Línea</th>
                    <th>Gerencia</th>
                    <th>Área</th>
                    <th>Cargo</th>
                    <th data-searchable="false">Autoriza</th>  
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="botonera-premium">
        <button type="button" class="btn-guardar-premium" id="btnGuardarPersonal">
            <i class="fa fa-save"></i> GUARDAR CAMBIOS
        </button>
    </div>

</div>

<style>
    /* Contenedor Premium */
    .panel-contenedor-premium {
        border: 1px solid #eef2f6; 
        padding: 24px; 
        border-radius: 12px; 
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        margin-top: 15px;
    }

    /* Tabla Premium */
    .tabla-personal-premium {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
        margin-top: 10px !important;
        margin-bottom: 20px !important;
        border: 1px solid #eef2f6 !important;
        border-radius: 8px !important;
        overflow: hidden !important;
    }

    .tabla-personal-premium thead th {
        background: linear-gradient(135deg, #1d3a6d 0%, #2a5298 100%) !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 12px 16px !important;
        text-align: center !important;
        vertical-align: middle !important;
        border: none !important;
        white-space: nowrap !important;
    }

    .tabla-personal-premium tbody td {
        padding: 14px 16px !important;
        font-size: 13px !important;
        color: #4a5568 !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #edf2f7 !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        transition: all 0.2s ease !important;
    }

    .tabla-personal-premium tbody tr:last-child td {
        border-bottom: none !important;
    }

    .tabla-personal-premium tbody tr:hover td {
        background-color: #f7fafc !important;
        color: #1a202c !important;
    }

    /* Selectores en Celdas */
    .tabla-personal-premium td select {
        border-radius: 6px !important;
        border: 1px solid #cbd5e0 !important;
        height: 38px !important;
        padding: 6px 12px !important;
        font-size: 13px !important;
        color: #4a5568 !important;
    }

    /* Botón Guardar Premium */
    .botonera-premium {
        text-align: center; 
        margin-top: 25px;
    }

    .btn-guardar-premium {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 12px 30px !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        letter-spacing: 1px !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        box-shadow: 0 4px 15px rgba(56, 239, 125, 0.3) !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
    }

    .btn-guardar-premium i {
        font-size: 16px !important;
        transition: transform 0.3s ease !important;
    }

    .btn-guardar-premium:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(56, 239, 125, 0.4) !important;
        filter: brightness(1.05) !important;
    }

    .btn-guardar-premium:hover i {
        transform: scale(1.15) !important;
    }

    .btn-guardar-premium:active {
        transform: translateY(0) !important;
        box-shadow: 0 4px 10px rgba(56, 239, 125, 0.2) !important;
    }

    /* Responsividad de Tabla */
    .table-responsive {
        overflow-x: auto;
        border-radius: 8px;
    }

    /* Personalización Avanzada de Select2 */
    .select2-container--default .select2-selection--single {
        border: 1px solid #cbd5e0 !important;
        border-radius: 6px !important;
        height: 38px !important;
        padding: 4px 8px !important;
        transition: all 0.3s ease !important;
        background-color: #fff !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default .select2-selection--single:focus {
        border-color: #2a5298 !important;
        box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.15) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        color: #2d3748 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        text-align: left !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 8px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #718096 transparent transparent transparent !important;
        border-width: 6px 5px 0 5px !important;
    }

    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #718096 transparent !important;
        border-width: 0 5px 6px 5px !important;
    }

    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        overflow: hidden !important;
    }

    .select2-search--dropdown {
        padding: 8px 10px !important;
    }

    .select2-search--dropdown .select2-search__field {
        border: 1px solid #cbd5e0 !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
        font-size: 13px !important;
    }

    .select2-results__option {
        padding: 8px 12px !important;
        font-size: 13px !important;
        color: #4a5568 !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2a5298 !important;
        color: #ffffff !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__clear {
        margin-right: 20px !important;
        color: #a0aec0 !important;
        font-size: 16px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__clear:hover {
        color: #e53e3e !important;
    }

</style>

<script>
$('#personalautoriza').DataTable({
    responsive: true,
    scrollX: true,
    autoWidth: false,
    columnDefs: [
        {
            targets: 0, // columna “Personal”
            render: function(data, type, row, meta){
                if(type === 'filter' || type === 'sort'){
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data;
                    var span = tmp.querySelector('.nombre-personal');
                    return span ? span.getAttribute('data-personal') : data;
                }
                return data;
            }
        }
    ],
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    }
});




</script>