<?php
session_start();
require_once "userguard.php";
require_once "../classes/Student.php";

$student = new Student;
$items = $student->get_open_lost_items();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusFind - Wanted/Lost Items</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fa/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <style>
        body { background: #f8fafc; }
        .page-banner { padding: 3rem 1rem; text-align: center; color: #fff; background: linear-gradient(135deg,#4f46e5,#06b6d4); }
        .lost-card { height: 100%; padding: 1.5rem; background: #fff; border: 1px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 12px rgba(15,23,42,.05); }
        .lost-card h2 { color: #0f172a; font-size: 1.25rem; font-weight: 750; }
        .lost-meta { color: #64748b; font-size: .9rem; }
    </style>
</head>
<body>
<?php require_once "header.php"; ?>
<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="studenthome.php"><img src="../images/logop.png" alt="CampusFind" height="40"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="studenthome.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="items.php">Found Items</a></li>
                    <li class="nav-item"><a class="nav-link nav-home" href="wanted.php">Wanted/Lost Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportlost.php">Report Lost Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="claims.php">Claims</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2"><a href="studentprofile.php" class="btn btn-login">Profile</a><a href="logout.php" class="btn btn-danger">Sign Out</a></div>
            </div>
        </nav>
    </div>
</header>
<section class="page-banner">
    <h1 class="fw-bold">Wanted / Lost Items</h1>
    <p class="mb-3">Help fellow students reunite with things they have lost.</p>
    <a class="btn btn-light fw-bold" href="reportlost.php"><i class="fas fa-plus me-1"></i>Report a Lost Item</a>
</section>
<main class="container py-5">
    <?php require_once "../partials/feedback.php"; ?>
    <div class="row g-4">
        <?php foreach($items ?: [] as $item): ?>
            <div class="col-lg-4 col-md-6">
                <article class="lost-card">
                    <span class="badge text-bg-warning mb-3">Lost item</span>
                    <h2><?php echo htmlspecialchars($item['lostitems_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="lost-meta mb-2"><i class="fas fa-tag me-1"></i><?php echo htmlspecialchars($item['category_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="lost-meta mb-2"><i class="fas fa-map-marker-alt me-1"></i>Last seen: <?php echo htmlspecialchars($item['lostitems_location'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="lost-meta mb-3"><i class="fas fa-calendar me-1"></i>Lost: <?php echo htmlspecialchars($item['lostitems_date'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <p><?php echo nl2br(htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                    <div class="small text-muted">Posted by <?php echo htmlspecialchars($item['student_fname'], ENT_QUOTES, 'UTF-8'); ?> on <?php echo htmlspecialchars($item['created_at'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php if(!empty($item['contact'])): ?>
                        <div class="mt-3"><strong>Contact:</strong> <?php echo htmlspecialchars($item['contact'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                </article>
            </div>
        <?php endforeach; ?>
        <?php if(!$items): ?>
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-search fa-2x mb-3"></i>
                <p>No open lost-item notices yet. Be the first to post one.</p>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php require_once "footer.php"; ?>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
