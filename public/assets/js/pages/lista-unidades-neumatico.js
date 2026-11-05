document.addEventListener('DOMContentLoaded', () => {

    const vehiculos = window.APP_DATA?.vehiculos || [];

    const input     = document.getElementById('inputPlaca');
    const lista     = document.getElementById('listaResultados');
    const infoBox   = document.getElementById('infoVehiculo');
    const infoPlaca = document.getElementById('infoPlaca');
    const infoTipo  = document.getElementById('infoTipo');
    const btnCrear  = document.getElementById('btnCrear');
    const rowEstado = document.getElementById('rowEstado');
    const infoEstado = document.getElementById('infoEstado');
    const modalKmTelemetria = document.getElementById('modalKmTelemetria');
    const modalCrear = document.getElementById('modalCrearInspeccion');
    const modalPlaca = document.getElementById('modalPlaca');
    const modalOdometro = document.getElementById('modalOdometro');
    const errOdometro = document.getElementById('err-odometro');

    let seleccionado = null;

    // Buscar placa
    input.addEventListener('input', () => {
        const texto = input.value.trim().toUpperCase();
        lista.innerHTML = '';
        btnCrear.disabled = true;
        infoBox.classList.add('d-none');

        if (texto.length < 2) return;

        vehiculos
            .filter(v => v.Placa?.toUpperCase().includes(texto))
            .slice(0, 6)
            .forEach(v => {
                const item = document.createElement('div');
                item.className = 'item-resultado';
                item.textContent = v.Placa;
                item.onclick = () => seleccionarVehiculo(v);
                lista.appendChild(item);
            });
    });

    function seleccionarVehiculo(v) {
        seleccionado = v;

        document.getElementById('idvehiculo').value = v.IdVehiculo;
        
        input.value = v.Placa;
        lista.innerHTML = '';

        infoPlaca.textContent = v.Placa;
        infoTipo.textContent  = v.TipoVehiculo ?? '-';

        modalKmTelemetria.value = Number(v.KmTelemetria || 0).toLocaleString('es-PE');

        infoBox.classList.remove('verde', 'amarillo');

        if (Number(v.TieneInspeccion) === 1) {
            infoBox.classList.add('amarillo');
            btnCrear.disabled = true;
            infoEstado.textContent = v.EstadoInspeccion ?? 'SIN ESTADO';
            rowEstado.classList.remove('d-none');
        } else {
            infoBox.classList.add('verde');
            btnCrear.disabled = false;
            rowEstado.classList.add('d-none');
            infoEstado.textContent = '';
        }

        infoBox.classList.remove('d-none');
    }

    modalCrear.addEventListener('show.bs.modal', () => {
        modalPlaca.textContent = seleccionado ? seleccionado.Placa : '';
    });

    modalOdometro.addEventListener('input', function () {
        if (this.value <= 0) {
            errOdometro.classList.remove('d-none');
            this.value = '';
        } else {
            errOdometro.classList.add('d-none');
        }
    });

});
