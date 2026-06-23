<section class="page-head">
    <div>
        <p class="eyebrow">Edit</p>
        <h1><?= e(old($order, 'order_code', 'Book order')) ?></h1>
    </div>
    <a class="button subtle" href="/book-orders">Back</a>
</section>

<form class="form-panel" method="post" action="/book-orders/update">
    <input type="hidden" name="id" value="<?= e(old($order, 'id')) ?>">
    <?php require base_path('app/Views/orders/_form.php'); ?>
    <div class="actions">
        <button class="button primary" type="submit">Update order</button>
        <a class="button subtle" href="/book-orders">Cancel</a>
    </div>
</form>
