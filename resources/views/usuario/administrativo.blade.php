@if($trol->UC=='OC' || $trol->UC==NULL)
	@include('usuario.dashboard.ordencompra')
@endif

@if($trol->UC=='CT' || $trol->UC==NULL)
	@include('usuario.dashboard.contrato')
@endif
