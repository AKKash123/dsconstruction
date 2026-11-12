<?php
/**
 * Admin Panel - Manage Portfolio Projects
 */

$pageTitle = 'Portfolio Projects';
require_once __DIR__ . '/includes/admin_header.php';

// Handle deletion
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$delId]);
    setFlash('success', 'Project removed successfully.');
    header("Location: projects.php");
    exit;
}

$projects = $pdo->query("SELECT * FROM projects ORDER BY featured DESC, id DESC")->fetchAll();
?>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fa-solid fa-city" style="color: var(--gold); margin-right: 8px;"></i> All Portfolio Projects (<?= count($projects) ?>)</h3>
        <a href="project-edit.php" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i> Add New Project
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Image</th>
                        <th>Project Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($projects)): ?>
                        <tr><td colspan="8" style="text-align: center; padding: 2rem;">No projects yet. Click "Add New Project" above.</td></tr>
                    <?php else: ?>
                        <?php foreach ($projects as $p): ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($p['image'] ?: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=100&q=80') ?>" class="table-img" alt="">
                                </td>
                                <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
                                <td><span style="color: var(--gold);"><?= htmlspecialchars($p['category']) ?></span></td>
                                <td><?= htmlspecialchars($p['location'] ?: '—') ?></td>
                                <td><?= htmlspecialchars($p['year'] ?: '—') ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower(str_replace(' ', '', $p['status'])) ?>">
                                        <?= htmlspecialchars($p['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($p['featured']): ?>
                                        <i class="fa-solid fa-star" style="color: var(--gold);" title="Featured on Homepage"></i>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">&mdash;</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="project-edit.php?id=<?= $p['id'] ?>" class="btn-admin btn-admin-secondary btn-icon-sm" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="projects.php?delete=<?= $p['id'] ?>" onclick="return confirmDeletion(event, 'project');" class="btn-admin btn-admin-danger btn-icon-sm" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
