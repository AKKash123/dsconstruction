<?php
/**
 * Admin Panel - Add or Edit Testimonial
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pageTitle = $id ? 'Edit Client Review' : 'Add Client Review';
require_once __DIR__ . '/includes/admin_header.php';

$testimonial = [
    'client_name' => '',
    'client_role' => '',
    'company' => '',
    'rating' => 5,
    'content' => '',
    'avatar' => ''
];

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $testimonial = $existing;
    } else {
        setFlash('danger', 'Review not found.');
        header("Location: testimonials.php");
        exit;
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $client_name = trim($_POST['client_name'] ?? '');
    $client_role = trim($_POST['client_role'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
    $content = trim($_POST['content'] ?? '');
    $avatarUrl = trim($_POST['avatar_url'] ?? '');

    $uploadedAvatar = handleImageUpload('avatar_file', 'uploads');
    $finalAvatar = $uploadedAvatar ?: ($avatarUrl ?: $testimonial['avatar']);

    if (empty($client_name) || empty($content)) {
        setFlash('danger', 'Client name and testimonial content are required.');
    } else {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE testimonials SET client_name = ?, client_role = ?, company = ?, rating = ?, content = ?, avatar = ? WHERE id = ?");
            $stmt->execute([$client_name, $client_role, $company, $rating, $content, $finalAvatar, $id]);
            setFlash('success', 'Testimonial updated successfully.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO testimonials (client_name, client_role, company, rating, content, avatar) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$client_name, $client_role, $company, $rating, $content, $finalAvatar]);
            setFlash('success', 'Testimonial added.');
        }
        header("Location: testimonials.php");
        exit;
    }
}
?>

<div class="content-card" style="max-width: 800px;">
    <div class="card-header">
        <h3><i class="fa-solid fa-star" style="color: var(--gold); margin-right: 8px;"></i> <?= $id ? 'Edit Testimonial' : 'Create Testimonial' ?></h3>
        <a href="testimonials.php" class="btn-admin btn-admin-secondary btn-icon-sm">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="testimonial-edit.php<?= $id ? '?id=' . $id : '' ?>" method="POST" enctype="multipart/form-data">
            <div class="admin-grid-3">
                <div class="admin-form-group">
                    <label class="admin-form-label">Client Name *</label>
                    <input type="text" name="client_name" class="admin-input" value="<?= htmlspecialchars($testimonial['client_name']) ?>" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Job Title / Role</label>
                    <input type="text" name="client_role" class="admin-input" value="<?= htmlspecialchars($testimonial['client_role']) ?>" placeholder="e.g. Managing Director">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Company / Entity</label>
                    <input type="text" name="company" class="admin-input" value="<?= htmlspecialchars($testimonial['company']) ?>" placeholder="e.g. Vance Capital Partners">
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Rating (Stars)</label>
                <select name="rating" class="admin-select" style="max-width: 200px;">
                    <option value="5" <?= ($testimonial['rating'] == 5) ? 'selected' : '' ?>>5 Stars (Exceptional)</option>
                    <option value="4" <?= ($testimonial['rating'] == 4) ? 'selected' : '' ?>>4 Stars (Very Good)</option>
                    <option value="3" <?= ($testimonial['rating'] == 3) ? 'selected' : '' ?>>3 Stars</option>
                </select>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Review Endorsement Text *</label>
                <textarea name="content" class="admin-textarea" rows="4" required><?= htmlspecialchars($testimonial['content']) ?></textarea>
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Upload Client Avatar Photo</label>
                    <input type="file" name="avatar_file" class="admin-input" accept="image/*">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Or Image URL</label>
                    <input type="url" name="avatar_url" class="admin-input" value="<?= htmlspecialchars($testimonial['avatar']) ?>" placeholder="https://images.unsplash.com/...">
                </div>
            </div>

            <?php if (!empty($testimonial['avatar'])): ?>
                <div style="margin-bottom: 1.5rem;">
                    <img src="<?= htmlspecialchars($testimonial['avatar']) ?>" alt="Avatar" style="width: 70px; height: 70px; border-radius: 50%; border: 2px solid var(--gold); object-fit: cover;">
                </div>
            <?php endif; ?>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn-admin btn-admin-gold">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span><?= $id ? 'Save Changes' : 'Publish Review' ?></span>
                </button>
                <a href="testimonials.php" class="btn-admin btn-admin-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
