<?php
/**
 * Admin Panel - Manage Quote Requests & Inquiries
 */

$pageTitle = 'Project Inquiries & Quotes';
require_once __DIR__ . '/includes/admin_header.php';

// Handle status updates
if (isset($_GET['status_update']) && isset($_GET['id'])) {
    $msgId = (int)$_GET['id'];
    $newStatus = in_array($_GET['status_update'], ['unread', 'read', 'contacted']) ? $_GET['status_update'] : 'read';
    $stmt = $pdo->prepare("UPDATE messages SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $msgId]);
    setFlash('success', 'Inquiry status updated to ' . ucfirst($newStatus) . '.');
    header("Location: messages.php" . (isset($_GET['view']) ? '?view=' . $msgId : ''));
    exit;
}

// Handle deletion
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$delId]);
    setFlash('success', 'Inquiry deleted successfully.');
    header("Location: messages.php");
    exit;
}

// View specific message
$viewMessage = null;
if (isset($_GET['view'])) {
    $viewId = (int)$_GET['view'];
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->execute([$viewId]);
    $viewMessage = $stmt->fetch();

    if ($viewMessage && $viewMessage['status'] === 'unread') {
        // Auto mark as read
        $pdo->prepare("UPDATE messages SET status = 'read' WHERE id = ?")->execute([$viewId]);
        $viewMessage['status'] = 'read';
    }
}

// Filter
$filter = $_GET['filter'] ?? 'all';
$query = "SELECT * FROM messages";
if ($filter === 'unread') {
    $query .= " WHERE status = 'unread'";
} elseif ($filter === 'contacted') {
    $query .= " WHERE status = 'contacted'";
}
$query .= " ORDER BY id DESC";

$messages = $pdo->query($query)->fetchAll();
?>

<!-- Single Message View Modal / Card if ?view=ID -->
<?php if ($viewMessage): ?>
    <div class="content-card" style="border-color: var(--gold); box-shadow: 0 0 25px rgba(212, 175, 55, 0.2);">
        <div class="card-header" style="background: rgba(212, 175, 55, 0.08);">
            <h3>
                <i class="fa-solid fa-envelope-open" style="color: var(--gold); margin-right: 8px;"></i>
                Proposal Inquiry from <?= htmlspecialchars($viewMessage['name']) ?>
            </h3>
            <a href="messages.php" class="btn-admin btn-admin-secondary btn-icon-sm">
                <i class="fa-solid fa-xmark"></i> Close Preview
            </a>
        </div>
        <div class="card-body">
            <div class="admin-grid-3" style="margin-bottom: 1.5rem; background: var(--admin-surface-light); padding: 1.25rem; border-radius: 8px;">
                <div>
                    <span style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Client Name:</span>
                    <p style="font-weight: 700; font-size: 1.05rem;"><?= htmlspecialchars($viewMessage['name']) ?></p>
                </div>
                <div>
                    <span style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Contact Email:</span>
                    <p><a href="mailto:<?= htmlspecialchars($viewMessage['email']) ?>" style="color: var(--gold);"><?= htmlspecialchars($viewMessage['email']) ?></a></p>
                </div>
                <div>
                    <span style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Phone Number:</span>
                    <p><?= htmlspecialchars($viewMessage['phone'] ?: 'None provided') ?></p>
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <span style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Service Category:</span>
                <span class="status-badge" style="background: rgba(212, 175, 55, 0.15); color: var(--gold); margin-left: 8px;"><?= htmlspecialchars($viewMessage['service'] ?: 'General') ?></span>
                <span style="margin-left: 15px; font-size: 0.85rem; color: var(--text-muted);"><i class="fa-regular fa-clock"></i> Received on <?= date('F d, Y \a\t g:i A', strtotime($viewMessage['created_at'])) ?></span>
            </div>

            <div style="background: var(--admin-surface-light); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--admin-border); margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gold); margin-bottom: 0.75rem;">Project Scope & Specifications:</h4>
                <p style="white-space: pre-line; line-height: 1.7;"><?= htmlspecialchars($viewMessage['message']) ?></p>
            </div>

            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <a href="mailto:<?= htmlspecialchars($viewMessage['email']) ?>?subject=<?= urlencode('Regarding your inquiry with DS Construction') ?>" class="btn-admin btn-admin-gold">
                    <i class="fa-solid fa-reply"></i>
                    <span>Reply via Email</span>
                </a>

                <?php if ($viewMessage['status'] !== 'contacted'): ?>
                    <a href="messages.php?status_update=contacted&id=<?= $viewMessage['id'] ?>" class="btn-admin btn-admin-secondary" style="color: #10b981;">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Mark as Contacted</span>
                    </a>
                <?php endif; ?>

                <a href="messages.php?delete=<?= $viewMessage['id'] ?>" onclick="return confirmDeletion(event, 'inquiry');" class="btn-admin btn-admin-danger">
                    <i class="fa-solid fa-trash"></i>
                    <span>Delete Inquiry</span>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Filter Tabs & Main Messages Table -->
<div class="content-card">
    <div class="card-header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <h3><i class="fa-solid fa-inbox" style="color: var(--gold); margin-right: 8px;"></i> Inquiries Inbox (<?= count($messages) ?>)</h3>
            <div style="display: flex; gap: 6px;">
                <a href="messages.php?filter=all" class="btn-admin <?= ($filter === 'all') ? 'btn-admin-gold' : 'btn-admin-secondary' ?> btn-icon-sm">All</a>
                <a href="messages.php?filter=unread" class="btn-admin <?= ($filter === 'unread') ? 'btn-admin-gold' : 'btn-admin-secondary' ?> btn-icon-sm">Unread</a>
                <a href="messages.php?filter=contacted" class="btn-admin <?= ($filter === 'contacted') ? 'btn-admin-gold' : 'btn-admin-secondary' ?> btn-icon-sm">Contacted</a>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Email & Phone</th>
                        <th>Service</th>
                        <th>Message Preview</th>
                        <th>Status</th>
                        <th style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($messages)): ?>
                        <tr><td colspan="7" style="text-align: center; padding: 2rem;">No inquiries matching the selected filter.</td></tr>
                    <?php else: ?>
                        <?php foreach ($messages as $msg): ?>
                            <tr style="<?= ($msg['status'] === 'unread') ? 'background: rgba(212, 175, 55, 0.05); font-weight: 600;' : '' ?>">
                                <td><?= date('M d, Y', strtotime($msg['created_at'])) ?></td>
                                <td><strong><?= htmlspecialchars($msg['name']) ?></strong></td>
                                <td>
                                    <div><?= htmlspecialchars($msg['email']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-dim);"><?= htmlspecialchars($msg['phone'] ?: 'No phone') ?></div>
                                </td>
                                <td><span style="color: var(--gold); font-size: 0.85rem;"><?= htmlspecialchars($msg['service'] ?: 'General') ?></span></td>
                                <td><span style="color: var(--text-dim); font-size: 0.85rem;"><?= htmlspecialchars(substr($msg['message'], 0, 60)) ?>...</span></td>
                                <td>
                                    <span class="status-badge status-<?= $msg['status'] ?>">
                                        <?= ucfirst(htmlspecialchars($msg['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="messages.php?view=<?= $msg['id'] ?>" class="btn-admin btn-admin-secondary btn-icon-sm" title="View Full Message">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="messages.php?delete=<?= $msg['id'] ?>" onclick="return confirmDeletion(event, 'message');" class="btn-admin btn-admin-danger btn-icon-sm" title="Delete">
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
