<?php 

//$app->get('/player/{username}/{token}', \Controllers\PlayerController::class . ':getPlayer');
//$app->get('/player/{username}/name', \Controllers\PlayerController::class . ':getPlayerName');
$app->post('/player/create', \Controllers\PlayerController::class . ':createPlayer');
$app->post('/player/connection', \Controllers\PlayerController::class . ':connectPlayer');
