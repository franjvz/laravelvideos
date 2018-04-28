@extends("layouts.app")
@section('title', 'Ver video')
@section("content")	
	<div class="row">
		<div class="col col-md-10">
			<h2>{{ $video->title }}</h2>
			<div class="card">
				<ul class="list-group list-group-flush">
					<li class="list-group-item">		
						<!-- Video player -->
						<video controls id="video-player">
							<source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}">
							Tu navegador no soporta HTML5
						</video>
					</li>
					<!-- Hora en formato amigable -->
					<li class="list-group-item">
						<h4><a href="{{ route('channelUser', $video->user->id) }}" title="Visitar canal">{{ $video->user->name." ".$video->user->surname }}</a> <small>{{ $video->created_at->diffForHumans() }}</small></h4>
					</li>
					<!-- Descripcion -->
					<li class="list-group-item">
						{{ $video->description }}
					</li>
					<!-- Comentarios -->
					<li class="list-group-item">			
						@include('video.comments')
					</li>
				</ul>
			</div>			
		</div>
		<div class="col col-md-2">
			Videos relacionados
		</div>	
	</div>
@endsection