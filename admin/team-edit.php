<?php
/**
 * Admin Panel - Add or Edit Team Member
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pageTitle = $id ? 'Edit Team Member' : 'Add Team Member';
require_once __DIR__ . '/includes/admin_header.php';

$member = [
    'name' => '',
    'role' => '',
    'bio' => '',
    'photo' => '',
    'linkedin' => ''
];

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM team WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $member = $existing;
    } else {
        setFlash('danger', 'Team member not found.');
        header("Location: team.php");
        exit;
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $linkedin = trim($_POST['linkedin'] ?? '');
    $photoUrl = trim($_POST['photo_url'] ?? '');

    $uploadedPhoto = handleImageUpload('photo_file', 'uploads');
    $finalPhoto = $uploadedPhoto ?: ($photoUrl ?: $member['photo']);

    if (empty($name) || empty($role)) {
        setFlash('danger', 'Name and role are required.');
    } else {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE team SET name = ?, role = ?, bio = ?, photo = ?, linkedin = ? WHERE id = ?");
            $stmt->execute([$name, $role, $bio, $finalPhoto, $linkedin, $id]);
            setFlash('success', 'Team member updated.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO team (name, role, bio, photo, linkedin) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $role, $bio, $finalPhoto, $linkedin]);
            setFlash('success', 'New team member added.');
        }
        header("Location: team.php");
        exit;
    }
}
?>

<div class="content-card" style="max-width: 800px;">
    <div class="card-header">
        <h3><i class="fa-solid fa-user-plus" style="color: var(--gold); margin-right: 8px;"></i> <?= $id ? 'Edit Executive Profile' : 'Add Executive' ?></h3>
        <a href="team.php" class="btn-admin btn-admin-secondary btn-icon-sm">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="team-edit.php<?= $id ? '?id=' . $id : '' ?>" method="POST" enctype="multipart/form-data">
            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Full Name *</label>
                    <input type="text" name="name" class="admin-input" value="<?= htmlspecialchars($member['name']) ?>" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Title / Role *</label>
                    <input type="text" name="role" class="admin-input" value="<?= htmlspecialchars($member['role']) ?>" placeholder="e.g. Head of Structural Engineering" required>
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Executive Biography</label>
                <textarea name="bio" class="admin-textarea" rows="3" placeholder="Credentials, licensing, career highlights..."><?= htmlspecialchars($member['bio']) ?></textarea>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label"><i class="fa-brands fa-linkedin"></i> LinkedIn Profile URL</label>
                <input type="url" name="linkedin" class="admin-input" value="<?= htmlspecialchars($member['linkedin']) ?>" placeholder="https://linkedin.com/in/...">
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Upload Executive Headshot</label>
                    <input type="file" name="photo_file" class="admin-input" accept="image/*">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Or Image URL</label>
                    <input type="url" name="photo_url" class="admin-input" value="<?= htmlspecialchars($member['photo']) ?>" placeholder="https://images.unsplash.com/...">
                </div>
            </div>

            <?php if (!empty($member['photo'])): ?>
                <div style="margin-bottom: 1.5rem;">
                    <img src="<?= htmlspecialchars($member['photo']) ?>" alt="Headshot" style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid var(--gold); object-fit: cover;">
                </div>
            <?php endif; ?>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn-admin btn-admin-gold">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span><?= $id ? 'Save Updates' : 'Publish Member' ?></span>
                </button>
                <a href="team.php" class="btn-admin btn-admin-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
