<?php
use Illuminate\Database\Capsule\Manager as DB;
use Slim\App;
use src\controllers\AuthController;

require_once(__DIR__ . '/vendor/autoload.php');
session_start();

/**
 * .env config
 */
$env = Dotenv\Dotenv::createImmutable(__DIR__);
$env->load();
$env->required(['DB_DRIVER', 'DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PWD', 'DB_CHARSET', 'DB_COLLATION', 'DB_PREFIX']);

/**
 * Eloquent Set-up
 */
$db = new DB();
$db->addConnection([
    'driver' => $_ENV['DB_DRIVER'],
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PWD'],
    'charset' => $_ENV['DB_CHARSET'],
    'collation' => $_ENV['DB_COLLATION'],
    'prefix' => $_ENV['DB_PREFIX']
]);
$db->setAsGlobal();
$db->bootEloquent();

/**
 * Slim config
 */
$config = [
    'settings' => [
        'displayErrorDetails' => 1,
    ],
];

/**
 * Instanciate app
 */
$app = new App($config);
$container = $app->getContainer();


// Home
$app->get('/', AuthController::class . ':showHome')->setName('showLogin');
$app->run();