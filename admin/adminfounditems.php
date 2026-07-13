<?php
session_start();
require_once "../classes/Admin.php";
require_once "adminguard.php";

$admin = new Admin;
$founditems = $admin->founditems_categrory();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind Admin - Found Items</title>

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

.page-strip {
    background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
    padding: 40px 0; position: relative; overflow: hidden;
}
.page-strip::after { content: ''; position: absolute; width: 400px; height: 400px; border-radius: 50%; background: rgba(255,255,255,0.05); top: -200px; right: -100px; }
.page-strip .container { position: relative; z-index: 2; }
.page-strip h2 { font-weight: 800; color: #fff; letter-spacing: -0.02em; }
.page-strip p { color: rgba(255,255,255,0.8); margin-bottom: 0; }

.content-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(15,23,42,0.05);
    overflow: hidden;
}

.table thead th {
    background: #f8fafc; color: #475569;
    font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
    font-weight: 700; border-bottom: 1px solid rgba(226,232,240,0.8); padding: 1rem 1.5rem;
}
.table tbody td {
    padding: 1rem 1.5rem; vertical-align: middle;
    border-bottom: 1px solid rgba(226,232,240,0.5); font-size: 0.88rem;
}
.table tbody tr:last-child td { border-bottom: none; }
.table tbody tr { transition: background 0.2s ease; }
.table tbody tr:hover { background: rgba(248,250,252,0.8); }

.item-thumb { width: 46px; height: 46px; object-fit: cover; border-radius: 10px; margin-right: 10px; border: 1px solid rgba(226,232,240,0.8); }

.badge-status {
    font-size: 0.72rem; font-weight: 700; padding: 3px 10px;
    border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em;
}
.badge-available { background: #ecfdf5; color: #047857; }
.badge-claimed   { background: #f1f5f9; color: #475569; }

.btn-action-view {
    background: transparent; border: 1.5px solid #4f46e5; color: #4f46e5;
    border-radius: 8px; padding: 4px 12px; font-size: 0.78rem; font-weight: 700;
    text-decoration: none; transition: all 0.25s ease; display: inline-block;
}
.btn-action-view:hover { background: #4f46e5; color: #fff; }

.btn-action-delete {
    background: #fef2f2; border: none; color: #b91c1c;
    border-radius: 8px; padding: 4px 12px; font-size: 0.78rem; font-weight: 700;
    text-decoration: none; transition: all 0.25s ease; display: inline-block;
}
.btn-action-delete:hover { background: #ef4444; color: #fff; }

.empty-row td { padding: 60px !important; color: #94a3b8; text-align: center; }
</style>

</head>
<body class="d-flex flex-column min-vh-100">

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
                    <li class="nav-item"><a class="nav-link" href="admindashboard.php"><i class="fas fa-th-large me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link nav-home" href="adminfounditems.php"><i class="fas fa-box me-1"></i>Found Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminclaims.php"><i class="fas fa-clipboard-check me-1"></i>Claims</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminstudents.php"><i class="fas fa-users me-1"></i>Students</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <span style="color: #475569; font-size: 0.85rem; font-weight: 600;"><i class="fas fa-user-shield me-1"></i> Admin</span>
                    <a href="logout.php" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.85rem; border-radius: 10px;">Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="page-strip">
    <div class="container">
        <h2 class="mb-1"><i class="fas fa-box me-2"></i>Manage Found Items</h2>
        <p>All items reported as found across campus.</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <?php require_once "../partials/feedback.php"; ?>
        <div class="content-card">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Date Found</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  if($founditems){ ?>
                        <?php foreach($founditems as $item){ ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $item['founditems_img']; ?>" class="item-thumb flex-shrink-0">
                                    <div style="word-break: break-word; min-width: 120px;"><?php echo $item['founditems_name']; ?></div>
                                </div>
                            </td>
                            <td><?php echo $item['category_name']; ?></td>
                            <td><?php echo $item['founditems_date']; ?></td>
                            <td><?php echo $item['founditems_location']; ?></td>
                            <td>
                                <?php if($item['status'] == 'available'){ ?>
                                    <span class="badge-status badge-available">Available</span>
                                <?php } else { ?>
                                    <span class="badge-status badge-claimed">Claimed</span>
                                <?php } ?>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="itemdetails.php?id=<?php echo $item['founditems_id']; ?>" class="btn-action-view"><i class="fas fa-eye"></i></a>
                                    <a href="action/deleteitem.php?id=<?php echo $item['founditems_id']; ?>" class="btn-action-delete" onclick="return confirm('Delete this item?');"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr class="empty-row">
                            <td colspan="6"><i class="fas fa-inbox fa-2x d-block mb-2 text-muted mx-auto"></i> No Items Found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php require_once "footer.php" ?>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>