<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Classes\Pais;
use App\Classes\Post;


class UsuarioController extends Controller {

	public function test() {
		$posts = Pais::find(1)->posts;
		foreach ($posts as $key => $post) {
			echo $post->titulo , '<br />';
		}
	}
}