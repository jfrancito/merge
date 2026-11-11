<div class="panel-heading panel-heading-divider" style="border:0px;">Cliente
		<span class="panel-subtitle">{{$precotizacion->cliente_nombre}}</span>
</div>

<div class="panel-heading panel-heading-divider" style="border:0px;">Descripcion
		<span class="panel-subtitle">{{$precotizacion->descripcion}}</span>
</div>

<div class="row" style="padding-bottom:300px;">
<div class="be">
	<div class="main-content container-fluid">
	  <div class="gallery-container" >
	    @foreach($listaimagenes as $index => $item)
		    <div class="item" style="top:50px !important;">
		      <div class="photo">
		        <div class="img" style="position: relative !important;object-fit: cover;"><img src="{{ asset('/storage/app/'.$item->nombre_archivo)}}" alt="Gallery Image">
		          <div class="over">
		            <div class="info-wrapper">
		              <div class="info">
		                <div class="func" style="position: absolute;right: -117px;">

		                	<a href="{{ asset('/storage/app/'.$item->nombre_archivo)}}" target="_blank" class="image-zoom">
		                	<i class="icon mdi mdi-search"></i></a>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>                 
	    @endforeach
	  </div>
	</div>
</div>	
</div>