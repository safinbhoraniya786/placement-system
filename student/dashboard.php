<?php
session_start(); require_once '../includes/db_connect.php';
if (!isset($_SESSION['student_id'])) { header('Location: login.php'); exit(); }
require_once 'layout.php';
$student = student_profile($conn, (int)$_SESSION['student_id']);
$driveCount = $conn->query("SELECT COUNT(*) AS total FROM drive WHERE drive_date >= CURDATE()");
$upcoming = $driveCount ? (int)$driveCount->fetch_assoc()['total'] : 0;
student_page_start($conn, 'Dashboard', 'dashboard');
?>
<section class="page-heading"><h1>Welcome back, <?= htmlspecialchars($_SESSION['student_name'] ?? 'Student') ?></h1><p>Your career workspace, from resume readiness to application tracking.</p></section>
<section class="portal-grid">
<article class="card portal-card"><h2>Resume studio</h2><p>Preview your resume, match it to a job description, and save it as a PDF.</p><a class="btn" href="resume_ai.php">Open resume tools</a></article>
<article class="card portal-card"><h2><?= $upcoming ?> active drives</h2><p>See eligibility before you apply. Criteria are checked against your branch and CGPA.</p><a class="btn" href="drives.php">Browse drives</a></article>
<article class="card portal-card"><h2>Application status</h2><p>Review recruiter updates and keep an eye on new alerts.</p><a class="btn" href="applications.php">View applications</a></article>
</section>
<?php if (!$student || !isset($student['cgpa']) || $student['cgpa'] === null || empty($student['branch'])): ?><div class="card portal-card" style="margin-top:20px"><h3>Complete your eligibility profile</h3><p>CGPA and branch are needed for automated drive checks. Ask your placement office to update your student record if these details are missing.</p></div><?php endif; ?>
<?php student_page_end(); ?>
