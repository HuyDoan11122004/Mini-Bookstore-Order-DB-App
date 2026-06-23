<section class="empty-state">
    <p class="eyebrow">500 Server Error</p>
    <h1>Something went wrong</h1>
    <p>A safe error message is shown here. Technical details were logged for the developer.</p>
    <?php if (!empty($requestId)): ?>
        <p class="muted">Request ID: <?= e($requestId) ?></p>
    <?php endif; ?>
    <a class="button primary" href="/">Back to dashboard</a>
</section>
