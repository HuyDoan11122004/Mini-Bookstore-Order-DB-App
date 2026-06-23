<?php
$nextDirection = strtolower($direction) === 'asc' ? 'desc' : 'asc';
$sortUrl = fn (string $column): string => '/prospects?' . query_string(['sort' => $column, 'direction' => $nextDirection, 'page' => 1]);
?>
<section class="page-head">
    <div>
        <p class="eyebrow">Bookstore prospects</p>
        <h1>Prospects</h1>
        <p class="lede"><?= e((string) $total) ?> records. Search by name, email, phone or interested genre.</p>
    </div>
    <a class="button primary" href="/prospects/create">Create prospect</a>
</section>

<form class="toolbar" method="get" action="/prospects">
    <label>
        <span>Search</span>
        <input type="search" name="q" value="<?= e($keyword) ?>" placeholder="name, email, phone, genre">
    </label>
    <input type="hidden" name="sort" value="<?= e($sort) ?>">
    <input type="hidden" name="direction" value="<?= e($direction) ?>">
    <button class="button" type="submit">Search</button>
    <a class="button subtle" href="/prospects">Reset</a>
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th><a href="<?= e($sortUrl('id')) ?>">ID</a></th>
                <th><a href="<?= e($sortUrl('full_name')) ?>">Name</a></th>
                <th><a href="<?= e($sortUrl('email')) ?>">Email</a></th>
                <th>Phone</th>
                <th><a href="<?= e($sortUrl('interested_genre')) ?>">Genre</a></th>
                <th><a href="<?= e($sortUrl('status')) ?>">Status</a></th>
                <th><a href="<?= e($sortUrl('created_at')) ?>">Created</a></th>
                <th class="right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prospects as $prospect): ?>
                <tr>
                    <td><?= e((string) $prospect['id']) ?></td>
                    <td><?= e($prospect['full_name']) ?></td>
                    <td><?= e($prospect['email']) ?></td>
                    <td><?= e($prospect['phone'] ?? '') ?></td>
                    <td><?= e($prospect['interested_genre']) ?></td>
                    <td><span class="badge status-<?= e($prospect['status']) ?>"><?= e($prospect['status']) ?></span></td>
                    <td><?= e($prospect['created_at']) ?></td>
                    <td class="row-actions">
                        <a class="button compact" href="/prospects/edit?id=<?= e((string) $prospect['id']) ?>">Edit</a>
                        <form method="post" action="/prospects/delete" onsubmit="return confirm('Delete this prospect?');">
                            <input type="hidden" name="id" value="<?= e((string) $prospect['id']) ?>">
                            <button class="button compact danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if ($prospects === []): ?>
                <tr><td colspan="8" class="empty-cell">No prospects found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<nav class="pagination">
    <a class="button compact <?= $page <= 1 ? 'disabled' : '' ?>" href="/prospects?<?= e(query_string(['page' => max(1, $page - 1)])) ?>">Previous</a>
    <span>Page <?= e((string) $page) ?> of <?= e((string) $totalPages) ?></span>
    <a class="button compact <?= $page >= $totalPages ? 'disabled' : '' ?>" href="/prospects?<?= e(query_string(['page' => min($totalPages, $page + 1)])) ?>">Next</a>
</nav>
