<?php

session_start();

require_once "../classes/Student.php";
require_once "userguard.php";

$student = new Student;
if(isset($_SESSION['useronline'])){
    $students = $student->fetch_studentid($_SESSION['useronline']);   
}

$all = $student->founditems_categrory();
$cats = $student->get_all_categories();


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind - Categories</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f8fafc; }

.student-hero {
    background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%) !important;
    padding: 70px 0 50px !important;
    position: relative;
    overflow: hidden;
}
.student-hero::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -150px; right: -80px;
}
.student-hero .container { position: relative; z-index: 2; }
.student-hero h1 { font-weight: 800; color: #fff; letter-spacing: -0.02em; }
.student-hero p { color: rgba(255,255,255,0.85); }

/* Filter bar */
.filter-bar {
    background: #fff;
    border-bottom: 1px solid rgba(226,232,240,0.8);
    padding: 20px 0;
    position: sticky;
    top: 62px;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(15,23,42,0.04);
}

.filter-select {
    border-radius: 12px !important;
    border: 1px solid rgba(226,232,240,0.8) !important;
    background: #f8fafc !important;
    padding: 0.7rem 1.1rem !important;
    font-weight: 600 !important;
    color: #0f172a !important;
    font-size: 0.92rem !important;
    transition: all 0.25s ease !important;
}
.filter-select:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 4px rgba(79,70,229,0.1) !important;
    background: #fff !important;
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
    height: 220px;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
.item-card:hover .card-img-top { transform: scale(1.06); }
.card-body { padding: 1.4rem; }
.card-category {
    font-size: 0.72rem;
    font-weight: 700;
    color: #4f46e5;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    background: rgba(79,70,229,0.08);
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    margin-bottom: 8px;
}
.card-title { font-weight: 700; color: #0f172a; font-size: 1rem; margin-bottom: 5px; }
.card-location { display: flex; align-items: center; gap: 6px; color: #64748b; font-size: 0.85rem; margin-bottom: 1rem; }
.card-location i { color: #4f46e5; font-size: 0.78rem; }

.btn-view {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff; border: none; border-radius: 10px;
    padding: 0.55rem 1.1rem; font-size: 0.85rem; font-weight: 700;
    transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(79,70,229,0.3);
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-view:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79,70,229,0.45); color: #fff; }

.section-heading { font-weight: 800; font-size: 1.6rem; color: #0f172a; letter-spacing: -0.02em; }
.section-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(79,70,229,0.08); color: #4f46e5;
    border-radius: 999px; font-size: 0.75rem; font-weight: 700;
    padding: 4px 14px; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px;
}

.empty-state { display: none; text-align: center; padding: 80px 20px; color: #94a3b8; }
.empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
.empty-state p { font-size: 1rem; }
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
                    <li class="nav-item"><a class="nav-link" href="studenthome.php"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="nav-item"><a class="nav-link nav-home" href="categories.php"><i class="fas fa-th-large me-1"></i>Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportfound.php"><i class="fas fa-plus-circle me-1"></i>Report Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="claims.php"><i class="fas fa-clipboard-list me-1"></i>Claims</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="studentprofile.php" class="btn btn-login"><i class="fas fa-user me-1"></i> Profile</a>
                    <a href="logout.php" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.9rem;"><i class="fas fa-sign-out-alt me-1"></i> Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- HERO SECTION -->
<section class="hero student-hero">
    <div class="container text-center">
        <h1 class="display-5 mb-3">Browse by Category</h1>
        <p class="lead mb-0">Narrow down found items by type to find yours faster.</p>
    </div>
</section>

<!-- FILTER BAR -->
<div class="filter-bar">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <select class="form-select filter-select" id="categorySelect" aria-label="Filter by category">
                    <option value="all"><i class="fas fa-th"></i> All Categories</option>
                    <?php foreach($cats as $cat){ ?>
                    <option value="<?php echo $cat['categories_id']; ?>"><?php echo $cat['category_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- ITEMS -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag"><i class="fas fa-box-open"></i> Found Items</div>
            <h2 class="section-heading" id="resultsTitle">All Items</h2>
            <p class="text-muted" id="resultsCount">Click on any item to view details and make a claim.</p>
        </div>

        <div class="row g-4" id="itemsGrid">
            <?php foreach($all as $al){ ?>
                <div class="col-lg-4 col-md-6 item-col" data-category-id="<?php echo $al['category_id']; ?>">
                    <div class="item-card">
                        <div style="overflow: hidden;">
                            <img src="<?php echo $al['founditems_img']; ?>" class="card-img-top" alt="<?php echo $al['founditems_name']; ?>">
                        </div>
                        <div class="card-body">
                            <div class="card-category"><?php echo $al['category_name']; ?></div>
                            <h5 class="card-title"><?php echo $al['founditems_name']; ?></h5>
                            <div class="card-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo $al['founditems_location']; ?>
                            </div>
                            <a href="itemdetails.php?id=<?php echo $al['founditems_id']; ?>" class="btn-view" style="text-decoration: none">
                                <i class="fas fa-eye"></i> View Item
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- EMPTY STATE -->
        <div class="empty-state" id="emptyState">
            <i class="fas fa-box-open d-block mb-3"></i>
            <p class="mb-0">No items available in this category.</p>
        </div>
    </div>
</section>

<script>
document.getElementById('categorySelect').onchange = function() {
    var selected = this.value;
    var items = document.querySelectorAll('.item-col');
    var visible = 0;
    items.forEach(function(item) {
        var catId = item.getAttribute('data-category-id');
        if (selected == 'all' || catId == selected) {
            item.style.display = '';
            visible++;
        } else {
            item.style.display = 'none';
        }
    });
    document.getElementById('emptyState').style.display = (visible > 0) ? 'none' : 'block';
};
</script>

<?php require_once "footer.php" ?>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>