<?php
session_start();
require_once "../classes/Admin.php";
require_once "adminguard.php";

$admin = new Admin;
$id = $_GET['id'];
$items = $admin->fetch_founditemtid($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind Admin - Item Details</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f1f5f9; }

.admin-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-bottom: 1px solid rgba(255,255,255,0.07);
    position: sticky; top: 0; z-index: 1000;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}
.admin-header .navbar-brand img { height: 38px; }
.admin-badge {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff; font-size: 0.6rem; font-weight: 800;
    padding: 3px 10px; border-radius: 999px; margin-left: 10px;
    text-transform: uppercase; letter-spacing: 0.1em; vertical-align: middle;
}
.admin-header .nav-link { color: rgba(255,255,255,0.7) !important; font-weight: 600; margin: 0 4px; padding: 8px 14px !important; border-radius: 8px; font-size: 0.88rem; transition: all 0.25s ease !important; }
.admin-header .nav-link:hover { color: #fff !important; background: rgba(255,255,255,0.1); }
.admin-header .nav-link.nav-home { color: #fff !important; background: rgba(79,70,229,0.4); }

.breadcrumb-link {
    color: rgba(255,255,255,0.7); text-decoration: none; font-weight: 600; font-size: 0.88rem;
    display: inline-flex; align-items: center; gap: 6px;
    transition: all 0.2s ease;
    padding: 8px 16px; border-radius: 10px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
}
.breadcrumb-link:hover { color: #fff; background: rgba(255,255,255,0.15); transform: translateX(-3px); }

.item-photo-wrap {
    border-radius: 24px; overflow: hidden;
    border: 1px solid rgba(226,232,240,0.8);
    box-shadow: 0 12px 36px rgba(15,23,42,0.1);
}
.item-photo { width: 100%; display: block; }

.details-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 8px 28px rgba(15,23,42,0.06);
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

.item-title { font-weight: 800; font-size: 1.6rem; color: #0f172a; letter-spacing: -0.02em; margin: 16px 0 24px; }

.detail-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1.1rem 0;
    border-bottom: 1px solid rgba(226,232,240,0.6);
}
.detail-row:last-child { border-bottom: none; }
.detail-label { font-weight: 600; color: #94a3b8; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; }
.detail-label i { color: #4f46e5; width: 18px; text-align: center; }
.detail-value { font-weight: 700; color: #0f172a; font-size: 0.92rem; text-align: right; }

.back-strip {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    padding: 20px 0;
}
</style>

</head>
<body>

<header class="admin-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand d-flex align-items-center" href="admindashboard.php">
                <img src="../images/logop.png" alt="CampusFind">
                <span class="admin-badge">Admin</span>
            </a>
            <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="admindashboard.php"><i class="fas fa-th-large me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminfounditems.php"><i class="fas fa-box me-1"></i>Found Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminclaims.php"><i class="fas fa-clipboard-check me-1"></i>Claims</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminstudents.php"><i class="fas fa-users me-1"></i>Students</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem; font-weight: 600;"><i class="fas fa-user-shield me-1"></i> Admin</span>
                    <a href="logout.php" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.85rem; border-radius: 10px;">Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Back strip -->
<div class="back-strip">
    <div class="container">
        <a href="adminfounditems.php" class="breadcrumb-link">
            <i class="fas fa-arrow-left"></i> Back to Found Items
        </a>
    </div>
</div>

<!-- ITEM DETAILS -->
<section class="py-5">
    <div class="container">

        <div class="row g-4">

            <?php if($items){ ?>

            <!-- IMAGE -->
            <div class="col-lg-6">
                <div class="item-photo-wrap">
                    <img src="<?php echo $items['founditems_img'] ?? '../images/item1.jpg'; ?>" class="item-photo" alt="<?php echo $items['founditems_name'] ?? 'Item'; ?>">
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
                </div>
            </div>

            <?php } else { ?>
            <div class="col-12">
                <div class="alert alert-warning" style="border-radius: 16px; border: none; padding: 2rem; font-size: 0.95rem;">
                    <i class="fas fa-exclamation-triangle me-2"></i>Item not found or invalid ID.
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