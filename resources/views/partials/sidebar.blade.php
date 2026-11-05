<div class="sidebar-area" id="sidebar-area" style="display: flex; flex-direction: column;">
	<div class="logo position-relative d-flex justify-content-center align-items-center"
		style="min-height: 75px; padding: 15px 0; flex-shrink: 0;">
		<a href="{{ url('/') }}" class="d-block text-decoration-none text-center w-100"
			title="{{ Session::get('empresa')->nombre ?? 'INVOXA' }}">
			@if(Session::get('empresa') && Session::get('empresa')->logo)
				{{-- Logo personalizado del cliente --}}
				<img src="{{ asset('storage/' . Session::get('empresa')->logo) }}" alt="logo-empresa"
					style="max-height: 170px; max-width: 90%; object-fit: contain; margin: 0 auto; transition: all 0.3s;">
			@else
				{{-- Nombre de empresa elegante --}}
				@php
					$empresaNombre = Session::get('empresa')->nombre ?? 'INVOXA';
					$iniciales = collect(explode(' ', $empresaNombre))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode('');
				@endphp
				<div style="display:flex; flex-direction:column; align-items:center; gap:8px; padding: 4px 12px;">
					{{-- Avatar con iniciales --}}
					<div style="
						width: 52px; height: 52px;
						border-radius: 14px;
						background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
						display: flex; align-items: center; justify-content: center;
						box-shadow: 0 4px 15px rgba(99,102,241,0.4);
						flex-shrink: 0;
					">
						<span style="color:#fff; font-size:18px; font-weight:700; letter-spacing:1px; line-height:1;">
							{{ $iniciales }}
						</span>
					</div>
					{{-- Nombre empresa --}}
					<div style="text-align:center;">
						<div style="
						font-size: 12.5px;
						font-weight: 700;
						color: #1e293b;
						line-height: 1.4;
						word-break: break-word;
						white-space: normal;
						letter-spacing: 0.3px;
					" title="{{ $empresaNombre }}">
						{{ $empresaNombre }}
					</div>
						<div style="font-size:10px; color:#059669; font-weight:600; margin-top:2px; letter-spacing:0.5px;">
							GESTIÓN DE LOTES
						</div>
					</div>
				</div>
			@endif
			{{-- Mantenemos la clase por si la plantilla la busca para animaciones, pero oculta visualmente --}}
			<span class="logo-text d-none"></span>
		</a>
		<button
			class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y"
			id="sidebar-burger-menu">
			<i data-feather="x"></i>
		</button>
	</div>

	{{-- Widget del Usuario Logueado --}}
	@if(Session::has('usuario'))
	<div class="user-profile-sidebar py-3 px-4 d-flex align-items-center gap-3" style="border-bottom: 1px dashed rgba(0,0,0,0.1); background-color: rgba(0,0,0,0.01); flex-shrink: 0;">
		<div class="user-avatar-initials d-flex align-items-center justify-content-center text-white fw-bold" 
			 style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); font-size: 13px; box-shadow: 0 2px 8px rgba(16,185,129,0.3); flex-shrink: 0;">
			{{ strtoupper(substr(Session::get('usuario')->nombre, 0, 2)) }}
		</div>
		<div style="min-width: 0; flex: 1;">
			<h6 style="margin: 0; font-size: 13px; font-weight: 700; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ Session::get('usuario')->nombre }}">
				{{ Session::get('usuario')->nombre }}
			</h6>
			<span style="font-size: 11px; color: #64748b; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
				<span class="material-symbols-outlined" style="font-size: 13px;">account_circle</span>
				{{ Session::get('usuario')->name }}
			</span>
		</div>
	</div>
	@endif

	<aside id="layout-menu" class="layout-menu menu-vertical menu active"
		style="flex: 1 1 auto; overflow-y: auto; min-height: 0;">
		<ul class="menu-inner">

			{{-- EL NOMBRE DE LA EMPRESA AQUÍ (Otro lado, elegante y seguro) --}}
			@php
				$_empConf = Session::get('empresa') ? (is_array(Session::get('empresa')->configuracion)
					? Session::get('empresa')->configuracion
					: json_decode(Session::get('empresa')->configuracion ?? '{}', true))
					: [];
				$_esHolding = isset($_empConf['holding_importador']['activo']) && !empty($_empConf['holding_importador']['activo']);
			@endphp
			<li class="menu-title small text-uppercase mt-2 pb-2 mb-2"
				style="border-bottom: 1px dashed rgba(0,0,0,0.1);">
				<span class="menu-title-text"
					style="display: flex; align-items: center; justify-content: center;">
					@if($_esHolding)
						<span style="
							display: inline-flex; align-items: center; gap: 3px;
							background: linear-gradient(135deg, #6366f1, #8b5cf6);
							color: #fff;
							font-size: 9px;
							font-weight: 700;
							letter-spacing: 0.6px;
							padding: 2px 10px;
							border-radius: 20px;
							text-transform: uppercase;
							box-shadow: 0 2px 6px rgba(99,102,241,0.35);
						">
							<i class="material-symbols-outlined" style="font-size:11px;">hub</i>
							HOLDING
						</span>
					@else
						<span style="
							display: inline-flex; align-items: center; gap: 3px;
							background: #e2e8f0;
							color: #64748b;
							font-size: 9px;
							font-weight: 600;
							letter-spacing: 0.5px;
							padding: 2px 10px;
							border-radius: 20px;
							text-transform: uppercase;
						">
							<i class="material-symbols-outlined" style="font-size:11px;">store</i>
							SIMPLE
						</span>
					@endif
				</span>
			</li>

			<li class="menu-title small text-uppercase">
				<span class="menu-title-text">MAIN</span>
			</li>


			<li class="menu-item">
				<a href="{{ route('login') }}" class="menu-link active">
					<span class="material-symbols-outlined menu-icon">dashboard</span>
					<span class="title">Inicio</span>
				</a>
			</li>

			<li class="menu-title small text-uppercase">
				<span class="menu-title-text">OPCIONES</span>
			</li>

			@foreach(Session::get('listamenu', []) as $grupo)
				<li class="menu-item">
					<a href="javascript:void(0);" class="menu-link menu-toggle">
						<span class="material-symbols-outlined menu-icon">{{ $grupo->icono }}</span>
						<span class="title">{{$grupo->nombre}}</span>
					</a>
					<ul class="menu-sub">
						@php
							$opcionesAutorizadas = \App\Models\Opcion::join('rolopciones', 'rolopciones.opcion_id', '=', 'opciones.id')
								->where('opciones.grupoopcion_id', $grupo->id)
								->where('rolopciones.rol_id', Session::get('usuario')->rol_id)
								->where('rolopciones.ver', 1)
								->orderBy('opciones.orden', 'asc')
								->select('opciones.*')
								->get();
						@endphp
						@foreach($opcionesAutorizadas as $opcion)
							<li class="menu-item opcmenu">
								<a href="{{ url('/' . $opcion->pagina . '/' . Hashids::encode(substr($opcion->id, -8))) }}"
									class="menu-link">
									{{$opcion->nombre}}
								</a>
							</li>
						@endforeach
					</ul>
				</li>
			@endforeach

			@if(session('usuario') && (session('usuario')->id === '1CIX00000001' || session('usuario')->rol_id === '1CIX00000001'))
				<li class="menu-title small text-uppercase">
					<span class="menu-title-text">SUPER ADMIN</span>
				</li>
				<li class="menu-item">
					<a href="javascript:void(0);" class="menu-link menu-toggle">
						<span class="material-symbols-outlined menu-icon">settings_applications</span>
						<span class="title">Config. Sistema</span>
					</a>
					<ul class="menu-sub">
						<li class="menu-item">
							<a href="{{ route('superadmin.grupo_opciones') }}" class="menu-link">
								Grupos de Opciones
							</a>
						</li>
						<li class="menu-item">
							<a href="{{ route('superadmin.opciones') }}" class="menu-link">
								Opciones del Menú
							</a>
						</li>
						<li class="menu-item">
							<a href="{{ route('superadmin.limpiar_bd') }}" class="menu-link">
								Limpieza de BD
							</a>
						</li>
					</ul>
				</li>
			@endif

			<li class="menu-item">
				<a href="{{ url('cerrarsession') }}" class="menu-link logout">
					<span class="material-symbols-outlined menu-icon">logout</span>
					<span class="title">Salir</span>
				</a>
			</li>
		</ul>
	</aside>
</div>