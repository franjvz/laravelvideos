<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\User;
use App\Video;
use App\Comment;

class UserController extends Controller
{
    public function channel($user_id){
    	$user = User::findOrFail($user_id);
    	$videos = Video::where('user_id', $user_id)->orderBy('id','desc')->paginate(6);

    	return view('user.channel', array(
    		'user'	=>	$user,
    		'videos' => $videos
    	));
    }
}
