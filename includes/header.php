<?php
/**
 * DS Construction - Global Header Include
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';

$settings = getSettings($pdo);
$themeData = resolveCurrentTheme($settings);

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" class="<?= $themeData['class'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_name'] ?? 'DS Construction') ?> | <?= htmlspecialchars($settings['tagline'] ?? 'Building Excellence') ?></title>
    
    <!-- Meta Descriptions -->
    <meta name="description" content="<?= htmlspecialchars(substr($settings['about_story'] ?? 'DS Construction luxury architectural builders', 0, 160)) ?>">

    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/jpeg" href="<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom Main Stylesheet with Day/Night Themes -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?= $themeData['class'] ?>">

    <!-- Main Navigation Bar -->
    <nav class="site-navbar">
        <div class="container">
            <div class="nav-inner">
                <!-- Brand / Logo -->
                <a href="index.php" class="brand-wrapper">
                    <img src="<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>" alt="DS Construction Emblem" class="brand-logo-img">
                    <div class="brand-text">
                        <span class="brand-name gold-text"><?= htmlspecialchars($settings['site_name'] ?? 'DS CONSTRUCTION') ?></span>
                        <span class="brand-tagline">Architectural & Builders</span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <ul class="nav-links">
                    <li><a href="index.php" class="nav-link <?= ($currentPage === 'index.php') ? 'active' : '' ?>">Home</a></li>
                    <li><a href="about.php" class="nav-link <?= ($currentPage === 'about.php') ? 'active' : '' ?>">About Us</a></li>
                    <li><a href="services.php" class="nav-link <?= ($currentPage === 'services.php') ? 'active' : '' ?>">Services</a></li>
                    <li><a href="projects.php" class="nav-link <?= ($currentPage === 'projects.php') ? 'active' : '' ?>">Projects</a></li>
                    <li><a href="contact.php" class="nav-link <?= ($currentPage === 'contact.php') ? 'active' : '' ?>">Contact</a></li>
                </ul>

                <!-- Nav Action Group: Day/Night Switcher & CTA -->
                <div class="nav-actions">
                    <!-- Day / Night Theme Controller -->
                    <div class="theme-switch-container" title="Day & Night Theme Switcher">
                        <button type="button" class="theme-btn" data-theme-btn="day" title="Switch to Day Theme">
                            <i class="fa-solid fa-sun" style="color: #f59e0b;"></i>
                            <span>Day</span>
                        </button>
                        <button type="button" class="theme-btn" data-theme-btn="night" title="Switch to Night Theme">
                            <i class="fa-solid fa-moon" style="color: #d4af37;"></i>
                            <span>Night</span>
                        </button>
                        <button type="button" class="theme-btn" data-theme-btn="auto" title="Automatic Day/Night Solar Sync">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            <span>Auto</span>
                        </button>
                    </div>

                    <!-- Get Quote CTA -->
                    <a href="contact.php" class="btn btn-gold btn-sm d-none-mobile">
                        <i class="fa-solid fa-phone"></i>
                        <span>Get Quote</span>
                    </a>

                    <!-- Mobile Hamburger -->
                    <button class="mobile-nav-toggle" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
