<div style="border: 1px solid #ccc; padding: 20px; border-radius: 6px; background: #f9f9f9;">

    <div class="table-responsive">
        <table id="personalautoriza" class="table table-bordered td-color-borde td-padding-7 display nowrap"
               cellspacing="0" width="100%" style="font-style: italic;">
            <thead>
                <tr>
                    <th style="text-align: center;">Personal</th>
                    <th style="text-align: center;">Línea</th>
                    <th style="text-align: center;">Gerencia</th>
                    <th style="text-align: center;">Área</th>
                    <th style="text-align: center;">Cargo</th>
                    <th style="text-align: center;">Autoriza</th>  
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <button type="button" class="btn-verde" id="btnGuardarPersonal">
            <i class="fa fa-save"></i> GUARDAR
        </button>
    </div>

</div>

<style>
    .btn-verde {
    background-color: #5cb85c;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
    }

    .btn-verde:hover {
        background-color: #4cae4c;
    }

    thead th {
        background: #1d3a6d; 
        color: white;              
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .table-responsive {
        overflow-x: auto;
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