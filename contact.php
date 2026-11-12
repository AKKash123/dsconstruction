<?php
/**
 * DS Construction - Contact Us
 */

require_once __DIR__ . '/includes/header.php';

$selectedService = $_GET['service'] ?? '';
$flash = getFlash();
?>

<!-- Page Banner -->
<section style="padding: 160px 0 80px; background: var(--bg-surface-elevated); border-bottom: 1px solid var(--border-color); text-align: center;">
    <div class="container">
        <span class="section-subtitle">Reach Our Team</span>
        <h1 class="section-title" style="margin-bottom: 1rem;">Contact & Consultation</h1>
        <p class="section-desc" style="max-width: 650px; margin: 0 auto;">
            Our estimation team, project managers, and lead architects are available to discuss your specifications, land plots, and development timelines.
        </p>
    </div>
</section>

<!-- Contact Section with Form -->
<section class="section" id="quote-form">
    <div class="container">
        <div class="contact-grid">
            <!-- Left Info Card -->
            <div class="contact-info-card">
                <span class="section-subtitle">Corporate Headquarters</span>
                <h2 class="section-title" style="font-size: 2.1rem; margin-bottom: 1.25rem;">Let's Connect</h2>
                <p class="section-desc" style="margin-bottom: 2rem;">
                    Whether planning a new commercial development, custom private villa, or seeking specialized structural retrofits, DS Construction delivers gold-standard results.
                </p>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Office Address</h4>
                        <p><?= htmlspecialchars($settings['address'] ?? '742 Park Avenue, New York, NY') ?></p>
                    </div>
                </div>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Direct Line</h4>
                        <p><a href="tel:<?= preg_replace('/[^0-9+]/', '', $settings['phone'] ?? '+18005550199') ?>"><?= htmlspecialchars($settings['phone'] ?? '+1 (800) 555-0199') ?></a></p>
                    </div>
                </div>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Electronic Mail</h4>
                        <p><a href="mailto:<?= htmlspecialchars($settings['email'] ?? 'contact@dsconstruction.com') ?>"><?= htmlspecialchars($settings['email'] ?? 'contact@dsconstruction.com') ?></a></p>
                    </div>
                </div>

                <div class="contact-detail-item">
                    <div class="contact-detail-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="contact-detail-text">
                        <h4>Hours of Operation</h4>
                        <p><?= htmlspecialchars($settings['working_hours'] ?? 'Mon - Sat: 8:00 AM - 7:00 PM') ?></p>
                    </div>
                </div>
            </div>

            <!-- Right Form Card -->
            <div class="contact-form-card">
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.6rem;">Send A Project Proposal Request</h3>
                <p style="color: var(--text-secondary); font-size: 0.92rem; margin-bottom: 1.8rem;">
                    Fill out the form below. Our principal estimation director will follow up with scheduling and details.
                </p>

                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] ?>">
                        <i class="fa-solid <?= ($flash['type'] === 'success') ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i>
                        <span><?= htmlspecialchars($flash['message']) ?></span>
                    </div>
                <?php endif; ?>

                <form action="submit-contact.php" method="POST">
                    <input type="text" name="website_url_hp" style="display:none;" tabindex="-1" autocomplete="off">
                    <input type="hidden" name="redirect" value="contact.php">

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
                                <option value="Commercial Construction" <?= ($selectedService === 'Commercial Construction') ? 'selected' : '' ?>>Commercial Construction</option>
                                <option value="Luxury Residential Estates" <?= ($selectedService === 'Luxury Residential Estates') ? 'selected' : '' ?>>Luxury Residential Estates</option>
                                <option value="Civil Engineering & Structural Design" <?= ($selectedService === 'Civil Engineering & Structural Design') ? 'selected' : '' ?>>Civil Engineering & Structural Design</option>
                                <option value="Renovation & Architectural Remodeling" <?= ($selectedService === 'Renovation & Architectural Remodeling') ? 'selected' : '' ?>>Renovation & Architectural Remodeling</option>
                                <option value="Project Management & Turnkey Contracting" <?= ($selectedService === 'Project Management & Turnkey Contracting') ? 'selected' : '' ?>>Project Management & Turnkey Contracting</option>
                                <option value="Industrial Infrastructure" <?= ($selectedService === 'Industrial Infrastructure') ? 'selected' : '' ?>>Industrial Infrastructure</option>
                                <option value="General Inquiry" <?= (empty($selectedService) || $selectedService === 'General Inquiry') ? 'selected' : '' ?>>Other / General Consultation</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Project Scope & Details *</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Please provide location, estimated dimensions, scope, blueprints or start dates..." required></textarea>
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
