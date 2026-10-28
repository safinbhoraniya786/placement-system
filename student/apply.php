<?php
session_start(); require_once '../includes/db_connect.php';
if (!isset($_SESSION['student_id'])) { header('Location: login.php'); exit(); }
require_once '../includes/student_helpers.php';
$studentId = (int)$_SESSION['student_id']; $driveId = filter_input(INPUT_GET, 'drive_id', FILTER_VALIDATE_INT); $message = ''; $success = false;
if (!$driveId) $message = 'Choose a valid drive before applying.';
else { $stmt = $conn->prepare('SELECT * FROM drive WHERE drive_id = ?'); $stmt->bind_param('i', $driveId); $stmt->execute(); $drive = $stmt->get_result()->fetch_assoc();
    if (!$drive) $message = 'This drive is no longer available.';
    else { $check = eligibility_result(student_profile($conn, $studentId) ?: [], $drive);
        if (!$check['eligible']) $message = 'Application not submitted. ' . implode(' ', $check['reasons']);
        else { $existing = $conn->prepare('SELECT application_id FROM application WHERE student_id = ? AND drive_id = ?'); $existing->bind_param('ii', $studentId, $driveId); $existing->execute();
            if ($existing->get_result()->num_rows) $message = 'You have already applied to this drive.';
            else { $status = 'Applied'; $insert = $conn->prepare('INSERT INTO application (student_id, drive_id, status) VALUES (?, ?, ?)'); $insert->bind_param('iis', $studentId, $driveId, $status); $success = $insert->execute(); $message = $success ? 'Application submitted successfully. Good luck!' : 'We could not submit your application. Please try again.'; }
        }
    }
}
require_once 'layout.php'; student_page_start($conn, 'Apply'); ?>
<section class="page-heading"><h1><?= $success ? 'You are all set' : 'Application check' ?></h1></section><div class="card portal-card"><p class="<?= $success ? 'eligible' : 'ineligible' ?>"><?= htmlspecialchars($message) ?></p><a class="btn" href="drives.php">Back to drives</a></div><?php student_page_end(); ?>
