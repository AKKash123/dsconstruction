<?php
/**
 * Admin Panel - Credentials & Security
 */

$pageTitle = 'Security & Admin Credentials';
require_once __DIR__ . '/includes/admin_header.php';

$userId = $_SESSION['admin_user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $newUsername = trim($_POST['username'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');
    $currentPass = $_POST['current_password'] ?? '';
    $newPass = $_POST['new_password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';

    // Verify current password first
    if (!password_verify($currentPass, $user['password_hash'])) {
        setFlash('danger', 'The current password you entered is incorrect.');
    } else {
        $updateFields = [];
        $params = [];

        if (!empty($newUsername) && $newUsername !== $user['username']) {
            $updateFields[] = "username = ?";
            $params[] = $newUsername;
            $_SESSION['admin_username'] = $newUsername;
        }

        if (!empty($newEmail)) {
            $updateFields[] = "email = ?";
            $params[] = $newEmail;
        }

        if (!empty($newPass)) {
            if (strlen($newPass) < 6) {
                setFlash('danger', 'New password must be at least 6 characters long.');
                header("Location: profile.php");
                exit;
            }
            if ($newPass !== $confirmPass) {
                setFlash('danger', 'The new passwords do not match.');
                header("Location: profile.php");
                exit;
            }
            $updateFields[] = "password_hash = ?";
            $params[] = password_hash($newPass, PASSWORD_BCRYPT);
        }

        if (!empty($updateFields)) {
            $params[] = $userId;
            $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
            $pdo->prepare($sql)->execute($params);
            setFlash('success', 'Admin credentials updated successfully.');
        } else {
            setFlash('info', 'No changes made.');
        }

        header("Location: profile.php");
        exit;
    }
}
?>

<div class="content-card" style="max-width: 650px;">
    <div class="card-header">
        <h3><i class="fa-solid fa-shield-halved" style="color: var(--gold); margin-right: 8px;"></i> Change Admin Credentials</h3>
    </div>
    <div class="card-body">
        <form action="profile.php" method="POST">
            <div class="admin-form-group">
                <label class="admin-form-label">Username</label>
                <input type="text" name="username" class="admin-input" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Recovery Email</label>
                <input type="email" name="email" class="admin-input" value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="admin@dsconstruction.com">
            </div>

            <div style="border-top: 1px solid var(--admin-border); margin: 2rem 0; padding-top: 1.5rem;">
                <h4 style="font-size: 1rem; color: var(--gold); margin-bottom: 1rem;">Update Password (Optional)</h4>

                <div class="admin-form-group">
                    <label class="admin-form-label">Current Password (Required for confirmation) *</label>
                    <input type="password" name="current_password" class="admin-input" placeholder="Enter current password" required>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">New Password</label>
                    <input type="password" name="new_password" class="admin-input" placeholder="Leave blank to keep unchanged">
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="admin-input" placeholder="Confirm new password">
                </div>
            </div>

            <button type="submit" class="btn-admin btn-admin-gold">
                <i class="fa-solid fa-key"></i>
                <span>Update Credentials</span>
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
