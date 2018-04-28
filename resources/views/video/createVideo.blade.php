@extends("layouts.app")
@section('title', 'Subir vídeo')
@section("content")
<div class="container">
	<div class="row">
		<h2 class="col-lg-12">Crear un nuevo vídeo</h2>
		<form action="{{ route("saveVideo") }}" method="post" enctype="multipart/form-data" class="col-lg-7">
			@csrf

			@if($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<div class="form-group">
				<label for="title">Título: </label>
				<input type="text" name="title" class="form-control" placeholder="Título que mostrará al mundo su vídeo" value="{{ old('title') }}" />
			</div>

			<div class="form-group">
				<label for="description">Descripción: </label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Introduzca una breve descripción para su video">{{ old('description') }}</textarea>
			</div>

			<div class="form-group">
				<label for="image">Miniatura: </label>
				<input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}" />
			</div>

			<div class="form-group">
				<label for="video">Archivo de vídeo: </label>
				<input type="file" class="form-control" id="video" name="video" value="{{ old('video') }}" />
			</div>
			<div class="form-group">
				<button type="submit" name="crearvideo" class="btn btn-primary btn-success">Crear video</button>
			</div>
		</form>
	</div>
</div>
@endsection