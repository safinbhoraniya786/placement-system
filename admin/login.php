<?php
session_start();
require_once "../includes/db_connect.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT admin_id, username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin["password"])) {
            session_regenerate_id(true);
            $_SESSION["admin_id"]       = $admin["admin_id"];
            $_SESSION["admin_username"] = $admin["username"];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect username or password.";
        }
    } else {
        $error = "Incorrect username or password.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Placement Portal</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dark-saas-theme.css">
<style>
  .admin-register-link { color: #E8C777; text-decoration: underline; text-underline-offset: 3px; font-weight: 700; }
  .admin-register-link:hover, .admin-register-link:focus-visible { color: #f1d58d; }
</style>
</head>
<body>
  <div class="form-wrap">
    <div class="form-card">
      <span class="eyebrow">Admin</span>
      <h2>Placement cell login</h2>

      <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <form method="POST" action="login.php">
        <div class="field">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn-primary">Log in</button>
      </form>

      <div class="form-footer-link">
        Don't have an admin account? <a class="admin-register-link" href="register.php">Register here</a>
      </div>

    </div>
  </div>
</body>
</html>
