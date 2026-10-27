<?php
require_once __DIR__ . '/auth.php';
AdminAuth::requireLogin();
$currentUser = AdminAuth::user();
$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'CMS Dashboard'); ?> | Smart Choice CMS</title>
    <link rel="icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
</head>
<body>

<div class="cms-app">
    <!-- Sidebar -->
    <aside class="cms-sidebar">
        <div class="cms-brand">
            <div class="cms-brand-logo">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <div class="cms-brand-text">
                <h1>Smart Choice</h1>
                <span>CMS Admin Panel</span>
            </div>
        </div>

        <nav class="cms-nav">
            <div class="cms-nav-group-title">Main</div>
            <a href="index.php" class="cms-nav-link <?php echo ($currentScript === 'index.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
            <a href="pages.php" class="cms-nav-link <?php echo ($currentScript === 'pages.php') ? 'active' : ''; ?>">
                <i class="fa-regular fa-file-lines"></i>
                <span>Page Editor & Preview</span>
            </a>
            <a href="media.php" class="cms-nav-link <?php echo ($currentScript === 'media.php') ? 'active' : ''; ?>">
                <i class="fa-regular fa-images"></i>
                <span>Media Manager</span>
            </a>

            <div class="cms-nav-group-title">Design & Structure</div>
            <a href="design.php" class="cms-nav-link <?php echo ($currentScript === 'design.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-palette"></i>
                <span>Theme & Styling</span>
            </a>
            <a href="navigation.php" class="cms-nav-link <?php echo ($currentScript === 'navigation.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-bars"></i>
                <span>Header & Footer</span>
            </a>

            <div class="cms-nav-group-title">Content & Operations</div>
            <a href="blog.php" class="cms-nav-link <?php echo ($currentScript === 'blog.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-newspaper"></i>
                <span>Blog Articles</span>
            </a>
            <a href="faqs.php" class="cms-nav-link <?php echo ($currentScript === 'faqs.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-circle-question"></i>
                <span>FAQ Accordions</span>
            </a>
            <a href="forms.php" class="cms-nav-link <?php echo ($currentScript === 'forms.php') ? 'active' : ''; ?>">
                <i class="fa-regular fa-envelope"></i>
                <span>Leads & Inquiries</span>
            </a>
            <a href="backup.php" class="cms-nav-link <?php echo ($currentScript === 'backup.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-cloud-arrow-down"></i>
                <span>Backup & Snapshots</span>
            </a>
        </nav>

        <div class="cms-sidebar-footer">
            <div class="cms-user-info">
                <div class="cms-avatar">
                    <?php echo strtoupper(substr($currentUser['username'] ?? 'A', 0, 1)); ?>
                </div>
                <div class="cms-user-meta">
                    <div class="cms-user-name"><?php echo htmlspecialchars($currentUser['name'] ?? 'Admin'); ?></div>
                    <div class="cms-user-role"><?php echo htmlspecialchars($currentUser['role'] ?? 'Super Admin'); ?></div>
                </div>
            </div>
            <a href="logout.php" title="Sign Out" style="color: var(--text-muted); font-size: 15px;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Workspace -->
    <main class="cms-main">
        <header class="cms-topbar">
            <div class="cms-breadcrumb">
                <a href="index.php"><i class="fa-solid fa-house"></i></a>
                <i class="fa-solid fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i>
                <span class="active"><?php echo htmlspecialchars($breadcrumb ?? 'Dashboard'); ?></span>
            </div>

            <div class="cms-topbar-actions">
                <a href="../" target="_blank" class="cms-btn cms-btn-outline cms-btn-sm" title="Open live production website in new tab">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Live Website</span>
                </a>
                <a href="pages.php?page=home" class="cms-btn cms-btn-primary cms-btn-sm">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>Live Edit Home</span>
                </a>
            </div>
        </header>
