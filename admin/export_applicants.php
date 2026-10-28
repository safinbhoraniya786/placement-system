<?php
require_once 'layout.php'; admin_require_login(); require_once '../includes/db_connect.php'; require_once 'applicant_data.php';
$result = applicant_result($conn, applicant_filters($conn));
header('Content-Type: text/csv; charset=utf-8'); header('Content-Disposition: attachment; filename=placement-applicants-' . date('Y-m-d') . '.csv');
$out = fopen('php://output', 'w'); fputcsv($out, ['Student', 'Email', 'Company', 'CGPA', 'Branch', 'Skills', 'Application status', 'Applied date']);
if ($result) while ($row = $result->fetch_assoc()) fputcsv($out, [$row['name'], $row['email'], $row['company_name'], $row['cgpa'], $row['branch'], $row['skills'], $row['status'], $row['applied_date']]); fclose($out); exit;
