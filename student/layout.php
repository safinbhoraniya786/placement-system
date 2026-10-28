<?php
require_once __DIR__ . '/../includes/student_helpers.php';
function student_page_start(mysqli $conn, string $title, string $active = ''): void {
    $count = student_notification_count($conn, (int)$_SESSION['student_id']);
    ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?> | Placement Portal</title><link rel="stylesheet" href="../css/dark-saas-theme.css"><link rel="stylesheet" href="../css/student-portal.css"></head><body>
<header class="student-header"><a class="brand" href="dashboard.php">Placement<span>Portal</span></a><nav>
<a class="<?= $active === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a><a class="<?= $active === 'resume' ? 'active' : '' ?>" href="resume_ai.php">Resume</a><a class="<?= $active === 'drives' ? 'active' : '' ?>" href="drives.php">Drives</a><a class="<?= $active === 'applications' ? 'active' : '' ?>" href="applications.php">Applications</a>
<a class="notification-link" href="applications.php" aria-label="Notifications">Alerts<?php if ($count): ?><b><?= $count > 9 ? '9+' : $count ?></b><?php endif; ?></a><a class="logout-btn" href="logout.php">Log out</a></nav></header><main class="student-main">
<?php }
function student_page_end(): void { ?>
</main><footer>Placement Record Management System &bull; Student Portal</footer></body></html>
<?php }
