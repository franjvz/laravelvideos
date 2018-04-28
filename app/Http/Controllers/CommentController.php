<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request){
    	$validate = $this->validate($request, [
    		'body' => 'required',
    	]);

    	$comment = new Comment();
    	$user = \Auth::user();

    	$comment->user_id = $user->id;
    	$comment->video_id = $request->input('video_id');
    	$comment->body = $request->input('body');

    	$comment->save();

    	return redirect()->route('detailVideo', array(
    		'video_id'	=>	$comment->video_id,
    	))->with("status", "Comentario añadido correctamente !!!");
    }

    public function delete($id){
        $comentario = Comment::find($id);
        
        // Si no se ha encontrado el comentario, redireccionamos con mensaje
        if(!$comentario)
            return redirect('/')->with('status', "No tramers");

        // Comprobar si el usuario es el dueño del comentario a borrar o el creador del video
        $userPeticion = \Auth::user();
        if($userPeticion && (($userPeticion->id == $comentario->user_id) or ($userPeticion->id == $comentario->video->user_id))){
            $comentario->delete(); # BORRAR BD
            return redirect('/video/'.$comentario->video_id)->with('status', 'El comentario se perdió para siempre.');
        }

        
    }
}
