<?php
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\BookingController;
use app\controllers\AdminController;
use app\controllers\CourseController;

//getting dependencies
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//configuring the application
$config = [
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

//creating the application with the config
$app = new Application(dirname(__DIR__), $config);


//creating the routes
//site routes
$app->router->get('/', [SiteController::class, 'home']);
$app->router->post('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);
$app->router->get('/dashboard', [SiteController::class, 'dashboard']);

//booking routes
$app->router->get('/booking', [BookingController::class, 'booking']);
$app->router->post('/booking', [BookingController::class, 'booking']);
$app->router->get('/booking/setup', [BookingController::class, 'bookingSetup']);
$app->router->post('/booking/setup', [BookingController::class, 'bookingSetup']);

//auth routes
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/profile', [AuthController::class, 'profile']);
$app->router->post('/profile', [AuthController::class, 'profile']);

//Admin routes
$app->router->get('/admin', [AdminController::class, 'admin']);
$app->router->post('/admin', [AdminController::class, 'admin']);
$app->router->get('/admin/editcourse', [AdminController::class, 'editCourse']);
$app->router->post('/admin/editcourse', [AdminController::class, 'editCourse']);
$app->router->post('/admin/search', [AdminController::class, 'postSearch']);
$app->router->post('/admin/newHolder', [AdminController::class, 'postSetNewHolder']);

//Course routes
$app->router->get('/courseAdmin', [CourseController::class, 'courseAdmin']);
$app->router->post('/courseAdmin', [CourseController::class, 'courseAdmin']);
$app->router->post('/courseAdmin/manageMembers', [CourseController::class, 'manageMembers']);
$app->router->post('/courseAdmin/editCourse', [CourseController::class, 'postEditCourse']);

//starting the application
$app->run();