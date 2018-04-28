<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;

class VideoController extends Controller
{
    public function createVideo()
    {
    	return view('video.createVideo');
    }

    public function saveVideo(Request $request)
    {
    	// Validar formulario
    	$validatedData = $this->validate($request, [
    		"title" => "required|min:5",
    		"description" => "required",
    		"video" => "required|mimes:mp4"
    	]);

        // Almacenar vídeo usando ORM
        $video = new Video();
        $video->user_id = \Auth::user()->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        // Subida de la miniatura
        $image = $request->file('image');
        if($image){
            $image_path = time().$image->getClientOriginalName();
            Storage::disk('images')->put($image_path, \File::get($image));

            $video->image = $image_path;
        }

        // Subida del video
        $video_file = $request->file('video');
        if($video_file){
            $video_path = time().$video_file->getClientOriginalName();
            Storage::disk('videos')->put($video_path, \File::get($video_file));

            $video->video_path = $video_path;
        }

        // Guardar vídeo y redireccionar con mensaje
        $video->save();
        return redirect()->route('home')->with('status','El vídeo se ha subido correctamente.');
    }

    public function getImage($filename = 'videoPlaceholder.jpg'){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function getVideoDetail($video_id){
        $video = Video::find($video_id);

        return view('video.detail', array(
            'video' => $video
        ));
    }

    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    public function deleteVideo($video_id){
        $video = Video::find($video_id);

        // Si no se ha encontrado el vídeo, redireccionamos con mensaje
        if(!$video)
            return redirect('/')->with('status', "No tramers");
        

        // Comprobar si el usuario es el dueño del video
        $userPeticion = \Auth::user();
        if($userPeticion && ($userPeticion->id == $video->user->id)){
            // Obtener todos los comentarios del vídeo y borrarlos si tiene
            $videoComments = Comment::where('video_id', $video_id)->get();
            if($videoComments && count($videoComments) >= 1)
                foreach($videoComments as $comment)
                    $comment->delete();

            // Eliminar mediafiles
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);

            // Eliminar registro del vídeo y redireccionar
            $video->delete();
            return redirect()
                    ->route('home')
                    ->with('status', 'El vídeo con título "'.$video->title.'" ha sido eliminado');
        }       
    }

    public function editVideo($video_id){
        $video = Video::findOrFail($video_id);
        $userPeticion = \Auth::user();
        if($userPeticion && ($userPeticion->id == $video->user->id))
            return view('video.editVideo', ['video' => $video]);
        else
            return redirect()->route('home');
    }

    public function updateVideo($video_id, Request $request){

        // Reglas de validación
        $validate = $this->validate($request, array(
            "title" => "required|min:5",
            "description" => "required",
            "video" => "mimes:mp4"
        ));

        // Si no encuentra el video da página de error
        $video = Video::findOrFail($video_id);
        $userPeticion = \Auth::user();
        if($userPeticion && ($userPeticion->id == $video->user->id)){
            $video->title = $request->input('title');
            $video->description = $request->input('description');

            // Subida de la nueva miniatura
            $image = $request->file('image');
            if($image){
                // Eliminar miniatura antigua
                Storage::disk('images')->delete($video->image);

                // Establecer nueva miniatura
                $image_path = time().$image->getClientOriginalName();
                Storage::disk('images')->put($image_path, \File::get($image));

                $video->image = $image_path;
            }

            // Subida del nuevo video
            $video_file = $request->file('video');
            if($video_file){
                // Eliminar video antiguo
                Storage::disk('videos')->delete($video->video_path);

                // Actualizar con nuevo video
                $video_path = time().$video_file->getClientOriginalName();
                Storage::disk('videos')->put($video_path, \File::get($video_file));

                $video->video_path = $video_path;
            }

            $video->update();

            return redirect()->route('editVideo', $video_id)->with("status", "El vídeo ha sido editado correctamente.");
        }
    }

    // Busca los vídeos relacionados en title o description con la string dada
    public function searchVideosByString($search = null, $filter = null){

        if(is_null($search)){
            $search = \Request::get('search');
            return redirect()->route('searchVideosByString', ['search' => $search]);
        }

        $filtroPeticion = \Request::get('filter');
        if (is_null($filter) && $filtroPeticion && !is_null($search)) {
            return redirect()->route('searchVideosByString', [
                'search' => $search,
                'filter' => $filtroPeticion
            ]);
        }

        // Get searchText
        $search = strip_tags($search);

        // Ordenación
        $column = 'id';
        $order = 'desc';
        if(!is_null($filter)){
            switch ($filter) {
                case 'new':
                    $column = 'id';
                    $order = 'desc';
                    break;
                case 'old':
                    $column = 'id';
                    $order = 'asc';
                    break;
                case 'alfa':
                    $column = 'title';
                    $order = 'asc';
            }
        }

        // Buscar videos relacionados con el searchString
        $relatedVideos = Video::where('title', 'like', '%' . $search . '%')
                              ->orWhere('description', 'like', '%' . $search . '%')
                              ->orderBy($column, $order)
                              ->paginate(6);

        if(count($relatedVideos) == 0)
            return redirect('/')->with('status', 'No se encuentran vídeos relacionados con"'.$search.'".');

        return view('video.busqueda', [
            'search' => $search,
            'videos' => $relatedVideos
        ]);
    }
}
