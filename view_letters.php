<?php
/**
 * view_letters.php
 * Shows every letter on the community wall, and lets a
 * logged-in member write a reply (the old version had a
 * reply box in the design but no working form at all).
 */
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$result = $conn->query('SELECT * FROM letters ORDER BY id DESC');

$pageTitle = 'My Letters';
require 'includes/header.php';
?>

<div class="page-wrap" style="padding-top:120px; padding-bottom:40px;">
    <div class="container">
        <h2 class="text-center mb-5">My Letters</h2>

        <?php if (isset($_GET['replied'])): ?>
            <div class="alert alert-success">Your reply was posted. 💕</div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'already'): ?>
            <div class="alert alert-danger">That letter already has a reply.</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Please write a reply before posting.</div>
        <?php endif; ?>

        <div class="row g-4 stagger">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-12 col-md-6">
                        <div class="letter-card">
                            <h3>To: <?= e($row['to_user']) ?></h3>
                            <p><b>From:</b> <?= e($row['from_user']) ?></p>
                            <p><?= nl2br(e($row['message'])) ?></p>

                            <?php if (!empty($row['reply'])): ?>
                                <div class="reply-box">
                                    <h4>Reply:</h4>
                                    <p class="mb-1"><?= nl2br(e($row['reply'])) ?></p>
                                    <small>Replied by: <?= e($row['reply_from']) ?></small>
                                </div>
                            <?php else: ?>
                                <form action="reply_letter.php" method="POST" class="reply-box">
                                    <input type="hidden" name="letter_id" value="<?= (int) $row['id'] ?>">
                                    <h4 class="mb-2">Write a reply</h4>
                                    <textarea name="reply" class="form-control mb-2" rows="3"
                                              maxlength="500" placeholder="Say something kind..." required></textarea>
                                    <button type="submit" class="btn btn-cozy btn-sm">Post Reply</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No letters found yet. <a href="letter.php">Write the first one</a> 💌</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
