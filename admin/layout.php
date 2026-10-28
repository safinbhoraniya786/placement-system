<?php
function admin_require_login(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit(); }
}
function admin_column_exists(mysqli $conn, string $table, string $column): bool {
    $table = $conn->real_escape_string($table); $column = $conn->real_escape_string($column);
    $result = $conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $result && $result->num_rows > 0;
}
function admin_page_start(string $title, string $active = ''): void { ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= htmlspecialchars($title) ?> | Placement Portal</title><link rel="stylesheet" href="../css/dark-saas-theme.css"><link rel="stylesheet" href="../css/admin-portal.css"></head><body>
<header class="admin-header"><a class="brand" href="dashboard.php">Placement<span>Portal</span></a><nav><a class="<?= $active === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">Overview</a><a class="<?= $active === 'drives' ? 'active' : '' ?>" href="manage_drives.php">Companies & drives</a><a class="<?= $active === 'applicants' ? 'active' : '' ?>" href="view_applicants.php">Applicants</a><span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span><a class="logout" href="logout.php">Log out</a></nav></header><main class="admin-main">
<?php }
function admin_page_end(): void { ?></main><footer>Placement Record Management System &bull; Admin Console</footer></body></html><?php }
