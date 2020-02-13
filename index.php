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
use src\controllers\NeedController;
use src\controllers\NicheController;
use src\controllers\RegistrationController;
use src\controllers\ValidatorController;
use src\extensions\TwigCalcDate;
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
    $view->addExtension(new TwigCalcDate());
    return $view;
};

$app->add(new OldInputMiddleware($container));
$app->add($container->csrf);

// Home
$app->get('/validator', ValidatorController::class . ':validator')->setName('validator');

// Guest
$app->group('', function() {
    $this->get('/', AuthController::class . ':showLogin')->setName('showLogin');
    $this->post('/login', AuthController::class . ':login')->setName('login');
})->add(new GuestMiddleware($container));

// Authenticated
$app->group('', function() {
    $this->get('/home', AuthController::class . ':showHome')->setName('home');
    $this->get('/logout', AuthController::class . ':logout')->setName('logout');
    $this->get('/profile', AccountController::class . ':showMyProfile')->setName('showMyProfile');
    $this->post('/updateMyProfile', AccountController::class . ':updateMyProfile')->setName('updateMyProfile');
    $this->post('/updateMyPassword', AccountController::class . ':updateMyPassword')->setName('updateMyPassword');
    $this->get('/profile/{id:[0-9]+}', AccountController::class . ':showProfile')->setName('showProfile');
    $this->get('/createNeed/{id:[0-9]+}', NeedController::class . ':showCreateNeed')->setName('showCreateNeed');
    $this->post('/createNeed/{id:[0-9]+}', NeedController::class . ':createNeed')->setName('createNeed');
    $this->get('/niche/{id:[0-9]+}', NeedController::class . ':showNeedsNiche')->setName('showNeedsNiche');
    $this->get('/inscriptionNeed/{id:[0-9]+}', RegistrationController::class . ':inscription')->setName('inscriptionNeed');
    $this->post('/updateNeed', NeedController::class . ':updateNeed')->setName('updateNeed');
    $this->post('/deleteNeed', NeedController::class . ':deleteNeed')->setName('deleteNeed');
    $this->get('/niches', NicheController::class . ':showNiches')->setName("showNiches");
    $this->get('/needs', NeedController::class .':showAll')->setName("showNeeds");
})->add(new AuthMiddleware($container));

// Administration
$app->group('/admin', function (){
    $this->get('/', AdminController::class . ':showAdmin')->setName('showAdmin');
    $this->get('/delete/{id}', AdminController::class .':deleteUser')->setName('deleteUser');
    $this->get('/register', AdminController::class . ':showRegister')->setName('showRegister');
    $this->get('/setAdmin/{id:[0-9]+}', AdminController::class . ':setAdmin')->setName('setAdmin');
    $this->post('/register', AdminController::class . ':register')->setName('register');
    $this->post('/update/{id:[0-9]+}', AdminController::class . ':updateProfile')->setName('updateProfile');
    $this->get('/update/{id:[0-9]+}', AdminController::class . ':updateProfileAdmin')->setName('updateProfileAdmin');

    //Niches
    $this->get('/niches', NicheController::class . ':showNiches')->setName("showNiches");
    $this->post('/niche/create', NicheController::class . ':addNiche')->setName('addNiche');
    $this->get('/niche/create', NicheController::class . ':formNiche')->setName('formNiche');
})->add(new AdminMiddleware($container));

$app->run();