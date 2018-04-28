@extends("layouts.app")
@section('title', 'Editar vídeo')
@section("content")
<div class="container">
	<div class="row">
		<h2 class="col-lg-12">Editando: {{ $video->title }}</h2>
		<form action="{{ route("updateVideo", $video->id) }}" method="post" enctype="multipart/form-data" class="col-lg-7">
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
				<label for="title">Título actual: </label>
				<input type="text" name="title" class="form-control" placeholder="Título que mostrará al mundo su vídeo" value="{{ $video->title }}" />
			</div>

			<div class="form-group">
				<label for="description">Descripción actual: </label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Introduzca una breve descripción para su video">{{ $video->description }}</textarea>
			</div>

			<div class="form-group">
				<label for="image">Miniatura actual: </label>
				<input type="file" class="form-control" id="image" name="image" />
				<img src="{{ route('imageVideo',$video->image) }}" class="img-thumbnail"/>
			</div>

			<div class="form-group">
				<label for="video">Archivo de vídeo actual: </label>
				<input type="file" class="form-control" id="video" name="video" />
				<video controls id="video-player" style="max-width:100%">
					<source src="{{ route('fileVideo', $video->video_path) }}">
					Tu navegador no soporta HTML5
				</video>
			</div>
			<div class="form-group">
				<button type="submit" name="editarvideo" class="btn btn-primary btn-success">Editar video</button>
			</div>
		</form>
	</div>
</div>
@endsection