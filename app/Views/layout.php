<?php $app = require base_path('config/app.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Dashboard') . ' - ' . $app['name']) ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="/">Bookstore DB</a>
        <nav class="nav">
            <a href="/" class="<?= ($_SERVER['REQUEST_URI'] ?? '/') === '/' ? 'active' : '' ?>">Dashboard</a>
            <a href="/prospects">Prospects</a>
            <a href="/book-orders">Book Orders</a>
            <a href="/health">Health</a>
        </nav>
    </header>

    <main class="shell">
        <?php if ($message = flash_get('success')): ?>
            <div class="alert success"><?= e($message) ?></div>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>
</html>
