<?php
$nextDirection = strtolower($direction) === 'asc' ? 'desc' : 'asc';
$sortUrl = fn (string $column): string => '/book-orders?' . query_string(['sort' => $column, 'direction' => $nextDirection, 'page' => 1]);
?>
<section class="page-head">
    <div>
        <p class="eyebrow">Bookstore orders</p>
        <h1>Book Orders</h1>
        <p class="lede"><?= e((string) $total) ?> records. Search by order code, customer, email or book title.</p>
    </div>
    <a class="button primary" href="/book-orders/create">Create order</a>
</section>

<form class="toolbar" method="get" action="/book-orders">
    <label>
        <span>Search</span>
        <input type="search" name="q" value="<?= e($keyword) ?>" placeholder="code, customer, email, title">
    </label>
    <input type="hidden" name="sort" value="<?= e($sort) ?>">
    <input type="hidden" name="direction" value="<?= e($direction) ?>">
    <button class="button" type="submit">Search</button>
    <a class="button subtle" href="/book-orders">Reset</a>
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th><a href="<?= e($sortUrl('order_code')) ?>">Code</a></th>
                <th><a href="<?= e($sortUrl('customer_name')) ?>">Customer</a></th>
                <th>Email</th>
                <th><a href="<?= e($sortUrl('book_title')) ?>">Book</a></th>
                <th><a href="<?= e($sortUrl('quantity')) ?>">Qty</a></th>
                <th><a href="<?= e($sortUrl('total_amount')) ?>">Amount</a></th>
                <th><a href="<?= e($sortUrl('status')) ?>">Status</a></th>
                <th class="right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= e($order['order_code']) ?></td>
                    <td><?= e($order['customer_name']) ?></td>
                    <td><?= e($order['customer_email'] ?? '') ?></td>
                    <td><?= e($order['book_title']) ?></td>
                    <td><?= e((string) $order['quantity']) ?></td>
                    <td><?= e(number_format((float) $order['total_amount'], 0)) ?></td>
                    <td><span class="badge status-<?= e($order['status']) ?>"><?= e($order['status']) ?></span></td>
                    <td class="row-actions">
                        <a class="button compact" href="/book-orders/edit?id=<?= e((string) $order['id']) ?>">Edit</a>
                        <form method="post" action="/book-orders/delete" onsubmit="return confirm('Delete this order?');">
                            <input type="hidden" name="id" value="<?= e((string) $order['id']) ?>">
                            <button class="button compact danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if ($orders === []): ?>
                <tr><td colspan="8" class="empty-cell">No book orders found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<nav class="pagination">
    <a class="button compact <?= $page <= 1 ? 'disabled' : '' ?>" href="/book-orders?<?= e(query_string(['page' => max(1, $page - 1)])) ?>">Previous</a>
    <span>Page <?= e((string) $page) ?> of <?= e((string) $totalPages) ?></span>
    <a class="button compact <?= $page >= $totalPages ? 'disabled' : '' ?>" href="/book-orders?<?= e(query_string(['page' => min($totalPages, $page + 1)])) ?>">Next</a>
</nav>
