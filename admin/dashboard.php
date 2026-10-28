<?php
require_once 'layout.php'; admin_require_login(); require_once '../includes/db_connect.php';
function admin_count(mysqli $conn, string $sql): int { $row = $conn->query($sql); return $row ? (int)$row->fetch_assoc()['total'] : 0; }
$students = admin_count($conn, 'SELECT COUNT(*) AS total FROM students');
$placed = admin_count($conn, "SELECT COUNT(DISTINCT student_id) AS total FROM application WHERE LOWER(status) IN ('selected', 'placed')");
$active = admin_count($conn, "SELECT COUNT(*) AS total FROM drive WHERE LOWER(COALESCE(status, 'upcoming')) = 'upcoming' AND drive_date >= CURDATE()");
admin_page_start('Admin overview', 'dashboard'); ?>
<section class="page-heading"><h1>Placement overview</h1><p>A live snapshot of your campus recruitment activity.</p></section>
<section class="stats-grid"><article class="card stat-card"><span>Total students</span><strong><?= $students ?></strong><small>Registered candidates</small></article><article class="card stat-card"><span>Total placed</span><strong><?= $placed ?></strong><small>Selected or placed candidates</small></article><article class="card stat-card"><span>Active drives</span><strong><?= $active ?></strong><small>Upcoming recruitment drives</small></article></section>
<article class="card portal-card"><h2>Placement operations</h2><p class="help">Create companies and drives, review applications, update outcomes, or export filtered records for reporting.</p><div class="action-row"><a class="btn" href="manage_drives.php">Manage companies & drives</a><a class="btn" href="view_applicants.php">Review applicants</a></div></article><?php admin_page_end(); ?>
