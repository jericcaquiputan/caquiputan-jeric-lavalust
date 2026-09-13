<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <style>
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f4f6f8; color: #1f2937; }
        .container { width: min(420px, calc(100% - 32px)); margin: 72px auto; background: #fff; border-radius: 12px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,.08); box-sizing: border-box; }
        h1 { margin: 0 0 8px; }
        p { color: #6b7280; }
        label { display: block; margin: 18px 0 6px; font-weight: 600; }
        input { width: 100%; box-sizing: border-box; padding: 11px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; }
        button { margin-top: 24px; width: 100%; border: 0; border-radius: 6px; padding: 11px 16px; background: #2563eb; color: #fff; font-size: 15px; cursor: pointer; }
        .error { color: #b91c1c; }
    </style>
</head>
<body>
<main class="container">
    <h1>Sign in</h1>
    <p>Authentication is required to manage products.</p>
    <?php if (!empty($error)) : ?><p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
    <form method="post" action="/login">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?= htmlspecialchars((string) $username, ENT_QUOTES, 'UTF-8') ?>" required autofocus>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
        <button type="submit">Sign in</button>
    </form>
</main>
</body>
</html>
