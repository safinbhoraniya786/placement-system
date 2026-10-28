<?php
/** Shared, schema-tolerant helpers for the student portal. */
function student_column_exists(mysqli $conn, string $table, string $column): bool {
    $table = $conn->real_escape_string($table);
    $column = $conn->real_escape_string($column);
    $result = $conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $result && $result->num_rows > 0;
}

function student_profile(mysqli $conn, int $studentId): ?array {
    $stmt = $conn->prepare('SELECT * FROM students WHERE student_id = ?');
    if (!$stmt) return null;
    $stmt->bind_param('i', $studentId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc() ?: null;
}

function eligibility_result(array $student, array $drive): array {
    $criteria = trim((string)($drive['eligibility'] ?? ''));
    $cgpa = isset($student['cgpa']) && $student['cgpa'] !== '' ? (float)$student['cgpa'] : null;
    $branch = trim((string)($student['branch'] ?? $student['department'] ?? ''));
    $reasons = [];

    if (preg_match('/(?:cgpa|gpa)\s*(?:of)?\s*([0-9](?:\.[0-9]+)?)(?:\s*\+|\s*(?:or|and)?\s*(?:above|minimum|min))?/i', $criteria, $match)) {
        $minimum = (float)$match[1];
        if ($cgpa === null) $reasons[] = 'Add your CGPA to your student profile.';
        elseif ($cgpa < $minimum) $reasons[] = "Minimum CGPA is $minimum (yours: $cgpa).";
    }

    // Matches common admin entries such as "CSE/IT", "B.Tech CSE", or "branches: CSE, IT".
    if (preg_match('/(?:branch(?:es)?\s*[:\-]?|b\.?tech\s+)([A-Za-z,&\/\s]+)/i', $criteria, $match)) {
        $allowed = preg_split('/\s*(?:,|\/|&|or)\s*/i', trim($match[1]));
        $allowed = array_filter(array_map('trim', $allowed));
        if (!$branch) $reasons[] = 'Add your branch to your student profile.';
        elseif ($allowed && !array_filter($allowed, fn($item) => $item !== '' && stripos($branch, $item) !== false)) {
            $reasons[] = 'Your branch (' . $branch . ') is not listed in the drive criteria.';
        }
    }
    return ['eligible' => !$reasons, 'reasons' => $reasons, 'criteria' => $criteria ?: 'No additional criteria listed.'];
}

function student_notification_count(mysqli $conn, int $studentId): int {
    $count = 0;
    $recent = $conn->query("SELECT COUNT(*) AS total FROM drive WHERE drive_date >= CURDATE() AND drive_date <= DATE_ADD(CURDATE(), INTERVAL 14 DAY)");
    if ($recent) $count += (int)$recent->fetch_assoc()['total'];
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM application WHERE student_id = ? AND LOWER(status) NOT IN ('applied', 'pending', 'submitted')");
    if ($stmt) { $stmt->bind_param('i', $studentId); $stmt->execute(); $count += (int)$stmt->get_result()->fetch_assoc()['total']; }
    return $count;
}
