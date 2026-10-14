<?php

session_start();
require_once "userguard.php";
require_once "../classes/Student.php";
$item = new Student;
$id = $_GET['id'];
$items = $item->fetch_founditemtid($id);
$is_reporter = ($items && isset($_SESSION['useronline']) && (int)$_SESSION['useronline'] === (int)($items['student_id'] ?? -1));

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind - Item Details</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f8fafc; }

.breadcrumb-link {
    color: #64748b; text-decoration: none; font-weight: 600; font-size: 0.9rem;
    display: inline-flex; align-items: center; gap: 6px;
    transition: all 0.2s ease;
    padding: 8px 16px;
    border-radius: 10px;
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    box-shadow: 0 1px 4px rgba(15,23,42,0.05);
}
.breadcrumb-link:hover { color: #4f46e5; border-color: rgba(79,70,229,0.3); transform: translateX(-3px); }

.item-photo-wrap {
    border-radius: 20px; overflow: hidden;
    border: 1px solid rgba(226,232,240,0.8);
    box-shadow: 0 8px 24px rgba(15,23,42,0.08);
}
.item-photo { width: 100%; display: block; }

.details-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 24px;
    padding: 2.25rem;
    box-shadow: 0 8px 24px rgba(15,23,42,0.06);
}

.category-pill {
    display: inline-block;
    background: rgba(79,70,229,0.1); color: #4f46e5;
    font-weight: 700; font-size: 0.72rem;
    text-transform: uppercase; letter-spacing: 0.05em;
    padding: 4px 12px; border-radius: 999px;
}

.status-pill {
    display: inline-block;
    font-weight: 700; font-size: 0.72rem;
    text-transform: uppercase; letter-spacing: 0.05em;
    padding: 4px 12px; border-radius: 999px;
    background: #ecfdf5; color: #047857;
}
.status-pill.claimed { background: #f1f5f9; color: #64748b; }

.item-title { font-weight: 800; font-size: 1.6rem; color: #0f172a; letter-spacing: -0.02em; margin: 14px 0 20px; }

.detail-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(226,232,240,0.6);
}
.detail-row:last-child { border-bottom: none; }
.detail-label { font-weight: 600; color: #94a3b8; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; }
.detail-label i { color: #4f46e5; }
.detail-value { font-weight: 700; color: #0f172a; font-size: 0.92rem; text-align: right; }

.btn-claim {
    width: 100%;
    padding: 1rem;
    font-size: 1rem; font-weight: 700;
    border-radius: 14px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border: none; color: #fff;
    box-shadow: 0 4px 14px rgba(79,70,229,0.35);
    transition: all 0.3s ease;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    margin-top: 1.5rem;
}
.btn-claim:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,70,229,0.45); filter: brightness(1.08); color: #fff; }

.btn-claimed-disabled {
    width: 100%;
    padding: 1rem;
    font-size: 1rem; font-weight: 700;
    border-radius: 14px;
    background: #f1f5f9;
    border: none; color: #94a3b8;
    cursor: not-allowed;
    margin-top: 1.5rem;
    display: flex; align-items: center; justify-content: center; gap: 8px;
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
                    <li class="nav-item"><a class="nav-link" href="reportfound.php"><i class="fas fa-plus-circle me-1"></i>Report Item</a></li>
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

<!-- ITEM DETAILS -->
<section class="py-5">
    <div class="container">
        <?php require_once "../partials/feedback.php"; ?>
        
        <a href="categories.php" class="breadcrumb-link mb-4 d-inline-flex">
            <i class="fas fa-arrow-left"></i> Back to results
        </a>

        <div class="row g-4 mt-2">

            <?php if($items){ ?>
            <!-- IMAGE -->
            <div class="col-lg-6">
                <div class="item-photo-wrap">
                    <img src="<?php echo $items['founditems_img']; ?>" class="item-photo" alt="<?php echo $items['founditems_name']; ?>">
                </div>
            </div>

            <!-- DETAILS -->
            <div class="col-lg-6">
                <div class="details-card">
                    <div>
                        <span class="category-pill"><?php echo $items['category_name'] ?? ''; ?></span>
                        <span class="status-pill ms-2 <?php echo ($items['status'] === 'claimed') ? 'claimed' : ''; ?>">
                            <?php echo ucfirst($items['status'] ?? 'available'); ?>
                        </span>
                    </div>

                    <h2 class="item-title"><?php echo $items['founditems_name'] ?? 'Item not found'; ?></h2>

                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Found Location</span>
                        <span class="detail-value"><?php echo $items['founditems_location'] ?? ''; ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-calendar-alt"></i> Date Found</span>
                        <span class="detail-value"><?php echo $items['founditems_date'] ?? ''; ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-tag"></i> Category</span>
                        <span class="detail-value"><?php echo $items['category_name'] ?? ''; ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-shield-alt"></i> Reported To</span>
                        <span class="detail-value"><?php echo $items['reported_to'] ?? ''; ?></span>
                    </div>

                    <?php if(($items['status'] ?? 'available') === 'available'){ ?>
                        <?php if($is_reporter){ ?>
                            <div class="btn-claimed-disabled" style="background:#eff6ff; color:#1d4ed8;">
                                <i class="fas fa-info-circle"></i> You reported this item &mdash; you cannot claim it
                            </div>
                        <?php } else { ?>
                            <form action="../action/claims.php" method="post">
                                <button type="submit" class="btn-claim" name="claim" value="<?php echo $items['founditems_id']; ?>">
                                    <i class="fas fa-hand-paper"></i> Claim This Item
                                </button>
                            </form>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="btn-claimed-disabled">
                            <i class="fas fa-lock"></i> Already Claimed
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php } else { ?>
            <div class="col-12">
                <div class="alert alert-warning rounded-4">Item not found or invalid ID.</div>
            </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php require_once "footer.php" ?>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
