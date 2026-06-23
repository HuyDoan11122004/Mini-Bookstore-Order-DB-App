<section class="page-head">
    <div>
        <p class="eyebrow">Edit</p>
        <h1><?= e(old($prospect, 'full_name', 'Prospect')) ?></h1>
    </div>
    <a class="button subtle" href="/prospects">Back</a>
</section>

<form class="form-panel" method="post" action="/prospects/update">
    <input type="hidden" name="id" value="<?= e(old($prospect, 'id')) ?>">
    <?php require base_path('app/Views/prospects/_form.php'); ?>
    <div class="actions">
        <button class="button primary" type="submit">Update prospect</button>
        <a class="button subtle" href="/prospects">Cancel</a>
    </div>
</form>
