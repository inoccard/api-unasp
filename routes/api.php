<?php

use Illuminate\Http\Request;

// API do site
$this->group(['prefix' => 'V1'], function(){

	// rota para gerar o token
	$this->post('auth', 'Auth\AuthApiController@authenticate');
	// rota para gerar outro token, caso o primeiro expirar
	$this->post('auth-refresh','Auth\AuthApiController@refreshToken');

	$this->group(['middleware' => 'jwt.auth'], function(){
		// rota para pesquisar aluno
		$this->get('alunos/search','Api\V1\AlunoController@search');
		$this->resource('alunos','Api\V1\AlunoController', ['except' => ['create', 'edit']]);
	});
});
