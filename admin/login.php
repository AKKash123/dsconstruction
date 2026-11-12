<?php
/**
 * Admin Panel Login
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/auth.php';

if (isAdminLoggedIn()) {
    header("Location: index.php");
    exit;
}

$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_user_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            setFlash('success', 'Welcome back, ' . htmlspecialchars($user['username']) . '!');
            header("Location: index.php");
            exit;
        } else {
            $error = 'Invalid administrative credentials. Please verify your username and password.';
        }
    } else {
        $error = 'Please enter both username and password.';
    }
}

$settings = getSettings($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= htmlspecialchars($settings['site_name'] ?? 'DS Construction') ?></title>
    <link rel="icon" type="image/jpeg" href="../<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="login-screen">
        <div class="login-card">
            <img src="../<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>" alt="DS Construction Logo" class="login-logo">
            <h1 class="login-title"><?= htmlspecialchars($settings['site_name'] ?? 'DS CONSTRUCTION') ?></h1>
            <p class="login-subtitle">Management & Content Control Portal</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" style="margin-bottom: 1.5rem; text-align: left;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" style="text-align: left;">
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fa-solid fa-user"></i> Username</label>
                    <input type="text" name="username" class="admin-input" placeholder="admin" value="admin" required autofocus>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fa-solid fa-lock"></i> Password</label>
                    <input type="password" name="password" class="admin-input" placeholder="admin123" value="admin123" required>
                </div>

                <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center; padding: 0.85rem; margin-top: 1rem;">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Sign In to Dashboard</span>
                </button>
            </form>

            <div style="margin-top: 2rem; padding: 1rem; background: var(--admin-surface-light); border-radius: 8px; font-size: 0.82rem; color: var(--text-dim);">
                <p><strong>Default Access Credentials:</strong></p>
                <p style="margin-top: 3px;">Username: <code style="color: var(--gold);">admin</code> &bull; Password: <code style="color: var(--gold);">admin123</code></p>
            </div>

            <div style="margin-top: 1.5rem;">
                <a href="../index.php" style="font-size: 0.85rem; color: var(--text-muted);"><i class="fa-solid fa-arrow-left"></i> Return to Public Website</a>
            </div>
        </div>
    </div>
</body>
</html>
