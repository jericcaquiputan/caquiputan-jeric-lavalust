<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f4f6f8; color: #1f2937; }
        .container { width: min(1100px, calc(100% - 32px)); margin: 48px auto; background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,.08); overflow: hidden; }
        .header { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 24px 28px; border-bottom: 1px solid #e5e7eb; }
        .header h1 { margin: 0 0 6px; font-size: 28px; }
        .header p { margin: 0; color: #6b7280; }
        .header-actions { display: flex; gap: 8px; align-items: center; }
        .button, .link-button { display: inline-block; border: 0; border-radius: 6px; padding: 10px 14px; background: #2563eb; color: #fff; cursor: pointer; font-size: 14px; text-decoration: none; }
        .button.danger { background: #dc2626; }
        .button.secondary { background: #6b7280; }
        .actions { display: flex; align-items: center; gap: 8px; }
        .actions form { margin: 0; }
        .actions .edit { color: #2563eb; text-decoration: none; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 18px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-size: 13px; text-transform: uppercase; letter-spacing: .04em; color: #4b5563; }
        tbody tr:hover { background: #f9fafb; }
        .empty { padding: 28px; text-align: center; color: #6b7280; }
        @media (max-width: 700px) { .header { align-items: flex-start; flex-direction: column; } }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div><h1>Products</h1><p>Manage records in the <strong>products</strong> table.</p></div>
        <div class="header-actions">
            <a class="link-button" href="/products/create">Add product</a>
            <form method="post" action="/logout"><button class="button secondary" type="submit">Sign out</button></form>
        </div>
    </div>

    <?php if (!empty($products)) : ?>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Product</th><th>Description</th><th>Price</th><th>Quantity</th><th>Created</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach ($products as $product) : ?>
                    <?php $value = static function ($key) use ($product) { return is_array($product) ? ($product[$key] ?? '') : ($product->$key ?? ''); }; ?>
                    <tr>
                        <td><?= (int) $value('id') ?></td>
                        <td><?= htmlspecialchars((string) $value('product_name'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $value('description'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars(number_format((float) $value('price'), 2), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= (int) $value('quantity') ?></td>
                        <td><?= htmlspecialchars((string) $value('created_at'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="actions">
                            <a class="edit" href="/products/edit/<?= (int) $value('id') ?>">Edit</a>
                            <form method="post" action="/products/delete/<?= (int) $value('id') ?>" onsubmit="return confirm('Delete this product?');"><button class="button danger" type="submit">Delete</button></form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?><div class="empty">No product records found.</div><?php endif; ?>
</div>
</body>
</html>
