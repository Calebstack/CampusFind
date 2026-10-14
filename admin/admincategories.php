<?php
session_start();
require_once "../classes/Admin.php";
require_once "adminguard.php";

$admin      = new Admin;
$categories = $admin->get_all_categories_with_count();
$cat_count  = is_array($categories) ? count($categories) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CampusFind Admin - Categories</title>
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/all.min.css">
<link rel="stylesheet" href="../assets/css/theme.css">
<style>
:root { --primary: #4f46e5; }
body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #f1f5f9; }
.admin-header { background: rgba(255,255,255,0.85) !important; backdrop-filter: blur(12px) !important; border-bottom: 1px solid rgba(226,232,240,0.8); position: sticky; top: 0; z-index: 1000; box-shadow: 0 1px 12px rgba(15,23,42,0.06); }
.admin-header .navbar-brand img { height: 38px; }
.admin-header .nav-link { color: #475569 !important; font-weight: 600; margin: 0 4px; padding: 8px 14px !important; border-radius: 8px; font-size: 0.88rem; transition: all 0.25s ease !important; }
.admin-header .nav-link:hover { color: #4f46e5 !important; background: rgba(79,70,229,0.08); }
.admin-header .nav-link.nav-home { color: #4f46e5 !important; background: rgba(79,70,229,0.1); }
.page-strip { background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%); padding: 40px 0; position: relative; overflow: hidden; }
.page-strip::after { content:''; position:absolute; width:400px; height:400px; border-radius:50%; background:rgba(255,255,255,0.05); top:-200px; right:-100px; }
.page-strip .container { position:relative; z-index:2; }
.page-strip h2 { font-weight:800; color:#fff; letter-spacing:-0.02em; }
.page-strip p { color:rgba(255,255,255,0.8); margin-bottom:0; }
.content-card { background:#fff; border:1px solid rgba(226,232,240,0.8); border-radius:20px; box-shadow:0 4px 12px rgba(15,23,42,0.05); overflow:hidden; }
.table thead th { background:#f8fafc; color:#475569; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; font-weight:700; border-bottom:1px solid rgba(226,232,240,0.8); padding:1rem 1.5rem; }
.table tbody td { padding:1rem 1.5rem; vertical-align:middle; border-bottom:1px solid rgba(226,232,240,0.5); font-size:0.88rem; }
.table tbody tr:last-child td { border-bottom:none; }
.table tbody tr { transition:background 0.2s ease; }
.table tbody tr:hover { background:rgba(248,250,252,0.8); }
.badge-status { font-size:0.72rem; font-weight:700; padding:3px 10px; border-radius:999px; text-transform:uppercase; letter-spacing:0.05em; }
.count-badge { display:inline-flex; align-items:center; justify-content:center; min-width:32px; height:28px; background:rgba(79,70,229,0.08); color:#4f46e5; font-weight:700; font-size:0.82rem; border-radius:8px; }
.btn-add { background:linear-gradient(135deg,#4f46e5,#6366f1); color:#fff; border:none; border-radius:12px; padding:0.65rem 1.5rem; font-weight:700; font-size:0.9rem; }
.btn-add:hover { opacity:0.9; color:#fff; }
.btn-action-edit { background:rgba(79,70,229,0.08); border:none; color:#4f46e5; border-radius:8px; padding:4px 12px; font-size:0.78rem; font-weight:700; transition:all 0.25s ease; display:inline-block; }
.btn-action-edit:hover { background:#4f46e5; color:#fff; }
.btn-action-delete { background:#fef2f2; border:none; color:#b91c1c; border-radius:8px; padding:4px 12px; font-size:0.78rem; font-weight:700; transition:all 0.25s ease; display:inline-block; }
.btn-action-delete:hover { background:#ef4444; color:#fff; }
.empty-row td { padding:60px !important; color:#94a3b8; text-align:center; }
</style>
</head>
<body class="d-flex flex-column min-vh-100">

<header class="admin-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand d-flex align-items-center" href="admindashboard.php"><img src="../images/logop.png" alt="CampusFind"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="admindashboard.php"><i class="fas fa-th-large me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminfounditems.php"><i class="fas fa-box me-1"></i>Found Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminclaims.php"><i class="fas fa-clipboard-check me-1"></i>Claims</a></li>
                    <li class="nav-item"><a class="nav-link" href="adminstudents.php"><i class="fas fa-users me-1"></i>Students</a></li>
                    <li class="nav-item"><a class="nav-link nav-home" href="admincategories.php"><i class="fas fa-tags me-1"></i>Categories</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <span style="color:#475569; font-size:0.85rem; font-weight:600;"><i class="fas fa-user-shield me-1"></i> Admin</span>
                    <a href="logout.php" class="btn btn-danger" style="padding:8px 18px; font-size:0.85rem; border-radius:10px;">Sign Out</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="page-strip">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fas fa-tags me-2"></i>Manage Categories</h2>
            <p><?php echo $cat_count; ?> category(ies) available. Add, edit, or remove item categories.</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus me-1"></i>Add Category
        </button>
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
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Items</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($categories): ?>
                        <?php foreach($categories as $i => $cat): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><strong><?php echo htmlspecialchars($cat['category_name']); ?></strong></td>
                            <td><span class="count-badge"><?php echo $cat['item_count']; ?></span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn-action-edit" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $cat['categories_id']; ?>">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <?php if($cat['item_count'] == 0): ?>
                                    <a href="action/delete_category.php?id=<?php echo $cat['categories_id']; ?>" class="btn-action-delete" onclick="return confirm('Delete this category? This cannot be undone.');">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                    <?php else: ?>
                                    <span style="color:#94a3b8; font-size:0.78rem; padding:4px 8px;" title="Cannot delete: category has items">
                                        <i class="fas fa-lock me-1"></i>Has Items
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal<?php echo $cat['categories_id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius:20px; border:none;">
                                    <div class="modal-header" style="border-bottom:1px solid rgba(226,232,240,0.8);">
                                        <h5 class="modal-title" style="font-weight:800; color:#0f172a;"><i class="fas fa-edit me-2" style="color:#4f46e5;"></i>Edit Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="action/edit_category.php" method="post">
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="category_id" value="<?php echo $cat['categories_id']; ?>">
                                            <label class="form-label" style="font-weight:600;">Category Name</label>
                                            <input type="text" name="category_name" class="form-control" value="<?php echo htmlspecialchars($cat['category_name']); ?>" required style="border-radius:12px;">
                                        </div>
                                        <div class="modal-footer" style="border-top:1px solid rgba(226,232,240,0.8);">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cancel</button>
                                            <button type="submit" name="edit_category" class="btn btn-primary" style="border-radius:10px; background:#4f46e5; border:none; font-weight:700;">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr class="empty-row">
                            <td colspan="4"><i class="fas fa-tags fa-2x d-block mb-2 text-muted mx-auto"></i>No categories found. Add one to get started.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px; border:none;">
            <div class="modal-header" style="border-bottom:1px solid rgba(226,232,240,0.8);">
                <h5 class="modal-title" style="font-weight:800; color:#0f172a;"><i class="fas fa-plus me-2" style="color:#4f46e5;"></i>Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="action/add_category.php" method="post">
                <div class="modal-body p-4">
                    <label class="form-label" style="font-weight:600;">Category Name</label>
                    <input type="text" name="category_name" class="form-control" placeholder="e.g. Electronics, Clothing, Documents..." required style="border-radius:12px;">
                </div>
                <div class="modal-footer" style="border-top:1px solid rgba(226,232,240,0.8);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cancel</button>
                    <button type="submit" name="add_category" class="btn btn-primary" style="border-radius:10px; background:#4f46e5; border:none; font-weight:700;">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php" ?>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>