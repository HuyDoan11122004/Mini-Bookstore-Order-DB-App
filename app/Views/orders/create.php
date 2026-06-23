<section class="page-head">
    <div>
        <p class="eyebrow">Create</p>
        <h1>New book order</h1>
    </div>
    <a class="button subtle" href="/book-orders">Back</a>
</section>

<form class="form-panel" method="post" action="/book-orders/store">
    <?php require base_path('app/Views/orders/_form.php'); ?>
    <div class="actions">
        <button class="button primary" type="submit">Save order</button>
        <a class="button subtle" href="/book-orders">Cancel</a>
    </div>
</form>
