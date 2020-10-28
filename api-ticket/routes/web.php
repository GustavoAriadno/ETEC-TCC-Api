<?php

$router->get('/', function () use ($router) {
	return $router->app->version();
});

// $router->get('/sendemail', "SendEmailController@send");
// $router->get('/verifyotp', "verifyotpController@check");

$router->get('/equipamentos', "EquipamentoController@index");
$router->get('/equipamentos/{id}', "EquipamentoController@show");


$router->get('/chamados', "ChamadoController@index");
$router->get('/chamados/{sigla}', "ChamadoController@nome");


$router->get('/locais', "LocalController@index");