<?php
/**
 * DS Construction - Services Page
 */

require_once __DIR__ . '/includes/header.php';

// Fetch all services
$stmt = $pdo->query("SELECT * FROM services ORDER BY order_num ASC");
$services = $stmt->fetchAll();
?>

<!-- Page Banner -->
<section style="padding: 160px 0 80px; background: var(--bg-surface-elevated); border-bottom: 1px solid var(--border-color); text-align: center;">
    <div class="container">
        <span class="section-subtitle">Our Capabilities</span>
        <h1 class="section-title" style="margin-bottom: 1rem;">Comprehensive Construction Services</h1>
        <p class="section-desc" style="max-width: 650px; margin: 0 auto;">
            From seismic foundation design to luxury finishes, explore our full spectrum of architectural and civil engineering capabilities.
        </p>
    </div>
</section>

<!-- Services Detail List -->
<section class="section">
    <div class="container">
        <div style="display: flex; flex-direction: column; gap: 4rem;">
            <?php foreach ($services as $index => $s): 
                $isEven = ($index % 2 === 1);
            ?>
                <div id="service-<?= $s['id'] ?>" class="service-detail-row" style="display: grid; grid-template-columns: <?= $isEven ? '1.2fr 1fr' : '1fr 1.2fr' ?>; gap: 3.5rem; align-items: center; background: var(--bg-surface); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <?php if (!$isEven): ?>
                        <div style="border-radius: var(--radius-md); overflow: hidden; height: 360px;">
                            <img src="<?= htmlspecialchars($s['image'] ?: 'https://images.unsplash.com/photo-1541888946425-d0fbb1861563?auto=format&fit=crop&w=800&q=80') ?>" alt="<?= htmlspecialchars($s['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php endif; ?>

                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 10px; color: var(--gold-400); font-size: 1.4rem; margin-bottom: 1rem;">
                            <i class="fa-solid <?= htmlspecialchars($s['icon'] ?: 'fa-building') ?>"></i>
                            <span style="font-size: 0.85rem; font-family: var(--font-body); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-400);">Division 0<?= $index + 1 ?></span>
                        </div>
                        <h2 style="font-size: 2rem; margin-bottom: 1.25rem; font-weight: 700;"><?= htmlspecialchars($s['title']) ?></h2>
                        <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.7; margin-bottom: 1.5rem;">
                            <?= htmlspecialchars($s['full_desc'] ?: $s['short_desc']) ?>
                        </p>
                        
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <a href="contact.php?service=<?= urlencode($s['title']) ?>#quote-form" class="btn btn-gold btn-sm">
                                <i class="fa-solid fa-calculator"></i>
                                <span>Inquire About This Service</span>
                            </a>
                            <a href="projects.php" class="btn btn-outline btn-sm">
                                <span>See Relevant Projects</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <?php if ($isEven): ?>
                        <div style="border-radius: var(--radius-md); overflow: hidden; height: 360px;">
                            <img src="<?= htmlspecialchars($s['image'] ?: 'https://images.unsplash.com/photo-1541888946425-d0fbb1861563?auto=format&fit=crop&w=800&q=80') ?>" alt="<?= htmlspecialchars($s['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Call to action block -->
<section class="section section-alt" style="text-align: center;">
    <div class="container" style="max-width: 800px;">
        <h2 class="section-title">Need a Custom Engineering or Construction Solution?</h2>
        <p class="section-desc" style="margin-bottom: 2rem;">Our technical advisors can review your blueprints and site specifications to provide precise cost estimates and timelines.</p>
        <a href="contact.php" class="btn btn-gold">
            <i class="fa-solid fa-phone-volume"></i>
            <span>Speak With A Senior Engineer</span>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
