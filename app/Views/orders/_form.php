<div class="form-grid">
    <label>
        <span>Order code</span>
        <input name="order_code" value="<?= e(old($order, 'order_code')) ?>" placeholder="BOOK-2026-0017" required>
        <?php if (!empty($errors['order_code'])): ?><small class="error"><?= e($errors['order_code']) ?></small><?php endif; ?>
    </label>
    <label>
        <span>Customer name</span>
        <input name="customer_name" value="<?= e(old($order, 'customer_name')) ?>" required>
        <?php if (!empty($errors['customer_name'])): ?><small class="error"><?= e($errors['customer_name']) ?></small><?php endif; ?>
    </label>
    <label>
        <span>Customer email</span>
        <input type="email" name="customer_email" value="<?= e(old($order, 'customer_email')) ?>">
        <?php if (!empty($errors['customer_email'])): ?><small class="error"><?= e($errors['customer_email']) ?></small><?php endif; ?>
    </label>
    <label>
        <span>Book title</span>
        <input name="book_title" value="<?= e(old($order, 'book_title')) ?>" required>
        <?php if (!empty($errors['book_title'])): ?><small class="error"><?= e($errors['book_title']) ?></small><?php endif; ?>
    </label>
    <label>
        <span>Quantity</span>
        <input type="number" min="1" name="quantity" value="<?= e(old($order, 'quantity', '1')) ?>" required>
    </label>
    <label>
        <span>Total amount</span>
        <input type="number" min="0" step="1000" name="total_amount" value="<?= e(old($order, 'total_amount', '0')) ?>" required>
    </label>
    <label>
        <span>Status</span>
        <select name="status">
            <?php foreach (['pending', 'confirmed', 'packed', 'shipped', 'cancelled'] as $status): ?>
                <option value="<?= e($status) ?>" <?= selected(old($order, 'status', 'pending'), $status) ?>><?= e(ucfirst($status)) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['status'])): ?><small class="error"><?= e($errors['status']) ?></small><?php endif; ?>
    </label>
    <label class="wide">
        <span>Note</span>
        <textarea name="note" rows="4"><?= e(old($order, 'note')) ?></textarea>
    </label>
</div>
