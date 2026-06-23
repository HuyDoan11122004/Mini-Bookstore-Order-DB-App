<div class="form-grid">
    <label>
        <span>Full name</span>
        <input name="full_name" value="<?= e(old($prospect, 'full_name')) ?>" required>
        <?php if (!empty($errors['full_name'])): ?><small class="error"><?= e($errors['full_name']) ?></small><?php endif; ?>
    </label>
    <label>
        <span>Email</span>
        <input type="email" name="email" value="<?= e(old($prospect, 'email')) ?>" required>
        <?php if (!empty($errors['email'])): ?><small class="error"><?= e($errors['email']) ?></small><?php endif; ?>
    </label>
    <label>
        <span>Phone</span>
        <input name="phone" value="<?= e(old($prospect, 'phone')) ?>">
    </label>
    <label>
        <span>Interested genre</span>
        <input name="interested_genre" value="<?= e(old($prospect, 'interested_genre', 'General')) ?>" required>
        <?php if (!empty($errors['interested_genre'])): ?><small class="error"><?= e($errors['interested_genre']) ?></small><?php endif; ?>
    </label>
    <label>
        <span>Status</span>
        <select name="status">
            <?php foreach (['new', 'contacted', 'qualified', 'lost'] as $status): ?>
                <option value="<?= e($status) ?>" <?= selected(old($prospect, 'status', 'new'), $status) ?>><?= e(ucfirst($status)) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['status'])): ?><small class="error"><?= e($errors['status']) ?></small><?php endif; ?>
    </label>
    <label class="wide">
        <span>Note</span>
        <textarea name="note" rows="4"><?= e(old($prospect, 'note')) ?></textarea>
    </label>
</div>
