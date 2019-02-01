<?php 

$app->get('/player/{username}', \Controllers\PlayerController::class . ':getPlayer');
$app->get('/player/{username}', \Controllers\PlayerController::class . ':getPlayerName');
$app->post('/player', \Controllers\PlayerController::class . ':createPlayer');
