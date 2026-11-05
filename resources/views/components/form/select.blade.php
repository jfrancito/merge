@php
	$fieldName = strtolower($name ?? '');
	if (!isset($icon) || empty($icon)) {
		if (str_contains($fieldName, 'rol')) {
			$icon = 'ri-shield-user-line';
		} elseif (str_contains($fieldName, 'grupo')) {
			$icon = 'ri-folder-settings-line';
		} elseif (str_contains($fieldName, 'estado') || str_contains($fieldName, 'activo')) {
			$icon = 'ri-checkbox-circle-line';
		} elseif (str_contains($fieldName, 'proy')) {
			$icon = 'ri-building-line';
		} elseif (str_contains($fieldName, 'manz') || str_contains($fieldName, 'mz')) {
			$icon = 'ri-community-line';
		} elseif (str_contains($fieldName, 'lote')) {
			$icon = 'ri-map-pin-range-line';
		} elseif (str_contains($fieldName, 'client')) {
			$icon = 'ri-user-line';
		} else {
			$icon = 'ri-list-check';
		}
	}
@endphp

<div class="col-lg-{{ $col }}">
	<div class="form-group mb-4">
		<label class="label text-secondary">{{ $label }} @if($required ?? '') <span class="text-danger">*</span> @endif</label>
		<div class="form-group position-relative input-icon-wrapper">
			<select 
				name="{{ $name }}" 
				id="{{ $id ?? 'selectcampo' }}"
				class="form-select form-control ps-5 h-55 custom-select-{{ $name }}"
				data-placeholder="Seleccione una opción"
				{{ $required ?? '' }}
			>
				@foreach($options as $key => $text)
					<option 
						value="{{ $key }}" 
						{{ $value == $key ? 'selected' : '' }}
					>
						{{ $text }}
					</option>
				@endforeach
			</select>
			<i class="{{ $icon }} position-absolute top-50 start-0 translate-middle-y fs-20 ps-20 text-muted input-icon" style="z-index: 10; pointer-events: none;"></i>
		</div>
	</div>
</div>

{{-- <div class="col-lg-{{ $col ?? 6 }}">
    <div class="form-group mb-4">
        <label class="label text-secondary">{{ $label }}</label>

        <div class="form-group position-relative">
            <select 
                name="{{ $name }}"
                class="form-select form-control ps-5 h-55 {{ $class ?? '' }}"
            >
                @foreach($options as $key => $text)
                    <option value="{{ $key }}" {{ ($value == $key) ? 'selected' : '' }}>
                        {{ $text }}
                    </option>
                @endforeach
            </select>

            @if($icon)
                <i class="{{ $icon }} position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
            @endif
        </div>
    </div>
</div> --}}

{{-- 	<div class="col-lg-{{ $col }}">
		<div class="form-group mb-4">
			<label class="label text-secondary">{{ $label }}</label>
			<div class="form-group position-relative">
				<select 
					name="{{ $name }}" 
					class="form-select form-control ps-5 h-55 select2-input text-dark input-lg"
				>
					@foreach($options as $key => $text)
						<option 
							value="{{ $key }}" 
							{{ $value == $key ? 'selected' : '' }}
						>
							{{ $text }}
						</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
 --}}