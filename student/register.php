<?php
include '../includes/db_connect.php';
require_once '../includes/student_helpers.php';

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $branch = trim($_POST['branch'] ?? '');
    $cgpa = trim($_POST['cgpa'] ?? '');
    $skills = trim($_POST['skills'] ?? '');

    // Check karo ki email pehle se registered toh nahi hai
    $check_query = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_msg = "This email is already registered! Please login.";
    } else {
        // Password ko secure hash banakar save karna
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (student_column_exists($conn, 'students', 'branch') && student_column_exists($conn, 'students', 'cgpa') && student_column_exists($conn, 'students', 'skills')) {
            $insert_query = "INSERT INTO students (name, email, password, branch, cgpa, skills) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($insert_query);
            $cgpaValue = $cgpa === '' ? null : (float)$cgpa;
            $stmt_insert->bind_param("ssssds", $name, $email, $hashed_password, $branch, $cgpaValue, $skills);
        } else {
            $insert_query = "INSERT INTO students (name, email, password) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($insert_query);
            $stmt_insert->bind_param("sss", $name, $email, $hashed_password);
        }

        if ($stmt_insert->execute()) {
            $success_msg = "Registration successful! You can now <a href='login.php'>Login here</a>.";
        } else {
            $error_msg = "Database Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration - Placement Portal</title>
    <style>
        body { font-family: 'Heebo', sans-serif; background: #0b0f19; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: rgba(255,255,255,0.04); border: 1px solid rgba(254,254,254,0.1); padding: 30px; border-radius: 12px; width: 100%; max-width: 400px; }
        h2 { color: #E8C777; margin-top: 0; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; background: rgba(254,254,254,0.05); border: 1px solid rgba(254,254,254,0.15); color: #fff; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #E8C777; color: #0b0f19; border: none; font-weight: bold; border-radius: 6px; cursor: pointer; margin-top: 10px; }
        button:hover { background: #f1d58d; }
        .alert-error { color: #ff6b6b; background: rgba(255,107,107,0.1); padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.9rem; }
        .alert-success { color: #28a745; background: rgba(40,167,69,0.1); padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.9rem; }
        .link { text-align: center; margin-top: 15px; font-size: 0.9rem; color: #94a3b8; }
        .link a { color: #E8C777; text-decoration: none; }
    </style>
<link rel="stylesheet" href="../css/dark-saas-theme.css">
</head>
<body>
<div class="card">
    <h2>Student Register 🎓</h2>
    <?php if (!empty($error_msg)): ?>
        <div class="alert-error"><?= htmlspecialchars($error_msg) ?></div>
    <?php endif; ?>
    <?php if (!empty($success_msg)): ?>
        <div class="alert-success"><?= $success_msg ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="branch" placeholder="Branch (e.g. CSE)">
        <input type="number" name="cgpa" min="0" max="10" step="0.01" placeholder="CGPA (e.g. 7.50)">
        <input type="text" name="skills" placeholder="Skills (e.g. PHP, MySQL, JavaScript)">
        <button type="submit">Register Account</button>
    </form>
    <div class="link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>
</body>
</html>
