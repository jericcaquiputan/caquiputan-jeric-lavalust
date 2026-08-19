<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeric's Protected Student Profile</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef2f7;
            color: #1f2937;
            min-height: 100vh;
            padding: 45px 20px;
        }
        .profile-card {
            max-width: 760px;
            margin: auto;
            background: white;
            border-radius: 18px;
            padding: 34px;
            box-shadow: 0 14px 35px rgba(0,0,0,.10);
        }
        nav { margin-bottom: 24px; }
        nav a {
            display: inline-block;
            text-decoration: none;
            margin-right: 8px;
            padding: 10px 15px;
            border-radius: 8px;
            background: #1f2937;
            color: white;
        }
        .protected {
            background: #dcfce7;
            color: #166534;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-weight: 600;
        }
        h1 { margin-top: 0; }
        .row {
            display: grid;
            grid-template-columns: 170px 1fr;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .label { font-weight: 700; }
        @media (max-width: 560px) {
            .row { grid-template-columns: 1fr; gap: 4px; }
        }
    </style>
</head>
<body>
<div class="profile-card">
    <nav>
        <a href="<?= site_url('student'); ?>">Home</a>
        <a href="<?= site_url('student/profile'); ?>">Student Profile</a>
    </nav>

    <div class="protected">
        Protected route successfully accessed through StudentMiddleware.
    </div>

    <h1>Student Information</h1>

    <div class="row">
        <div class="label">Student ID</div>
        <div><?= htmlspecialchars($student_id); ?></div>
    </div>
    <div class="row">
        <div class="label">Student Name</div>
        <div><?= htmlspecialchars($name); ?></div>
    </div>
    <div class="row">
        <div class="label">Course</div>
        <div><?= htmlspecialchars($course); ?></div>
    </div>
    <div class="row">
        <div class="label">Year Level</div>
        <div><?= htmlspecialchars($year); ?></div>
    </div>
    <div class="row">
        <div class="label">Section</div>
        <div><?= htmlspecialchars($section); ?></div>
    </div>
    <div class="row">
        <div class="label">Email</div>
        <div><?= htmlspecialchars($email); ?></div>
    </div>
</div>
</body>
</html>
