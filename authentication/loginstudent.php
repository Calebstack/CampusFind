<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="CampusFind Team">
    <meta name="robots" content="index, follow">
    <title>Student Login - CampusFind</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fa/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <style>
        body {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.55) 0%, rgba(6, 182, 212, 0.55) 100%), url('../images/bg1.jpg') center/cover no-repeat;
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
            box-shadow: 0 32px 64px rgba(15, 23, 42, 0.15), 0 4px 16px rgba(79, 70, 229, 0.1);
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

        /* Tab switcher — side-by-side with icons */
        .auth-tabs {
            display: flex;
            gap: 10px;
            background: rgba(241, 245, 249, 0.9);
            border-radius: 14px;
            padding: 6px;
            margin-bottom: 28px;
        }

        .auth-tab {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.92rem;
            cursor: pointer;
            text-decoration: none;
            color: #64748b;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .auth-tab i {
            font-size: 1rem;
        }

        .auth-tab.active {
            background: #ffffff;
            color: #4f46e5;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.1);
        }

        .auth-tab:not(.active):hover {
            color: #4f46e5;
            background: rgba(79, 70, 229, 0.06);
            text-decoration: none;
        }

        .extra-links {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }
        .extra-links:hover { text-decoration: underline; color: #4338ca; }

        .btn-auth {
            width: 100%;
            padding: 0.85rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border: none;
            color: #fff;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            transition: all 0.3s ease;
        }
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
            filter: brightness(1.08);
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <a href="index.php" class="auth-logo">Campus<span>Find</span></a>
                <p class="auth-tagline">Lost today, found tomorrow</p>
            </div>



            <?php require_once "../partials/feedback.php"; ?>
            <form action="../action/student_login.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="you@university.edu" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label text-muted" for="rememberMe">Remember me</label>
                    </div>
                </div>
                <button type="submit" name="loginstd" class="btn-auth mb-4">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
                <div class="text-center" style="font-size: 0.92rem; color: #64748b;">
                    Don't have an account? <a href="signupstudent.php" class="extra-links">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>