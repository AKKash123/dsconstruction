<?php
/**
 * Admin Panel - Add or Edit Project
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pageTitle = $id ? 'Edit Portfolio Project' : 'Add New Portfolio Project';
require_once __DIR__ . '/includes/admin_header.php';

$project = [
    'title' => '',
    'category' => 'Commercial',
    'client' => '',
    'location' => '',
    'year' => date('Y'),
    'image' => '',
    'description' => '',
    'featured' => 0,
    'status' => 'Completed'
];

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $project = $existing;
    } else {
        setFlash('danger', 'Project not found.');
        header("Location: projects.php");
        exit;
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'Commercial');
    $client = trim($_POST['client'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $year = trim($_POST['year'] ?? date('Y'));
    $description = trim($_POST['description'] ?? '');
    $status = trim($_POST['status'] ?? 'Completed');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $imageUrl = trim($_POST['image_url'] ?? '');

    // Check image upload
    $uploadedImage = handleImageUpload('image_file', 'uploads');
    $finalImage = $uploadedImage ?: ($imageUrl ?: $project['image']);

    if (empty($title)) {
        setFlash('danger', 'Project title is required.');
    } else {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE projects SET title = ?, category = ?, client = ?, location = ?, year = ?, image = ?, description = ?, featured = ?, status = ? WHERE id = ?");
            $stmt->execute([$title, $category, $client, $location, $year, $finalImage, $description, $featured, $status, $id]);
            setFlash('success', 'Project updated successfully.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (title, category, client, location, year, image, description, featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $category, $client, $location, $year, $finalImage, $description, $featured, $status]);
            setFlash('success', 'New project added to portfolio.');
        }
        header("Location: projects.php");
        exit;
    }
}
?>

<div class="content-card" style="max-width: 860px;">
    <div class="card-header">
        <h3><i class="fa-solid fa-pen-to-square" style="color: var(--gold); margin-right: 8px;"></i> <?= $id ? 'Edit Development Entry' : 'Add Development to Portfolio' ?></h3>
        <a href="projects.php" class="btn-admin btn-admin-secondary btn-icon-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Projects
        </a>
    </div>
    <div class="card-body">
        <form action="project-edit.php<?= $id ? '?id=' . $id : '' ?>" method="POST" enctype="multipart/form-data">
            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Project Title *</label>
                    <input type="text" name="title" class="admin-input" value="<?= htmlspecialchars($project['title']) ?>" placeholder="e.g. Aura Grand Luxury Tower" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Category *</label>
                    <select name="category" class="admin-select">
                        <option value="Commercial" <?= ($project['category'] === 'Commercial') ? 'selected' : '' ?>>Commercial</option>
                        <option value="Luxury Residential" <?= ($project['category'] === 'Luxury Residential') ? 'selected' : '' ?>>Luxury Residential</option>
                        <option value="Renovation" <?= ($project['category'] === 'Renovation') ? 'selected' : '' ?>>Renovation</option>
                        <option value="Infrastructure" <?= ($project['category'] === 'Infrastructure') ? 'selected' : '' ?>>Infrastructure</option>
                    </select>
                </div>
            </div>

            <div class="admin-grid-3">
                <div class="admin-form-group">
                    <label class="admin-form-label">Client / Developer</label>
                    <input type="text" name="client" class="admin-input" value="<?= htmlspecialchars($project['client']) ?>" placeholder="e.g. Skyline Group or Private">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Site Location</label>
                    <input type="text" name="location" class="admin-input" value="<?= htmlspecialchars($project['location']) ?>" placeholder="e.g. Financial District, NY">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Completion Year</label>
                    <input type="text" name="year" class="admin-input" value="<?= htmlspecialchars($project['year']) ?>" placeholder="2026">
                </div>
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Construction Status</label>
                    <select name="status" class="admin-select">
                        <option value="Completed" <?= ($project['status'] === 'Completed') ? 'selected' : '' ?>>Completed</option>
                        <option value="In Progress" <?= ($project['status'] === 'In Progress') ? 'selected' : '' ?>>In Progress</option>
                    </select>
                </div>
                <div class="admin-form-group" style="display: flex; align-items: center; padding-top: 1.8rem;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--gold); font-weight: 700;">
                        <input type="checkbox" name="featured" value="1" <?= $project['featured'] ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                        <span>Feature on Homepage Showcase</span>
                    </label>
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Project Description & Technical Scope</label>
                <textarea name="description" class="admin-textarea" rows="4" placeholder="Materials used, square footage, structural features..."><?= htmlspecialchars($project['description']) ?></textarea>
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Upload High-Res Project Photo</label>
                    <input type="file" name="image_file" class="admin-input" accept="image/*">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Or Image URL</label>
                    <input type="url" name="image_url" class="admin-input" value="<?= htmlspecialchars($project['image']) ?>" placeholder="https://images.unsplash.com/...">
                </div>
            </div>

            <?php if (!empty($project['image'])): ?>
                <div style="margin-bottom: 1.5rem;">
                    <label class="admin-form-label">Current Photo</label>
                    <img src="<?= htmlspecialchars($project['image']) ?>" alt="Preview" style="max-height: 180px; border-radius: 8px; border: 1px solid var(--admin-border); object-fit: cover;">
                </div>
            <?php endif; ?>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn-admin btn-admin-gold">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span><?= $id ? 'Save Project Details' : 'Publish Project' ?></span>
                </button>
                <a href="projects.php" class="btn-admin btn-admin-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
