<section class="page-head">
    <div>
        <p class="eyebrow">Create</p>
        <h1>New prospect</h1>
    </div>
    <a class="button subtle" href="/prospects">Back</a>
</section>

<form class="form-panel" method="post" action="/prospects/store">
    <?php require base_path('app/Views/prospects/_form.php'); ?>
    <div class="actions">
        <button class="button primary" type="submit">Save prospect</button>
        <a class="button subtle" href="/prospects">Cancel</a>
    </div>
</form>
