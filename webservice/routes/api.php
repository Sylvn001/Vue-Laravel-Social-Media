<?php

use App\User;
use App\Conteudo;
use App\Comentario;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/cadastro', "UsuarioController@cadastro");
Route::post('/login', "UsuarioController@login");

Route::middleware('auth:api')->put('/perfil', "UsuarioController@perfil");
Route::middleware('auth:api')->post('/conteudo/adicionar', "ConteudoController@adicionar");
Route::middleware('auth:api')->get('/conteudo/lista', "ConteudoController@lista");
Route::middleware('auth:api')->put('/conteudo/curtir/{id}', "ConteudoController@curtir");
Route::middleware('auth:api')->put('/conteudo/comentar/{id}', "ConteudoController@comentar");
Route::middleware('auth:api')->get('/conteudo/pagina/lista/{id}', "ConteudoController@pagina");
Route::middleware('auth:api')->post('/usuario/amigo', "UsuarioController@amigo");
Route::middleware('auth:api')->get('/usuario/listaamigos', "UsuarioController@listaamigos");
Route::middleware('auth:api')->get('usuario/listaamigospagina/{id}', "UsuarioController@listaamigospagina");

Route::middleware('auth:api')->put('/conteudo/curtirpagina/{id}', "ConteudoController@curtirpagina");
Route::middleware('auth:api')->put('/conteudo/comentarpagina/{id}', "ConteudoController@comentarpagina");



Route::get('/testes', function(){
  $user = User::find(1);
  $conteudo = Conteudo::find(20);
  $user->comentarios()->create([
    'conteudo_id'=>$conteudo->id,
    'texto'=>"Show de bola!",
    'data'=>date('Y-m-d H:i:s') //date('Y-m-d')
  ]);

  /*
  $user = User::find(1);
  $user2 = User::find(2);
  
  $conteudos = Conteudo::all();
  foreach($conteudos as $key => $value)
  {
    $value->delete();
  }
  */





  /*
  $user->conteudos()->create([
    'titulo'=>'Conteúdo 3',
    'texto'=>"Aqui o texto",
    'imagem'=>'url da imagem',
    'link'=>'Link',
    'data'=>'2018-05-10' //date('Y-m-d')
  ]);
  return $user->conteudos;
  */

  /*
  // add Amigos:
  //$user->amigos()->attach($user2->id);
  //$user->amigos()->detach($user2->id);
  $user->amigos()->toggle($user2->id);

  return $user->amigos;
  */

  /*
  // add Curtidas:
  $conteudo = Conteudo::find(1);
  $user->curtidas()->toggle($conteudo->id);
  //return $conteudo->curtidas()->count();
  return $conteudo->curtidas;
  */

  /*
  // add comentários:
  $conteudo = Conteudo::find(1);
  $user->comentarios()->create([
    'conteudo_id'=>$conteudo->id,
    'texto'=>"Show de bola!",
    'data'=>date('Y-m-d') //date('Y-m-d')
  ]);
  $user2->comentarios()->create([
    'conteudo_id'=>$conteudo->id,
    'texto'=>"Não gostei.",
    'data'=>date('Y-m-d') //date('Y-m-d')
  ]);
  return $conteudo->comentarios;
  */

});
