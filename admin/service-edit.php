<?php
/**
 * Admin Panel - Add or Edit Service
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pageTitle = $id ? 'Edit Construction Service' : 'Add New Construction Service';
require_once __DIR__ . '/includes/admin_header.php';

$service = [
    'title' => '',
    'slug' => '',
    'icon' => 'fa-building',
    'short_desc' => '',
    'full_desc' => '',
    'image' => '',
    'order_num' => 1
];

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $service = $existing;
    } else {
        setFlash('danger', 'Service not found.');
        header("Location: services.php");
        exit;
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
    $icon = trim($_POST['icon'] ?? 'fa-building');
    $short_desc = trim($_POST['short_desc'] ?? '');
    $full_desc = trim($_POST['full_desc'] ?? '');
    $order_num = (int)($_POST['order_num'] ?? 0);
    $imageUrl = trim($_POST['image_url'] ?? '');

    // Check image upload
    $uploadedImage = handleImageUpload('image_file', 'uploads');
    $finalImage = $uploadedImage ?: ($imageUrl ?: $service['image']);

    if (empty($title)) {
        setFlash('danger', 'Service title cannot be empty.');
    } else {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE services SET title = ?, slug = ?, icon = ?, short_desc = ?, full_desc = ?, image = ?, order_num = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $icon, $short_desc, $full_desc, $finalImage, $order_num, $id]);
            setFlash('success', 'Service updated successfully.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO services (title, slug, icon, short_desc, full_desc, image, order_num) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $icon, $short_desc, $full_desc, $finalImage, $order_num]);
            setFlash('success', 'New service created successfully.');
        }
        header("Location: services.php");
        exit;
    }
}
?>

<div class="content-card" style="max-width: 860px;">
    <div class="card-header">
        <h3><i class="fa-solid fa-pen-nib" style="color: var(--gold); margin-right: 8px;"></i> <?= $id ? 'Modify Service Details' : 'Create Service Entry' ?></h3>
        <a href="services.php" class="btn-admin btn-admin-secondary btn-icon-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Services
        </a>
    </div>
    <div class="card-body">
        <form action="service-edit.php<?= $id ? '?id=' . $id : '' ?>" method="POST" enctype="multipart/form-data">
            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Service Title *</label>
                    <input type="text" name="title" class="admin-input" value="<?= htmlspecialchars($service['title']) ?>" placeholder="e.g. Commercial Construction" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">URL Slug</label>
                    <input type="text" name="slug" class="admin-input" value="<?= htmlspecialchars($service['slug']) ?>" placeholder="e.g. commercial-construction">
                </div>
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">FontAwesome Icon Class</label>
                    <input type="text" name="icon" class="admin-input" value="<?= htmlspecialchars($service['icon']) ?>" placeholder="e.g. fa-building, fa-hammer, fa-helmet-safety">
                    <span style="font-size: 0.75rem; color: var(--text-muted);">Preview: <i class="fa-solid <?= htmlspecialchars($service['icon']) ?>" style="color: var(--gold);"></i></span>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Display Order</label>
                    <input type="number" name="order_num" class="admin-input" value="<?= (int)$service['order_num'] ?>">
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Short Summary (Displayed on Cards & Homepage) *</label>
                <textarea name="short_desc" class="admin-textarea" rows="2" placeholder="Brief summary of capability..." required><?= htmlspecialchars($service['short_desc']) ?></textarea>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Full Technical Description (Detailed Page)</label>
                <textarea name="full_desc" class="admin-textarea" rows="5" placeholder="Detailed engineering protocols, machinery, scope..."><?= htmlspecialchars($service['full_desc']) ?></textarea>
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Image File Upload</label>
                    <input type="file" name="image_file" class="admin-input" accept="image/*">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Or Image URL</label>
                    <input type="url" name="image_url" class="admin-input" value="<?= htmlspecialchars($service['image']) ?>" placeholder="https://images.unsplash.com/...">
                </div>
            </div>

            <?php if (!empty($service['image'])): ?>
                <div style="margin-bottom: 1.5rem;">
                    <label class="admin-form-label">Current Image Preview</label>
                    <img src="<?= htmlspecialchars($service['image']) ?>" alt="Preview" style="max-height: 140px; border-radius: 8px; border: 1px solid var(--admin-border); object-fit: cover;">
                </div>
            <?php endif; ?>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn-admin btn-admin-gold">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span><?= $id ? 'Save Service Updates' : 'Publish New Service' ?></span>
                </button>
                <a href="services.php" class="btn-admin btn-admin-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
