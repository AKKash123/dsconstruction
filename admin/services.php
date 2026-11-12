<?php
/**
 * Admin Panel - Manage Services
 */

$pageTitle = 'Services Management';
require_once __DIR__ . '/includes/admin_header.php';

// Handle deletion
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$delId]);
    setFlash('success', 'Service deleted successfully.');
    header("Location: services.php");
    exit;
}

$services = $pdo->query("SELECT * FROM services ORDER BY order_num ASC, id ASC")->fetchAll();
?>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fa-solid fa-trowel-bricks" style="color: var(--gold); margin-right: 8px;"></i> Active Construction Services (<?= count($services) ?>)</h3>
        <a href="service-edit.php" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i> Add New Service
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th style="width: 80px;">Icon</th>
                        <th>Service Title</th>
                        <th>Short Summary</th>
                        <th style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($services)): ?>
                        <tr><td colspan="5" style="text-align: center; padding: 2rem;">No services defined. Click "Add New Service" above.</td></tr>
                    <?php else: ?>
                        <?php foreach ($services as $s): ?>
                            <tr>
                                <td><span style="font-weight: 700; color: var(--gold);"><?= $s['order_num'] ?></span></td>
                                <td>
                                    <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(212, 175, 55, 0.15); display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 1.1rem;">
                                        <i class="fa-solid <?= htmlspecialchars($s['icon'] ?: 'fa-building') ?>"></i>
                                    </div>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($s['title']) ?></strong>
                                </td>
                                <td>
                                    <span style="color: var(--text-dim); font-size: 0.85rem;"><?= htmlspecialchars(substr($s['short_desc'] ?? '', 0, 90)) ?>...</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="service-edit.php?id=<?= $s['id'] ?>" class="btn-admin btn-admin-secondary btn-icon-sm" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="services.php?delete=<?= $s['id'] ?>" onclick="return confirmDeletion(event, 'service');" class="btn-admin btn-admin-danger btn-icon-sm" title="Delete">
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
