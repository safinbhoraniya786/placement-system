<?php
include '../includes/db_connect.php';

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); // Plain text ya hash rakh sakte ho

    // Check karo email already exists toh nahi
    $check = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $error_msg = "Email is already registered! Please login.";
    } else {
        $insert = $conn->prepare("INSERT INTO students (name, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $name, $email, $password);

        if ($insert->execute()) {
            $success_msg = "Registration successful! <a href='login.php' style='color:#E8C777;'>Login here</a>";
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration — Placement Portal</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700&display=swap">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Heebo', sans-serif;
    background: radial-gradient(circle at 50% 10%, rgba(30, 20, 35, 0.9) 0%, #0b0f19 85%);
    color: #ffffff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
    background: rgba(11, 15, 25, 0.85);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(254, 254, 254, 0.08);
}
.brand { font-size: 1.5rem; font-weight: 700; color: #ffffff; text-decoration: none; }
.brand span { color: #E8C777; }
.back-home { color: #94a3b8; text-decoration: none; font-size: 0.95rem; font-weight: 500; }
.back-home:hover { color: #E8C777; }
.register-wrapper { display: flex; justify-content: center; align-items: center; padding: 40px 20px; flex: 1; }
.card {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(254, 254, 254, 0.1);
    border-radius: 16px;
    padding: 40px 35px;
    width: 100%;
    max-width: 420px;
    backdrop-filter: blur(16px);
}
.card__heading { font-size: 1.8rem; font-weight: 700; margin-bottom: 8px; color: #ffffff; text-align: center; }
.card__subheading { font-size: 0.95rem; color: #94a3b8; margin-bottom: 25px; text-align: center; }
.alert-error { background: rgba(255, 107, 107, 0.15); border: 1px solid #ff6b6b; color: #ff6b6b; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; }
.alert-success { background: rgba(40, 167, 69, 0.15); border: 1px solid #28a745; color: #28a745; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; }
.input-group { margin-bottom: 20px; }
.input-group label { font-size: 0.85rem; color: #cbd5e1; display: block; margin-bottom: 8px; font-weight: 500; }
.card__input {
    background: rgba(254, 254, 254, 0.05);
    border: 1px solid rgba(254, 254, 254, 0.15);
    border-radius: 8px;
    color: #FEFEFE;
    display: block;
    font-size: 1rem;
    padding: 14px;
    width: 100%;
}
.card__input:focus { border-color: #E8C777; outline: none; }
.card__button {
    background: #E8C777;
    border: none;
    border-radius: 8px;
    color: #0b0f19;
    font-weight: 700;
    font-size: 1rem;
    margin-top: 10px;
    padding: 14px;
    width: 100%;
    cursor: pointer;
}
.card__button:hover { background: #f1d58d; }
.card-footer-text { margin-top: 25px; font-size: 0.9rem; color: #94a3b8; text-align: center; }
.card-footer-text a { color: #E8C777; text-decoration: none; font-weight: 600; }
footer { text-align: center; padding: 20px; font-size: 0.85rem; color: #64748b; background: #0b0f19; border-top: 1px solid rgba(254, 254, 254, 0.05); }
</style>
<link rel="stylesheet" href="../css/dark-saas-theme.css">
</head>
<body>

<header>
    <a href="../index.php" class="brand">Placement<span>Portal</span></a>
    <a href="../index.php" class="back-home">&larr; Back to Home</a>
</header>

<div class="register-wrapper">
    <section class="card">
        <h1 class="card__heading">Student Register</h1>
        <p class="card__subheading">Create your account to apply for drives</p>
        
        <?php if (!empty($error_msg)): ?>
            <div class="alert-error"><?= htmlspecialchars($error_msg) ?></div>
        <?php endif; ?>
        <?php if (!empty($success_msg)): ?>
            <div class="alert-success"><?= $success_msg ?></div>
        <?php endif; ?>

        <form class="card__form" action="" method="POST">
            <div class="input-group">
                <label for="name">Full Name</label>
                <input id="name" name="name" class="card__input" type="text" placeholder="Safin Bhoraniya" required />
            </div>

            <div class="input-group">
                <label for="email">Email Address</label>
                <input id="email" name="email" class="card__input" type="email" placeholder="student@college.edu" required />
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input id="password" name="password" class="card__input" type="password" placeholder="••••••••" required />
            </div>

            <button class="card__button" type="submit">
                <span>Register Account</span>
            </button>
        </form>

        <div class="card-footer-text">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </section>
</div>

<footer>
    Placement Record Management System &bull; Minor Project
</footer>

</body>
</html>
