<?php
session_start();
require_once "../classes/Student.php";
require_once "userguard.php";

$student = new Student;
if(isset($_SESSION['useronline'])){
    $students = $student->fetch_studentid($_SESSION['useronline']);   
}

$founditems = $student->get_founditems();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind - Home</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }

body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f8fafc; }

/* Hero */
.student-hero {
    background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%) !important;
    padding: 90px 0 70px !important;
    position: relative;
    overflow: hidden;
}

.student-hero::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -200px; right: -100px;
}

.student-hero::after {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    bottom: -100px; left: -50px;
}

.student-hero .container { position: relative; z-index: 2; }

.student-hero h1 { font-weight: 800; font-size: clamp(2rem, 4.5vw, 2.8rem); color: #fff; letter-spacing: -0.02em; line-height: 1.2; }
.student-hero p { color: rgba(255,255,255,0.85); font-size: 1.05rem; }

.hero-welcome {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 999px;
    padding: 6px 18px;
    font-size: 0.9rem;
    font-weight: 600;
    color: rgba(255,255,255,0.95);
    margin-bottom: 20px;
}

/* Item cards */
.item-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
}

.item-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 48px rgba(79, 70, 229, 0.12);
    border-color: rgba(79, 70, 229, 0.2);
}

.item-card .card-img-top {
    height: 230px;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.item-card:hover .card-img-top { transform: scale(1.06); }

.card-body { padding: 1.5rem; }

.card-title {
    font-weight: 700;
    color: #0f172a;
    font-size: 1.05rem;
    margin-bottom: 6px;
}

.card-location {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #64748b;
    font-size: 0.88rem;
    margin-bottom: 1.25rem;
}

.card-location i { color: var(--primary); font-size: 0.8rem; }

.btn-view {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.6rem 1.25rem;
    font-size: 0.88rem;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.45);
    color: #fff;
}

.section-heading {
    font-weight: 800;
    font-size: 1.8rem;
    color: #0f172a;
    letter-spacing: -0.02em;
}

.section-sub { color: #64748b; font-size: 0.95rem; }

.section-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(79, 70, 229, 0.08);
    color: #4f46e5;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 14px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 10px;
}

.btn-view-more {
    background: transparent;
    border: 2px solid #4f46e5;
    color: #4f46e5;
    border-radius: 12px;
    padding: 0.75rem 2.5rem;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.btn-view-more:hover {
    background: #4f46e5;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
}
</style>

</head>
<body>

<?php require_once "header.php"; ?>

<!-- HEADER NAV -->
<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">

            <a class="navbar-brand" href="#">
                <img src="../images/logop.png" alt="CampusFind">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-home" href="studenthome.php"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php"><i class="fas fa-th-large me-1"></i>Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reportfound.php"><i class="fas fa-plus-circle me-1"></i>Report Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="claims.php"><i class="fas fa-clipboard-list me-1"></i>Claims</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="studentprofile.php" class="btn btn-login">
                        <i class="fas fa-user me-1"></i> Profile
                    </a>
                    <a href="logout.php" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.9rem;">
                        <i class="fas fa-sign-out-alt me-1"></i> Sign Out
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- HERO SECTION -->
<section class="hero student-hero">
    <div class="container text-center">
        <div class="hero-welcome">
            <i class="fas fa-hand-peace"></i>
            Welcome back, <?php echo $students['student_fname'] . " " . $students['student_lname']; ?>
        </div>
        <h1 class="mb-3">Find Lost Items Across Campus</h1>
        <p class="lead mb-0">Browse reported items and reclaim what belongs to you.</p>
    </div>
</section>

<!-- RECENT ITEMS -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag"><i class="fas fa-box-open"></i> Recent Finds</div>
            <h2 class="section-heading">Recently Found Items</h2>
            <p class="section-sub">Click on any item to view details and make a claim.</p>
            <?php
                if(isset($_SESSION['errormsg'])){
                    echo "<div class='alert alert-danger rounded-3 mt-3'>".$_SESSION['errormsg']."</div>";
                    unset($_SESSION['errormsg']);
                }
                if(isset($_SESSION['feedback'])){
                    echo "<div class='alert alert-success rounded-3 mt-3'>".$_SESSION['feedback']."</div>";
                    unset($_SESSION['feedback']);
                }
            ?>
        </div>

        <div class="row g-4">
            <?php foreach($founditems as $founditem){ ?>
            <div class="col-lg-4 col-md-6">
                <div class="item-card">
                    <div style="overflow: hidden;">
                        <img src="<?php echo $founditem['founditems_img']; ?>" class="card-img-top" alt="<?php echo $founditem['founditems_name']; ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $founditem['founditems_name']; ?></h5>
                        <div class="card-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $founditem['founditems_location']; ?>
                        </div>
                        <a href="itemdetails.php?id=<?php echo $founditem['founditems_id']; ?>" class="btn-view" style="text-decoration: none">
                            <i class="fas fa-eye"></i> View Item
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

    </div>
</section>

<?php require_once "footer.php" ?>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>