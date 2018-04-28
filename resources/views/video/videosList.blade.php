<section id="videos-list" class="row">
    @if(count($videos) >= 1)
    @foreach($videos as $video)
        <div class="col-md-4">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" alt="{{ $video->title }}" src="{{ route('imageVideo',$video->image) }}" />
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('detailVideo', ['video_id' => $video->id]) }}">{{ $video->title }}</a></h5>
                    <p class="card-text">{{ $video->description }} </p>
                    <div class="d-flex justify-content-between align-items-center">
                        @if (Auth::check() && (Auth::user()->id == $video->user->id))    
                            <div class="btn-group">
                                <a href="{{ route('detailVideo', ['video_id' => $video->id]) }}" class="btn btn-sm btn-outline-primary" role="button">Ver</a>
                                <a href="{{ route('editVideo', ['video_id' => $video->id]) }}" class="btn btn-sm btn-outline-secondary" role="button">Editar</a>
                                <a href="{{ route('deleteVideo', ['video_id' => $video->id]) }}" class="btn btn-sm btn-outline-danger" role="button">Borrar</a>
                            </div>
                        @endif    
                        <small class="text-muted">{{ $video->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="card-footer text-right">
                    Publicado por: <a href="{{ route('channelUser', $video->user->id) }}" title="Visitar canal">{{ $video->user->name." ".$video->user->surname }}</a>
                </div>
            </div>
        </div>  
        {{ $videos->links() }}  
    @endforeach
    @else
        <h3>Sin vídeos</h3>
    @endif
</section>