@php
	$hasError = $errors->has($name ?? '');
	$fieldName = strtolower($name ?? '');
	if (!isset($icon) || empty($icon)) {
		if (str_contains($fieldName, 'email') || str_contains($fieldName, 'correo')) {
			$icon = 'ri-mail-line';
		} elseif (str_contains($fieldName, 'pass') || str_contains($fieldName, 'clave')) {
			$icon = 'ri-lock-line';
		} elseif (str_contains($fieldName, 'tel') || str_contains($fieldName, 'cel')) {
			$icon = 'ri-phone-line';
		} elseif (str_contains($fieldName, 'url') || str_contains($fieldName, 'pagina') || str_contains($fieldName, 'link')) {
			$icon = 'ri-link';
		} elseif (str_contains($fieldName, 'desc')) {
			$icon = 'ri-file-text-line';
		} elseif (str_contains($fieldName, 'icono')) {
			$icon = 'ri-remixicon-line';
		} elseif (str_contains($fieldName, 'orden')) {
			$icon = 'ri-sort-asc';
		} elseif (str_contains($fieldName, 'nom') || str_contains($fieldName, 'user')) {
			$icon = 'ri-user-line';
		} else {
			$icon = 'ri-edit-line';
		}
	}
@endphp

<div class="col-lg-{{ $col??'6' }}">
	<div class="form-group mb-4">
		<label class="label text-secondary">{{ $label ?? 'Campo' }} @if($required ?? '') <span class="text-danger">*</span> @endif</label>
		<div class="form-group position-relative input-icon-wrapper">
			<input 
				type="{{ $type?? 'text' }}" 
				id="{{ $name ?? 'campo' }}" 
				name="{{ $name ?? 'campo' }}" 
				class="form-control text-dark ps-5 h-55"
				value="{{ $value ?? '' }}"
				placeholder="{{ $placeholder ?? 'Ingrese el campo' }}"
				{{ $disabled ?? '' }}
				{{ $required ?? '' }}
			>
			<i class="{{ $icon }} position-absolute top-50 start-0 translate-middle-y fs-20 ps-20 text-muted input-icon" style="z-index: 10; pointer-events: none;"></i>

			@if($hasError)
				<div class="invalid-feedback d-block">
					{{ $errors->first($name) }}
				</div>
			@endif
		
		</div>
	</div>
</div>