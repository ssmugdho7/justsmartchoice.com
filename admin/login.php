<?php
require_once __DIR__ . '/auth.php';

if (AdminAuth::check()) {
    header('Location: index.php');
    exit;
}

$error = '';
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!AdminAuth::verifyCsrf($token)) {
        $error = 'Security session expired. Please refresh and try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (AdminAuth::login($username, $password)) {
            // Success
            $target = (!empty($redirect) && strpos($redirect, 'login.php') === false) ? $redirect : 'index.php';
            header('Location: ' . $target);
            exit;
        } else {
            $error = 'Invalid username or password. Please try again.';
        }
    }
}

$csrf = AdminAuth::csrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Admin Login | Just Smart Choice Construction</title>
    <link rel="icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
</head>
<body class="cms-login-page">

<div class="cms-login-card">
    <div class="cms-login-header">
        <div class="cms-login-logo">
            <i class="fa-solid fa-leaf"></i>
        </div>
        <h2>Smart Choice CMS</h2>
        <p>Sign in to manage website pages, media, and design</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="cms-alert cms-alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php?redirect=<?php echo urlencode($redirect); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">

        <div class="cms-form-group">
            <label class="cms-label" for="username">Username or Email</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                class="cms-input" 
                placeholder="admin" 
                required 
                autofocus
                value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
            >
        </div>

        <div class="cms-form-group">
            <label class="cms-label" for="password">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="cms-input" 
                placeholder="••••••••••••" 
                required
            >
        </div>

        <div style="margin-top: 24px;">
            <button type="submit" class="cms-btn cms-btn-primary" style="width: 100%; padding: 12px; font-size: 14px;">
                <i class="fa-solid fa-right-to-bracket"></i>
                Sign In to CMS Admin
            </button>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="/" style="font-size: 12.5px; color: var(--text-muted); text-decoration: none;">
                <i class="fa-solid fa-arrow-left"></i> Return to live website
            </a>
        </div>
    </form>
</div>

</body>
</html>
