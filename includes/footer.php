<?php
/**
 * DS Construction - Global Footer Include
 */
?>
    <!-- Footer Section -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-top">
                <!-- Col 1: Brand & Bio -->
                <div>
                    <div class="footer-logo-row">
                        <img src="<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>" alt="DS Construction" class="brand-logo-img">
                        <div>
                            <h3 class="brand-name gold-text" style="font-size: 1.25rem;"><?= htmlspecialchars($settings['site_name'] ?? 'DS CONSTRUCTION') ?></h3>
                            <p style="font-size: 0.75rem; color: var(--gold-400); text-transform: uppercase; letter-spacing: 0.1em;">Luxury Engineering & Construction</p>
                        </div>
                    </div>
                    <p class="footer-about-text">
                        <?= htmlspecialchars($settings['about_mission'] ?? 'Delivering world-class infrastructure and architectural masterpieces with unyielding structural integrity and client transparency.') ?>
                    </p>
                    <div class="social-links">
                        <?php if (!empty($settings['facebook_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" class="social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['instagram_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['instagram_url']) ?>" target="_blank" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['linkedin_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['linkedin_url']) ?>" target="_blank" class="social-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['twitter_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['twitter_url']) ?>" target="_blank" class="social-btn" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="footer-col-title">Navigation</h4>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fa-solid fa-angle-right" style="font-size: 0.7rem; margin-right: 5px;"></i> Home</a></li>
                        <li><a href="about.php"><i class="fa-solid fa-angle-right" style="font-size: 0.7rem; margin-right: 5px;"></i> About Company</a></li>
                        <li><a href="services.php"><i class="fa-solid fa-angle-right" style="font-size: 0.7rem; margin-right: 5px;"></i> Core Services</a></li>
                        <li><a href="projects.php"><i class="fa-solid fa-angle-right" style="font-size: 0.7rem; margin-right: 5px;"></i> Portfolio Gallery</a></li>
                        <li><a href="contact.php"><i class="fa-solid fa-angle-right" style="font-size: 0.7rem; margin-right: 5px;"></i> Get A Quote</a></li>
                    </ul>
                </div>

                <!-- Col 3: Services -->
                <div>
                    <h4 class="footer-col-title">Expertise</h4>
                    <ul class="footer-links">
                        <li><a href="services.php">Commercial Builds</a></li>
                        <li><a href="services.php">Luxury Residential</a></li>
                        <li><a href="services.php">Structural Engineering</a></li>
                        <li><a href="services.php">Architectural Remodeling</a></li>
                        <li><a href="services.php">Turnkey Project Mgmt</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Operations -->
                <div>
                    <h4 class="footer-col-title">Headquarters</h4>
                    <ul class="footer-links" style="gap: 1rem;">
                        <li style="display: flex; gap: 10px;">
                            <i class="fa-solid fa-location-dot" style="color: var(--gold-400); margin-top: 5px;"></i>
                            <span><?= htmlspecialchars($settings['address'] ?? '742 Park Avenue, New York, NY') ?></span>
                        </li>
                        <li style="display: flex; gap: 10px;">
                            <i class="fa-solid fa-phone" style="color: var(--gold-400); margin-top: 5px;"></i>
                            <a href="tel:<?= preg_replace('/[^0-9+]/', '', $settings['phone'] ?? '+18005550199') ?>"><?= htmlspecialchars($settings['phone'] ?? '+1 (800) 555-0199') ?></a>
                        </li>
                        <li style="display: flex; gap: 10px;">
                            <i class="fa-solid fa-envelope" style="color: var(--gold-400); margin-top: 5px;"></i>
                            <a href="mailto:<?= htmlspecialchars($settings['email'] ?? 'contact@dsconstruction.com') ?>"><?= htmlspecialchars($settings['email'] ?? 'contact@dsconstruction.com') ?></a>
                        </li>
                        <li style="display: flex; gap: 10px;">
                            <i class="fa-solid fa-clock" style="color: var(--gold-400); margin-top: 5px;"></i>
                            <span><?= htmlspecialchars($settings['working_hours'] ?? 'Mon - Sat: 8:00 AM - 7:00 PM') ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div>
                    &copy; <?= date('Y') ?> <strong><?= htmlspecialchars($settings['site_name'] ?? 'DS Construction') ?></strong>. All rights reserved.
                </div>
                <div>
                    <a href="admin/login.php" style="color: var(--gold-400); margin-right: 1.5rem; font-weight: 600;">
                        <i class="fa-solid fa-lock" style="font-size: 0.8rem;"></i> Admin Panel
                    </a>
                    <span>Crafted for Architectural Excellence</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Frontend Interactive Main Script -->
    <script src="assets/js/main.js"></script>
</body>
</html>
