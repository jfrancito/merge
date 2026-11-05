
<div class="col-lg-{{ $col??'6' }}">
	<div class="form-group mb-4">
		<label class="label text-secondary">{{ $label ?? 'Icono' }}</label>
		<div class="form-group position-relative cuadradoredondo">
			<span 
				class="material-symbols-outlined menu-icon"
				id="{{ $name ?? 'icono' }}" 
				name="{{ $name ?? 'icono' }}" 
				{{ $disabled ?? '' }}
			>{{ $value ?? '' }}</span>
		</div>
	</div>
</div>

<style>
	{{-- .cuadradoredondo{
		border-radius: 5px;
		border: solid 1px black;
		padding: 8px;
		width: 48px;
		height: 48px;
	} --}}
	.cuadradoredondo {
		width: 52px;
		height: 52px;
		padding: 6px;

		display: flex;
		justify-content: center;
		align-items: center;

		border-radius: 10px;
		border: 1px solid rgba(0, 0, 0, 0.15);

		background: #ffffff;
		box-shadow: 
			0 2px 6px rgba(0, 0, 0, 0.08),
			0 1px 3px rgba(0, 0, 0, 0.05);

		transition: all 0.2s ease-in-out;
	}

</style>


