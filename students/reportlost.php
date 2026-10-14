<?php
session_start();
require_once "userguard.php";
require_once "../classes/Student.php";

$student = new Student;
$categories = $student->get_all_categories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusFind - Report a Lost Item</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fa/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <style>
        body { background: #f8fafc; }
        .lost-form { max-width: 760px; margin: 3rem auto; padding: 2rem; background: #fff; border-radius: 20px; box-shadow: 0 8px 24px rgba(15,23,42,.06); }
        .page-banner { padding: 3rem 1rem; text-align: center; color: #fff; background: linear-gradient(135deg,#4f46e5,#06b6d4); }
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
                    <li class="nav-item"><a class="nav-link" href="wanted.php">Wanted/Lost Items</a></li>
                    <li class="nav-item"><a class="nav-link nav-home" href="reportlost.php">Report Lost Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="claims.php">Claims</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2"><a href="studentprofile.php" class="btn btn-login">Profile</a><a href="logout.php" class="btn btn-danger">Sign Out</a></div>
            </div>
        </nav>
    </div>
</header>
<section class="page-banner">
    <h1 class="fw-bold">Report a Lost Item</h1>
    <p class="mb-0">Post a notice so other students can help you find it.</p>
</section>
<main class="container">
    <form class="lost-form" action="../action/reportlost.php" method="post">
        <?php require_once "../partials/feedback.php"; ?>
        <div class="mb-3">
            <label for="lostName" class="form-label">Item name</label>
            <input id="lostName" name="name" class="form-control" maxlength="150" required>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="lostCategory" class="form-label">Category</label>
                <select id="lostCategory" name="category" class="form-select" required>
                    <option value="">Choose a category</option>
                    <?php foreach($categories ?: [] as $category): ?>
                        <option value="<?php echo (int)$category['categories_id']; ?>"><?php echo htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="lostDate" class="form-label">Date lost</label>
                <input id="lostDate" name="date_lost" type="date" class="form-control" max="<?php echo date('Y-m-d'); ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="lostLocation" class="form-label">Last seen location</label>
            <input id="lostLocation" name="location" class="form-control" maxlength="255" required>
        </div>
        <div class="mb-3">
            <label for="lostDescription" class="form-label">Description (include identifying details)</label>
            <textarea id="lostDescription" name="description" class="form-control" rows="4" maxlength="2000" required></textarea>
        </div>
        <div class="mb-4">
            <label for="lostContact" class="form-label">Contact details (optional)</label>
            <input id="lostContact" name="contact" class="form-control" maxlength="255" placeholder="How should someone contact you?">
            <div class="form-text">Only share details you are comfortable displaying to other students.</div>
        </div>
        <button type="submit" class="btn btn-primary w-100" name="report_lost" value="1">Post Lost Item Notice</button>
    </form>
</main>
<?php require_once "footer.php"; ?>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
