<?php

function base_path(string $path = ''): string
{
    $root = dirname(__DIR__, 2);
    return $path === '' ? $root : $root . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function query_string(array $params = []): string
{
    $current = $_GET;
    foreach ($params as $key => $value) {
        if ($value === null) {
            unset($current[$key]);
            continue;
        }
        $current[$key] = $value;
    }

    return http_build_query($current);
}

function flash_set(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function flash_get(string $key): ?string
{
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

function render(string $path, array $data = [], int $status = 200): void
{
    http_response_code($status);
    extract($data, EXTR_SKIP);

    ob_start();
    require base_path('app/Views/' . $path . '.php');
    $content = ob_get_clean();

    require base_path('app/Views/layout.php');
}

function log_exception(Throwable $exception): string
{
    $requestId = bin2hex(random_bytes(6));
    $line = sprintf(
        "[%s] request_id=%s %s in %s:%d\n%s\n",
        date('Y-m-d H:i:s'),
        $requestId,
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
        $exception->getTraceAsString()
    );

    file_put_contents(base_path('storage/logs/app.log'), $line, FILE_APPEND);

    return $requestId;
}

function selected(string $actual, string $expected): string
{
    return $actual === $expected ? 'selected' : '';
}

function old(array $values, string $key, string $fallback = ''): string
{
    return (string) ($values[$key] ?? $fallback);
}
