<?php

session_start();
require_once "userguard.php";
require_once "../classes/Student.php";
$student = new Student;

$student_id = $_SESSION['useronline'];
$claims = $student->getStudentClaims($student_id);

$total_claims = 0;
$pending_claims = 0;
$approved_claims = 0;
$rejected_claims = 0;

if($claims){
    $total_claims = count($claims);
    foreach($claims as $claim){
        if($claim['status'] == 'pending')      $pending_claims++;
        elseif($claim['status'] == 'approved') $approved_claims++;
        elseif($claim['status'] == 'rejected') $rejected_claims++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind - My Claims</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f8fafc; }

.page-hero {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.88) 0%, rgba(6, 182, 212, 0.88) 100%);
    padding: 70px 0 50px;
    position: relative; overflow: hidden;
}
.page-hero::before {
    content: ''; position: absolute; width: 400px; height: 400px;
    border-radius: 50%; background: rgba(255,255,255,0.05); top: -150px; right: -80px;
}
.page-hero .container { position: relative; z-index: 2; }
.page-hero h1 { font-weight: 800; color: #fff; letter-spacing: -0.02em; }
.page-hero p { color: rgba(255,255,255,0.85); }

/* Stat cards */
.stat-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 20px;
    padding: 1.75rem 1.5rem;
    box-shadow: 0 4px 12px rgba(15,23,42,0.05);
    text-align: center;
    transition: all 0.3s ease;
}
.stat-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(79,70,229,0.1); }

.stat-icon-wrap {
    width: 58px; height: 58px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    margin: 0 auto 14px;
}

.stat-number {
    font-size: 2.2rem; font-weight: 800; color: #0f172a; line-height: 1;
    margin-bottom: 6px;
}
.stat-label {
    font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; color: #94a3b8;
}

/* Claims table */
.claims-table-card {
    background: #fff;
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(15,23,42,0.05);
}

.table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 700;
    border-bottom: 1px solid rgba(226,232,240,0.8);
    padding: 1rem 1.5rem;
}

.table tbody td {
    padding: 1.1rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(226,232,240,0.5);
    font-size: 0.92rem;
}

.table tbody tr:last-child td { border-bottom: none; }
.table tbody tr { transition: background 0.2s ease; }
.table tbody tr:hover { background: rgba(248,250,252,0.8); }

.item-thumb {
    width: 52px; height: 52px;
    object-fit: cover; border-radius: 10px;
    border: 1px solid rgba(226,232,240,0.8);
    margin-right: 12px;
}
.item-name { font-weight: 700; color: #0f172a; font-size: 0.92rem; }
.item-category { font-size: 0.75rem; color: #94a3b8; }

.status-pill {
    font-size: 0.72rem; font-weight: 700;
    padding: 4px 12px; border-radius: 999px;
    text-transform: uppercase; letter-spacing: 0.05em;
    display: inline-block;
}
.status-pending  { background: #fffbeb; color: #b45309; }
.status-approved { background: #ecfdf5; color: #047857; }
.status-rejected { background: #fef2f2; color: #b91c1c; }
.status-returned { background: #eff6ff; color: #1d4ed8; }

.btn-view-sm {
    background: transparent; border: 1.5px solid #4f46e5; color: #4f46e5;
    border-radius: 8px; padding: 5px 14px; font-size: 0.8rem; font-weight: 700;
    transition: all 0.25s ease;
}
.btn-view-sm:hover { background: #4f46e5; color: #fff; }

.section-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(79,70,229,0.08); color: #4f46e5;
    border-radius: 999px; font-size: 0.75rem; font-weight: 700;
    padding: 4px 14px; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px;
}
.section-heading { font-weight: 800; font-size: 1.6rem; color: #0f172a; letter-spacing: -0.02em; }

.empty-row td { padding: 60px !important; color: #94a3b8; font-size: 0.95rem; }
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
                    <li class="nav-item"><a class="nav-link nav-home" href="claims.php"><i class="fas fa-clipboard-list me-1"></i>Claims</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="studentprofile.php" class="btn btn-login"><i class="fas fa-user me-1"></i> Profile</a>
                    <a href="logout.php" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.9rem;"><i class="fas fa-sign-out-alt me-1"></i> Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- HERO -->
<section class="page-hero">
    <div class="container text-center">
        <h1 class="display-5 mb-3">My Claims</h1>
        <p class="lead mb-0">Track the status of every item you've claimed.</p>
    </div>
</section>

<!-- STATS + TABLE -->
<section class="py-5">
    <div class="container">

        <?php require_once "../partials/feedback.php"; ?>

        <!-- Stats Row -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background: rgba(79,70,229,0.1);">
                        <i class="fas fa-list" style="color: #4f46e5;"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_claims; ?></div>
                    <div class="stat-label">Total Claims</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background: #fffbeb;">
                        <i class="fas fa-clock" style="color: #b45309;"></i>
                    </div>
                    <div class="stat-number" style="color:#b45309;"><?php echo $pending_claims; ?></div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background: #ecfdf5;">
                        <i class="fas fa-check-circle" style="color: #047857;"></i>
                    </div>
                    <div class="stat-number" style="color:#047857;"><?php echo $approved_claims; ?></div>
                    <div class="stat-label">Approved</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="text-center mb-4">
            <div class="section-tag"><i class="fas fa-history"></i> History</div>
            <h2 class="section-heading">Claim History</h2>
            <p class="text-muted">A record of items you've claimed and their current status.</p>
        </div>

        <div class="claims-table-card">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Found Location</th>
                            <th>Date Found</th>
                            <th>Date Claimed</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($claims)): ?>
                            <?php foreach($claims as $claim): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $claim['founditems_img'] ?? '../images/item1.jpg'; ?>" class="item-thumb" alt="<?php echo $claim['founditems_name']; ?>">
                                        <div>
                                            <div class="item-name"><?php echo $claim['founditems_name']; ?></div>
                                            <div class="item-category"><?php echo $claim['category_name']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $claim['founditems_location']; ?></td>
                                <td><?php echo $claim['founditems_date']; ?></td>
                                <td><?php echo $claim['claim_date']; ?></td>
                                <td>
                                    <span class="status-pill status-<?php echo $claim['status']; ?>">
                                        <?php echo ucfirst($claim['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="itemdetails.php?id=<?php echo $claim['founditems_id']; ?>" class="btn-view-sm">View</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="empty-row">
                                <td colspan="6" class="text-center">
                                    <i class="fas fa-inbox fa-2x d-block mb-2 text-muted"></i>
                                    No claims found. <a href="categories.php" style="color:#4f46e5; font-weight:600;">Browse items to claim</a>
                                </td>
                            </tr>
                        <?php endif; ?>
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