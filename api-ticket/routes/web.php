<?php

$router->get('/', function () use ($router) {
	return $router->app->version();
});

// SERVICES
$router->get('/sendemail', "OtpController@send");
$router->get('/verifyotp', "OtpController@check");
$router->get('/tests', "OtpController@test");

// CHAMADOS
$router->get('/chamados', "ChamadoController@index");
$router->get('/chamados/{id}', "ChamadoController@show");
$router->post('/chamados', "ChamadoController@store");
$router->get('/chamados/{sigla}', "ChamadoController@tooManyChamados");

// EQUIPAMENTOS
$router->get('/equipamentos', "EquipamentoController@index");
$router->get('/equipamentos/{id}', "EquipamentoController@show");

// TESTAR
$router->get('/equipamentos/{sigla}', "EquipamentoController@isSiglaOnDB");

// LOCAIS
$router->get('/locais', "LocalController@index");
$router->get('/locais/{id}', "LocalController@show");

// USUARIOS
$router->get('/usuarios', "UsuarioController@index");
$router->post('/usuarios', "UsuarioController@store");
