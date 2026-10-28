<?php
require_once 'layout.php';
require_once '../includes/db_connect.php';

$error = ''; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $username)) {
        $error = 'Use 3–50 letters, numbers, dots, underscores, or hyphens for the username.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $error = 'Enter a valid email address.';
    } elseif (strlen($password) < 10) {
        $error = 'Use a password with at least 10 characters.';
    } elseif (!hash_equals($password, $confirm)) {
        $error = 'The passwords do not match.';
    } else {
        $check = $conn->prepare('SELECT admin_id FROM admin WHERE username = ? OR email = ?');
        $check->bind_param('ss', $username, $email);
        $check->execute();
        if ($check->get_result()->num_rows) {
            $error = 'That username is already in use.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare('INSERT INTO admin (username, email, password) VALUES (?, ?, ?)');
            $insert->bind_param('sss', $username, $email, $hash);
            if ($insert->execute()) $success = 'Admin account created.';
            else $error = 'The account could not be created.';
        }
    }
}
admin_page_start('Add admin account', '');
?>
<section class="page-heading"><h1>Create an administrator account</h1><p>Set up your placement portal administrator access.</p></section>
<section class="card portal-card" style="max-width:560px">
<?php if ($success): ?><p class="success"><?= htmlspecialchars($success) ?> You can now <a href="login.php">go to admin login</a>.</p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-grid"><div class="field"><label for="username">Username</label><input id="username" name="username" maxlength="50" required autocomplete="username"></div><div class="field"><label for="email">Email address</label><input id="email" type="email" name="email" maxlength="100" required autocomplete="email"></div><div class="field"><label for="password">Password</label><input id="password" type="password" name="password" minlength="10" required autocomplete="new-password"></div><div class="field"><label for="confirm_password">Confirm password</label><input id="confirm_password" type="password" name="confirm_password" minlength="10" required autocomplete="new-password"></div><div class="full"><button class="btn" type="submit">Create administrator</button> <a class="btn" href="login.php">Back to login</a></div></form>
</section><?php admin_page_end(); ?>
