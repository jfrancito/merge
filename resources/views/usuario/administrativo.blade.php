@if($trol->UC=='OC' || $trol->UC==NULL)
	@include('usuario.dashboard.ordencompra')
@endif

@if($trol->UC=='CT' || $trol->UC==NULL)
	@include('usuario.dashboard.contrato')
@endif

@if($trol->UC=='ES' || $trol->UC==NULL)
	@include('usuario.dashboard.estiba')
@endif