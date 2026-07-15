<?php
/**
 * profile.php
 */
require_once 'includes/functions.php';

// Only logged-in members can see this page.
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    // Account was deleted but the session is stale - log them out cleanly.
    header('Location: logout.php');
    exit();
}

$pageTitle = 'My Profile';
require 'includes/header.php';
?>

<div class="page-wrap d-flex align-items-center" style="padding-top:110px; padding-bottom:50px;">
    <div class="container">
        <div class="cozy-card profile-card animate-pop">
            <div class="avatar-circle">👤</div>
            <h2><?= e($user['username']) ?></h2>
            <p><b>Email:</b> <?= e($user['email']) ?></p>
            <p><b>Member since:</b> <?= e(date('d M Y', strtotime($user['created_at']))) ?></p>

            <div class="d-flex justify-content-center gap-2 mt-3">
                <a href="cozypicks.php" class="btn btn-cozy">Back to Dashboard</a>
                <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
