<div class="col-lg-{{ $col }}">
    <div class="form-group mb-4">

        <label class="label text-secondary d-block mb-2">
            {{ $label }}
        </label>

        {{-- Input oculto para forzar envío de 0 si no está marcado --}}
        <input type="hidden" name="{{ $name }}" value="0">

        <div class="form-check form-switch">
            <input 
                class="form-check-input @error($name) is-invalid @enderror"
                type="checkbox"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                {{ old($name, $checked) ? 'checked' : '' }}
                {{ $disabled ? 'disabled' : '' }}
            >

            <label class="form-check-label" for="{{ $name }}">
                {{ old($name, $checked) ? 'SI' : 'NO' }}
            </label>
        </div>

        {{-- ERROR DE VALIDACIÓN --}}
        @error($name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

    </div>
</div>
