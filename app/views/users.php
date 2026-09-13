<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            color: #1f2937;
        }
        .container {
            width: min(1100px, calc(100% - 32px));
            margin: 48px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            overflow: hidden;
        }
        .header {
            padding: 24px 28px;
            border-bottom: 1px solid #e5e7eb;
        }
        .header h1 {
            margin: 0 0 6px;
            font-size: 28px;
        }
        .header p {
            margin: 0;
            color: #6b7280;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .button, .link-button {
            display: inline-block;
            border: 0;
            border-radius: 6px;
            padding: 10px 14px;
            background: #2563eb;
            color: #ffffff;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }
        .button.danger {
            background: #dc2626;
        }
        .actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .actions form {
            margin: 0;
        }
        .actions .edit {
            color: #2563eb;
            text-decoration: none;
        }
        .table-wrap {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }
        th {
            background: #f9fafb;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #4b5563;
        }
        tbody tr:hover {
            background: #f9fafb;
        }
        .empty {
            padding: 28px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Users</h1>
        <p>Manage records in the <strong>users</strong> table.</p>
        <a class="link-button" href="/users/create">Add user</a>
    </div>

    <?php if (!empty($users)) : ?>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) : ?>
                   <?php
$id        = is_array($user) ? ($user['id'] ?? '') : ($user->id ?? '');
$firstname = is_array($user) ? ($user['firstname'] ?? '') : ($user->firstname ?? '');
$lastname  = is_array($user) ? ($user['lastname'] ?? '') : ($user->lastname ?? '');
$email     = is_array($user) ? ($user['email'] ?? '') : ($user->email ?? '');
$username  = is_array($user) ? ($user['username'] ?? '') : ($user->username ?? '');
?>
                    <tr>
                        <td><?= htmlspecialchars((string) $id, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $firstname, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $lastname, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $email, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $username, ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="actions">
                            <a class="edit" href="/users/edit/<?= (int) $id ?>">Edit</a>
                            <form method="post" action="/users/delete/<?= (int) $id ?>" onsubmit="return confirm('Delete this user?');">
                                <button class="button danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="empty">No user records found.</div>
    <?php endif; ?>
</div>
</body>
</html>
