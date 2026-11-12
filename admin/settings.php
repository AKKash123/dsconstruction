<?php
/**
 * Admin Panel - Global Site Settings
 */

$pageTitle = 'Site & Content Settings';
require_once __DIR__ . '/includes/admin_header.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    // Process text fields
    $fields = [
        'site_name', 'tagline', 'phone', 'email', 'address', 'working_hours',
        'hero_title', 'hero_subtitle', 'hero_cta_text', 'hero_cta_link',
        'stat_experience', 'stat_projects', 'stat_clients', 'stat_awards',
        'about_story', 'about_mission', 'default_theme_mode',
        'facebook_url', 'instagram_url', 'linkedin_url', 'twitter_url'
    ];

    $updateStmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $updateStmt->execute([$field, trim($_POST[$field])]);
        }
    }

    // Process logo upload if submitted
    $uploadedLogo = handleImageUpload('logo_file', 'uploads');
    if ($uploadedLogo) {
        $updateStmt->execute(['logo_path', $uploadedLogo]);
    }

    setFlash('success', 'Site configuration and content updated successfully!');
    header("Location: settings.php");
    exit;
}

// Reload updated settings
$settings = getSettings($pdo);
?>

<form action="settings.php" method="POST" enctype="multipart/form-data">
    <!-- Brand Identity Card -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fa-solid fa-gem" style="color: var(--gold); margin-right: 8px;"></i> Brand Identity & Logo</h3>
        </div>
        <div class="card-body">
            <div class="admin-grid-2">
                <div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Company / Brand Name</label>
                        <input type="text" name="site_name" class="admin-input" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Company Slogan / Tagline</label>
                        <input type="text" name="tagline" class="admin-input" value="<?= htmlspecialchars($settings['tagline'] ?? '') ?>">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Default Theme Behavior for New Visitors</label>
                        <select name="default_theme_mode" class="admin-select">
                            <option value="auto" <?= (($settings['default_theme_mode'] ?? 'auto') === 'auto') ? 'selected' : '' ?>>Auto (Syncs with local sunrise & sunset)</option>
                            <option value="day" <?= (($settings['default_theme_mode'] ?? '') === 'day') ? 'selected' : '' ?>>Day Theme (Clean Architectural White & Gold)</option>
                            <option value="night" <?= (($settings['default_theme_mode'] ?? '') === 'night') ? 'selected' : '' ?>>Night Theme (Dark Luxury Obsidian & Gold)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="admin-form-label">Current Company Logo</label>
                    <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.25rem; background: var(--admin-surface-light); padding: 1.25rem; border-radius: 10px;">
                        <img src="../<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>" alt="Logo Preview" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid var(--gold); object-fit: cover;">
                        <div>
                            <p style="font-weight: 700; color: var(--gold);">DS Construction Emblem</p>
                            <p style="font-size: 0.8rem; color: var(--text-muted);">Active in Navbar, Hero, and Footer.</p>
                        </div>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Upload New Logo (JPG, PNG, WEBP)</label>
                        <input type="file" name="logo_file" class="admin-input" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section Content -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fa-solid fa-bullhorn" style="color: var(--gold); margin-right: 8px;"></i> Homepage Hero Section</h3>
        </div>
        <div class="card-body">
            <div class="admin-form-group">
                <label class="admin-form-label">Hero Headline Title</label>
                <input type="text" name="hero_title" class="admin-input" value="<?= htmlspecialchars($settings['hero_title'] ?? '') ?>" required>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Hero Subtitle & Value Proposition</label>
                <textarea name="hero_subtitle" class="admin-textarea" rows="3"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></textarea>
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Call To Action Button Text</label>
                    <input type="text" name="hero_cta_text" class="admin-input" value="<?= htmlspecialchars($settings['hero_cta_text'] ?? '') ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Call To Action Target Link</label>
                    <input type="text" name="hero_cta_link" class="admin-input" value="<?= htmlspecialchars($settings['hero_cta_link'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Live Statistics Counters -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fa-solid fa-chart-line" style="color: var(--gold); margin-right: 8px;"></i> Live Achievement Counters</h3>
        </div>
        <div class="card-body">
            <div class="admin-grid-2" style="grid-template-columns: repeat(4, 1fr);">
                <div class="admin-form-group">
                    <label class="admin-form-label">Years of Mastery</label>
                    <input type="text" name="stat_experience" class="admin-input" value="<?= htmlspecialchars($settings['stat_experience'] ?? '18+') ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Completed Builds</label>
                    <input type="text" name="stat_projects" class="admin-input" value="<?= htmlspecialchars($settings['stat_projects'] ?? '350+') ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Client Retention (%)</label>
                    <input type="text" name="stat_clients" class="admin-input" value="<?= htmlspecialchars($settings['stat_clients'] ?? '99%') ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Industry Awards</label>
                    <input type="text" name="stat_awards" class="admin-input" value="<?= htmlspecialchars($settings['stat_awards'] ?? '25') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Contact & Operating Information -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fa-solid fa-address-book" style="color: var(--gold); margin-right: 8px;"></i> Corporate Contact & Location</h3>
        </div>
        <div class="card-body">
            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Direct Telephone</label>
                    <input type="text" name="phone" class="admin-input" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Primary Email Address</label>
                    <input type="email" name="email" class="admin-input" value="<?= htmlspecialchars($settings['email'] ?? '') ?>" required>
                </div>
            </div>

            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label">Headquarters Physical Address</label>
                    <input type="text" name="address" class="admin-input" value="<?= htmlspecialchars($settings['address'] ?? '') ?>" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Operating Hours</label>
                    <input type="text" name="working_hours" class="admin-input" value="<?= htmlspecialchars($settings['working_hours'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- About Story & Mission -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fa-solid fa-book-open" style="color: var(--gold); margin-right: 8px;"></i> Company Story & Mission</h3>
        </div>
        <div class="card-body">
            <div class="admin-form-group">
                <label class="admin-form-label">Company History & Heritage Story</label>
                <textarea name="about_story" class="admin-textarea" rows="4"><?= htmlspecialchars($settings['about_story'] ?? '') ?></textarea>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Core Mission Statement</label>
                <textarea name="about_mission" class="admin-textarea" rows="2"><?= htmlspecialchars($settings['about_mission'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Social Media Links -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fa-solid fa-share-nodes" style="color: var(--gold); margin-right: 8px;"></i> Social Network Profiles</h3>
        </div>
        <div class="card-body">
            <div class="admin-grid-2">
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fa-brands fa-facebook-f"></i> Facebook URL</label>
                    <input type="url" name="facebook_url" class="admin-input" value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fa-brands fa-instagram"></i> Instagram URL</label>
                    <input type="url" name="instagram_url" class="admin-input" value="<?= htmlspecialchars($settings['instagram_url'] ?? '') ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fa-brands fa-linkedin-in"></i> LinkedIn URL</label>
                    <input type="url" name="linkedin_url" class="admin-input" value="<?= htmlspecialchars($settings['linkedin_url'] ?? '') ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fa-brands fa-x-twitter"></i> Twitter/X URL</label>
                    <input type="url" name="twitter_url" class="admin-input" value="<?= htmlspecialchars($settings['twitter_url'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3rem;">
        <button type="submit" class="btn-admin btn-admin-gold" style="padding: 1rem 2rem; font-size: 1rem;">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Save All Configuration Changes</span>
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
