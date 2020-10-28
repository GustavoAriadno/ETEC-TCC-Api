<?php

$router->get('/', function () use ($router) {
	return $router->app->version();
});

$router->get('/equipamentos', "EquipamentoController@index");