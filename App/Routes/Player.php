<?php 

$app->get('/player/{username}', \Controllers\PlayerController::class . ':getPlayer');
