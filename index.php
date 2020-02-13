<?php
use Illuminate\Database\Capsule\Manager as DB;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use src\controllers\AccountController;
use src\controllers\AdminController;
use src\controllers\AuthController;
use src\controllers\HomeController;
use src\controllers\ValidatorController;
use src\extensions\TwigCsrf;
use src\extensions\TwigMessages;
use src\helpers\Auth;
use src\middlewares\AdminMiddleware;
use src\middlewares\AuthMiddleware;
use src\middlewares\GuestMiddleware;
use src\middlewares\OldInputMiddleware;

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


$container['csrf'] = function () {
    $guard = new Guard();
    $guard->setPersistentTokenMode(true);
    return $guard;
};

$container['flash'] = function () {
    return new Messages();
};

$container['view'] = function ($container) {
    $view = new Twig(__DIR__ . '/src/views', [
        'cache' => false
    ]);

    $view->getEnvironment()->addGlobal('auth', [
        'check' => Auth::check(),
        'user' => Auth::user()
    ]);

    $view->addExtension(new TwigExtension($container->router, Uri::createFromEnvironment(new Environment($_SERVER))));
    $view->addExtension(new TwigMessages(new Messages()));
    $view->addExtension(new TwigCsrf($container->csrf));
    return $view;
};

$app->add(new OldInputMiddleware($container));
$app->add($container->csrf);

// Home
$app->get('/', HomeController::class . ':showHome')->setName('home');
$app->get('/validator', ValidatorController::class . ':validator')->setName('validator');

// Guest
$app->group('', function() {
    $this->get('/login', AuthController::class . ':showLogin')->setName('showLogin');
    $this->post('/login', AuthController::class . ':login')->setName('login');

    $this->get('/register', AdminController::class . ':showRegister')->setName('showRegister');
    $this->post('/register', AdminController::class . ':register')->setName('register');
})->add(new GuestMiddleware($container));

// Authenticated
$app->group('', function() {
    $this->get('/logout', AuthController::class . ':logout')->setName('logout');
    $this->get('/profile', AccountController::class . ':showMyProfile')->setName('showMyProfile');
    $this->post('/updateMyProfile', AccountController::class . ':updateMyProfile')->setName('updateMyProfile');
    $this->post('/updateMyPassword', AccountController::class . ':updateMyPassword')->setName('updateMyPassword');
    $this->get('/profile/{id:[0-9]+}', AccountController::class . ':showProfile')->setName('showProfile');
})->add(new AuthMiddleware($container));

// Administration
$app->group('/admin', function (){
    $this->get('/', AdminController::class . ':showAdmin')->setName('showAdmin');
    $this->get('/delete/{id:[0-9]+}', AdminController::class .':deleteUser')->setName('deleteUser');
})->add(new AdminMiddleware($container));

$app->run();