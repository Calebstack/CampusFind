<?php
session_start();
require_once "../classes/Admin.php";
require_once "adminguard.php";

$admin = new Admin;
$students = $admin->get_all_students();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind Admin - Students</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">

<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f1f5f9; }


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
    background: linear-gradient(135deg, #4f46e5 0%, #0891b2 100%);
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

.student-avatar {
    width: 40px; height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(79,70,229,0.12), rgba(6,182,212,0.12));
    color: #4f46e5;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 0.9rem; margin-right: 12px;
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.table tbody tr:hover .student-avatar {
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    color: #fff;
}

.student-name { font-weight: 700; color: #0f172a; font-size: 0.92rem; }
.student-email { color: #64748b; font-size: 0.82rem; }

.dept-pill {
    display: inline-block;
    background: rgba(79,70,229,0.08); color: #4f46e5;
    font-weight: 600; font-size: 0.78rem;
    padding: 3px 12px; border-radius: 999px;
}

.count-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 28px;
    background: rgba(79,70,229,0.08); color: #4f46e5;
    font-weight: 700; font-size: 0.82rem;
    border-radius: 8px;
}

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
                    <li class="nav-item"><a class="nav-link" href="adminfounditems.php"><i class="fas fa-box me-1"></i>Found Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminclaims.php"><i class="fas fa-clipboard-check me-1"></i>Claims</a></li>
                    <li class="nav-item"><a class="nav-link nav-home" href="adminstudents.php"><i class="fas fa-users me-1"></i>Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="admincategories.php"><i class="fas fa-tags me-1"></i>Categories</a></li>
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
        <h2 class="mb-1"><i class="fas fa-users me-2"></i>Manage Students</h2>
        <p>Students registered on CampusFind.</p>
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
                            <th>Student</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Items Reported</th>
                            <th>Claims Made</th>
                            <th>Account</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($students){ ?>
                        <?php foreach($students as $student){ ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="student-avatar"><i class="fas fa-user"></i></span>
                                    <span class="student-name"><?php echo $student['student_fname'] . ' ' . $student['student_lname']; ?></span>
                                </div>
                            </td>
                            <td class="student-email"><?php echo $student['student_email']; ?></td>
                            <td><span class="dept-pill"><?php echo $student['dept_name']; ?></span></td>
                            <td><span class="count-badge"><?php echo $admin->count_items_reported($student['student_id']); ?></span></td>
                            <td><span class="count-badge"><?php echo $admin->count_claims_made($student['student_id']); ?></span></td>
                            <td>
                                <?php if(!empty($student['is_banned'])){ ?>
                                    <span class="badge text-bg-danger">Banned</span>
                                <?php } else { ?>
                                    <span class="badge text-bg-success">Active</span>
                                <?php } ?>
                            </td>
                            <td>
                                <form action="action/togglestudent.php" method="post" onsubmit="return confirm('<?php echo !empty($student['is_banned']) ? 'Unban' : 'Ban'; ?> this student?');">
                                    <input type="hidden" name="student_id" value="<?php echo (int)$student['student_id']; ?>">
                                    <input type="hidden" name="is_banned" value="<?php echo empty($student['is_banned']) ? '1' : '0'; ?>">
                                    <button type="submit" class="btn btn-sm <?php echo !empty($student['is_banned']) ? 'btn-outline-success' : 'btn-outline-danger'; ?>">
                                        <?php echo !empty($student['is_banned']) ? 'Unban' : 'Ban'; ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } } else { ?>
                        <tr class="empty-row">
                            <td colspan="7"><i class="fas fa-user-slash fa-2x d-block mb-2 text-muted mx-auto"></i> No students found</td>
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