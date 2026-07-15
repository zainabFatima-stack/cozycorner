<?php
/**
 * publish_blog.php
 * The original page had NO login check at all - anyone could
 * publish a blog without an account, saving a blank/NULL author.
 */
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$errors = [];
$old = ['title' => '', 'image' => '', 'content' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['publish'])) {
    $old['title']   = $title   = trim($_POST['title'] ?? '');
    $old['image']   = $image   = trim($_POST['image'] ?? '');
    $old['content'] = $content = trim($_POST['content'] ?? '');
    $author = current_username();

    if ($title === '' || strlen($title) > 150) {
        $errors[] = 'Please enter a blog title (up to 150 characters).';
    }
    if ($content === '') {
        $errors[] = 'Please write some content for your blog.';
    }
    if ($image !== '' && !filter_var($image, FILTER_VALIDATE_URL)) {
        $errors[] = 'The image field must be a valid URL (or left empty).';
    }

    if (!$errors) {
        $stmt = $conn->prepare('INSERT INTO blogs (title, image, content, author) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $title, $image, $content, $author);

        if ($stmt->execute()) {
            $stmt->close();
            header('Location: view_blog.php?published=1');
            exit();
        }
        $errors[] = 'Something went wrong publishing your blog. Please try again.';
    }
}

$pageTitle = 'Publish Blog';
require 'includes/header.php';
?>

<div class="page-wrap" style="padding-top:120px; padding-bottom:50px;">
    <div class="container">
        <div class="cozy-card mx-auto animate-pop" style="max-width:640px;">
            <h1 class="text-center mb-4" style="color:var(--cozy-mauve-deep);">📝 Publish Your Blog</h1>

            <?php foreach ($errors as $err): ?>
                <div class="alert alert-danger py-2"><?= e($err) ?></div>
            <?php endforeach; ?>

            <form method="POST" novalidate>
                <div class="mb-3">
                    <label class="form-label">Blog Title</label>
                    <input type="text" name="title" class="form-control" maxlength="150"
                           value="<?= e($old['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image URL <span class="text-muted">(optional)</span></label>
                    <input type="text" name="image" class="form-control" placeholder="https://..."
                           value="<?= e($old['image']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="8" maxlength="5000"
                              data-maxlength="5000" required><?= e($old['content']) ?></textarea>
                </div>

                <button type="submit" name="publish" class="btn btn-cozy w-100">Publish Blog</button>
            </form>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
