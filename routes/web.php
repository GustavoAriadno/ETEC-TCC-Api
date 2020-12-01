<?php

$router->get('/', function () use ($router) {
	return $router->app->version();
});

// SERVICES
$router->post('/sendemail', "OtpController@genOTP");
$router->post('/verifyotp', "OtpController@check");

// CHAMADOS
$router->get('/chamados', "ChamadoController@index");
$router->post('/chamado', "ChamadoController@store");
$router->post('/chamados/id', "ChamadoController@show");

// EQUIPAMENTOS
$router->get('/equipamentos', "EquipamentoController@index");
$router->post('/equipamentos/id', "EquipamentoController@show");
$router->post('/equipamentos/sigla', "EquipamentoController@getStrLocal");

// LOCAIS
$router->get('/locais', "LocalController@index");
$router->post('/locais/id', "LocalController@show");

// USUARIOS
// $router->get('/usuarios', "UsuarioController@index");
// $router->post('/usuarios', "UsuarioController@store");
