<?php
require_once 'includes/functions.php';

$old = ['name' => '', 'email' => '', 'feedback' => ''];

$pageTitle = 'Feedback';
require 'includes/header.php';
?>

<div class="hero-page page-form">
    <div class="cozy-card mx-auto animate-pop" style="max-width:480px; width:100%;">
        <h3 class="text-center mb-4" style="color:var(--cozy-mauve-deep);">Feedback Form</h3>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2">Please fill in every field with a valid name, email, and message.</div>
        <?php endif; ?>

        <form action="save_feedback.php" method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" maxlength="100" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" maxlength="100" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Feedback</label>
                <textarea name="feedback" class="form-control" rows="4" maxlength="500"
                          data-maxlength="500" required></textarea>
            </div>

            <button type="submit" class="btn btn-cozy w-100">Submit</button>
        </form>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
