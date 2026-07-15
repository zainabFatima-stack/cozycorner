<?php
/**
 * includes/header.php
 * -------------------------------------------------------
 * Shared <head> + navbar for every page.
 * Before including this file, a page can optionally set:
 *   $pageTitle  -> shown in the browser tab
 *   $bodyClass  -> e.g. 'page-home' to pick a background (see style.css)
 * -------------------------------------------------------
 */
$pageTitle = $pageTitle ?? 'CozyCorner';
$bodyClass = $bodyClass ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> · CozyCorner</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font used across the site -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Site styles (kept in one place now instead of repeated inline <style> blocks) -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Simple cozy favicon (no extra file needed) -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌻</text></svg>">
</head>
<body class="<?= e($bodyClass) ?>">

<nav class="navbar navbar-expand-lg cozy-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">🌻 Cozy<span>Corner</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#cozyNav" aria-controls="cozyNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="cozyNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?= is_active_page('index.php') ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active_page('about.php') ?>" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active_page('baking.php') ?>" href="baking.php">Baking</a></li>
                <li class="nav-item"><a class="nav-link <?= is_active_page('blog.php') ?>" href="blog.php">Blog</a></li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?= is_active_page('cozypicks.php') ?>" href="cozypicks.php">CozyPicks</a></li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto align-items-lg-center">
                <?php if (is_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?= is_active_page('profile.php') ?>" href="profile.php">👤 <?= e(current_username()) ?></a></li>
                    <li class="nav-item"><a class="nav-link btn-nav-outline" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?= is_active_page('login.php') ?>" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn-nav-fill" href="signup.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

