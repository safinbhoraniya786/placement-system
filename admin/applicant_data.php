<?php
require_once __DIR__ . '/layout.php';
function applicant_filters(mysqli $conn): array {
    return ['min_cgpa' => filter_input(INPUT_GET, 'min_cgpa', FILTER_VALIDATE_FLOAT), 'max_cgpa' => filter_input(INPUT_GET, 'max_cgpa', FILTER_VALIDATE_FLOAT), 'branch' => trim($_GET['branch'] ?? ''), 'skills' => trim($_GET['skills'] ?? '')];
}
function applicant_result(mysqli $conn, array $filters): mysqli_result|false {
    $hasCgpa = admin_column_exists($conn, 'students', 'cgpa'); $hasBranch = admin_column_exists($conn, 'students', 'branch'); $hasSkills = admin_column_exists($conn, 'students', 'skills');
    $selectCgpa = $hasCgpa ? 's.cgpa' : 'NULL AS cgpa'; $selectBranch = $hasBranch ? 's.branch' : 's.department AS branch'; $selectSkills = $hasSkills ? 's.skills' : "'' AS skills";
    $sql = "SELECT a.application_id, a.status, a.applied_date, s.name, s.email, $selectCgpa, $selectBranch, $selectSkills, c.name AS company_name FROM application a JOIN students s ON s.student_id=a.student_id JOIN drive d ON d.drive_id=a.drive_id LEFT JOIN company c ON c.company_id=d.company_id WHERE 1=1";
    if ($hasCgpa && $filters['min_cgpa'] !== false && $filters['min_cgpa'] !== null) $sql .= ' AND s.cgpa >= ' . (float)$filters['min_cgpa'];
    if ($hasCgpa && $filters['max_cgpa'] !== false && $filters['max_cgpa'] !== null) $sql .= ' AND s.cgpa <= ' . (float)$filters['max_cgpa'];
    if ($filters['branch'] !== '') $sql .= " AND " . ($hasBranch ? 's.branch' : 's.department') . " LIKE '%" . $conn->real_escape_string($filters['branch']) . "%'";
    if ($hasSkills && $filters['skills'] !== '') $sql .= " AND s.skills LIKE '%" . $conn->real_escape_string($filters['skills']) . "%'";
    return $conn->query($sql . ' ORDER BY a.applied_date DESC');
}
