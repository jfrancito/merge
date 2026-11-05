$(function () {
    // ─── Variables globales del módulo ────────────────────────────────────────
    const $chatMessages = $('#chat-messages');
    const $resultsPanel = $('#results-panel');
    const $chatInput = $('#chat-input');
    const $btnSend = $('#btn-send');
    const $btnExport = $('#btn-export');
    const $btnExportPdf = $('#btn-export-pdf');
    const $autocomplete = $('#autocomplete-list');
    let currentChartData = null;
    let currentSessionId = null;
    let autocompleteTimeout = null;

    // Registro: { rid → responseData } para burbujas clickeables
    const responseRegistry = {};
    let msgIdCounter = 0;

    // ─── Helpers ──────────────────────────────────────────────────────────────
    function getMonthName(n) {
        return ['', 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'][parseInt(n)] || `Mes ${n}`;
    }

    // ─── Send Message (función declarada, se eleva/hoistea dentro del scope) ──
    function sendMessage(text) {
        text = (typeof text === 'string' ? text : $chatInput.val()).trim();
        if (!text) return;
        $chatInput.val('');
        appendChatMessage('user', text);
        showTyping();
        clearResults();

        const filtroAnio = $('#filtro-anio').val() || 'todos';
        const filtroEmpresa = $('#filtro-empresa').val() || 'todas';

        $.ajax({
            url: window.baseUrl + '/ajax-consultar-asistente-ventas',
            type: 'POST',
            data: {
                pregunta: text,
                session_id: currentSessionId,
                filtro_anio: filtroAnio,
                filtro_empresa: filtroEmpresa,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            timeout: 120000, // 2 minutos para consultas complejas
            success: function (res) {
                hideTyping();
                if (res.success) {
                    currentSessionId = res.session_id;
                    hideTyping();
                    let responseText = res.analysis_ia || res.mensaje || 'Aquí están los resultados:';
                    appendChatMessage('assistant', responseText, res);
                    currentChartData = res;
                    renderResults(res);
                    $btnExport.prop('disabled', false);
                    $btnExportPdf.prop('disabled', false);
                } else {
                    appendChatMessage('assistant', res.error || 'No se pudo procesar la consulta.');
                    $resultsPanel.html(`<div class="empty-state"><i class="material-symbols-outlined">error_outline</i><p>${res.error || 'Error desconocido'}</p></div>`);
                }
            },
            error: function (xhr) {
                hideTyping();
                let msg = 'Error de conexión. Intenta de nuevo.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    msg = xhr.responseJSON.error;
                } else if (xhr.responseText) {
                    // Si es error de PHP o timeout, extraer mensaje si es posible
                    const match = xhr.responseText.match(/Exception: (.*?) in/);
                    if (match) msg = "Error del servidor: " + match[1];
                    else msg = "Error del servidor (" + xhr.status + ").";
                }
                appendChatMessage('assistant', msg);
            }
        });
    }

    // Exponer globalmente para onclick en alert-cards y drill-down
    window.sendMessage = sendMessage;

    // ─── Event Handlers ───────────────────────────────────────────────────────
    $chatInput.on('keypress', function (e) {
        if (e.which === 13 && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });
    $btnSend.on('click', function () { sendMessage(); });
    window.setQuery = function (query) { $chatInput.val(query); sendMessage(); };

    $(document).on('click', '.query-shortcut', function () {
        $chatInput.val($(this).data('query'));
        sendMessage();
    });

    $btnExport.on('click', function () {
        if (currentChartData) exportToCSV(currentChartData);
    });

    $btnExportPdf.on('click', function () {
        if (!currentChartData) return;
        const element = document.getElementById('results-panel');
        const opt = {
            margin: 0.5,
            filename: `reporte_bi_${Date.now()}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, backgroundColor: '#10121d' },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        $btnExportPdf.prop('disabled', true).html('<i class="material-symbols-outlined">sync</i>...');
        html2pdf().set(opt).from(element).save().then(() => {
            $btnExportPdf.prop('disabled', false).html('<i class="material-symbols-outlined">picture_as_pdf</i> PDF');
        });
    });


    // ─── Nueva Conversación (Modal Personalizado) ──────────────────────────────
    const $ncModal = $('#modal-confirmar-nueva');

    $(document).on('click', '#btn-nueva-conversacion', function () {
        $ncModal.addClass('show'); // Abrir modal bonito
    });

    $(document).on('click', '#btn-nc-cancelar', function () {
        $ncModal.removeClass('show'); // Cerrar sin hacer nada
    });

    $(document).on('click', '#btn-nc-confirmar', function () {
        $ncModal.removeClass('show');

        // Ejecutar reset del chat
        currentSessionId = null;
        $chatMessages.html('');
        $resultsPanel.html(`
            <div class="empty-state">
                <div class="empty-state-icon"><i class="material-symbols-outlined">bar_chart</i></div>
                <div class="empty-state-title">Resultados</div>
                <div class="empty-state-sub">Haz una pregunta para ver el análisis aquí</div>
            </div>`);
        $btnExport.prop('disabled', true);
        appendChatMessage('assistant', '¡Nueva conversación iniciada! ¿Sobre qué datos quieres analizar hoy?');
    });

    // Cerrar al hacer clic fuera de la card
    $ncModal.on('click', function (e) {
        if (e.target === this) $ncModal.removeClass('show');
    });

    // ─── Filtros: badge activo ────────────────────────────────────────────────
    function updateFilterBadge() {
        const anio = $('#filtro-anio').val();
        const empresa = $('#filtro-empresa').val();
        const active = (anio !== 'todos') || (empresa !== 'todas');
        $('#filter-active-badge').toggleClass('d-none', !active);
    }
    $(document).on('change', '#filtro-anio, #filtro-empresa', updateFilterBadge);

    // ─── Chat UI ──────────────────────────────────────────────────────────────
    function appendChatMessage(role, text, responseData = null) {
        const isUser = role === 'user';
        const avatarCls = isUser ? 'user' : 'ai';
        const icon = isUser ? 'person' : 'smart_toy';
        const bubbleCls = isUser ? 'user' : 'ai';
        const msgCls = isUser ? 'user' : '';

        let dataAttr = '';
        let clickStyle = '';
        let hintBadge = '';

        if (!isUser && responseData) {
            const id = 'res_' + (++msgIdCounter);
            responseRegistry[id] = responseData;
            dataAttr = `data-rid="${id}"`;
            clickStyle = 'cursor:pointer;';
            hintBadge = `<span class="msg-view-hint" title="Ver resultado en el panel">
                              <i class="material-symbols-outlined" style="font-size:.9rem;vertical-align:middle">bar_chart</i>
                          </span>`;
        }

        let feedbackHtml = '';
        if (!isUser && responseData && responseData.message_id) {
            const fb = responseData.feedback; // 'up', 'down', null
            const upActive = fb === 'up' ? 'active-up' : '';
            const downActive = fb === 'down' ? 'active-down' : '';
            const disabled = fb ? 'pointer-events:none' : '';

            feedbackHtml = `
                <div class="feedback-actions" data-msg-id="${responseData.message_id}">
                    <button class="btn-feedback fb-up ${upActive}" style="${disabled}" title="Respuesta útil"><i class="material-symbols-outlined">thumb_up</i></button>
                    <button class="btn-feedback fb-down ${downActive}" style="${disabled}" title="Respuesta incorrecta"><i class="material-symbols-outlined">thumb_down</i></button>
                </div>`;
        }

        $chatMessages.append(`
            <div class="chat-message ${msgCls}">
                <div class="msg-avatar ${avatarCls}"><i class="material-symbols-outlined">${icon}</i></div>
                <div class="msg-bubble ${bubbleCls}" ${dataAttr} style="${clickStyle}">${text}${hintBadge}</div>
                ${feedbackHtml}
            </div>
        `);
        $chatMessages.scrollTop($chatMessages[0].scrollHeight);
    }

    // Clic en burbuja con datos → mostrar en panel derecho
    $(document).on('click', '.msg-bubble[data-rid]', function () {
        const rid = $(this).data('rid');
        const rd = responseRegistry[rid];
        if (!rd) return;
        currentChartData = rd;
        renderResults(rd);
        $btnExport.prop('disabled', false);
        $('.msg-bubble[data-rid]').css('outline', '');
        $(this).css('outline', '2px solid #6366f1');
    });

    // Feedback Handler
    $(document).on('click', '.btn-feedback', function (e) {
        e.stopPropagation();
        const $btn = $(this);
        const $parent = $btn.closest('.feedback-actions');
        const msgId = $parent.data('msg-id');
        const isUp = $btn.hasClass('fb-up');
        const vote = isUp ? 'up' : 'down';

        $parent.find('.btn-feedback').removeClass('active-up active-down').css('pointer-events', 'none');
        $btn.addClass(isUp ? 'active-up' : 'active-down');

        $.post(window.baseUrl + '/ajax-chat-feedback', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            message_id: msgId,
            vote: vote
        });
    });

    function showTyping() {
        $chatMessages.append(`
            <div class="chat-message" id="typing-indicator">
                <div class="msg-avatar ai"><i class="material-symbols-outlined">smart_toy</i></div>
                <div class="msg-bubble ai"><div class="typing-dots"><span></span><span></span><span></span></div></div>
            </div>
        `);
        $chatMessages.scrollTop($chatMessages[0].scrollHeight);
        $btnSend.prop('disabled', true);
    }

    function hideTyping() {
        $('#typing-indicator').remove();
        $btnSend.prop('disabled', false);
    }

    function clearResults() {
        $btnExport.prop('disabled', true);
        $resultsPanel.html(`
            <div class="d-flex align-items-center justify-content-center h-100" style="min-height:200px">
                <div class="text-center">
                    <div class="spinner-border" style="color:#6366f1;width:2rem;height:2rem" role="status"></div>
                    <div class="mt-2" style="font-size:.8rem;color:#94a3b8">Analizando tu consulta...</div>
                </div>
            </div>`);
    }

    // ─── Helpers de datos ─────────────────────────────────────────────────────
    function getDimensionKey(item) {
        const preferred = [
            'periodo', 'periodo_nombre', 'mes_nombre', 'mes',
            'jefe_venta_nombre', 'cliente_nombre', 'producto_nombre',
            'area_venta', 'canal_venta', 'subcanal_venta', 'tipo_cliente',
            'empresa_nombre', 'subfamilia_nombre'
        ];
        // Si hay 'anio' y 'mes', preferir una combinación si existiera, pero por ahora priorizamos 'mes' si está,
        // o 'anio' solo si no hay nada más específico. 'anio' al final.

        for (const k of preferred) {
            if (item[k] !== undefined && item[k] !== null) return k;
        }

        // Secondary priority
        if (item.anio || item.year) return item.anio ? 'anio' : 'year';

        return Object.keys(item)[0];
    }

    function formatValue(key, val) {
        if (val === null || val === undefined) return '—';
        const k = key.toLowerCase();

        // Fix: Años sin comas (2,025 -> 2025)
        if (['anio', 'year', 'año'].includes(k)) return String(val).replace(/[,.]/g, '');

        const n = parseFloat(val);
        if (!isNaN(n)) {
            if (['variacion', 'participacion', 'crecimiento', 'pct', 'porcentaje'].some(x => k.includes(x)))
                return (n >= 0 ? '+' : '') + n.toFixed(1) + '%';
            if (['kilos', 'peso', 'kilogramos'].some(x => k.includes(x)))
                return n.toLocaleString('es-PE', { minimumFractionDigits: 0 }) + ' kg';
            if (['num_ventas', 'clientes', 'ordenes', 'cantidad', 'unidades'].some(x => k.includes(x)))
                return n.toLocaleString('es-PE');
            if (['total', 'importe', 'monto', 'precio', 'ticket', 'promedio', 'igv', 'sin_igv'].some(x => k.includes(x)) || k === 'total')
                return 'S/. ' + n.toLocaleString('es-PE', { minimumFractionDigits: 2 });
            return n % 1 === 0 ? n.toLocaleString('es-PE') : n.toLocaleString('es-PE', { minimumFractionDigits: 2 });
        }
        return String(val);
    }

    function humanizeKey(key) {
        const map = {
            jefe_venta_nombre: 'Jefe de Venta', cliente_nombre: 'Cliente',
            producto_nombre: 'Producto', area_venta: 'Área de Venta',
            canal_venta: 'Canal', subcanal_venta: 'Subcanal',
            tipo_cliente: 'Tipo Cliente', empresa_nombre: 'Empresa',
            subfamilia_nombre: 'Subfamilia', periodo: 'Período',
            total: 'Total (S/.)', num_ventas: '# Ventas',
            kilos_vendidos: 'Kilos', clientes_activos: 'Clientes',
            ticket_promedio: 'Ticket Prom.', precio_promedio: 'Precio Prom.',
            variacion_pct: 'Variación %', participacion: 'Participación %',
            mes: 'Mes', anio: 'Año'
        };
        return map[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }

    function buildFullTable(data, alertas) {
        if (!data || !data.length) return '';
        const keys = Object.keys(data[0]);
        const dimKey = getDimensionKey(data[0]);

        const thead = `<thead><tr class="table-header-row">
            ${keys.map(k => `<th class="border-0 fs-11 fw-bold text-muted text-uppercase px-3 py-2${k !== dimKey ? ' text-end' : ''}">${humanizeKey(k)}</th>`).join('')}
        </tr></thead>`;

        const tbody = `<tbody>${data.map((item, idx) => {
            const dimVal = String(item[dimKey] || '');
            const alerta = (alertas || []).find(a => a.concepto === dimVal);
            const rowCls = alerta ? (alerta.tipo === 'danger' ? 'row-danger' : 'row-warning') : (idx % 2 ? 'row-alt' : '');
            const cells = keys.map(k => {
                const isDim = k === dimKey;
                const warnIcon = (isDim && alerta) ? `<i class="material-symbols-outlined align-middle fs-6 ms-1 text-danger" title="${alerta.motivo}">warning</i>` : '';
                return `<td class="px-3 py-2${isDim ? ' fw-semibold text-dark' : ' text-end text-secondary'}">${formatValue(k, item[k])}${warnIcon}</td>`;
            }).join('');
            return `<tr class="data-row ${rowCls}">${cells}</tr>`;
        }).join('')}</tbody>`;

        return `<div class="table-wrapper"><table class="data-table">${thead}${tbody}</table></div>`;
    }

    // ─── Render Principal ─────────────────────────────────────────────────────
    function renderResults(response) {
        if (!response.data || response.data.length === 0) {
            $resultsPanel.html(`<div class="empty-state"><i class="material-symbols-outlined">search_off</i><p>No se encontraron datos para esta consulta.</p></div>`);
            return;
        }

        const layout = response.layout_sugerido || 'detailed_table';
        const config = response.config_visual || {};
        const icon = config.icono || 'analytics';
        const color = config.color_base || '#0d6efd';
        const temporal = response.comparativo_temporal || null;
        const alertas = response.alertas || [];
        const data = response.data;
        const dimKey = getDimensionKey(data[0]);

        const temporalBadge = temporal ? (() => {
            const up = temporal.porcentaje_variacion >= 0;
            return `<span class="temporal-badge ${up ? 'up' : 'down'}">
                <i class="material-symbols-outlined">${up ? 'trending_up' : 'trending_down'}</i>
                ${up ? '+' : ''}${temporal.porcentaje_variacion}% ${temporal.etiqueta}
            </span>`;
        })() : '';

        let sections = [];

        if (response.insight_principal) {
            sections.push(`
                <div class="insight-card">
                    <div class="insight-icon"><i class="material-symbols-outlined">lightbulb</i></div>
                    <div>
                        <div class="insight-label">Insight del Asistente</div>
                        <div class="insight-text">${response.insight_principal}</div>
                    </div>
                </div>`);
        }

        if (layout === 'medal_ranking') {
            const medals = ['🥇', '🥈', '🥉'];
            const bgs = ['rgba(255,215,0,0.12)', 'rgba(192,192,192,0.12)', 'rgba(205,127,50,0.12)'];
            const borders = ['#f5c518', '#aaa', '#cd7f32'];

            const podium = data.slice(0, 3).map((item, i) => {
                const label = String(item[dimKey] || `#${i + 1}`);
                const total = parseFloat(item.total || 0);
                const extras = Object.entries(item)
                    .filter(([k]) => k !== dimKey && k !== 'total')
                    .map(([k, v]) => `<div class="medal-extra"><span>${humanizeKey(k)}</span><span>${formatValue(k, v)}</span></div>`)
                    .join('');
                return `<div class="medal-card" style="background:${bgs[i]};border-color:${borders[i]}">
                    <div class="medal-emoji">${medals[i]}</div>
                    <div class="medal-name" title="${label}">${label}</div>
                    <div class="medal-value">S/. ${total.toLocaleString('es-PE', { minimumFractionDigits: 2 })}</div>
                    ${extras}
                </div>`;
            }).join('');

            sections.push(`
                <div class="section-header">
                    <i class="material-symbols-outlined" style="color:#f5c518">emoji_events</i>
                    <span>Top Ranking</span>${temporalBadge}
                </div>
                <div class="medal-grid">${podium}</div>`);

            sections.push(`
                <div class="section-header mt-3">
                    <i class="material-symbols-outlined" style="color:${color}">table_chart</i>
                    <span>Detalle Completo</span>
                </div>
                ${buildFullTable(data, alertas)}`);

        } else if (layout === 'comparison_cards') {
            const cards = data.map((item, i) => {
                // Dimensión principal
                let labelVal = item[dimKey];
                if (!labelVal) {
                    // Si no hay dimKey claro, buscar el primer string
                    labelVal = Object.values(item).find(v => typeof v === 'string' && !/^\d+$/.test(v)) || `Opción ${i + 1}`;
                }
                const label = String(labelVal);

                // Valor principal (Smart detection actualizado)
                let total = parseFloat(item.total);
                let totalKey = 'total';

                if (isNaN(total)) {
                    // Prioridad de detección de métricas
                    const candidates = ['ventas', 'importe', 'monto', 'crecimiento_pct', 'crecimiento', 'variacion', 'pct', 'porcentaje', 'peso', 'kilos', 'cantidad'];
                    const foundKey = candidates.find(k => item[k] !== undefined && !isNaN(parseFloat(item[k])));

                    if (foundKey) {
                        total = parseFloat(item[foundKey]);
                        totalKey = foundKey;
                    } else {
                        // Fallback: primer número que no sea ID o fecha
                        const pair = Object.entries(item).find(([k, v]) =>
                            !isNaN(parseFloat(v)) && k !== dimKey &&
                            !['id', 'anio', 'mes', 'year', 'month'].includes(k.toLowerCase())
                        );
                        if (pair) {
                            total = parseFloat(pair[1]);
                            totalKey = pair[0];
                        } else {
                            total = 0;
                        }
                    }
                }

                // Heurística de Rescate:
                // Si la llave es 'total' pero el valor es pequeño (< 1000) y tenemos ventas grandes (> 10000), es %
                if (totalKey === 'total' && Math.abs(total) < 1000) {
                    const hasHugeSales = Object.values(item).some(v => typeof v === 'number' && Math.abs(v) > 10000);
                    if (hasHugeSales) totalKey = 'pct';
                }

                // Extras (todo lo que no sea el label ni la métrica principal usada)
                const extras = Object.entries(item)
                    .filter(([k, v]) => k !== dimKey && k !== totalKey && k !== 'total')
                    .map(([k, v]) => `
                        <div class="comp-extra">
                            <span>${humanizeKey(k)}</span>
                            <span>${formatValue(k, v)}</span>
                        </div>`)
                    .join('');

                return `<div class="comp-card" style="border-top:3px solid ${color}">
                    <div class="comp-label">${label}</div>
                    <div class="comp-value" style="color:${color}">
                        ${formatValue(totalKey, total)}
                    </div>
                    ${extras}
                </div>`;
            }).join('');

            sections.push(`
                <div class="section-header">
                    <i class="material-symbols-outlined text-info">compare_arrows</i>
                    <span>Comparativa</span>${temporalBadge}
                </div>
                <div class="comp-grid">${cards}</div>`);

        } else if (response.tipo_consulta === 'evolution' || response.tipo_consulta === 'kpi') {
            const totalValue = data.reduce((s, i) => s + (parseFloat(i.total) || 0), 0);
            sections.push(`
                <div class="kpi-hero" style="border-left:4px solid ${color}">
                    <div>
                        <div class="kpi-label" style="color:${color}">Total Acumulado</div>
                        <div class="kpi-value" style="color:${color}">S/. ${totalValue.toLocaleString('es-PE', { minimumFractionDigits: 2 })}</div>
                    </div>
                    ${temporalBadge}
                </div>`);
        }

        if (layout !== 'comparison_cards') {
            const chartId = 'chart-' + Date.now();
            const chartTitle = layout === 'medal_ranking' ? 'Gráfico de Ranking'
                : response.tipo_consulta === 'evolution' ? 'Evolución Temporal'
                    : 'Distribución de Resultados';

            sections.push(`
                <div class="chart-section">
                    <div class="section-header">
                        <i class="material-symbols-outlined" style="color:${color}">${icon}</i>
                        <span>${chartTitle}</span>
                        ${layout !== 'medal_ranking' ? temporalBadge : ''}
                    </div>
                    <div class="chart-box"><canvas id="${chartId}"></canvas></div>
                </div>`);

            if (layout !== 'medal_ranking') {
                sections.push(`
                    <div class="section-header mt-3">
                        <i class="material-symbols-outlined" style="color:${color}">table_chart</i>
                        <span>Detalle Completo</span>
                    </div>
                    ${buildFullTable(data, alertas)}`);
            }

            $resultsPanel.html(`<div class="results-wrapper">${sections.join('')}</div>`);
            setTimeout(() => initChart(chartId, response, color), 100);
        } else {
            $resultsPanel.html(`<div class="results-wrapper">${sections.join('')}</div>`);
        }

        if (response.preguntas_sugeridas && response.preguntas_sugeridas.length > 0) {
            const chips = response.preguntas_sugeridas
                .map(q => `<button class="suggestion-chip query-shortcut" data-query="${q}">${q}</button>`)
                .join('');


            $resultsPanel.append(`
                <div class="suggestions-section">
                <div class="suggestions-section">
                    <div class="suggestions-label">
                        <i class="material-symbols-outlined">auto_awesome</i> ¿Qué más quieres saber?
                    </div>
                    <div class="suggestions-chips">${chips}</div>
                </div>`);
        }
    }


    // ─── Smart Chart Renderer ─────────────────────────────────────────────────
    function initChart(canvasId, response, color) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        // ── 1. Modo Arquitectura Híbrida (Haiku Config) ──
        if (response.chart_config_ia) {
            let config = response.chart_config_ia;
            if (typeof config === 'string') config = JSON.parse(config);

            // Rehidratar funciones de callback
            const moneyFormatter = (val) => 'S/. ' + parseFloat(val).toLocaleString('es-PE', { minimumFractionDigits: 2 });
            const percentFormatter = (val) => parseFloat(val).toFixed(1) + '%';

            const hydrate = (obj) => {
                for (const k in obj) {
                    if (typeof obj[k] === 'object' && obj[k] !== null) {
                        hydrate(obj[k]);
                    } else if (typeof obj[k] === 'string') {
                        if (obj[k].includes('__CALLBACK_MONEY__')) {
                            obj[k] = function (val) {
                                // Chart.js pasa (value, index, values) en ticks
                                // O (context) en tooltips
                                if (typeof val === 'object' && val.parsed) return moneyFormatter(val.parsed.y || val.raw);
                                return moneyFormatter(val);
                            };
                        } else if (obj[k].includes('__CALLBACK_PERCENT__')) {
                            obj[k] = function (val) {
                                if (typeof val === 'object' && val.parsed) return percentFormatter(val.parsed.y || val.raw);
                                return percentFormatter(val);
                            };
                        }
                    }
                }
            };
            hydrate(config);

            new Chart(ctx, config);
            return;
        }

        // ── 2. Modo Fallback (Legacy Logic) ──
        const data = response.data || [];
        if (!data.length) return;

        const dimKey = getDimensionKey(data[0]);
        const baseColor = color || '#0d6efd';
        const chartType = response.chart_type || inferChartType(response);

        if (chartType === 'none') { ctx.parentElement.style.display = 'none'; return; }

        const labels = data.map(item => {
            const raw = item[dimKey];
            if (typeof raw === 'string' && /^\d{4}-\d{2}$/.test(raw)) {
                const [y, m] = raw.split('-');
                return getMonthName(parseInt(m)) + ' ' + y;
            }
            return String(raw || '');
        });

        const values = data.map(d => {
            let val = parseFloat(d.total);
            if (!isNaN(val)) return val;

            // Detección inteligente de métrica para el gráfico
            const candidates = ['ventas', 'ventas_total', 'importe', 'monto', 'crecimiento_pct', 'crecimiento', 'variacion', 'pct', 'porcentaje', 'peso', 'kilos', 'cantidad'];
            const foundKey = candidates.find(k => d[k] !== undefined && !isNaN(parseFloat(d[k])));

            if (foundKey) return parseFloat(d[foundKey]);

            // Fallback: primer número disponible
            const pair = Object.entries(d).find(([k, v]) =>
                !isNaN(parseFloat(v)) && k !== dimKey &&
                !['id', 'anio', 'mes', 'year', 'month'].includes(k.toLowerCase())
            );
            return pair ? parseFloat(pair[1]) : 0;
        });

        const PALETTE = [
            '#0d6efd', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
            '#06b6d4', '#f97316', '#ec4899', '#14b8a6', '#84cc16'
        ];
        const multiColors = labels.map((_, i) => PALETTE[i % PALETTE.length]);
        const multiAlpha = labels.map((_, i) => PALETTE[i % PALETTE.length] + 'cc');
        const barColors = values.map((_, i) => {
            const hex = Math.round((0.45 + (i / Math.max(values.length - 1, 1)) * 0.55) * 255).toString(16).padStart(2, '0');
            return baseColor + hex;
        });

        let lineGradient = null;
        if (chartType === 'line') {
            const g = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
            g.addColorStop(0, baseColor + '55');
            g.addColorStop(1, baseColor + '00');
            lineGradient = g;
        }

        const tooltipLabel = (ctx) => {
            // Detectar orientación del gráfico para saber qué eje tiene el valor
            const isHorizontal = ctx.chart.config.type === 'bar' && ctx.chart.options.indexAxis === 'y';
            // En gráficos verticales (línea/barra), el valor está en Y. En horizontales, en X.
            // ctx.parsed.y puede ser 0, así que cuidado con falsy values.
            let val = isHorizontal ? ctx.parsed.x : ctx.parsed.y;

            // Si por alguna razón es undefined, intentamos el fallback
            if (val === undefined || val === null) val = ctx.raw;

            const v = parseFloat(val);
            return ' ' + (color === '#10b981' ? '+' : '') + // Si es verde (crecimiento), poner +
                (v < 100 ? v.toFixed(1) + '%' : // heurística simple: si es pequeño en gráfico, asumimos % o cantidad
                    'S/. ' + v.toLocaleString('es-PE', { minimumFractionDigits: 2 }));
        };
        const tooltipLabelCircular = (ctx) => {
            const v = parseFloat(ctx.parsed ?? 0);
            return ' S/. ' + v.toLocaleString('es-PE', { minimumFractionDigits: 2 });
        };

        const configs = {
            line: {
                type: 'line',
                data: { labels, datasets: [{ label: 'Total (S/.)', data: values, backgroundColor: lineGradient, borderColor: baseColor, borderWidth: 2.5, fill: true, tension: 0.4, pointBackgroundColor: baseColor, pointRadius: 4, pointHoverRadius: 7 }] },
                options: { responsive: true, maintainAspectRatio: false, animation: { duration: 700, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip: { ...tooltipStyle(), callbacks: { label: tooltipLabel } } }, scales: { x: { grid: { display: false }, ticks: tickStyle() }, y: { beginAtZero: true, grid: gridStyle(), ticks: { ...tickStyle(), callback: compactMoney } } } }
            },
            bar: {
                type: 'bar',
                data: { labels, datasets: [{ label: 'Total (S/.)', data: values, backgroundColor: barColors, borderRadius: 8, borderWidth: 0 }] },
                options: { responsive: true, maintainAspectRatio: false, animation: { duration: 600, easing: 'easeOutBounce' }, plugins: { legend: { display: false }, tooltip: { ...tooltipStyle(), callbacks: { label: tooltipLabel } } }, scales: { x: { grid: { display: false }, ticks: { ...tickStyle(), maxRotation: 35 } }, y: { beginAtZero: true, grid: gridStyle(), ticks: { ...tickStyle(), callback: compactMoney } } } }
            },
            bar_horizontal: {
                type: 'bar',
                data: { labels, datasets: [{ label: 'Total (S/.)', data: values, backgroundColor: barColors, borderRadius: 6, borderWidth: 0 }] },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, animation: { duration: 600, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip: { ...tooltipStyle(), callbacks: { label: tooltipLabel } } }, scales: { x: { beginAtZero: true, grid: gridStyle(), ticks: { ...tickStyle(), callback: compactMoney } }, y: { grid: { display: false }, ticks: { ...tickStyle(), font: { size: 10 } } } } }
            },
            doughnut: {
                type: 'doughnut',
                data: { labels, datasets: [{ data: values, backgroundColor: multiAlpha, borderColor: multiColors, borderWidth: 2, hoverOffset: 8 }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '65%', animation: { duration: 700, animateRotate: true }, plugins: { legend: { display: true, position: 'right', labels: { color: '#475569', font: { size: 11 }, padding: 12, boxWidth: 14 } }, tooltip: { ...tooltipStyle(), callbacks: { label: tooltipLabelCircular } } } }
            },
            pie: {
                type: 'pie',
                data: { labels, datasets: [{ data: values, backgroundColor: multiAlpha, borderColor: '#fff', borderWidth: 3, hoverOffset: 10 }] },
                options: { responsive: true, maintainAspectRatio: false, animation: { duration: 700, animateRotate: true }, plugins: { legend: { display: true, position: 'right', labels: { color: '#475569', font: { size: 11 }, padding: 12, boxWidth: 14 } }, tooltip: { ...tooltipStyle(), callbacks: { label: tooltipLabelCircular } } } }
            },
            radar: {
                type: 'radar',
                data: { labels, datasets: [{ label: 'Total (S/.)', data: values, backgroundColor: baseColor + '33', borderColor: baseColor, borderWidth: 2, pointBackgroundColor: baseColor, pointRadius: 4 }] },
                options: { responsive: true, maintainAspectRatio: false, animation: { duration: 700 }, plugins: { legend: { display: false }, tooltip: { ...tooltipStyle(), callbacks: { label: tooltipLabel } } }, scales: { r: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.06)' }, ticks: { color: '#94a3b8', font: { size: 9 }, callback: compactMoney }, pointLabels: { color: '#475569', font: { size: 10 } } } } }
            }
        };

        const heights = { bar_horizontal: Math.max(220, labels.length * 32), doughnut: 300, pie: 300, radar: 300 };
        if (heights[chartType]) ctx.parentElement.style.height = heights[chartType] + 'px';

        const cfg = configs[chartType] || configs.bar;

        // Drill-down: clic en barra/segmento
        cfg.options.onClick = (event, elements) => {
            if (!elements.length) return;
            const idx = elements[0].index;
            const label = labels[idx];
            if (!label) return;

            const tip = document.createElement('div');
            tip.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#6366f1;color:#fff;padding:.4rem 1rem;border-radius:999px;font-size:.78rem;z-index:9999;pointer-events:none';
            tip.textContent = `🔍 Explorando: ${label}`;
            document.body.appendChild(tip);
            setTimeout(() => tip.remove(), 2000);

            window.drillDown(label, dimKey, response);
        };
        cfg.options.plugins = cfg.options.plugins || {};
        cfg.options.plugins.tooltip = {
            ...(cfg.options.plugins.tooltip || {}),
            callbacks: {
                ...(cfg.options.plugins.tooltip?.callbacks || {}),
                afterLabel: () => '👆 Clic para ver detalle'
            }
        };

        new Chart(ctx, cfg);
    }

    function inferChartType(response) {
        const tipo = response.tipo_consulta || '';
        const data = response.data || [];
        if (tipo === 'evolution') return 'line';
        if (tipo === 'kpi' && data.length === 1) return 'none';
        if (tipo === 'distribution') return 'doughnut';
        if (tipo === 'ranking' || tipo === 'aggregate') return data.length > 8 ? 'bar_horizontal' : 'bar';
        if (tipo === 'compare') return data.length <= 5 ? 'doughnut' : 'bar';
        return 'bar';
    }

    function tooltipStyle() { return { backgroundColor: '#1e293b', titleColor: '#94a3b8', bodyColor: '#f1f5f9', padding: 12, cornerRadius: 8 }; }
    function tickStyle() { return { color: '#64748b', font: { size: 11 } }; }
    function gridStyle() { return { color: 'rgba(0,0,0,0.05)' }; }
    function compactMoney(v) {
        if (v >= 1_000_000) return 'S/. ' + (v / 1_000_000).toFixed(1) + 'M';
        if (v >= 1_000) return 'S/. ' + (v / 1_000).toFixed(0) + 'k';
        return 'S/. ' + v;
    }

    // ─── Export CSV ───────────────────────────────────────────────────────────
    function exportToCSV(data) {
        if (!data || !data.data || !data.data.length) return;
        const keys = Object.keys(data.data[0]);
        let csv = '\uFEFF' + keys.map(humanizeKey).join(';') + '\n';
        data.data.forEach(item => {
            csv += keys.map(k => {
                const v = item[k];
                return (v === null || v === undefined) ? '' : String(v).replace(/;/g, ',');
            }).join(';') + '\n';
        });
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `analisis_ventas_${Date.now()}.csv`;
        link.click();
    }

    // ─── Drill-Down ───────────────────────────────────────────────────────────
    window.drillDown = function (label, dimKey, prevResponse) {
        if (!label) return;

        const fieldMap = {
            'razon_social': { es: 'cliente', filtro: `WHERE razon_social = '${label}'` },
            'nombre_cliente': { es: 'cliente', filtro: `WHERE nombre_cliente = '${label}'` },
            'cliente_nombre': { es: 'cliente', filtro: `WHERE cliente_nombre = '${label}'` },
            'cliente': { es: 'cliente', filtro: `WHERE cliente = '${label}'` },
            'descripcion': { es: 'producto', filtro: `WHERE descripcion = '${label}'` },
            'producto_nombre': { es: 'producto', filtro: `WHERE producto_nombre = '${label}'` },
            'producto': { es: 'producto', filtro: `WHERE producto = '${label}'` },
            'area_venta': { es: 'área de venta', filtro: `WHERE area_venta = '${label}'` },
            'nombre_area': { es: 'área de venta', filtro: `WHERE nombre_area = '${label}'` },
            'jefe_venta_nombre': { es: 'jefe de venta', filtro: `WHERE jefe_venta_nombre = '${label}'` },
            'jefe_venta': { es: 'jefe de venta', filtro: `WHERE jefe_venta = '${label}'` },
            'tipo_cliente': { es: 'tipo de cliente', filtro: `WHERE tipo_cliente = '${label}'` },
            'canal_venta': { es: 'canal', filtro: `WHERE canal_venta = '${label}'` },
            'subfamilia_nombre': { es: 'subfamilia', filtro: `WHERE subfamilia_nombre = '${label}'` },
            'subfamilia': { es: 'subfamilia', filtro: `WHERE subfamilia = '${label}'` },
        };

        const field = fieldMap[dimKey];
        let query;
        if (field) {
            query = `Muestra el detalle completo solo del ${field.es} "${label}": ` +
                `¿cuánto vendió en total, cuántos kilos, cuántas órdenes y cuál fue su ticket promedio? ` +
                `Filtra EXACTAMENTE por ${dimKey} = '${label}'. ` +
                `Desglósalo por productos y muestra el total general al final.`;
        } else {
            query = `Dame el detalle específico de "${label}". ` +
                `Filtra los datos SOLO para "${label}" (no hagas un ranking general). ` +
                `Muestra ventas por producto, kilos y órdenes.`;
        }
        sendMessage(query);
    };

    // ─── Historial de Sesiones ────────────────────────────────────────────────
    window.loadSessions = function () {
        $.post(window.baseUrl + '/ajax-listar-sesiones-chat',
            { _token: $('meta[name="csrf-token"]').attr('content') },
            function (res) {
                if (!res.sesiones || !res.sesiones.length) {
                    appendChatMessage('assistant', 'No tienes conversaciones guardadas aún.');
                    return;
                }
                let html = '<div style="display:flex;flex-direction:column;gap:.4rem;max-width:90%">';
                res.sesiones.forEach(s => {
                    html += `<div class="suggestion-chip" style="text-align:left;border-radius:8px;padding:.5rem .9rem;cursor:pointer"
                        onclick="window.loadSession(${s.id})">
                        <div style="font-size:.75rem;font-weight:600">${s.titulo}</div>
                        <div style="font-size:.68rem;color:#94a3b8">${s.created_at} · ${s.total_mensajes} mensajes</div>
                    </div>`;
                });
                html += '</div>';
                appendChatMessage('assistant', '📂 Selecciona una conversación para cargarla:');
                $chatMessages.append(`<div class="chat-message" style="padding-left:2.5rem">${html}</div>`);
                $chatMessages.scrollTop($chatMessages[0].scrollHeight);
            }
        );
    };

    window.loadSession = function (sessionId) {
        $.post(window.baseUrl + '/ajax-cargar-sesion-chat',
            { session_id: sessionId, _token: $('meta[name="csrf-token"]').attr('content') },
            function (res) {
                $chatMessages.html('');
                currentSessionId = res.session_id;
                let lastRd = null;

                res.mensajes.forEach(m => {
                    if (m.role === 'assistant') {
                        let rd = m.response_data || {};
                        // Inject metadata
                        rd.message_id = m.id;
                        rd.feedback = m.feedback;

                        appendChatMessage('assistant', m.content, rd);
                        if (m.response_data) lastRd = rd;
                    } else {
                        appendChatMessage('user', m.content);
                    }
                });

                if (lastRd) {
                    currentChartData = lastRd;
                    renderResults(lastRd);
                    $btnExport.prop('disabled', false);
                }

                appendChatMessage('assistant',
                    `✅ Conversación restaurada — <strong>haz clic en cualquier respuesta</strong> para ver su gráfico.`);
            }
        );
    };

    $(document).on('click', '#btn-load-history', function () { window.loadSessions(); });

    // ─── Cargar Filtros disponibles ───────────────────────────────────────────
    function loadFiltros() {
        $.post(window.baseUrl + '/ajax-filtros-chat',
            { _token: $('meta[name="csrf-token"]').attr('content') },
            function (res) {
                const $anio = $('#filtro-anio');
                const $empresa = $('#filtro-empresa');

                // Sin pre-selección: empieza en "Todos los años"
                (res.anios || []).forEach(a => {
                    $anio.append(`<option value="${a}">📅 ${a}</option>`);
                });
                (res.empresas || []).forEach(e => {
                    $empresa.append(`<option value="${e}">🏢 ${e}</option>`);
                });
                // Badge: solo actualizar tras selección manual del usuario
            }
        );
    }

    // ─── Alertas Proactivas ───────────────────────────────────────────────────
    function loadAlertas() {
        $.post(window.baseUrl + '/ajax-alertas-chat',
            { _token: $('meta[name="csrf-token"]').attr('content') },
            function (res) {
                if (!res.alertas || !res.alertas.length) return;

                let html = '<div style="display:flex;flex-direction:column;gap:.35rem;max-width:95%">';
                res.alertas.forEach(a => {
                    const tipoCls = a.tipo === 'alerta' ? 'alerta' : (a.tipo === 'positiva' ? 'positiva' : '');
                    const safeQuery = (a.query || '').replace(/'/g, "\\'");
                    html += `<div class="alert-card ${tipoCls}" onclick="window.sendMessage('${safeQuery}')">
                        <div>
                            <div class="alert-card-title">${a.titulo}</div>
                            <div class="alert-card-detail">${a.detalle} · <em>Clic para analizar</em></div>
                        </div>
                    </div>`;
                });
                html += '</div>';

                appendChatMessage('assistant', '👋 ¡Hola! Aquí algunos datos destacados de hoy para comenzar:');
                $chatMessages.append(`<div class="chat-message" style="padding-left:2.5rem">${html}</div>`);
                $chatMessages.scrollTop($chatMessages[0].scrollHeight);
            }
        );
    }

    // ─── Inicialización ───────────────────────────────────────────────────────
    loadFiltros();
    loadAlertas();
});
