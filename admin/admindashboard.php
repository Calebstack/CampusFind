<?php
session_start();
require_once "../classes/Admin.php";
require_once "adminguard.php";

$admin = new Admin;
if(isset($_SESSION['adminonline'])){
    $admins = $admin->fetch_adminid($_SESSION['adminonline']);  
}

$count = $admin->count_users();
$items = $admin->count_founditems();
$pending_claims = $admin->count_pending_claims();
$approved_claims = $admin->count_approved_claims();
$all_claims = $admin->get_all_claims();

$recent_items = is_array($items) ? array_slice($items, 0, 5) : [];
$recent_claims = is_array($all_claims) ? array_slice($all_claims, 0, 5) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind Admin - Dashboard</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f1f5f9; }

/* Admin navbar */
.admin-header {
    background: rgba(255, 255, 255, 0.85) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    position: sticky; top: 0; z-index: 1000;
    box-shadow: 0 1px 12px rgba(15, 23, 42, 0.06);
}
.admin-header .navbar-brand img { height: 38px; }
.admin-header .nav-link { color: #475569 !important; font-weight: 600; margin: 0 4px; padding: 8px 14px !important; border-radius: 8px; font-size: 0.88rem; transition: all 0.25s ease !important; }
.admin-header .nav-link:hover { color: #4f46e5 !important; background: rgba(79, 70, 229, 0.08); }
.admin-header .nav-link.nav-home { color: #4f46e5 !important; background: rgba(79, 70, 229, 0.1); }

/* Page header strip */
.page-strip {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    padding: 40px 0 60px;
    position: relative; overflow: hidden;
}
.page-strip::after {
    content: ''; position: absolute;
    width: 400px; height: 400px; border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -200px; right: -100px;
}
.page-strip .container { position: relative; z-index: 2; }
.page-strip h2 { font-weight: 800; color: #fff; letter-spacing: -0.02em; }
.page-strip p { color: rgba(255,255,255,0.8); }
.welcome-chip {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 999px; padding: 5px 16px;
    font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.95);
    margin-bottom: 12px;
}

/* Stats Section */
.stats-section {
    margin-top: -36px;
    position: relative; z-index: 10;
}

.stat-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 20px;
    padding: 1.6rem 1.5rem;
    box-shadow: 0 8px 24px rgba(15,23,42,0.07);
    display: flex; align-items: center; gap: 1.2rem;
    transition: all 0.3s ease;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(79,70,229,0.12); }

.stat-icon-wrap {
    width: 56px; height: 56px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}

.stat-number { font-size: 1.9rem; font-weight: 800; color: #0f172a; line-height: 1; }
.stat-label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin-top: 4px; }

/* Content cards */
.content-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(15,23,42,0.05);
    overflow: hidden;
}

.content-card-header {
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid rgba(226,232,240,0.8);
    font-weight: 700; font-size: 0.95rem; color: #0f172a;
    display: flex; align-items: center; gap: 8px;
}
.content-card-header i { color: #4f46e5; }

.table thead th {
    background: #f8fafc;
    color: #475569; font-size: 0.75rem;
    text-transform: uppercase; letter-spacing: 0.05em;
    font-weight: 700; border-bottom: 1px solid rgba(226,232,240,0.8);
    padding: 1rem 1.5rem;
}
.table tbody td {
    padding: 1rem 1.5rem; vertical-align: middle;
    border-bottom: 1px solid rgba(226,232,240,0.5);
    font-size: 0.88rem;
}
.table tbody tr:last-child td { border-bottom: none; }
.table tbody tr { transition: background 0.2s ease; }
.table tbody tr:hover { background: rgba(248,250,252,0.8); }

.item-thumb { width: 44px; height: 44px; object-fit: cover; border-radius: 10px; margin-right: 10px; border: 1px solid rgba(226,232,240,0.8); }

.status-dot {
    width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px;
}
.dot-success { background: #10b981; }
.dot-secondary { background: #94a3b8; }
.dot-warning { background: #f59e0b; }
.dot-danger { background: #ef4444; }

.badge-available { background: #ecfdf5 !important; color: #047857 !important; }
.badge-claimed   { background: #f1f5f9 !important; color: #475569 !important; }
.badge-pending   { background: #fffbeb !important; color: #b45309 !important; }
.badge-approved  { background: #ecfdf5 !important; color: #047857 !important; }
.badge-rejected  { background: #fef2f2 !important; color: #b91c1c !important; }

.badge-status {
    font-size: 0.72rem; font-weight: 700; padding: 3px 10px;
    border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em;
}

.view-all-link {
    color: #4f46e5; font-size: 0.85rem; font-weight: 700;
    text-decoration: none; display: flex; align-items: center; gap: 4px;
    transition: gap 0.2s ease;
}
.view-all-link:hover { gap: 8px; color: #4338ca; }
</style>

</head>
<body class="d-flex flex-column min-vh-100">

<!-- ADMIN HEADER -->
<header class="admin-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand d-flex align-items-center" href="admindashboard.php">
                <img src="../images/logop.png" alt="CampusFind">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link nav-home" href="admindashboard.php"><i class="fas fa-th-large me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminfounditems.php"><i class="fas fa-box me-1"></i>Found Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminclaims.php"><i class="fas fa-clipboard-check me-1"></i>Claims</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminstudents.php"><i class="fas fa-users me-1"></i>Students</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <span style="color: #475569; font-size: 0.85rem; font-weight: 600;">
                        <i class="fas fa-user-shield me-1"></i> Admin
                    </span>
                    <a href="logout.php" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.85rem; border-radius: 10px;">Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- PAGE HEADER STRIP -->
<div class="page-strip">
    <div class="container">
        <div class="welcome-chip">
            <i class="fas fa-hand-peace"></i>
            Welcome back, <?php echo $admins['admin_fullname']; ?>
        </div>
        <h2 class="mb-1">Dashboard</h2>
        <p class="mb-0">Overview of CampusFind activity.</p>
    </div>
</div>

<!-- STATS -->
<section class="stats-section pb-4">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background: rgba(79,70,229,0.1);">
                        <i class="fas fa-box" style="color:#4f46e5;"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?php echo count($items) ?></div>
                        <div class="stat-label">Found Items</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background: #fffbeb;">
                        <i class="fas fa-clock" style="color:#b45309;"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?php echo count($pending_claims) ?></div>
                        <div class="stat-label">Pending Claims</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background: #ecfdf5;">
                        <i class="fas fa-check-circle" style="color:#047857;"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?php echo is_array($approved_claims) ? count($approved_claims) : 0; ?></div>
                        <div class="stat-label">Approved Claims</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background: rgba(6,182,212,0.1);">
                        <i class="fas fa-user-graduate" style="color:#0891b2;"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?php echo count($count) ?></div>
                        <div class="stat-label">Students</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TABLES -->
<section class="py-4 pb-5">
    <div class="container">
        <div class="row g-4">

            <!-- RECENT FOUND ITEMS -->
            <div class="col-lg-6">
                <div class="content-card">
                    <div class="content-card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-box"></i> Recent Found Items</span>
                        <a href="adminfounditems.php" class="view-all-link">View all <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php if(!empty($recent_items)){ ?>
                               <?php foreach($recent_items as $item){ ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $item['founditems_img']; ?>" class="item-thumb flex-shrink-0">
                                            <div style="word-break: break-word; min-width: 120px;"><?php echo $item['founditems_name']; ?></div>
                                        </div>
                                    </td>
                                    <td><?php echo $item['category_name'] ?? 'Electronics'; ?></td>
                                    <td><?php echo $item['founditems_date'] ?? ''; ?></td>
                                    <td>
                                        <?php if(($item['status'] ?? 'available') == 'available'){ ?>
                                            <span class="badge-status badge-available">Available</span>
                                        <?php } else { ?>
                                            <span class="badge-status badge-claimed">Claimed</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                               <?php } ?>
                               <?php } else { ?>
                               <tr><td colspan="4" class="text-center py-4 text-muted">No found items</td></tr>
                               <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- RECENT CLAIMS -->
            <div class="col-lg-6">
                <div class="content-card">
                    <div class="content-card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-clipboard-check"></i> Recent Claims</span>
                        <a href="adminclaims.php" class="view-all-link">View all <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Claimed By</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($recent_claims)){ ?>
                                <?php foreach($recent_claims as $claim){ ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $claim['founditems_img'] ?? '../images/item1.jpg'; ?>" class="item-thumb flex-shrink-0">
                                            <div style="word-break: break-word; min-width: 120px;"><?php echo $claim['founditems_name'] ?? 'Item'; ?></div>
                                        </div>
                                    </td>
                                    <td><?php echo $claim['student_fname'] . ' ' . $claim['student_lname']; ?></td>
                                    <td><?php echo $claim['claim_date'] ?? ''; ?></td>
                                    <td>
                                        <?php if($claim['status'] == 'pending'){ ?>
                                            <span class="badge-status badge-pending">Pending</span>
                                        <?php } elseif($claim['status'] == 'approved'){ ?>
                                            <span class="badge-status badge-approved">Approved</span>
                                        <?php } else { ?>
                                            <span class="badge-status badge-rejected">Rejected</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">No claims found</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
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