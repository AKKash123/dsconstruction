<?php
/**
 * DS Construction - Projects / Portfolio Gallery
 */

require_once __DIR__ . '/includes/header.php';

// Fetch all projects
$stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$projects = $stmt->fetchAll();

// Extract unique categories
$categories = array_unique(array_filter(array_column($projects, 'category')));
?>

<!-- Page Banner -->
<section style="padding: 160px 0 80px; background: var(--bg-surface-elevated); border-bottom: 1px solid var(--border-color); text-align: center;">
    <div class="container">
        <span class="section-subtitle">Our Work</span>
        <h1 class="section-title" style="margin-bottom: 1rem;">Architectural & Engineering Portfolio</h1>
        <p class="section-desc" style="max-width: 650px; margin: 0 auto;">
            A showcase of precision developments delivered across North America with exemplary structural integrity and luxurious finishes.
        </p>
    </div>
</section>

<!-- Portfolio Section -->
<section class="section">
    <div class="container">
        <!-- Filter Tabs -->
        <div class="portfolio-filters">
            <button class="filter-btn active" data-filter="all">All (<?= count($projects) ?>)</button>
            <?php foreach ($categories as $cat): ?>
                <button class="filter-btn" data-filter="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Projects Grid -->
        <div class="projects-grid">
            <?php foreach ($projects as $proj): ?>
                <div class="project-card" data-category="<?= htmlspecialchars($proj['category']) ?>">
                    <div class="project-img-box">
                        <img src="<?= htmlspecialchars($proj['image'] ?: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80') ?>" alt="<?= htmlspecialchars($proj['title']) ?>">
                        <span class="project-category-badge"><?= htmlspecialchars($proj['category']) ?></span>
                        <span class="project-status-badge <?= ($proj['status'] === 'In Progress') ? 'style="color:#f59e0b;"' : '' ?>"><?= htmlspecialchars($proj['status']) ?></span>
                    </div>
                    <div class="project-info">
                        <div class="project-meta">
                            <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($proj['location'] ?: 'USA') ?></span>
                            <span>•</span>
                            <span><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($proj['year'] ?: '2026') ?></span>
                            <?php if (!empty($proj['client'])): ?>
                                <span>•</span>
                                <span><i class="fa-solid fa-user-tie"></i> <?= htmlspecialchars($proj['client']) ?></span>
                            <?php endif; ?>
                        </div>
                        <h3 class="project-title"><?= htmlspecialchars($proj['title']) ?></h3>
                        <p class="project-desc"><?= htmlspecialchars($proj['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
