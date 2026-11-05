@props([
    'name',          // nombre del campo
    'value' => 0,    // 0 o 1
    'label' => '',   // texto descriptivo
    'id' => null,    // id único
])

@php
    $id = $id ?? 'bandera_' . uniqid();
@endphp

<div class="col-lg-{{ $col??'6' }}">
    <div class="form-group mb-4">
            @if($label)
            <label 
                class="form-check-label cursor-pointer ms-2"
                for="{{ $id }}"
            >
                {{ $label }}
            </label>
            @endif

        <div class="form-check form-switch d-flex justify-content-center">
            <input 
                type="checkbox"
                class="form-check-input cursor-pointer"
                id="{{ $id }}"
                name="{{ $name }}"
                role="switch"
                style="width: 2.5rem; height: 1.25rem;"
                {{ $value == 1 ? 'checked' : '' }}
            >

        </div>
    </div>
</div>