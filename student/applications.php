<?php
session_start(); require_once '../includes/db_connect.php';
if (!isset($_SESSION['student_id'])) { header('Location: login.php'); exit(); }
require_once 'layout.php'; $studentId = (int)$_SESSION['student_id'];
$stmt = $conn->prepare('SELECT a.*, c.name AS company_name, d.drive_date FROM application a JOIN drive d ON d.drive_id = a.drive_id LEFT JOIN company c ON c.company_id = d.company_id WHERE a.student_id = ? ORDER BY a.applied_date DESC');
$stmt->bind_param('i', $studentId); $stmt->execute(); $applications = $stmt->get_result(); student_page_start($conn, 'My Applications', 'applications'); ?>
<section class="page-heading"><h1>Application updates</h1><p>Status changes from your placement team appear here and in your alert badge.</p></section>
<?php if ($applications->num_rows): while ($app = $applications->fetch_assoc()): ?><article class="card app-card"><div><h2><?= htmlspecialchars($app['company_name'] ?? 'Company Drive') ?></h2><p class="meta">Applied <?= htmlspecialchars(date('d M Y', strtotime($app['applied_date']))) ?><?= !empty($app['drive_date']) ? ' · Drive: ' . htmlspecialchars($app['drive_date']) : '' ?></p></div><span class="status-badge"><?= htmlspecialchars(ucfirst($app['status'])) ?></span></article><?php endwhile; else: ?><article class="card portal-card"><h2>No applications yet</h2><p>Browse company drives to find a suitable opportunity.</p><a class="btn" href="drives.php">Browse drives</a></article><?php endif; student_page_end(); ?>
