<?php
session_start();
include '../includes/db_connect.php';

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
        
        if (password_verify($password, $student['password'])) {
            session_regenerate_id(true);
            $_SESSION['student_id'] = $student['student_id'];
            $_SESSION['student_name'] = $student['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_msg = "Invalid password!";
        }
    } else {
        $error_msg = "No account found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Login — Placement Portal</title>
<style>
body { font-family: sans-serif; background: #0b0f19; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
.card { background: rgba(255,255,255,0.05); padding: 30px; border-radius: 10px; width: 350px; border: 1px solid rgba(255,255,255,0.1); }
input { width: 100%; padding: 12px; margin: 10px 0; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 5px; box-sizing: border-box; }
button { width: 100%; padding: 12px; background: #E8C777; color: #0b0f19; border: none; font-weight: bold; border-radius: 5px; cursor: pointer; margin-top: 10px; }
.error { color: #ff6b6b; font-size: 0.9rem; margin-bottom: 10px; text-align: center; }
</style>
<link rel="stylesheet" href="../css/dark-saas-theme.css">
</head>
<body>
<div class="card">
    <h2 style="color: #E8C777; text-align: center; margin-top: 0;">Student Login</h2>
    <?php if(!empty($error_msg)): ?><div class="error"><?= $error_msg ?></div><?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p style="text-align:center; color:#94a3b8; margin:16px 0 0; font-size:.9rem;">New to the portal? <a href="register.php" style="color:#E8C777;">Create a student account</a></p>
</div>
</body>
</html>
