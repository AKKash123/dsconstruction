<?php
/**
 * Admin Panel Header
 */

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/helpers.php';

requireAdminLogin();

$settings = getSettings($pdo);
$currentPage = basename($_SERVER['PHP_SELF']);

// Count unread messages
$unreadStmt = $pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'unread'");
$unreadCount = (int)$unreadStmt->fetchColumn();

$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | <?= htmlspecialchars($settings['site_name'] ?? 'DS Construction') ?></title>
    
    <link rel="icon" type="image/jpeg" href="../<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <img src="../<?= htmlspecialchars($settings['logo_path'] ?? 'assets/images/logo.jpg') ?>" alt="Logo" class="sidebar-logo">
                <span class="sidebar-brand-name">DS ADMIN</span>
            </div>

            <nav class="sidebar-nav">
                <span class="nav-category">Main Overview</span>
                <a href="index.php" class="nav-item <?= ($currentPage === 'index.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard</span>
                </a>

                <span class="nav-category">Content Control</span>
                <a href="settings.php" class="nav-item <?= ($currentPage === 'settings.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Site & Hero Settings</span>
                </a>
                <a href="services.php" class="nav-item <?= (strpos($currentPage, 'service') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-trowel-bricks"></i>
                    <span>Services</span>
                </a>
                <a href="projects.php" class="nav-item <?= (strpos($currentPage, 'project') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-city"></i>
                    <span>Portfolio Projects</span>
                </a>
                <a href="testimonials.php" class="nav-item <?= (strpos($currentPage, 'testimonial') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-comments"></i>
                    <span>Testimonials</span>
                </a>
                <a href="team.php" class="nav-item <?= (strpos($currentPage, 'team') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-users-gear"></i>
                    <span>Team Members</span>
                </a>

                <span class="nav-category">Communications</span>
                <a href="messages.php" class="nav-item <?= ($currentPage === 'messages.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-inbox"></i>
                    <span>Quote Requests</span>
                    <?php if ($unreadCount > 0): ?>
                        <span class="badge-pill"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </a>

                <span class="nav-category">Security</span>
                <a href="profile.php" class="nav-item <?= ($currentPage === 'profile.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Admin Credentials</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="../index.php" target="_blank" class="nav-item" style="color: var(--gold);">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>View Live Site</span>
                </a>
                <a href="logout.php" class="nav-item" style="color: #ef4444; margin-top: 5px;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <button type="button" id="sidebarToggle" class="btn-admin btn-admin-secondary btn-icon-sm" style="display: none;">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="page-title"><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h1>
                </div>

                <div class="topbar-right">
                    <a href="../index.php" target="_blank" class="btn-admin btn-admin-secondary btn-icon-sm">
                        <i class="fa-solid fa-globe"></i>
                        <span>Preview Website</span>
                    </a>
                    <div class="admin-user-pill">
                        <i class="fa-solid fa-circle-user" style="color: var(--gold); font-size: 1.1rem;"></i>
                        <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Administrator') ?></span>
                    </div>
                </div>
            </header>

            <!-- Content Area Body -->
            <div class="admin-content">
                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] ?>" style="margin-bottom: 2rem;">
                        <i class="fa-solid <?= ($flash['type'] === 'success') ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i>
                        <span><?= htmlspecialchars($flash['message']) ?></span>
                    </div>
                <?php endif; ?>
