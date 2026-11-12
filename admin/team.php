<?php
/**
 * Admin Panel - Manage Team Members
 */

$pageTitle = 'Executive Leadership Team';
require_once __DIR__ . '/includes/admin_header.php';

// Handle deletion
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM team WHERE id = ?");
    $stmt->execute([$delId]);
    setFlash('success', 'Team member removed.');
    header("Location: team.php");
    exit;
}

$team = $pdo->query("SELECT * FROM team ORDER BY id ASC")->fetchAll();
?>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fa-solid fa-users-gear" style="color: var(--gold); margin-right: 8px;"></i> Executive Leadership (<?= count($team) ?>)</h3>
        <a href="team-edit.php" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i> Add Team Member
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">Photo</th>
                        <th>Name</th>
                        <th>Role / Title</th>
                        <th>Brief Biography</th>
                        <th style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($team)): ?>
                        <tr><td colspan="5" style="text-align: center; padding: 2rem;">No team members defined yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($team as $m): ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($m['photo'] ?: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=100&q=80') ?>" class="table-img" style="border-radius: 50%;" alt="">
                                </td>
                                <td><strong><?= htmlspecialchars($m['name']) ?></strong></td>
                                <td><span style="color: var(--gold);"><?= htmlspecialchars($m['role']) ?></span></td>
                                <td><span style="color: var(--text-dim); font-size: 0.85rem;"><?= htmlspecialchars(substr($m['bio'] ?? '', 0, 80)) ?>...</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="team-edit.php?id=<?= $m['id'] ?>" class="btn-admin btn-admin-secondary btn-icon-sm" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="team.php?delete=<?= $m['id'] ?>" onclick="return confirmDeletion(event, 'team member');" class="btn-admin btn-admin-danger btn-icon-sm" title="Delete">
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
