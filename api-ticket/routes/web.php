<?php

$router->get('/', function () use ($router) {
	return $router->app->version();
});

// SERVICES
// $router->get('/sendemail', "SendEmailController@send");
// $router->get('/verifyotp', "verifyotpController@check");

// CHAMADOS
$router->get('/chamados', "ChamadoController@index");
$router->get('/chamados/{id}', "ChamadoController@show");
$router->post('/chamados', "ChamadoController@store");
$router->get('/chamados/{sigla}', "ChamadoController@tooManyChamados");

// EQUIPAMENTOS
$router->get('/equipamentos', "EquipamentoController@index");
$router->get('/equipamentos/{id}', "EquipamentoController@show");

// LOCAIS
$router->get('/locais', "LocalController@index");
$router->get('/locais/{id}', "LocalController@show");

// USUARIOS
$router->get('/usuarios', "UsuarioController@index");
$router->post('/usuarios', "UsuarioController@store");
