<div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #2563eb 100%); color: #ffffff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #ffffff; opacity: 0.85; font-size: 26px; font-weight: 300;">&times;</button>
    <h4 class="modal-title" style="font-weight: 700; font-size: 17px; display: flex; align-items: center; gap: 8px; margin: 0; color: #ffffff;">
        <i class="fa fa-link" style="color: #93c5fd;"></i> ASOCIAR COTIZACIÓN A ORDEN DE COMPRA
    </h4>
</div>

<div class="modal-body" style="padding: 24px; background: #f8fafc;">
    <!-- Resumen de la Cotización Seleccionada -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">Cotización</span>
                <div style="font-size: 15px; font-weight: 700; color: #1e3a8a;">
                    <i class="fa fa-hashtag text-muted"></i> {{ $cotizacion->ID_COTIZACION }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">Proveedor</span>
                <div style="font-size: 13.5px; font-weight: 600; color: #1e293b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <i class="fa fa-building-o text-muted"></i> {{ $cotizacion->NOM_EMPR_PROVEEDOR }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">Total Cotización</span>
                <div style="font-size: 15px; font-weight: 700; color: #059669;">
                    {{ $cotizacion->TXT_CATEGORIA_MONEDA }} {{ number_format((float) $cotizacion->CAN_TOTAL, 2, '.', ',') }}
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
        <span style="font-size: 13px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.4px;">
            <i class="fa fa-list-alt text-primary"></i> Órdenes de Compra Disponibles para la Empresa y Centro
        </span>
        <span class="badge" style="background: #e0e7ff; color: #1e40af; font-weight: 700; padding: 4px 10px; border-radius: 12px;">
            {{ count($lista_ordenes) }} resultado(s)
        </span>
    </div>

    <!-- Tabla de Órdenes de Compra -->
    <div class="table-responsive" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; max-height: 380px; overflow-y: auto;">
        <table id="tabla_modal_asociar_oc" class="table table-hover table-striped" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; font-weight: 700;">
                    <th class="text-center" style="width: 45px; vertical-align: middle;">#</th>
                    <th class="text-center" style="vertical-align: middle;">COD ORDEN</th>
                    <th class="text-center" style="vertical-align: middle;">FEC ORDEN</th>
                    <th class="text-left" style="vertical-align: middle;">PRODUCTO ORDEN</th>
                    <th class="text-center" style="width: 130px; vertical-align: middle;">ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lista_ordenes as $idx => $ord)
                    <tr style="vertical-align: middle;">
                        <td class="text-center" style="color: #64748b; font-weight: 600; vertical-align: middle;">
                            {{ $idx + 1 }}
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-weight: 700; font-size: 12px; border: 1px solid #bfdbfe; padding: 4px 8px; border-radius: 6px;">
                                <i class="fa fa-file-text-o mr-1"></i> {{ $ord->COD_ORDEN }}
                            </span>
                        </td>
                        <td class="text-center" style="vertical-align: middle; color: #334155; font-weight: 600;">
                            <i class="fa fa-calendar-o text-muted mr-1"></i>
                            {{ !empty($ord->FEC_ORDEN) ? date('d-m-Y', strtotime($ord->FEC_ORDEN)) : '-' }}
                        </td>
                        <td class="text-left" style="vertical-align: middle; color: #1e293b; font-weight: 500;">
                            <i class="fa fa-cube text-muted mr-1"></i>
                            {{ $ord->PRODUCTO_ORDEN }}
                            <small class="text-muted" style="display: block; font-size: 11px;">Código: {{ $ord->COD_PRODUCTO }}</small>
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <button type="button" 
                                    class="btn btn-xs btn-primary btn-confirmar-asociar-oc"
                                    data-cotizacion="{{ $cotizacion->ID_COTIZACION }}"
                                    data-orden="{{ $ord->COD_ORDEN }}"
                                    style="border-radius: 6px; font-weight: 700; padding: 6px 12px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none; box-shadow: 0 2px 6px rgba(37,99,235,0.3);">
                                <i class="fa fa-check"></i> ASOCIAR
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 40px 15px; color: #64748b;">
                            <i class="fa fa-info-circle fa-3x" style="color: #94a3b8; margin-bottom: 10px;"></i>
                            <h5 style="color: #475569; font-weight: 600;">No se encontraron Órdenes de Compra para asociar</h5>
                            <p class="text-muted" style="font-size: 12.5px;">No existen órdenes de compra registradas con los productos de esta cotización para su centro y empresa.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer" style="padding: 15px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 7px 18px;">
        <i class="fa fa-times mr-1"></i> Cerrar
    </button>
</div>
