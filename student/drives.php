<?php
session_start(); require_once '../includes/db_connect.php';
if (!isset($_SESSION['student_id'])) { header('Location: login.php'); exit(); }
require_once 'layout.php'; $student = student_profile($conn, (int)$_SESSION['student_id']) ?: [];
$result = $conn->query("SELECT d.*, c.name AS company_name, c.package, c.description FROM drive d LEFT JOIN company c ON c.company_id = d.company_id ORDER BY d.drive_id DESC");
student_page_start($conn, 'Company Drives', 'drives'); ?>
<section class="page-heading"><h1>Company drives</h1><p>Eligibility is checked before an application can be submitted.</p></section>
<?php if ($result && $result->num_rows): while ($drive = $result->fetch_assoc()): $check = eligibility_result($student, $drive); ?>
<article class="card drive-card"><div><h2><?= htmlspecialchars($drive['company_name'] ?? 'Company Drive') ?></h2><p class="meta"><?= htmlspecialchars($drive['role'] ?? 'Campus recruitment') ?><?= !empty($drive['package']) ? ' · ' . htmlspecialchars($drive['package']) : '' ?></p><p class="meta"><?= htmlspecialchars($drive['description'] ?? 'Eligible candidates may apply.') ?></p><p class="eligibility <?= $check['eligible'] ? 'eligible' : 'ineligible' ?>"><strong><?= $check['eligible'] ? 'Eligible to apply' : 'Not currently eligible' ?>:</strong> <?= htmlspecialchars($check['criteria']) ?><?= $check['reasons'] ? ' — ' . htmlspecialchars(implode(' ', $check['reasons'])) : '' ?></p></div><a class="btn" href="apply.php?drive_id=<?= (int)$drive['drive_id'] ?>">Check & apply</a></article>
<?php endwhile; else: ?><article class="card portal-card"><h2>No active drives</h2><p>Please check again soon.</p></article><?php endif; student_page_end(); ?>
