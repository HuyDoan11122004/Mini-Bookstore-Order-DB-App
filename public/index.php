<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/Core/helpers.php';
require_once base_path('app/Core/Database.php');
require_once base_path('app/Core/Router.php');
require_once base_path('app/Core/DuplicateRecordException.php');
require_once base_path('app/Repositories/ProspectRepository.php');
require_once base_path('app/Repositories/BookOrderRepository.php');
require_once base_path('app/Controllers/HomeController.php');
require_once base_path('app/Controllers/HealthController.php');
require_once base_path('app/Controllers/ProspectController.php');
require_once base_path('app/Controllers/BookOrderController.php');

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/health', [HealthController::class, 'index']);

$router->get('/prospects', [ProspectController::class, 'index']);
$router->get('/prospects/create', [ProspectController::class, 'create']);
$router->post('/prospects/store', [ProspectController::class, 'store']);
$router->get('/prospects/edit', [ProspectController::class, 'edit']);
$router->post('/prospects/update', [ProspectController::class, 'update']);
$router->post('/prospects/delete', [ProspectController::class, 'delete']);

$router->get('/book-orders', [BookOrderController::class, 'index']);
$router->get('/book-orders/create', [BookOrderController::class, 'create']);
$router->post('/book-orders/store', [BookOrderController::class, 'store']);
$router->get('/book-orders/edit', [BookOrderController::class, 'edit']);
$router->post('/book-orders/update', [BookOrderController::class, 'update']);
$router->post('/book-orders/delete', [BookOrderController::class, 'delete']);

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Throwable $exception) {
    $requestId = log_exception($exception);
    render('errors/500', [
        'title' => '500 Server Error',
        'requestId' => $requestId,
    ], 500);
}
