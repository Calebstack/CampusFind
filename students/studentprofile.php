<?php
session_start();
require_once "userguard.php";
require_once "../classes/Student.php";

$student  = new Student();
$students = $student->fetch_studentid($_SESSION['useronline']);
$profile  = $student->fetch_profile($_SESSION['useronline']);
$depts    = $student->departments();

// Display profile pic
$profile_img = !empty($profile['student_img']) ? $profile['student_img'] : null;
$initials = strtoupper(substr($students['student_fname'] ?? 'U', 0, 1) . substr($students['student_lname'] ?? '', 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind - My Profile</title>
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">
<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f8fafc; }
.page-banner { background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%); padding: 60px 0; text-align: center; }
.page-banner h2 { font-weight: 800; color: #fff; letter-spacing: -0.02em; font-size: 2rem; }
.page-banner p { color: rgba(255,255,255,0.85); margin-bottom: 0; }
.profile-avatar-ring {
    width: 110px; height: 110px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; color: #fff;
    border: 4px solid #fff;
    box-shadow: 0 8px 30px rgba(79,70,229,0.3);
    margin: 0 auto 16px; overflow: hidden;
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
}
.profile-avatar-ring img { width: 100%; height: 100%; object-fit: cover; }
.profile-card { background:#fff; border:1px solid rgba(226,232,240,0.8); border-radius:24px; padding:2.5rem; box-shadow:0 8px 24px rgba(15,23,42,0.07); text-align:center; }
.profile-name { font-size:1.5rem; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin-bottom:4px; }
.profile-dept { font-size:0.9rem; background:rgba(79,70,229,0.08); color:#4f46e5; border-radius:999px; padding:3px 14px; display:inline-block; margin-bottom:6px; }
.profile-email { font-size:0.88rem; color:#94a3b8; display:flex; align-items:center; justify-content:center; gap:6px; margin-top:8px; }
.info-card { background:#fff; border:1px solid rgba(226,232,240,0.8); border-radius:24px; padding:2rem; box-shadow:0 8px 24px rgba(15,23,42,0.06); }
.info-row { display:flex; justify-content:space-between; align-items:center; padding:1rem 0; border-bottom:1px solid rgba(226,232,240,0.6); }
.info-row:last-child { border-bottom:none; }
.info-label { font-size:0.82rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#94a3b8; display:flex; align-items:center; gap:8px; }
.info-label i { color:#4f46e5; }
.info-value { font-weight:600; color:#0f172a; font-size:0.92rem; }
.section-tag { display:inline-flex; align-items:center; gap:6px; background:rgba(79,70,229,0.08); color:#4f46e5; border-radius:999px; font-size:0.75rem; font-weight:700; padding:4px 14px; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:10px; }

/* Tab styles */
.profile-tabs { display:flex; gap:8px; border-bottom:2px solid rgba(226,232,240,0.8); margin-bottom:1.5rem; }
.ptab { padding:10px 20px; font-weight:700; font-size:0.9rem; border:none; background:none; cursor:pointer; color:#64748b; border-bottom:2px solid transparent; margin-bottom:-2px; transition:all 0.2s; }
.ptab.active { color:#4f46e5; border-bottom-color:#4f46e5; }
.ptab:hover { color:#4f46e5; }
.tab-pane { display:none; }
.tab-pane.show { display:block; }

.img-preview-wrap { position:relative; width:100px; height:100px; margin:0 auto 1rem; }
.img-preview { width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid rgba(79,70,229,0.3); }
.img-change-btn { position:absolute; bottom:0; right:0; width:30px; height:30px; border-radius:50%; background:#4f46e5; color:#fff; border:none; font-size:0.75rem; display:flex; align-items:center; justify-content:center; cursor:pointer; }
.btn-save { background:linear-gradient(135deg,#4f46e5,#6366f1); color:#fff; border:none; border-radius:12px; padding:0.75rem 2rem; font-weight:700; font-size:0.95rem; transition:all 0.3s; width:100%; }
.btn-save:hover { transform:translateY(-2px); box-shadow:0 4px 14px rgba(79,70,229,0.35); }
</style>
</head>
<body>

<?php require_once "header.php"; ?>

<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#"><img src="../images/logop.png" alt="CampusFind"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
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
                    <a href="studentprofile.php" class="btn btn-login nav-home"><i class="fas fa-user me-1"></i> Profile</a>
                    <a href="logout.php" class="btn btn-danger" style="padding:8px 18px; font-size:0.9rem;"><i class="fas fa-sign-out-alt me-1"></i> Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- PAGE BANNER -->
<div class="page-banner">
    <h2><i class="fas fa-user-circle me-2"></i>My Profile</h2>
    <p>View and update your account information.</p>
</div>

<!-- ALERTS -->
<?php
if(isset($_SESSION['errormsg'])){ echo '<div class="alert alert-danger text-center mb-0 rounded-0">'.$_SESSION['errormsg'].'</div>'; unset($_SESSION['errormsg']); }
if(isset($_SESSION['feedback'])){ echo '<div class="alert alert-success text-center mb-0 rounded-0">'.$_SESSION['feedback'].'</div>'; unset($_SESSION['feedback']); }
?>

<!-- PROFILE CONTENT -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center g-4">

            <!-- Profile Summary Card -->
            <div class="col-lg-4">
                <div class="profile-card">
                    <div class="profile-avatar-ring">
                        <?php if($profile_img): ?>
                            <img src="<?php echo htmlspecialchars($profile_img); ?>" alt="Profile Photo">
                        <?php else: ?>
                            <span style="font-weight:800;"><?php echo $initials; ?></span>
                        <?php endif; ?>
                    </div>
                    <h4 class="profile-name"><?php echo htmlspecialchars($students['student_fname'] . " " . $students['student_lname']); ?></h4>
                    <div class="profile-dept"><?php echo htmlspecialchars($profile['dept_name'] ?? 'N/A'); ?></div>
                    <div class="profile-email">
                        <i class="fas fa-envelope" style="color:#4f46e5;"></i>
                        <?php echo htmlspecialchars($profile['student_email']); ?>
                    </div>
                    <?php if(!empty($profile['student_phone'])): ?>
                    <div class="profile-email mt-1">
                        <i class="fas fa-phone" style="color:#4f46e5;"></i>
                        <?php echo htmlspecialchars($profile['student_phone']); ?>
                    </div>
                    <?php endif; ?>
                    <span style="background:rgba(79,70,229,0.1); color:#4f46e5; border-radius:999px; padding:3px 12px; font-size:0.8rem; display:inline-block; margin-top:12px;">Student</span>
                </div>
            </div>

            <!-- Details + Edit -->
            <div class="col-lg-6">
                <div class="info-card">
                    <!-- Tabs -->
                    <div class="profile-tabs">
                        <button class="ptab active" onclick="showTab('view', this)"><i class="fas fa-id-card me-1"></i>Account Details</button>
                        <button class="ptab" onclick="showTab('edit', this)"><i class="fas fa-edit me-1"></i>Edit Profile</button>
                    </div>

                    <!-- View Tab -->
                    <div id="tab-view" class="tab-pane show">
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-user"></i> First Name</div>
                            <div class="info-value"><?php echo htmlspecialchars($students['student_fname']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-user"></i> Last Name</div>
                            <div class="info-value"><?php echo htmlspecialchars($students['student_lname']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                            <div class="info-value"><?php echo htmlspecialchars($profile['student_email']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-graduation-cap"></i> Department</div>
                            <div class="info-value"><?php echo htmlspecialchars($profile['dept_name'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-phone"></i> Phone</div>
                            <div class="info-value"><?php echo !empty($profile['student_phone']) ? htmlspecialchars($profile['student_phone']) : '<span style="color:#94a3b8;">Not set</span>'; ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-shield-alt"></i> Role</div>
                            <div class="info-value"><span style="background:rgba(79,70,229,0.1);color:#4f46e5;border-radius:999px;padding:3px 12px;font-size:0.8rem;">Student</span></div>
                        </div>
                    </div>

                    <!-- Edit Tab -->
                    <div id="tab-edit" class="tab-pane">
                        <form action="../action/update_profile.php" method="post" enctype="multipart/form-data">
                            <!-- Profile Picture Preview -->
                            <div class="text-center mb-4">
                                <div class="img-preview-wrap">
                                    <?php if($profile_img): ?>
                                        <img id="imgPreview" src="<?php echo htmlspecialchars($profile_img); ?>" class="img-preview" alt="Preview">
                                    <?php else: ?>
                                        <div class="img-preview d-flex align-items-center justify-content-center" id="imgFallback" style="background:linear-gradient(135deg,#4f46e5,#06b6d4); color:#fff; font-size:1.8rem; font-weight:800; border-radius:50%;">
                                            <?php echo $initials; ?>
                                        </div>
                                        <img id="imgPreview" src="" class="img-preview" alt="Preview" style="display:none;">
                                    <?php endif; ?>
                                    <button type="button" class="img-change-btn" onclick="document.getElementById('profilePicInput').click();" title="Change photo">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                                <input type="file" id="profilePicInput" name="profile_pic" accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;" onchange="previewImage(this)">
                                <p style="font-size:0.78rem; color:#94a3b8; margin-top:4px;">Click the camera icon to change your photo</p>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-weight:600; font-size:0.9rem;">First Name</label>
                                    <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($students['student_fname']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-weight:600; font-size:0.9rem;">Last Name</label>
                                    <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($students['student_lname']); ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-weight:600; font-size:0.9rem;">Department</label>
                                <select name="department" class="form-select" required>
                                    <?php foreach($depts as $dept): ?>
                                    <option value="<?php echo $dept['dept_id']; ?>" <?php echo ($dept['dept_id'] == $profile['student_dept_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($dept['dept_name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" style="font-weight:600; font-size:0.9rem;">Phone Number <span style="color:#94a3b8;">(optional)</span></label>
                                <input type="text" name="phone" class="form-control" placeholder="e.g. 08012345678" value="<?php echo htmlspecialchars($profile['student_phone'] ?? ''); ?>">
                            </div>
                            <button type="submit" name="update_profile" class="btn-save">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "footer.php" ?>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
function showTab(tab, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('show'));
    document.querySelectorAll('.ptab').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('show');
    btn.classList.add('active');
}
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('imgPreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
            var fallback = document.getElementById('imgFallback');
            if (fallback) fallback.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>