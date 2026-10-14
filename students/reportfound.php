<?php

session_start();
require_once "userguard.php";
require_once "../classes/Student.php";
    $student = new Student();
    $record = $student->fetch_studentid($_SESSION['useronline']);
    $cats = $student->get_all_categories();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind - Report a Found Item</title>

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

.form-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 8px 24px rgba(15,23,42,0.06);
}

.section-divider {
    border: none;
    border-top: 1px solid rgba(226,232,240,0.8);
    margin: 2rem 0;
}

.field-group-label {
    font-weight: 700; color: #0f172a;
    font-size: 0.88rem; margin-bottom: 0.75rem;
    text-transform: uppercase; letter-spacing: 0.05em;
    display: flex; align-items: center; gap: 8px;
}

/* Radio option cards */
.dropoff-option {
    border: 2px solid rgba(226,232,240,0.8);
    border-radius: 14px;
    padding: 1.1rem 1.25rem;
    margin-bottom: 12px;
    display: flex; align-items: flex-start; gap: 14px;
    cursor: pointer;
    transition: all 0.25s ease;
    background: #fff;
}
.dropoff-option:hover { border-color: #4f46e5; background: rgba(79,70,229,0.02); }
.dropoff-option input[type="radio"] { margin-top: 3px; accent-color: #4f46e5; flex-shrink: 0; }
.opt-title { font-weight: 700; color: #0f172a; font-size: 0.92rem; }
.opt-desc { font-size: 0.8rem; color: #64748b; margin-top: 2px; }

.badge-default {
    font-size: 0.68rem; background: #ecfdf5; color: #047857;
    padding: 2px 8px; border-radius: 999px; font-weight: 700;
    margin-left: 8px; vertical-align: middle;
}

.file-upload-area {
    border: 2px dashed rgba(79,70,229,0.25);
    border-radius: 14px;
    padding: 1.5rem;
    background: rgba(79,70,229,0.02);
    transition: all 0.25s ease;
}
.file-upload-area:hover { border-color: #4f46e5; background: rgba(79,70,229,0.04); }
.file-upload-area .form-control { border: none !important; background: transparent !important; padding: 0 !important; box-shadow: none !important; }

.btn-submit {
    width: 100%;
    padding: 1rem;
    font-size: 1rem; font-weight: 700;
    border-radius: 14px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border: none; color: #fff;
    box-shadow: 0 4px 14px rgba(79,70,229,0.35);
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,70,229,0.45); filter: brightness(1.08); }

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
                    <li class="nav-item"><a class="nav-link" href="items.php"><i class="fas fa-th-large me-1"></i>Browse Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="wanted.php"><i class="fas fa-bullhorn me-1"></i>Wanted/Lost</a></li>
                    <li class="nav-item"><a class="nav-link nav-home" href="reportfound.php"><i class="fas fa-plus-circle me-1"></i>Report Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportlost.php"><i class="fas fa-search me-1"></i>Report Lost</a></li>
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

<!-- PAGE BANNER -->
<div class="page-banner">
    <h2><i class="fas fa-search-location me-2"></i>Report a Found Item</h2>
    <p>Found something on campus? Fill in the details to help reunite it with its owner.</p>
</div>

<!-- FORM -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="form-card">
                    <form action="../action/reportitems.php" method="post" enctype="multipart/form-data">
                        <?php
                            if(isset($_SESSION['errormsg'])){
                                echo "<div class='alert alert-danger rounded-3 mb-4'>".$_SESSION['errormsg']."</div>";
                                unset($_SESSION['errormsg']);
                            }
                            if(isset($_SESSION['feedback'])){
                                echo "<div class='alert alert-success rounded-3 mb-4'>".$_SESSION['feedback']."</div>";
                                unset($_SESSION['feedback']);
                            }
                        ?>

                        <!-- Item Info -->
                        <div class="mb-3">
                            <label class="form-label" for="itemName"><i class="fas fa-tag me-1" style="color:#4f46e5;"></i> Item Name</label>
                            <input type="text" name="name" class="form-control" id="itemName" placeholder="e.g. HP Laptop, Samsung Phone..." value="">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="category"><i class="fas fa-th me-1" style="color:#4f46e5;"></i> Category</label>
                                <select name="category" class="form-select" id="category">
                                    <option value="">Select category</option>
                                    <?php foreach($cats as $cat){ ?>
                                    <option value="<?php echo $cat['categories_id'] ?>"><?php echo $cat['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="dateFound"><i class="fas fa-calendar me-1" style="color:#4f46e5;"></i> Date Found</label>
                                <input type="date" name="date_found" class="form-control" id="dateFound" value="">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="location"><i class="fas fa-map-marker-alt me-1" style="color:#4f46e5;"></i> Location Found</label>
                            <input type="text" name="location" class="form-control" id="location" placeholder="e.g. Library, 2nd Floor" value="">
                        </div>

                        <!-- Photo Upload -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-camera me-1" style="color:#4f46e5;"></i> Item Photo</label>
                            <div class="file-upload-area">
                                <input type="file" name="photo" class="form-control" id="itemPhoto" accept="image/png, image/jpeg, image/gif">
                                <div class="form-text mt-2" style="color:#64748b;"><i class="fas fa-info-circle me-1"></i>Upload a clear photo of the item (PNG, JPG, GIF)</div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Collection Location -->
                        <div class="mb-3">
                            <div class="field-group-label"><i class="fas fa-map-pin" style="color:#4f46e5;"></i> Where can the item be collected?</div>

                            <div class="dropoff-option">
                                <input type="radio" name="report_option" value="security" id="securityOption" checked>
                                <div>
                                    <div class="opt-title">Campus Security Desk <span class="badge-default">Recommended</span></div>
                                    <div class="opt-desc">Item will be held at the main security desk</div>
                                </div>
                            </div>

                            <div class="dropoff-option">
                                <input type="radio" name="report_option" value="self" id="selfOption">
                                <div>
                                    <div class="opt-title">I am keeping the item</div>
                                    <div class="opt-desc">Provide your contact details below</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="reportedTo"><i class="fas fa-user me-1" style="color:#4f46e5;"></i> Your Contact Details</label>
                            <input type="text" name="reported_to" class="form-control" id="reportedTo" placeholder="Enter your name or contact details">
                        </div>

                        <button type="submit" name="report" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Submit Report
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "footer.php" ?>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>