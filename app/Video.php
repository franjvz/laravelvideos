<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Modelo que identifica a una entidad de la tabla videos
class Video extends Model
{
    // Tabla a la que se enlaza
    protected $table = 'videos';

    // Relacionar entidades
    
    # Relación One to Many
    public function comments(){
    	return $this->hasMany('App\Comment')->orderBy('id','desc');
    }
    
    #Relación Muchos to Uno
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    // Fin de relación entidades
    
}
