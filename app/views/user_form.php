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
        input { width: 100%; box-sizing: border-box; padding: 11px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; }
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
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'Email',
            'username' => 'Username',
        ] as $field => $label) : ?>
            <label for="<?= $field ?>"><?= $label ?></label>
            <input id="<?= $field ?>" name="<?= $field ?>" type="<?= $field === 'email' ? 'email' : 'text' ?>" value="<?= htmlspecialchars((string) ($user[$field] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
            <?php if (!empty($errors[$field])) : ?><p class="error"><?= htmlspecialchars($errors[$field], ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
        <?php endforeach; ?>
        <div class="actions">
            <button type="submit">Save user</button>
            <a class="cancel" href="/">Cancel</a>
        </div>
    </form>
</main>
</body>
</html>