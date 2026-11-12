<?php
/**
 * Admin Dashboard Overview
 */

$pageTitle = 'Executive Dashboard';
require_once __DIR__ . '/includes/admin_header.php';

// Fetch metrics
$projectCount = (int)$pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$serviceCount = (int)$pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$testimonialCount = (int)$pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();
$teamCount = (int)$pdo->query("SELECT COUNT(*) FROM team")->fetchColumn();
$totalMessages = (int)$pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$unreadMessages = (int)$pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'unread'")->fetchColumn();

// Fetch recent messages
$recentMessages = $pdo->query("SELECT * FROM messages ORDER BY id DESC LIMIT 5")->fetchAll();

// Fetch recent projects
$recentProjects = $pdo->query("SELECT * FROM projects ORDER BY id DESC LIMIT 4")->fetchAll();
?>

<!-- Statistics Summary Grid -->
<div class="stats-cards-grid">
    <div class="stat-box">
        <div class="stat-box-icon">
            <i class="fa-solid fa-city"></i>
        </div>
        <div>
            <div class="stat-box-val"><?= $projectCount ?></div>
            <div class="stat-box-label">Portfolio Projects</div>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-icon">
            <i class="fa-solid fa-trowel-bricks"></i>
        </div>
        <div>
            <div class="stat-box-val"><?= $serviceCount ?></div>
            <div class="stat-box-label">Active Services</div>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-icon">
            <i class="fa-solid fa-inbox"></i>
        </div>
        <div>
            <div class="stat-box-val"><?= $unreadMessages ?> <span style="font-size: 0.9rem; color: #ef4444;">(<?= $totalMessages ?> total)</span></div>
            <div class="stat-box-label">Unread Proposals / Quotes</div>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-icon">
            <i class="fa-solid fa-star"></i>
        </div>
        <div>
            <div class="stat-box-val"><?= $testimonialCount ?></div>
            <div class="stat-box-label">Client Endorsements</div>
        </div>
    </div>
</div>

<!-- Quick Actions Banner -->
<div class="content-card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h3><i class="fa-solid fa-bolt" style="color: var(--gold); margin-right: 8px;"></i> Quick Administrative Actions</h3>
    </div>
    <div class="card-body" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="project-edit.php" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Add New Project</span>
        </a>
        <a href="service-edit.php" class="btn-admin btn-admin-secondary">
            <i class="fa-solid fa-plus"></i>
            <span>Add New Service</span>
        </a>
        <a href="settings.php" class="btn-admin btn-admin-secondary">
            <i class="fa-solid fa-sliders"></i>
            <span>Edit Company & Hero Settings</span>
        </a>
        <a href="messages.php" class="btn-admin btn-admin-secondary">
            <i class="fa-solid fa-envelope-open-text"></i>
            <span>Review Quote Inquiries (<?= $unreadMessages ?>)</span>
        </a>
        <a href="../index.php" target="_blank" class="btn-admin btn-admin-secondary">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>View Public Website</span>
        </a>
    </div>
</div>

<!-- Recent Messages Table -->
<div class="content-card">
    <div class="card-header">
        <h3><i class="fa-solid fa-inbox" style="color: var(--gold); margin-right: 8px;"></i> Recent Project Inquiries & Leads</h3>
        <a href="messages.php" class="btn-admin btn-admin-secondary btn-icon-sm">View All Messages</a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Contact Email</th>
                        <th>Service Required</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentMessages)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">No inquiries received yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentMessages as $msg): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($msg['created_at'])) ?></td>
                                <td><strong><?= htmlspecialchars($msg['name']) ?></strong></td>
                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                <td><span style="color: var(--gold);"><?= htmlspecialchars($msg['service'] ?: 'General') ?></span></td>
                                <td>
                                    <span class="status-badge status-<?= $msg['status'] ?>">
                                        <?= ucfirst(htmlspecialchars($msg['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="messages.php?view=<?= $msg['id'] ?>" class="btn-admin btn-admin-secondary btn-icon-sm">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Projects Preview -->
<div class="content-card">
    <div class="card-header">
        <h3><i class="fa-solid fa-city" style="color: var(--gold); margin-right: 8px;"></i> Portfolio Developments</h3>
        <a href="projects.php" class="btn-admin btn-admin-secondary btn-icon-sm">Manage All Projects</a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Project Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentProjects as $p): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($p['image'] ?: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=100&q=80') ?>" class="table-img" alt="">
                            </td>
                            <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
                            <td><?= htmlspecialchars($p['category']) ?></td>
                            <td><?= htmlspecialchars($p['location'] ?: '—') ?></td>
                            <td><?= htmlspecialchars($p['year'] ?: '—') ?></td>
                            <td><span class="status-badge status-<?= strtolower(str_replace(' ', '', $p['status'])) ?>"><?= htmlspecialchars($p['status']) ?></span></td>
                            <td>
                                <a href="project-edit.php?id=<?= $p['id'] ?>" class="btn-admin btn-admin-secondary btn-icon-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
