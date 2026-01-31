/**
 * ASISTENTE ANALÍTICO DE LIQUIDACIÓN DE GASTOS
 * Chatbot Gerencial con IA para consultas de datos
 */
(function ($) {
    'use strict';

    // =========================================
    // CONFIGURATION
    // =========================================
    const idopcion = $('#idopcion').val() || '0';
    const CONFIG = {
        apiUrl: `/merge/api/asistente-analitico/${idopcion}`,
        conversacionUrl: `/merge/api/asistente-analitico/conversacion/${idopcion}`,
        preguntasUrl: `/merge/api/asistente-analitico/preguntas-frecuentes/${idopcion}`,
        insightsUrl: `/merge/api/asistente-analitico/insights/${idopcion}`,
        maxRetries: 2,
        typingDelay: 1500
    };

    // Chart instance
    let resultsChart = null;

    // Conversation history for context
    let conversationHistory = [];
    let lastKPIs = []; // Store KPIs for export

    // =========================================
    // INITIALIZATION
    // =========================================
    $(document).ready(function () {
        initEventListeners();
        adjustTextareaHeight();
        loadConversationHistory(); // Load previous conversation
        loadSavedQuestions();      // Load favorite questions
    });

    function initEventListeners() {
        // Send message on button click
        $('#btn_send').on('click', sendMessage);

        // Send message on Enter (without Shift)
        $('#chat_input').on('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Auto-resize textarea
        $('#chat_input').on('input', adjustTextareaHeight);

        // Quick questions
        $(document).on('click', '.quick-question, .suggestion-btn', function (e) {
            e.preventDefault();
            const question = $(this).text().trim();
            $('#chat_input').val(question);
            sendMessage();
        });

        // Clear chat
        $('#btn_clear_chat').on('click', clearChat);

        // Export results (PDF)
        $('#btn_export_pdf').on('click', exportToPDF);

        // Insights Button ("Sorpréndeme")
        $('#btn_insights').on('click', generateInsights);

        // Saved Questions Interactions
        $(document).on('click', '.saved-question-chip', function (e) {
            if (!$(e.target).closest('.delete-question').length) {
                const question = $(this).find('.question-text').text().trim();
                $('#chat_input').val(question);
                sendMessage();
            }
        });

        $(document).on('click', '.delete-question', function (e) {
            e.stopPropagation();
            const id = $(this).data('id');
            deleteSavedQuestion(id);
        });

        // Save question button (dynamically added to user messages)
        $(document).on('click', '.btn-save-question', function (e) {
            const question = $(this).data('question');
            saveQuestion(question);
            $(this).remove(); // Remove button after saving
        });
    }

    function adjustTextareaHeight() {
        const textarea = document.getElementById('chat_input');
        if (textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
        }
    }

    // =========================================
    // CHAT FUNCTIONS
    // =========================================
    function sendMessage() {
        const input = $('#chat_input');
        const message = input.val().trim();

        if (!message) return;

        // Add user message to chat
        addMessage(message, 'user');
        input.val('').trigger('input');

        // Store in history
        conversationHistory.push({ role: 'user', content: message });

        // Show typing indicator
        showTyping(true);

        // Send to backend
        processQuery(message);
    }

    function addMessage(content, type, isHtml = false, timestamp = null) {
        const messagesContainer = $('#chat_messages');
        const avatarIcon = type === 'user' ? 'fa-user' : 'fa-robot';

        // Format timestamp
        const now = timestamp ? new Date(timestamp) : new Date();
        const timeStr = now.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });
        const dateStr = now.toLocaleDateString('es-PE', { day: '2-digit', month: 'short' });

        let actionsHtml = '';
        if (type === 'user') {
            actionsHtml = `
                <button class="btn-save-question" data-question="${escapeHtml(content)}" title="Guardar como favorita">
                    <i class="fa fa-star"></i>
                </button>
            `;
        }

        const messageHtml = `
            <div class="message ${type}-message">
                <div class="message-avatar"><i class="fa ${avatarIcon}"></i></div>
                <div class="message-content">
                    ${isHtml ? content : `<p>${escapeHtml(content)}</p>`}
                    ${actionsHtml}
                    <span class="message-time">${dateStr} ${timeStr}</span>
                </div>
            </div>
        `;

        messagesContainer.append(messageHtml);
        scrollToBottom();
    }

    function showTyping(show) {
        if (show) {
            $('#typing_indicator').show();
            $('#btn_send').prop('disabled', true);
        } else {
            $('#typing_indicator').hide();
            $('#btn_send').prop('disabled', false);
        }
    }

    function scrollToBottom() {
        const container = document.getElementById('chat_messages');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    function clearChat() {
        // Clear on server
        $.ajax({
            url: CONFIG.conversacionUrl,
            method: 'DELETE',
            data: { _token: $('#token').val() },
            success: function () {
                console.log('Conversación limpiada en servidor');
            }
        });

        // Clear locally
        $('#chat_messages').html(`
            <div class="message bot-message">
                <div class="message-avatar"><i class="fa fa-robot"></i></div>
                <div class="message-content">
                    <p>Conversación reiniciada. ¿En qué puedo ayudarte?</p>
                </div>
            </div>
        `);
        conversationHistory = [];
        resetResultsPanel();
    }

    /**
     * Generate Automatic Insights ("Sorpréndeme")
     */
    function generateInsights() {
        // Get current time for timestamps
        const now = new Date();
        const timeStr = now.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });
        const dateStr = now.toLocaleDateString('es-PE', { day: '2-digit', month: 'short' });

        // Add user message to chat
        const userMessage = `
            <div class="message user-message">
                <div class="message-avatar"><i class="fa fa-user"></i></div>
                <div class="message-content">
                    <p>✨ Sorpréndeme con un análisis automático</p>
                    <span class="message-time">${dateStr} ${timeStr}</span>
                </div>
            </div>
        `;
        $('#chat_messages').append(userMessage);
        scrollToBottom();

        // Show typing indicator
        showTyping(true);
        $('#typing_indicator .typing-text').text('Analizando patrones...');

        // Call the insights API
        $.ajax({
            url: CONFIG.insightsUrl,
            method: 'GET',
            success: function (response) {
                showTyping(false);

                // Get response time
                const respNow = new Date();
                const respTimeStr = respNow.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });
                const respDateStr = respNow.toLocaleDateString('es-PE', { day: '2-digit', month: 'short' });

                if (response.success) {
                    // Add simplified bot response to chat
                    const botMessage = `
                        <div class="message bot-message">
                            <div class="message-avatar"><i class="fa fa-robot"></i></div>
                            <div class="message-content">
                                <p>✅ ¡Análisis completado! He encontrado información interesante en tus datos.</p>
                                <p class="text-muted" style="font-size: 11px; margin-top: 5px;">
                                    <i class="fa fa-arrow-right"></i> Revisa el <strong>Panel de Resultados</strong> a la derecha para ver los detalles completos.
                                </p>
                                <span class="message-time">${respDateStr} ${respTimeStr}</span>
                            </div>
                        </div>
                    `;
                    $('#chat_messages').append(botMessage);
                    scrollToBottom();

                    // Update results panel - pass wrapped response so updateResultsPanel finds .data
                    if (response.data) {
                        updateResultsPanel({ data: response.data, ai_mode: response.ai_mode, sql_ejecutado: response.sql_ejecutado });
                    }

                } else {
                    addBotMessage(response.message || 'Error al generar insights');
                }
            },
            error: function (xhr) {
                showTyping(false);
                let errorMsg = 'Error al conectar con el servidor';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                addBotMessage(`<p class="error-message">❌ ${errorMsg}</p>`);
            }
        });
    }


    /**
     * Load conversation history from server
     */
    function loadConversationHistory() {
        $.ajax({
            url: CONFIG.conversacionUrl,
            method: 'GET',
            success: function (response) {
                if (response.success && response.data && response.data.length > 0) {
                    // Clear welcome message
                    $('#chat_messages').empty();

                    // Add each message from history
                    response.data.forEach(function (msg) {
                        const type = msg.rol === 'user' ? 'user' : 'bot';
                        const isHtml = msg.rol === 'assistant';
                        addMessage(msg.mensaje, type, isHtml);
                    });

                    // Add a separator
                    $('#chat_messages').append(`
                        <div class="chat-separator">
                            <span>Conversación anterior cargada</span>
                        </div>
                    `);

                    scrollToBottom();
                    console.log('Conversación cargada:', response.data.length, 'mensajes');
                }
            },
            error: function (err) {
                console.log('No se pudo cargar historial de conversación');
            }
        });
    }

    // =========================================
    // API COMMUNICATION
    // =========================================
    function processQuery(question) {
        $.ajax({
            url: CONFIG.apiUrl,
            method: 'POST',
            data: {
                _token: $('#token').val(),
                question: question,
                context: conversationHistory.slice(-6) // Last 3 exchanges for context
            },
            success: function (response) {
                showTyping(false);

                if (response.success) {
                    // Add bot response to chat
                    addMessage(response.message, 'bot', true);

                    // Update results panel
                    if (response.data) {
                        updateResultsPanel(response);
                    }

                    // Store response in history
                    conversationHistory.push({ role: 'assistant', content: response.message });
                } else {
                    addMessage(response.message || 'No pude procesar tu consulta. Por favor, intenta reformularla.', 'bot');
                }
            },
            error: function (xhr) {
                showTyping(false);
                let errorMsg = 'Ocurrió un error al procesar tu consulta.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                addMessage(`<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ${errorMsg}</p>`, 'bot', true);
            }
        });
    }

    // =========================================
    // RESULTS PANEL
    // =========================================
    function updateResultsPanel(response) {
        const data = response.data;

        // Hide placeholder, show dynamic content
        $('#results_placeholder').hide();
        $('#results_dynamic').show();

        // Show AI mode indicator
        if (response.ai_mode) {
            const isClaudeAI = response.ai_mode.includes('Claude');
            const modeClass = isClaudeAI ? 'ai-mode-claude' : 'ai-mode-local';
            const modeIcon = isClaudeAI ? 'fa-brain' : 'fa-microchip';
            $('#ai_mode_badge').remove();
            const badge = `<div id="ai_mode_badge" class="ai-mode-badge ${modeClass}">
                <i class="fa ${modeIcon}"></i> ${response.ai_mode}
            </div>`;
            $('#context_bar').prepend(badge);
        }

        // Log SQL to console for debugging
        if (response.sql_ejecutado) {
            console.log('=== SQL EJECUTADO ===');
            console.log(response.sql_ejecutado);
            console.log('=====================');
        }

        // Update context bar
        if (data.periodo) {
            $('#ctx_periodo').text(data.periodo);
        }
        if (data.filtros) {
            $('#ctx_filtros').text(data.filtros);
        }

        // Update KPIs
        if (data.kpis && data.kpis.length > 0) {
            renderKPIs(data.kpis);
            lastKPIs = data.kpis; // Save for export
        } else {
            lastKPIs = [];
        }

        // Update Table
        if (data.tabla && data.tabla.length > 0) {
            renderTable(data.tabla, data.columnas);
        } else {
            // Show custom no-data message instead of hiding
            renderTable([], []);
        }

        // Update Chart
        if (data.chart) {
            renderChart(data.chart);
        } else {
            $('#chart_container').hide();
        }

        // Suggested questions
        if (data.sugerencias && data.sugerencias.length > 0) {
            renderSuggestions(data.sugerencias);
        } else {
            $('#suggested_questions').hide();
        }
    }

    function resetResultsPanel() {
        $('#results_placeholder').show();
        $('#results_dynamic').hide();
        $('#kpi_row').empty();
        $('#results_thead').empty();
        $('#results_tbody').empty();
        $('#suggestions_list').empty();

        if (resultsChart) {
            resultsChart.destroy();
            resultsChart = null;
        }
    }

    function renderKPIs(kpis) {
        const container = $('#kpi_row');
        container.empty();

        kpis.forEach(kpi => {
            const cardClass = kpi.tipo === 'positive' ? 'positive' : (kpi.tipo === 'negative' ? 'negative' : 'info');
            const html = `
                <div class="kpi-card ${cardClass}">
                    <div class="kpi-label">${escapeHtml(kpi.label)}</div>
                    <div class="kpi-value">${escapeHtml(kpi.value)}</div>
                    ${kpi.subtext ? `<div class="kpi-subtext">${escapeHtml(kpi.subtext)}</div>` : ''}
                </div>
            `;
            container.append(html);
        });
    }

    function renderTable(data, columns) {
        const thead = $('#results_thead');
        const tbody = $('#results_tbody');
        thead.empty();
        tbody.empty();

        // Show message if no data
        if (!data || data.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="10" class="no-data-message">
                        <i class="fa fa-info-circle"></i>
                        No se encontraron datos para los filtros aplicados.
                        <br><small>Intenta con otros criterios de búsqueda.</small>
                    </td>
                </tr>
            `);
            $('#table_container').show();
            return;
        }

        if (!columns || columns.length === 0) {
            columns = Object.keys(data[0] || {});
        }

        // Header
        let headerHtml = '<tr>';
        columns.forEach(col => {
            headerHtml += `<th>${escapeHtml(col)}</th>`;
        });
        headerHtml += '</tr>';
        thead.html(headerHtml);

        // Body
        data.slice(0, 15).forEach(row => {
            let rowHtml = '<tr>';
            columns.forEach(col => {
                let value = row[col] !== undefined ? row[col] : '';
                // Format numbers
                if (typeof value === 'number') {
                    value = formatNumber(value);
                }
                rowHtml += `<td>${escapeHtml(String(value))}</td>`;
            });
            rowHtml += '</tr>';
            tbody.append(rowHtml);
        });

        $('#table_container').show();
    }

    function renderChart(chartData) {
        const ctx = document.getElementById('results_chart');
        if (!ctx) return;

        if (resultsChart) {
            resultsChart.destroy();
        }

        resultsChart = new Chart(ctx.getContext('2d'), {
            type: chartData.type || 'bar',
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += formatNumber(context.parsed.y);
                                }
                                return label;
                            },
                            afterLabel: function () {
                                return '🖱️ Clic para ver detalle'; // Tip for user
                            }
                        }
                    }
                },
                onHover: (event, chartElement) => {
                    event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                },
                onClick: (event, elements, chart) => {
                    if (elements && elements.length > 0) {
                        const index = elements[0].index;
                        // Use chartData.labels as it corresponds to the tapped bar
                        const label = chartData.labels[index];
                        if (label) {
                            const question = `Ver detalle de ${label}`;
                            $('#chat_input').val(question);
                            sendMessage();
                        }
                    }
                },
                ...(chartData.options || {})
            }
        });

        $('#chart_container').show();
    }

    function renderSuggestions(suggestions) {
        const container = $('#suggestions_list');
        container.empty();

        suggestions.forEach(s => {
            container.append(`<button class="suggestion-btn">${escapeHtml(s)}</button>`);
        });

        $('#suggested_questions').show();
    }

    // =========================================
    // EXPORT
    // =========================================
    function exportResults() {
        const tableData = [];

        // 1. Add Report Metadata
        tableData.push(['REPORTE DE ASISTENTE ANALÍTICO']);
        tableData.push(['Fecha Generación:', new Date().toLocaleString('es-PE')]);
        tableData.push(['Usuario:', $('#usuario_nombre').val() || 'Usuario']);
        tableData.push([]); // Empty line

        // 2. Add KPIs (Summary)
        if (lastKPIs && lastKPIs.length > 0) {
            tableData.push(['RESUMEN (KPIs)']);
            const kpiLabels = lastKPIs.map(k => k.label);
            const kpiValues = lastKPIs.map(k => k.value);
            tableData.push(kpiLabels);
            tableData.push(kpiValues);
            tableData.push([]); // Empty line
        }

        // 3. Add Table Data
        tableData.push(['DETALLE DE DATOS']);
        const headers = [];
        $('#results_table thead th').each(function () {
            headers.push($(this).text());
        });
        tableData.push(headers);

        $('#results_table tbody tr').each(function () {
            const row = [];
            $(this).find('td').each(function () {
                row.push($(this).text());
            });
            tableData.push(row);
        });

        if (tableData.length <= 5) { // Adjusted check considering header rows
            alert('No hay datos suficientes para exportar.');
            return;
        }

        // Convert to CSV with proper Excel encoding (UTF-8 BOM)
        let csv = tableData.map(row =>
            row.map(cell => {
                if (!cell) return '';
                let strCell = String(cell);
                // Escape cells containing commas or quotes
                if (strCell.includes(',') || strCell.includes('"') || strCell.includes('\n')) {
                    return '"' + strCell.replace(/"/g, '""') + '"';
                }
                return strCell;
            }).join(',')
        ).join('\n');

        // Add BOM for Excel to recognize UTF-8
        const BOM = '\uFEFF';
        const blob = new Blob([BOM + csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `Asistente_Resultados_${new Date().toISOString().slice(0, 10)}.csv`;
        link.click();

        // Show success message
        addMessage('📊 Archivo exportado: Asistente_Resultados_' + new Date().toISOString().slice(0, 10) + '.csv', 'bot', false);
    }

    // =========================================
    // SAVED QUESTIONS
    // =========================================
    function loadSavedQuestions() {
        $.ajax({
            url: CONFIG.preguntasUrl,
            method: 'GET',
            success: function (response) {
                if (response.success && response.data && response.data.length > 0) {
                    const container = $('#saved_questions_list');
                    container.empty();

                    response.data.forEach(q => {
                        const html = `
                            <div class="saved-question-chip">
                                <span class="question-text">${escapeHtml(q.pregunta)}</span>
                                <span class="delete-question" data-id="${q.id}">&times;</span>
                            </div>
                        `;
                        container.append(html);
                    });

                    $('#saved_questions_container').show();
                } else {
                    $('#saved_questions_container').hide();
                }
            }
        });
    }

    function saveQuestion(question) {
        if (!question) return;

        console.log('Intentando guardar pregunta:', question);

        $.ajax({
            url: CONFIG.preguntasUrl,
            method: 'POST',
            data: {
                _token: $('#token').val(),
                pregunta: question
            },
            success: function (response) {
                console.log('Respuesta guardar:', response);
                if (response.success) {
                    // Mostrar mensaje de éxito en el chat
                    addMessage('⭐ Pregunta guardada exitosamente.', 'bot');

                    // Recargar la lista visual
                    loadSavedQuestions();
                } else {
                    addMessage('❌ No se pudo guardar: ' + response.message, 'bot');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error AJAX:', error);
                console.log('Respuesta:', xhr.responseText);

                let msg = 'Error de conexión.';
                if (xhr.status === 500) {
                    msg = 'Error interno (¿Creaste la tabla en BD?).';
                }
                addMessage('❌ Error al guardar pregunta: ' + msg, 'bot');
            }
        });
    }

    function deleteSavedQuestion(id) {
        $.ajax({
            url: CONFIG.preguntasUrl,
            method: 'DELETE',
            data: {
                _token: $('#token').val(),
                id: id
            },
            success: function (response) {
                if (response.success) {
                    loadSavedQuestions();
                }
            }
        });
    }

    // =========================================
    // EXPORT PDF
    // =========================================
    function exportToPDF() {
        if (typeof window.jspdf === 'undefined') {
            alert('Error: Librería PDF no cargada.');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        let yPos = 20;

        // 1. Header
        doc.setFontSize(16);
        doc.setTextColor(40);
        doc.text("REPORTE DE ASISTENTE ANALÍTICO", 14, yPos);
        yPos += 10;

        doc.setFontSize(10);
        doc.setTextColor(100);
        const fecha = new Date().toLocaleString('es-PE');
        const usuario = $('#usuario_nombre').val() || 'Usuario';
        doc.text(`Fecha: ${fecha}  |  Usuario: ${usuario}`, 14, yPos);
        yPos += 15;

        // 2. KPIs (Summary)
        if (lastKPIs && lastKPIs.length > 0) {
            doc.setFontSize(12);
            doc.setTextColor(0);
            doc.text("Resumen (KPIs)", 14, yPos);
            yPos += 5;

            const kpiHeaders = lastKPIs.map(k => k.label);
            const kpiValues = lastKPIs.map(k => k.value);

            doc.autoTable({
                startY: yPos,
                head: [kpiHeaders],
                body: [kpiValues],
                theme: 'grid',
                headStyles: { fillColor: [52, 144, 220], textColor: 255 }, // Blue header
                styles: { fontSize: 10, cellPadding: 4, halign: 'center' },
            });

            yPos = doc.lastAutoTable.finalY + 15;
        }

        // 3. Chart Diagram (New!)
        if (resultsChart) {
            try {
                const canvas = document.getElementById('results_chart');
                if (canvas) {
                    const canvasImg = canvas.toDataURL("image/png", 1.0);
                    doc.setFontSize(12);
                    doc.text("Visualización Gráfica", 14, yPos);
                    yPos += 5;

                    // Add image (x, y, width, height)
                    // A4 width is ~210mm. Margins 14mm. Usable ~180mm.
                    doc.addImage(canvasImg, 'PNG', 14, yPos, 180, 90);
                    yPos += 100; // 90mm height + 10mm padding
                }
            } catch (e) {
                console.error('Error adding chart to PDF', e);
            }
        }

        // Add new page if yPos is too low
        if (yPos > 250) {
            doc.addPage();
            yPos = 20;
        }

        // 4. Data Table
        const headers = [];
        $('#results_table thead th').each(function () { headers.push($(this).text()); });

        const rows = [];

        // Check if there is data
        if (headers.length === 0) {
            addMessage('⚠️ No hay datos para exportar.', 'bot');
            return;
        }

        $('#results_table tbody tr').each(function () {
            const row = [];
            $(this).find('td').each(function () { row.push($(this).text()); });
            rows.push(row);
        });

        doc.setFontSize(12);
        doc.setTextColor(0);
        doc.text("Detalle de Datos", 14, yPos);
        yPos += 5;

        doc.autoTable({
            startY: yPos,
            head: [headers],
            body: rows,
            theme: 'striped',
            headStyles: { fillColor: [71, 85, 105] }, // Dark slate
            styles: { fontSize: 8 },
            alternateRowStyles: { fillColor: [248, 250, 252] }
        });

        // Save
        const filename = `Reporte_Asistente_${new Date().toISOString().slice(0, 10)}.pdf`;
        doc.save(filename);

        addMessage('📑 PDF generado exitosamente: ' + filename, 'bot', false);
    }

    // =========================================
    // UTILITIES
    // =========================================
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    function formatNumber(num) {
        if (num === null || num === undefined || isNaN(num)) return '0';
        return parseFloat(num).toLocaleString('es-PE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

})(jQuery);
