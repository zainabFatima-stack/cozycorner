<?php
require_once 'includes/functions.php';
$pageTitle = 'Home';
require 'includes/header.php';
?>

<div class="hero-page page-home">
    <div class="hero-card cozy-fold">
        <?php if (isset($_GET['loggedout'])): ?>
            <div class="alert alert-success">You have been logged out. See you soon! 🌻</div>
        <?php endif; ?>

        <h1>Welcome to CozyCorner 🌻</h1>
        <p>
            Your little corner of comfort, calm, and creativity.
            Explore cozy aesthetics, peaceful vibes, and inspiring ideas that make
            everyday life feel warm and beautiful. Relax, unwind, and feel at home.
        </p>

        <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
            <?php if (is_logged_in()): ?>
                <a href="cozypicks.php" class="btn btn-cozy-outline">Go to CozyPicks</a>
            <?php else: ?>
                <a href="signup.php" class="btn btn-cozy-outline">Join CozyCorner</a>
            <?php endif; ?>
            <a href="blog.php" class="btn btn-cozy">Read the Blog</a>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
