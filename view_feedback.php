<?php
/**
 * view_feedback.php
 * Fixed: the old version printed raw lines from a public text
 * file straight into the page (XSS hole) and showed every
 * visitor's full email address to the whole world. Output is
 * now escaped and emails are partially masked for privacy.
 */
require_once 'includes/functions.php';

$result = $conn->query('SELECT * FROM feedback ORDER BY id DESC LIMIT 50');

// Turns "zainab@example.com" into "za***@example.com" for display.
function mask_email(string $email): string
{
    $parts = explode('@', $email);
    if (count($parts) !== 2) return $email;
    $name = $parts[0];
    $masked = substr($name, 0, 2) . str_repeat('*', max(1, strlen($name) - 2));
    return $masked . '@' . $parts[1];
}

$pageTitle = 'View Feedback';
require 'includes/header.php';
?>

<div class="container" style="padding-top:120px; padding-bottom:50px; max-width:760px;">
    <h1 class="text-center mb-5">All Feedback</h1>

    <?php if (isset($_GET['submitted'])): ?>
        <div class="alert alert-success text-center">Thank you for your feedback! 💕</div>
    <?php endif; ?>

    <?php if ($result->num_rows === 0): ?>
        <p class="text-center">No feedback yet. <a href="feedback.php">Be the first to share yours!</a></p>
    <?php else: ?>
        <div class="stagger">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="fb-card">
                    <div class="d-flex justify-content-between flex-wrap">
                        <span class="fb-name"><?= e($row['name']) ?> · <?= e(mask_email($row['email'])) ?></span>
                        <span class="fb-date"><?= e(date('d M Y', strtotime($row['created_at']))) ?></span>
                    </div>
                    <p class="mb-0 mt-2"><?= nl2br(e($row['message'])) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php require 'includes/footer.php'; ?>
