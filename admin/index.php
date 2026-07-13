<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="CampusFind Team">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login - CampusFind</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fa/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <style>
        body {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.75) 0%, rgba(79, 70, 229, 0.55) 100%), url('../images/bg1.jpg') center/cover no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 24px;
            padding: 48px 44px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 32px 64px rgba(15, 23, 42, 0.2), 0 4px 16px rgba(79, 70, 229, 0.1);
        }

        .auth-logo {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.05em;
            color: #0f172a;
            text-decoration: none;
        }
        .auth-logo span { color: #4f46e5; }

        .auth-tagline {
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 4px;
        }

        .admin-badge-header {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
        }

        .btn-auth {
            width: 100%;
            padding: 0.85rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 12px;
            background: linear-gradient(135deg, #0f172a 0%, #4f46e5 100%);
            border: none;
            color: #fff;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.3);
            transition: all 0.3s ease;
        }
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
            filter: brightness(1.1);
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <a href="#" class="auth-logo">Campus<span>Find</span></a><br>
                <p class="admin-badge-header"><i class="fas fa-shield-alt"></i> Admin Portal</p>
            </div>

            <?php require_once "../partials/feedback.php"; ?>
            <form action="action/login.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="email">Admin Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="admin@campusfind.ng" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-auth mb-3" name="login">
                    <i class="fas fa-lock me-2"></i>Admin Sign In
                </button>
            </form>
        </div>
    </div>
</body>
</html>
