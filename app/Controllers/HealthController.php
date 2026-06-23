<?php

class HealthController
{
    public function index(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            Database::connection()->query('SELECT 1');
            echo json_encode([
                'status' => 'ok',
                'app' => 'mini-bookstore-order-db-app',
                'database' => 'connected',
                'driver' => 'pdo_mysql',
                'checked_at' => date(DATE_ATOM),
            ], JSON_PRETTY_PRINT);
        } catch (Throwable $exception) {
            $requestId = log_exception($exception);
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'app' => 'mini-bookstore-order-db-app',
                'database' => 'disconnected',
                'message' => 'Database health check failed. Please contact the administrator.',
                'request_id' => $requestId,
            ], JSON_PRETTY_PRINT);
        }
    }
}
