<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Modelo que identifica a una entidad de la tabla comentarios
class Comment extends Model
{
    protected $table = 'comments';

    #Relación Muchos to Uno
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    #Relación Muchos to Uno
    public function video(){
    	return $this->belongsTo('App\Video', 'video_id');
    }
}
