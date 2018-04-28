<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Video;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------
| RUTAS DEL CONTROLADOR DE VIDEOS
|--------------------------------------------------------------------------
*/
Route::get('/crear-video', array(
    "as" => "createVideo",                  #as: alias para Facade URL
    "middleware" => "auth",                 #middleware: logica que controlará autenticación
    "uses" => "VideoController@createvideo" #uses: Controlador@acción a ejecutar
));

Route::post('/guardar-video', array(
    "as" => "saveVideo",                  
    "middleware" => "auth",                 
    "uses" => "VideoController@saveVideo" 
));

Route::get('/video/{video_id}', array(
    'as'  =>  'detailVideo',
    'uses'  =>  'VideoController@getVideoDetail'
));

Route::get('/delete-video/{video_id}', array(
    'as'  =>  'deleteVideo',
    "middleware" => "auth", 
    'uses'  =>  'VideoController@deleteVideo'
));

Route::get('editar-video/{video_id}', array(
    'as' =>  'editVideo',
    'uses' => 'VideoController@editVideo'
));

Route::post('/update-video/{video_id}', array(
    "as" => "updateVideo",                  
    "middleware" => "auth",                 
    "uses" => "VideoController@updateVideo" 
));

Route::get('buscar-videos/{search?}/{filter?}', 'VideoController@searchVideosByString')->name('searchVideosByString');

// RUTAS QUE DEVUELVE LOS RECURSOS DEL STORAGE CORRESPONDIENTE
Route::get('/miniatura/{filename?}', 'VideoController@getImage')->name('imageVideo');
Route::get('/video-file/{filename}', 'VideoController@getVideo')->name('fileVideo');

/*
|--------------------------------------------------------------------------
| RUTAS DEL CONTROLADOR DE COMENTARIOS
|--------------------------------------------------------------------------
*/
Route::post('/comment', array(
    'as'    =>  'comment',
    'middleware'    =>  'auth',
    'uses'  =>  'CommentController@store'
));

Route::get('/delete-comment/{comment_id}', array(
    "as" => "deleteComment",                  #as: alias para Facade URL
    "middleware" => "auth",                 #middleware: logica que controlará autenticación
    "uses" => "CommentController@delete" #uses: Controlador@acción a ejecutar
));


/*
|--------------------------------------------------------------------------
| RUTAS DEL CONTROLADOR DE USUARIOS
|--------------------------------------------------------------------------
*/

Route::get('/canal/{user_id}', 'UserController@channel')->name('channelUser');





Route::get('/clear-cache', function(){
    $code = Artisan::call('cache:clear');
});