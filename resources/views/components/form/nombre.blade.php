<div class="col-lg-6">
    <div class="form-group mb-4">

        <label class="form-label text-secondary">{{ $label ?? 'Nombre' }}</label>
        <div class="form-group position-relative">
            <input 
                type="text" 
                name="{{ $name ?? 'nombre' }}" 
                class="form-control text-dark ps-5 h-55" 
                value="{{ $value ?? '' }}"
                placeholder="{{ $placeholder ?? 'Ingrese el nombre' }}"
            >
            <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
        </div>
    </div>
</div>
