@extends('template_lateral')
@section('style')
    <link href="{{ url('/') }}/public/css/analisis/asistente.css?v={{ $version }}" rel="stylesheet" />
@endsection
@section('section')
    <div class="be-content contenido">
        <div class="main-content container-fluid">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="idopcion" id="idopcion" value="{{ $idopcion }}">

            <div class="assistant-container">
                <!-- Left Panel: Chat -->
                <div class="chat-panel">
                    <div class="chat-header">
                        <div class="assistant-avatar">
                            <i class="fa fa-robot"></i>
                        </div>
                        <div class="assistant-info">
                            <h4>Asistente Analítico</h4>
                            <span class="status-online"><i class="fa fa-circle"></i> En línea</span>
                        </div>
                        <div class="chat-actions">
                            <button class="btn-insights" id="btn_insights" title="Sorpréndeme con insights">
                                <i class="fa fa-magic"></i> Sorpréndeme
                            </button>
                            <button class="btn-clear-chat" id="btn_clear_chat" title="Nueva conversación">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>

                    <div class="chat-messages" id="chat_messages">
                        <!-- Welcome Message -->
                        <div class="message bot-message">
                            <div class="message-avatar"><i class="fa fa-robot"></i></div>
                            <div class="message-content">
                                <p>¡Hola! Soy tu <strong>Asistente Analítico de Liquidación de Gastos</strong>.</p>
                                <p>Puedo ayudarte a consultar información financiera y operativa usando lenguaje natural.
                                    Algunos
                                    ejemplos de lo que puedes preguntarme:</p>
                                <ul class="suggestion-list">
                                    <li><a href="#" class="quick-question">¿Cuánto se gastó en el último trimestre?</a></li>
                                    <li><a href="#" class="quick-question">¿Cuáles son los 5 proveedores con mayor
                                            facturación este
                                            año?</a></li>
                                    <li><a href="#" class="quick-question">¿Qué áreas tienen más liquidaciones
                                            pendientes?</a></li>
                                    <li><a href="#" class="quick-question">Comparar gasto de enero vs febrero 2024</a></li>
                                    <li><a href="#" class="quick-question">¿Quién autorizó más gastos este mes?</a></li>
                                </ul>
                                <p class="text-muted" style="font-size: 11px; margin-top: 10px;">
                                    <i class="fa fa-shield"></i> Todas mis respuestas provienen directamente de la base de
                                    datos. No
                                    invento información.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="chat-input-container">
                        <div class="typing-indicator" id="typing_indicator" style="display: none;">
                            <span></span><span></span><span></span>
                            <span class="typing-text">Analizando datos...</span>
                        </div>
                        <div class="chat-input-wrapper">
                            <textarea id="chat_input"
                                placeholder="Escribe tu consulta aquí... (Ej: ¿Cuánto gastamos en febrero?)"
                                rows="1"></textarea>
                            <button class="btn-send" id="btn_send">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Results -->
                <div class="results-panel">
                    <div class="results-header">
                        <h4><i class="fa fa-chart-bar"></i> Panel de Resultados</h4>
                        <div class="results-actions">
                            <button class="btn-export" id="btn_export_results" title="Exportar resultados">
                                <i class="fa fa-download"></i> Exportar
                            </button>
                        </div>
                    </div>

                    <div class="results-content" id="results_content">
                        <!-- Initial State -->
                        <div class="results-placeholder" id="results_placeholder">
                            <div class="placeholder-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <h5>Esperando tu consulta</h5>
                            <p>Los resultados de tus preguntas aparecerán aquí con:</p>
                            <div class="feature-list">
                                <div class="feature-item">
                                    <i class="fa fa-tachometer-alt"></i>
                                    <span>KPIs principales</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fa fa-table"></i>
                                    <span>Tablas de datos</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fa fa-chart-pie"></i>
                                    <span>Gráficos analíticos</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fa fa-filter"></i>
                                    <span>Filtros aplicados</span>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Results Container -->
                        <div class="results-dynamic" id="results_dynamic" style="display: none;">
                            <!-- Context Bar -->
                            <div class="context-bar" id="context_bar">
                                <div class="context-item">
                                    <i class="fa fa-calendar"></i>
                                    <span id="ctx_periodo">-</span>
                                </div>
                                <div class="context-item">
                                    <i class="fa fa-filter"></i>
                                    <span id="ctx_filtros">Sin filtros</span>
                                </div>
                                <div class="context-item ml-auto">
                                    <button type="button" id="btn_export_pdf" class="btn-export pdf-mode">
                                        <i class="fa fa-file-pdf"></i> Descargar Reporte PDF
                                    </button>
                                </div>
                            </div>

                            <!-- KPI Cards -->
                            <div class="kpi-row" id="kpi_row">
                                <!-- Dynamic KPIs will be inserted here -->
                            </div>

                            <!-- Data Table -->
                            <div class="results-table-container" id="table_container" style="display: none;">
                                <div class="table-header-row">
                                    <h5><i class="fa fa-table"></i> Detalle de Datos</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="results_table">
                                        <thead id="results_thead"></thead>
                                        <tbody id="results_tbody"></tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Chart Container -->
                            <div class="results-chart-container" id="chart_container" style="display: none;">
                                <h5><i class="fa fa-chart-bar"></i> Visualización</h5>
                                <div style="height: 300px;">
                                    <canvas id="results_chart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Saved Questions (Always visible if exists) -->
                        <div class="saved-questions-container" id="saved_questions_container" style="display: none;">
                            <h6><i class="fa fa-star text-warning"></i> Mis Preguntas Frecuentes</h6>
                            <div class="saved-questions-list" id="saved_questions_list">
                                <!-- Dynamic content -->
                            </div>
                        </div>

                        <!-- Suggested Questions -->
                        <div class="suggested-questions" id="suggested_questions" style="display: none;">
                            <h6><i class="fa fa-lightbulb"></i> Preguntas sugeridas para profundizar:</h6>
                            <div class="suggestions-list" id="suggestions_list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script src="{{ url('/') }}/public/js/analisis/asistenteliquidaciongasto.js?v={{ $version }}"></script>
@endsection