<?php
/**
 * DS Construction - About Us
 */

require_once __DIR__ . '/includes/header.php';

// Fetch team members
$stmt = $pdo->query("SELECT * FROM team ORDER BY id ASC");
$team = $stmt->fetchAll();
?>

<!-- Page Banner -->
<section style="padding: 160px 0 80px; background: var(--bg-surface-elevated); border-bottom: 1px solid var(--border-color); text-align: center;">
    <div class="container">
        <span class="section-subtitle">Heritage & Vision</span>
        <h1 class="section-title" style="margin-bottom: 1rem;">About DS Construction</h1>
        <p class="section-desc" style="max-width: 650px; margin: 0 auto;">
            Building landmarks through generational craftsmanship, certified engineering rigor, and client partnership.
        </p>
    </div>
</section>

<!-- Company Story Section -->
<section class="section">
    <div class="container">
        <div class="about-grid">
            <div>
                <span class="section-subtitle">Our Journey</span>
                <h2 class="section-title">Two Decades of Structural Excellence</h2>
                <p class="section-desc" style="margin-bottom: 1.5rem;">
                    <?= nl2br(htmlspecialchars($settings['about_story'] ?? 'Established with a vision for uncompromising quality, DS Construction has emerged as an industry benchmark.')) ?>
                </p>
                <div style="background: var(--bg-surface-elevated); border-left: 4px solid var(--gold-400); padding: 1.5rem; border-radius: var(--radius-sm); margin: 2rem 0;">
                    <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--gold-400);">Our Mission</h4>
                    <p style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.6;">
                        <?= htmlspecialchars($settings['about_mission'] ?? 'To deliver world-class infrastructure and architectural masterpieces with unyielding structural integrity.') ?>
                    </p>
                </div>
            </div>

            <div class="about-image-stack">
                <img src="https://images.unsplash.com/photo-1541888946425-d0fbb1861563?auto=format&fit=crop&w=1000&q=80" alt="Construction Crane at Sunset" class="about-main-img">
            </div>
        </div>
    </div>
</section>

<!-- Core Values Grid -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Our Principles</span>
            <h2 class="section-title">The DS Construction Gold Standard</h2>
            <p class="section-desc">The non-negotiable principles that drive every blueprint, structural calculation, and job site we manage.</p>
        </div>

        <div class="services-grid">
            <div class="service-card" style="padding: 2.5rem;">
                <div style="font-size: 2.2rem; color: var(--gold-400); margin-bottom: 1rem;"><i class="fa-solid fa-compass-drafting"></i></div>
                <h3 style="font-size: 1.3rem; margin-bottom: 0.8rem;">Architectural Precision</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">We honor the architect's intent with millimeter tolerances, utilizing high-precision laser alignment and building information modeling.</p>
            </div>

            <div class="service-card" style="padding: 2.5rem;">
                <div style="font-size: 2.2rem; color: var(--gold-400); margin-bottom: 1rem;"><i class="fa-solid fa-helmet-safety"></i></div>
                <h3 style="font-size: 1.3rem; margin-bottom: 0.8rem;">Safety First Protocol</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">OSHA certified site managers and zero-compromise safety standards ensure all workforce and community stakeholders remain secure.</p>
            </div>

            <div class="service-card" style="padding: 2.5rem;">
                <div style="font-size: 2.2rem; color: var(--gold-400); margin-bottom: 1rem;"><i class="fa-solid fa-leaf"></i></div>
                <h3 style="font-size: 1.3rem; margin-bottom: 0.8rem;">Sustainable Building</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">LEED-certified practices, energy-efficient thermal envelopes, solar readiness, and sustainable timber & concrete recycling.</p>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Team -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Executive Team</span>
            <h2 class="section-title">Meet Our Senior Leadership</h2>
            <p class="section-desc">Seasoned master builders, licensed civil engineers, and experienced project directors.</p>
        </div>

        <div class="services-grid">
            <?php foreach ($team as $member): ?>
                <div class="service-card" style="text-align: center; padding: 2rem;">
                    <div style="width: 140px; height: 140px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.5rem; border: 3px solid var(--gold-400); box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);">
                        <img src="<?= htmlspecialchars($member['photo'] ?: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80') ?>" alt="<?= htmlspecialchars($member['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h3 style="font-size: 1.3rem; margin-bottom: 0.3rem;"><?= htmlspecialchars($member['name']) ?></h3>
                    <p style="color: var(--gold-400); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;"><?= htmlspecialchars($member['role']) ?></p>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6;"><?= htmlspecialchars($member['bio']) ?></p>
                    <?php if (!empty($member['linkedin'])): ?>
                        <div style="margin-top: 1.25rem;">
                            <a href="<?= htmlspecialchars($member['linkedin']) ?>" target="_blank" class="social-btn" style="margin: 0 auto;"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
