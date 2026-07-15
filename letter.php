<?php
/**
 * letter.php
 * "The Letter I Never Sent" - write an anonymous message.
 */
require_once 'includes/functions.php';

// Only logged-in members can send a letter.
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Letter';
require 'includes/header.php';
?>

<div class="hero-page page-letter">
    <div class="hero-card cozy-fold" style="max-width:640px;">
        <?php if (isset($_GET['sent'])): ?>
            <div class="alert alert-success">Letter sent successfully! 💌</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Please write a message before sending.</div>
        <?php endif; ?>

        <h1>The Letter I Never Sent</h1>

        <p class="desc">
            A page dedicated to anyone who struggles to send a message or letter
            personally. This letter is anonymous, so type below to get something off
            your chest, rant, or spread a little positivity.
        </p>

        <form action="send_letter.php" method="POST" novalidate class="text-start">
            <input type="text" name="to" class="form-control mb-2" placeholder="To:" maxlength="100">
            <input type="text" name="from" class="form-control mb-2" placeholder="From (optional):" maxlength="100">

            <textarea name="message" class="form-control" placeholder="Message..."
                      maxlength="1000" data-maxlength="1000" required></textarea>

            <div class="text-center">
                <button type="submit" name="send" class="btn btn-cozy mt-3">Send</button>
            </div>
        </form>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
