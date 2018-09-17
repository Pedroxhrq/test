<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
||
|||  Comando para ligar o servidor PHP:
|||| 
|||  $ php -S localhost:8000 -t public
||
*/

use Illuminate\Http\Response;

$router->get('/', function () use ($router) {
	return $router->app->version();
});

$router->get('nome', function () {
	return "pedro";
});

$router->get('login/{nome}[/{apelido}]', function ($nome, $apelido = "Sr.") {
	return "Hey ". $nome . ", vou te chamar de ". $apelido;
});

$router->get('soma/{v1}/{v2}', function ($v1 = 0, $v2 = 0) {
	return $v1 + $v2;
});

$router->get('completo', function () {
	return response()->json(
		[
			'nome' => 'Pedro',
			'sobrenome' => 'Henrique'
		]
	);
});

$router->get("imc/{peso}/{altura}", "CalculoController@imc");

$router->get("bhaskara/{a}/{b}/{c}", "CalculoController@bhaskara");

$router->get("listarporid/{id}", "AuditController@listarPorId");

$router->get("listarTodasPerguntas", "AuditController@listarTodasPerguntas");

$router->get("responder/{idPergunta}/{idResposta}", "AuditController@responder");

$router->get("responderTodas/{arrayPerguntas}/{arrayRespostas}", "AuditController@responderTodas");

$router->get("calcular/{arrayPerguntas}/{arrayRespostas}", "AuditController@calcular");