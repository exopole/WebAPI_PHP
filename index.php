<?php
chdir(__DIR__);

require 'vendor/autoload.php';

session_start();

/**
 * Set connection to database
 */
\ErwanG\DataObject::setPDO(['dbname'=> \Config\Config::BDD_NAME,'host'=>\Config\Config::BDD_HOST,'username'=>\Config\Config::BDD_USER,'password'=>\Config\Config::BDD_PASSWORD]);

/**
 * Create Slim app.
 * Delete in prod.
 */
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($configuration);

/**
 * Include all routes.
 */
foreach (glob("App/Routes/*.php") as $filename){
    include $filename;
}

//Override the default Not Found Handler after App
unset($app->getContainer()['notFoundHandler']);
$app->getContainer()['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        \Models\Message::addDanger('Route not found');
        return $response;
    };
};

/**
 * Appel des middlewares
 */
$app->add(new \Middleware\CreateResponse());

/**
 * Launch slim.
 */
$app->run();

