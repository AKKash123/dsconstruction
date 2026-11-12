<?php
/**
 * Admin Panel - Manage Testimonials
 */

$pageTitle = 'Testimonials & Reviews';
require_once __DIR__ . '/includes/admin_header.php';

// Handle deletion
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
    $stmt->execute([$delId]);
    setFlash('success', 'Testimonial removed.');
    header("Location: testimonials.php");
    exit;
}

$testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();
?>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fa-solid fa-comments" style="color: var(--gold); margin-right: 8px;"></i> Client Testimonials (<?= count($testimonials) ?>)</h3>
        <a href="testimonial-edit.php" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i> Add Testimonial
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">Photo</th>
                        <th>Client Name</th>
                        <th>Role & Company</th>
                        <th>Rating</th>
                        <th>Review Text</th>
                        <th style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($testimonials)): ?>
                        <tr><td colspan="6" style="text-align: center; padding: 2rem;">No testimonials yet. Click "Add Testimonial" above.</td></tr>
                    <?php else: ?>
                        <?php foreach ($testimonials as $t): ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($t['avatar'] ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80') ?>" class="table-img" style="border-radius: 50%;" alt="">
                                </td>
                                <td><strong><?= htmlspecialchars($t['client_name']) ?></strong></td>
                                <td><?= htmlspecialchars($t['client_role']) ?> &bull; <?= htmlspecialchars($t['company']) ?></td>
                                <td>
                                    <span style="color: var(--gold);">
                                        <?php for ($i = 0; $i < (int)$t['rating']; $i++): ?>★<?php endfor; ?>
                                    </span>
                                </td>
                                <td><span style="color: var(--text-dim); font-size: 0.85rem;"><?= htmlspecialchars(substr($t['content'], 0, 80)) ?>...</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="testimonial-edit.php?id=<?= $t['id'] ?>" class="btn-admin btn-admin-secondary btn-icon-sm" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="testimonials.php?delete=<?= $t['id'] ?>" onclick="return confirmDeletion(event, 'testimonial');" class="btn-admin btn-admin-danger btn-icon-sm" title="Delete">
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
