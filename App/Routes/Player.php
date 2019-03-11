<?php 

/// get

//$app->get('/player/{username}/name', \Controllers\PlayerController::class . ':getPlayerName');
$app->get('/player', \Controllers\PlayerController::class . ':getPlayerTest');
$app->get('/leaderBoard', \Controllers\PlayerController::class . ':getLeaderBoard');

/// post
$app->post('/player/infos', \Controllers\PlayerController::class . ':getPlayer');
$app->post('/player/create', \Controllers\PlayerController::class . ':createPlayer');
$app->post('/player/connection', \Controllers\PlayerController::class . ':connectPlayer');
$app->post('/player/setScore', \Controllers\PlayerController::class . ':setScore');
