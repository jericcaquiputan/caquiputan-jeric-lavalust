<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeric's Student Information Portal</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef2f7, #dfe8f3);
            color: #1f2937;
            min-height: 100vh;
            padding: 45px 20px;
        }
        .card {
            max-width: 820px;
            margin: auto;
            background: #fff;
            border-radius: 18px;
            padding: 34px;
            box-shadow: 0 14px 35px rgba(0,0,0,.10);
        }
        h1 { margin-top: 0; font-size: 32px; }
        .subtitle { color: #64748b; margin-bottom: 24px; }
        nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 26px;
        }
        nav a, .btn {
            display: inline-block;
            padding: 11px 17px;
            border-radius: 9px;
            text-decoration: none;
            background: #1f2937;
            color: white;
            font-weight: 600;
        }
        .student-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 22px;
        }
        .student-box p { margin: 9px 0; }
        .status {
            padding: 14px 16px;
            border-radius: 10px;
            margin: 16px 0;
            font-weight: 600;
        }
        .allowed { background: #dcfce7; color: #166534; }
        .locked  { background: #fff7ed; color: #9a3412; }
        .blocked { background: #fee2e2; color: #991b1b; }
        .btn.secondary { background: #475569; }
    </style>
</head>
<body>
<div class="card">
    <h1>Jeric's Student Information Portal</h1>
    <p class="subtitle">Laboratory Activity 3 — LavaLust Routing, Controllers, Views, and Middleware</p>

    <nav>
        <a href="<?= site_url('student'); ?>">Home</a>
        <a href="<?= site_url('student/profile'); ?>">Student Profile</a>
    </nav>

    <?php if ($blocked): ?>
        <div class="status blocked">
            Access denied: the student profile is protected by StudentMiddleware.
        </div>
    <?php endif; ?>

    <div class="student-box">
        <h2>Student Home</h2>
        <p><strong>Student ID:</strong> <?= htmlspecialchars($student_id); ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($name); ?></p>
        <p><strong>Course:</strong> <?= htmlspecialchars($course); ?></p>
        <p><strong>Year & Section:</strong> <?= htmlspecialchars($year); ?> — <?= htmlspecialchars($section); ?></p>
    </div>

    <h3>Profile Access</h3>

    <?php if ($access_granted): ?>
        <div class="status allowed">Profile access is ENABLED.</div>
        <a class="btn" href="<?= site_url('student/profile'); ?>">Open Protected Profile</a>
        <a class="btn secondary" href="<?= site_url('student'); ?>?lock=1">Lock Profile</a>
    <?php else: ?>
        <div class="status locked">Profile access is LOCKED.</div>
        <a class="btn" href="<?= site_url('student'); ?>?access=JERIC3F6">Enable Profile Access</a>
    <?php endif; ?>
</div>
</body>
</html>
