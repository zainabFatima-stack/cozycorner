<?php
/**
 * cozypicks.php
 * The members-only dashboard. The original version had no
 * login check at all - anyone could open it directly.
 */
require_once 'includes/functions.php';

// Only logged-in members can see this page.
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// A couple of small, friendly stats for the welcome banner.
$stmt = $conn->prepare('SELECT COUNT(*) AS c FROM blogs WHERE author = ?');
$stmt->bind_param('s', $_SESSION['user']);
$stmt->execute();
$blogCount = $stmt->get_result()->fetch_assoc()['c'];
$stmt->close();

$letterCount = $conn->query('SELECT COUNT(*) AS c FROM letters')->fetch_assoc()['c'];

$pageTitle = 'CozyPicks';
require 'includes/header.php';

$tiles = [
    ['href' => 'letter.php',        'emoji' => '📩', 'title' => 'Send Letter',   'desc' => 'Write a beautiful message and send it to someone special, simply.'],
    ['href' => 'view_letters.php',  'emoji' => '📬', 'title' => 'View Letters',  'desc' => 'Read every letter on the wall and reply to one that speaks to you.'],
    ['href' => 'baking.php',        'emoji' => '🎂', 'title' => 'Baking',        'desc' => 'Discover cozy baking ideas and sweet treats to brighten your day.'],
    ['href' => 'blog.php',          'emoji' => '✉️', 'title' => 'Blogging',      'desc' => 'Share your thoughts and read cozy stories from other members.'],
    ['href' => 'feedback.php',      'emoji' => '📝', 'title' => 'Feedback',      'desc' => 'Share your thoughts and help us improve your experience.'],
    ['href' => 'view_feedback.php', 'emoji' => '💬', 'title' => 'View Feedback', 'desc' => 'See what other visitors have shared with the CozyCorner team.'],
    ['href' => 'profile.php',       'emoji' => '👤', 'title' => 'Profile',      'desc' => 'View and manage your personal account information.'],
];
?>

<div class="page-wrap" style="padding-top:120px;">
    <div class="container">
        <h1 class="text-center mb-2">✨ CozyPicks Dashboard</h1>
        <p class="text-center mb-5">
            Welcome back, <strong><?= e(current_username()) ?></strong>! You've published
            <strong><?= (int) $blogCount ?></strong> blog<?= $blogCount == 1 ? '' : 's' ?>,
            and the community wall now has <strong><?= (int) $letterCount ?></strong> letters. 💌
        </p>

        <div class="row g-4 stagger">
            <?php foreach ($tiles as $t): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="<?= e($t['href']) ?>" class="dash-tile cozy-fold">
                        <h2><?= $t['emoji'] ?> <?= e($t['title']) ?></h2>
                        <p><?= e($t['desc']) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
