<h4>Comentarios</h4>

@if(Auth::check())
	<form class="col-md-10" method="POST" action="{{ route('comment') }}">
		@csrf

		<input type="hidden" name="video_id" value="{{ $video->id }}" required />
		<p>
			<textarea class="form-control" name="body" rows="6" placeholder="Escriba su comentario" required>
				
			</textarea>
		</p>
		<input type="submit" class="btn btn-success" name="guardarComentario"  value="Comentar"/>
	</form>
@endif

<!-- listado de comentarios -->
@if (isset($video->comments))
	<div class="comments-list">
		@foreach($video->comments as $comment)
			<div class="comment-item col-md-12">
				<div class="card comment-data">
					<div class="card-body">		
						<!-- Cuerpo del comentario -->
						<p class="card-text">{{ $comment->body }}</p>
						<p class="card-text text-right text-muted">
							Publicado por: {{ $comment->user->name." ".$comment->user->surname }} | {{ $comment->created_at->diffForHumans() }}
							@if (Auth::check() && ((Auth::id() == $comment->user->id) or (Auth::id() == $video->user->id)))
								<a href="#victorModal{{ $comment->id }}" class="btn btn-outline-danger" data-toggle="modal" role="button">Borrar</a>
  
								<!-- Modal / Ventana / Overlay en HTML -->
								<div id="victorModal{{ $comment->id }}" class="modal fade">
								    <div class="modal-dialog">
								        <div class="modal-content">
								            <div class="modal-header">

								                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								            </div>
								            <div class="modal-body">
								                <p>¿Seguro que quieres borrar este elemento?</p>
								                <p class="text-warning"><small>Si lo borras, nunca podrás recuperarlo.</small></p>
								            </div>
								            <div class="modal-footer">
								                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								                <a href="{{ route('deleteComment',$comment->id) }}" class="btn btn-danger" role="button">Eliminar</a>
								            </div>
								        </div>
								    </div>
								</div>
							@endif
						</p>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endif