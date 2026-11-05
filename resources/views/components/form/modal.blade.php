<div>
	{{-- BOTON --}}
	<button 
			type="button" 
			class="btn btn-primary text-white py-2 px-4 fw-semibold" 
			data-bs-toggle="modal" 
			data-bs-target="#{{ $modal_id ?? 'idModal' }}"
			>
		{{ $btn_modal_lbl ?? 'Abrir Modal' }}
	</button>
	
	
	{{-- MODAL --}}
	{{-- 
		''		 --small
		modal-lg --large
		modal-xl --extra large 
	--}}
	<div 	
			class="modal fade" 
			id="{{ $modal_id ?? 'idModal' }}" 
			data-bs-backdrop="static" 
			data-bs-keyboard="false" 
			tabindex="-1" 
			aria-labelledby="{{ $modal_id ?? 'idModal' }}Label" 
			style="display: none;" 
			aria-hidden="true"
			>
		<div class="modal-dialog modal-dialog-scrollable {{ $modal_large ?? 'modal-xl' }}">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="{{ $modal_id ?? 'idModal' }}Label">{{ $modal_title ??'Titulo Modal' }}</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">

					<form action="#" method="{{ $form_method ?? 'POST'}}" name ="{{ $form_name ?? 'nameForm'}}" id="{{ $form_id ?? 'idForm' }}">
						Hello Modal Scrolling 
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">{{ $lbl_btn_cancel ?? 'Cancelar' }}</button>
					<button type="button" class="btn btn-primary text-white">{{ $lbl_btn_accept ?? 'Aceptar' }}</button>
				</div>
			</div>
		</div>
	</div>

</div>