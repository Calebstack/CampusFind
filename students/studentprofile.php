<?php

session_start();
require_once "userguard.php";
require "../classes/Student.php";
    $student = new Student();
    if(isset($_SESSION['useronline'])){
    $students = $student->fetch_studentid($_SESSION['useronline']);   
}

$profile = $student->fetch_profile($_SESSION['useronline']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind - My Profile</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f8fafc; }

.page-banner {
    background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
    padding: 60px 0;
    text-align: center;
}
.page-banner h2 { font-weight: 800; color: #fff; letter-spacing: -0.02em; font-size: 2rem; }
.page-banner p { color: rgba(255,255,255,0.85); margin-bottom: 0; }

.profile-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: -50px;
    position: relative;
    z-index: 10;
}

.profile-avatar-ring {
    width: 110px; height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.6rem; color: #fff;
    border: 4px solid #fff;
    box-shadow: 0 8px 30px rgba(79,70,229,0.3);
    margin-bottom: 16px;
}

.profile-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 8px 24px rgba(15,23,42,0.07);
    text-align: center;
}

.profile-name {
    font-size: 1.5rem; font-weight: 800; color: #0f172a;
    letter-spacing: -0.02em; margin-bottom: 4px;
}

.profile-dept {
    font-size: 0.9rem; color: #64748b; font-weight: 500;
    background: rgba(79,70,229,0.08); color: #4f46e5;
    border-radius: 999px; padding: 3px 14px;
    display: inline-block; margin-bottom: 6px;
}

.profile-email {
    font-size: 0.88rem; color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
    gap: 6px; margin-top: 8px;
}

.info-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 8px 24px rgba(15,23,42,0.06);
}

.info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(226,232,240,0.6);
}
.info-row:last-child { border-bottom: none; }

.info-label {
    font-size: 0.82rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: #94a3b8;
    display: flex; align-items: center; gap: 8px;
}

.info-label i { color: #4f46e5; }

.info-value { font-weight: 600; color: #0f172a; font-size: 0.92rem; }

.section-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(79,70,229,0.08); color: #4f46e5;
    border-radius: 999px; font-size: 0.75rem; font-weight: 700;
    padding: 4px 14px; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px;
}
</style>

</head>
<body>

<?php require_once "header.php"; ?>

<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#"><img src="../images/logop.png" alt="CampusFind"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="studenthome.php"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php"><i class="fas fa-th-large me-1"></i>Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportfound.php"><i class="fas fa-plus-circle me-1"></i>Report Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="claims.php"><i class="fas fa-clipboard-list me-1"></i>Claims</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="studentprofile.php" class="btn btn-login nav-home"><i class="fas fa-user me-1"></i> Profile</a>
                    <a href="logout.php" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.9rem;"><i class="fas fa-sign-out-alt me-1"></i> Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- PAGE BANNER -->
<div class="page-banner">
    <h2><i class="fas fa-user-circle me-2"></i>My Profile</h2>
    <p>Your account information at a glance.</p>
</div>

<!-- PROFILE CONTENT -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center g-4">

            <!-- Profile Summary Card -->
            <div class="col-lg-4">
                <div class="profile-card">
                    <div class="profile-wrapper">
                        <div class="profile-avatar-ring">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="profile-name"><?php echo $students['student_fname'] . " " . $students['student_lname']; ?></h4>
                        <div class="profile-dept"><?php echo $profile['dept_name']; ?></div>
                        <div class="profile-email">
                            <i class="fas fa-envelope" style="color:#4f46e5;"></i>
                            <?php echo $profile['student_email']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Detail Card -->
            <div class="col-lg-5">
                <div class="info-card">
                    <div class="section-tag mb-4"><i class="fas fa-id-card"></i> Account Details</div>

                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-user"></i> First Name</div>
                        <div class="info-value"><?php echo $students['student_fname']; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-user"></i> Last Name</div>
                        <div class="info-value"><?php echo $students['student_lname']; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="info-value"><?php echo $profile['student_email']; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-graduation-cap"></i> Department</div>
                        <div class="info-value"><?php echo $profile['dept_name']; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-shield-alt"></i> Role</div>
                        <div class="info-value">
                            <span style="background: rgba(79,70,229,0.1); color: #4f46e5; border-radius: 999px; padding: 3px 12px; font-size: 0.8rem;">Student</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once "footer.php" ?>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
