<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f4f6f8; color: #1f2937; }
        .container { width: min(620px, calc(100% - 32px)); margin: 48px auto; background: #fff; border-radius: 12px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,.08); box-sizing: border-box; }
        h1 { margin: 0 0 24px; }
        label { display: block; margin: 16px 0 6px; font-weight: 600; }
        input, textarea { width: 100%; box-sizing: border-box; padding: 11px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; font-family: inherit; }
        textarea { min-height: 120px; resize: vertical; }
        .error { margin: 4px 0 0; color: #b91c1c; font-size: 14px; }
        .actions { display: flex; gap: 12px; align-items: center; margin-top: 24px; }
        button, .cancel { border: 0; border-radius: 6px; padding: 11px 16px; font-size: 15px; text-decoration: none; cursor: pointer; }
        button { background: #2563eb; color: #fff; }
        .cancel { color: #374151; background: #e5e7eb; }
    </style>
</head>
<body>
<main class="container">
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
    <form method="post" action="<?= htmlspecialchars($action, ENT_QUOTES, 'UTF-8') ?>">
        <?php foreach ([
            'product_name' => 'Product name',
            'description' => 'Description',
            'price' => 'Price',
            'quantity' => 'Quantity',
        ] as $field => $label) : ?>
            <label for="<?= $field ?>"><?= $label ?></label>
            <?php if ($field === 'description') : ?>
                <textarea id="<?= $field ?>" name="<?= $field ?>" required><?= htmlspecialchars((string) (is_array($product) ? ($product[$field] ?? '') : ($product->$field ?? '')), ENT_QUOTES, 'UTF-8') ?></textarea>
            <?php else : ?>
                <input id="<?= $field ?>" name="<?= $field ?>" type="<?= $field === 'price' ? 'number' : ($field === 'quantity' ? 'number' : 'text') ?>" <?= $field === 'price' ? 'step="0.01" min="0"' : ($field === 'quantity' ? 'step="1" min="0"' : '') ?> value="<?= htmlspecialchars((string) (is_array($product) ? ($product[$field] ?? '') : ($product->$field ?? '')), ENT_QUOTES, 'UTF-8') ?>" required>
            <?php endif; ?>
            <?php if (!empty($errors[$field])) : ?><p class="error"><?= htmlspecialchars($errors[$field], ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
        <?php endforeach; ?>
        <div class="actions">
            <button type="submit">Save product</button>
            <a class="cancel" href="/products">Cancel</a>
        </div>
    </form>
</main>
</body>
</html>
