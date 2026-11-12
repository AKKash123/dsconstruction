<?php
/**
 * DS Construction - Homepage
 */

require_once __DIR__ . '/includes/header.php';

// Fetch active services
$servicesStmt = $pdo->query("SELECT * FROM services ORDER BY order_num ASC LIMIT 6");
$services = $servicesStmt->fetchAll();

// Fetch featured projects
$projectsStmt = $pdo->query("SELECT * FROM projects ORDER BY featured DESC, id DESC LIMIT 6");
$projects = $projectsStmt->fetchAll();

// Fetch testimonials
$testimonialsStmt = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC LIMIT 3");
$testimonials = $testimonialsStmt->fetchAll();

$flash = getFlash();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-background-art"></div>
    <div class="hero-backdrop-filter"></div>

    <div class="container hero-content">
        <div class="hero-badge">
            <i class="fa-solid fa-gem"></i>
            <span>Premier Engineering & Luxury Builders</span>
        </div>

        <h1 class="hero-title">
            <?= htmlspecialchars($settings['hero_title'] ?? 'Building Landmarks with Gold Standard Precision') ?>
        </h1>

        <p class="hero-subtitle">
            <?= htmlspecialchars($settings['hero_subtitle'] ?? 'From luxury residential estates to state-of-the-art commercial developments, DS Construction delivers engineering excellence.') ?>
        </p>

        <div class="hero-cta-group">
            <a href="projects.php" class="btn btn-gold">
                <i class="fa-solid fa-city"></i>
                <span><?= htmlspecialchars($settings['hero_cta_text'] ?? 'Explore Our Projects') ?></span>
            </a>
            <a href="contact.php" class="btn btn-outline">
                <i class="fa-solid fa-compass-drafting"></i>
                <span>Request Project Consultation</span>
            </a>
        </div>

        <!-- Live Statistics Counter Grid -->
        <div class="hero-stats-grid">
            <div class="stat-item">
                <div class="stat-number counter-val" data-target="<?= htmlspecialchars($settings['stat_experience'] ?? '18+') ?>">
                    <?= htmlspecialchars($settings['stat_experience'] ?? '18+') ?>
                </div>
                <div class="stat-label">Years of Mastery</div>
            </div>
            <div class="stat-item">
                <div class="stat-number counter-val" data-target="<?= htmlspecialchars($settings['stat_projects'] ?? '350+') ?>">
                    <?= htmlspecialchars($settings['stat_projects'] ?? '350+') ?>
                </div>
                <div class="stat-label">Completed Builds</div>
            </div>
            <div class="stat-item">
                <div class="stat-number counter-val" data-target="<?= htmlspecialchars($settings['stat_clients'] ?? '99%') ?>">
                    <?= htmlspecialchars($settings['stat_clients'] ?? '99%') ?>
                </div>
                <div class="stat-label">Client Retention</div>
            </div>
            <div class="stat-item">
                <div class="stat-number counter-val" data-target="<?= htmlspecialchars($settings['stat_awards'] ?? '25') ?>">
                    <?= htmlspecialchars($settings['stat_awards'] ?? '25') ?>
                </div>
                <div class="stat-label">Industry Awards</div>
            </div>
        </div>
    </div>
</section>

<!-- Core Services Section -->
<section class="section section-alt" id="services">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">What We Build</span>
            <h2 class="section-title">Specialized Construction & Structural Services</h2>
            <p class="section-desc">Comprehensive solutions crafted for commercial developers, luxury homeowners, and industrial operators demanding uncompromising engineering caliber.</p>
        </div>

        <div class="services-grid">
            <?php foreach ($services as $srv): ?>
                <div class="service-card">
                    <div class="service-image-wrap">
                        <img src="<?= htmlspecialchars($srv['image'] ?: 'https://images.unsplash.com/photo-1541888946425-d0fbb1861563?auto=format&fit=crop&w=800&q=80') ?>" alt="<?= htmlspecialchars($srv['title']) ?>">
                        <div class="service-icon-floating">
                            <i class="fa-solid <?= htmlspecialchars($srv['icon'] ?: 'fa-building') ?>"></i>
                        </div>
                    </div>
                    <div class="service-body">
                        <h3 class="service-title"><?= htmlspecialchars($srv['title']) ?></h3>
                        <p class="service-desc"><?= htmlspecialchars($srv['short_desc']) ?></p>
                        <a href="services.php#service-<?= $srv['id'] ?>" class="service-link">
                            <span>Learn Details & Specifications</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- About DS Construction / Why Us Section -->
<section class="section" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image-stack">
                <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1000&q=80" alt="DS Construction Onsite Engineers" class="about-main-img">
                <div class="about-badge-card">
                    <div class="about-badge-icon">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div class="about-badge-text">
                        <h4><?= htmlspecialchars($settings['stat_experience'] ?? '18+') ?> Years</h4>
                        <p>Certified Gold Standards</p>
                    </div>
                </div>
            </div>

            <div class="about-content">
                <span class="section-subtitle">Why Partner With Us</span>
                <h2 class="section-title">Architectural Precision Meets Turnkey Mastery</h2>
                <p class="section-desc">
                    <?= htmlspecialchars($settings['about_story'] ?? 'With nearly two decades of precision engineering, DS Construction is a leading luxury builder.') ?>
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="feature-item-content">
                            <h4>Rigorous Structural & Seismic Engineering</h4>
                            <p>Every foundation and framing structure is mathematically validated to exceed local codes and earthquake resilience.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div class="feature-item-content">
                            <h4>On-Time Delivery & Transparent Costing</h4>
                            <p>Guaranteed project milestones backed by real-time client status tracking, zero hidden markups, and dedicated PMs.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-cubes-stacked"></i>
                        </div>
                        <div class="feature-item-content">
                            <h4>Premium Grade Materials & Finishes</h4>
                            <p>Direct supply contracts with premium quarry stone, structural steel fabricators, and master joinery artisans.</p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <a href="about.php" class="btn btn-gold">
                        <i class="fa-solid fa-users"></i>
                        <span>Meet Our Leadership Team</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio / Projects Showcase Section -->
<section class="section section-alt" id="projects">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Flagship Portfolio</span>
            <h2 class="section-title">Signature Developments & Landmark Structures</h2>
            <p class="section-desc">Explore our handpicked archive of award-winning developments across residential, commercial, and heavy infrastructure.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="portfolio-filters">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <button class="filter-btn" data-filter="Commercial">Commercial</button>
            <button class="filter-btn" data-filter="Luxury Residential">Luxury Residential</button>
            <button class="filter-btn" data-filter="Renovation">Renovation</button>
            <button class="filter-btn" data-filter="Infrastructure">Infrastructure</button>
        </div>

        <div class="projects-grid">
            <?php foreach ($projects as $proj): ?>
                <div class="project-card" data-category="<?= htmlspecialchars($proj['category']) ?>">
                    <div class="project-img-box">
                        <img src="<?= htmlspecialchars($proj['image'] ?: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80') ?>" alt="<?= htmlspecialchars($proj['title']) ?>">
                        <span class="project-category-badge"><?= htmlspecialchars($proj['category']) ?></span>
                        <span class="project-status-badge"><?= htmlspecialchars($proj['status']) ?></span>
                    </div>
                    <div class="project-info">
                        <div class="project-meta">
                            <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($proj['location']) ?></span>
                            <span>•</span>
                            <span><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($proj['year']) ?></span>
                        </div>
                        <h3 class="project-title"><?= htmlspecialchars($proj['title']) ?></h3>
                        <p class="project-desc"><?= htmlspecialchars($proj['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="projects.php" class="btn btn-outline">
                <span>View Full Portfolio Gallery</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Client Accolades</span>
            <h2 class="section-title">What Project Stakeholders Say</h2>
            <p class="section-desc">Our long-term partnerships with developers, architects, and estate owners speak to our commitment to excellence.</p>
        </div>

        <div class="testimonials-grid">
            <?php foreach ($testimonials as $t): ?>
                <div class="testimonial-card">
                    <div class="rating-stars">
                        <?php for ($i = 0; $i < (int)$t['rating']; $i++): ?>
                            <i class="fa-solid fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="testimonial-content">"<?= htmlspecialchars($t['content']) ?>"</p>
                    <div class="testimonial-author">
                        <img src="<?= htmlspecialchars($t['avatar'] ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80') ?>" alt="<?= htmlspecialchars($t['client_name']) ?>" class="author-avatar">
                        <div>
                            <h4 class="author-name"><?= htmlspecialchars($t['client_name']) ?></h4>
                            <p class="author-role"><?= htmlspecialchars($t['client_role']) ?> &bull; <?= htmlspecialchars($t['company']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Consultation / Free Quote Section -->
<section class="section section-alt" id="quote-form">
    <div class="container">
        <div class="contact-grid">
            <!-- Left Info Card -->
            <div class="contact-info-card">
                <span class="section-subtitle">Connect With DS Construction</span>
                <h2 class="section-title" style="font-size: 2.1rem; margin-bottom: 1.25rem;">Let's Build Something Exceptional Together</h2>
                <p class="section-desc" style="margin-bottom: 2rem;">
                    Have an upcoming commercial development, custom home, or major structural remodel? Contact our lead estimators and structural advisors today for a detailed consultation.
                </p>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Main Office Headquarters</h4>
                        <p><?= htmlspecialchars($settings['address'] ?? '742 Park Avenue, New York, NY') ?></p>
                    </div>
                </div>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Direct Telephone</h4>
                        <p><a href="tel:<?= preg_replace('/[^0-9+]/', '', $settings['phone'] ?? '+18005550199') ?>"><?= htmlspecialchars($settings['phone'] ?? '+1 (800) 555-0199') ?></a></p>
                    </div>
                </div>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Estimations & Inquiries</h4>
                        <p><a href="mailto:<?= htmlspecialchars($settings['email'] ?? 'contact@dsconstruction.com') ?>"><?= htmlspecialchars($settings['email'] ?? 'contact@dsconstruction.com') ?></a></p>
                    </div>
                </div>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Operating Hours</h4>
                        <p><?= htmlspecialchars($settings['working_hours'] ?? 'Mon - Sat: 8:00 AM - 7:00 PM') ?></p>
                    </div>
                </div>
            </div>

            <!-- Right Form Card -->
            <div class="contact-form-card">
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.6rem;">Request A Project Proposal</h3>
                <p style="color: var(--text-secondary); font-size: 0.92rem; margin-bottom: 1.8rem;">
                    Submit your blueprints, project scopes, or project ideas for a comprehensive engineering estimation.
                </p>

                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] ?>">
                        <i class="fa-solid <?= ($flash['type'] === 'success') ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i>
                        <span><?= htmlspecialchars($flash['message']) ?></span>
                    </div>
                <?php endif; ?>

                <form action="submit-contact.php" method="POST">
                    <!-- Honeypot -->
                    <input type="text" name="website_url_hp" style="display:none;" tabindex="-1" autocomplete="off">
                    <input type="hidden" name="redirect" value="index.php">

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Johnathan Clark" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" placeholder="e.g. jclark@company.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Service Required</label>
                            <select name="service" class="form-control">
                                <option value="Commercial Construction">Commercial Construction</option>
                                <option value="Luxury Residential Estates">Luxury Residential Estates</option>
                                <option value="Civil Engineering & Structural Design">Civil Engineering & Structural Design</option>
                                <option value="Renovation & Architectural Remodeling">Renovation & Architectural Remodeling</option>
                                <option value="Project Management & Turnkey Contracting">Project Management & Turnkey Contracting</option>
                                <option value="Industrial Infrastructure">Industrial Infrastructure</option>
                                <option value="General Inquiry">Other / Consultation</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Project Scope & Details *</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Briefly describe your site location, estimated square footage, target timeline, or special engineering requirements..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-gold" style="width: 100%;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Submit Project Proposal Request</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
