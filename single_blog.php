<?php
/**
 * single_blog.php
 * The original built its query as:
 *   "SELECT * FROM blogs WHERE id=$id"
 * with $id taken straight from $_GET - a textbook SQL
 * injection hole. Fixed with a prepared statement + (int) cast.
 */
require_once 'includes/functions.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare('SELECT * FROM blogs WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    http_response_code(404);
    $pageTitle = 'Blog Not Found';
    require 'includes/header.php';
    ?>
    <div class="container text-center" style="padding-top:160px; padding-bottom:80px;">
        <h1>🌧️ Blog not found</h1>
        <p>That blog post doesn't exist or may have been removed.</p>
        <a href="view_blog.php" class="btn btn-cozy">Back to Blogs</a>
    </div>
    <?php
    require 'includes/footer.php';
    exit();
}

$pageTitle = $data['title'];
require 'includes/header.php';
?>

<div class="container" style="padding-top:120px; padding-bottom:50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="blog-card">
                <?php if (!empty($data['image'])): ?>
                    <img src="<?= e($data['image']) ?>" alt="<?= e($data['title']) ?>">
                <?php endif; ?>

                <div class="blog-card-body">
                    <h1><?= e($data['title']) ?></h1>
                    <p style="white-space: pre-wrap;"><?= e($data['content']) ?></p>
                    <p class="author">By: <?= e($data['author']) ?></p>

                    <hr>
                    <h3 class="h5">Comments</h3>

                    <?php
                    $stmt = $conn->prepare('SELECT * FROM comments WHERE blog_id = ? ORDER BY id DESC');
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $comments = $stmt->get_result();
                    while ($c = $comments->fetch_assoc()):
                    ?>
                        <div class="comment">
                            <b><?= e($c['username']) ?></b><br>
                            <?= e($c['comment']) ?>
                        </div>
                    <?php endwhile; $stmt->close(); ?>

                    <?php if (is_logged_in()): ?>
                        <form action="add_comment.php" method="POST" class="mt-3">
                            <input type="hidden" name="blog_id" value="<?= $id ?>">
                            <textarea name="comment" class="form-control" rows="3"
                                      maxlength="300" placeholder="Write a comment..." required></textarea>
                            <button type="submit" name="send_comment" class="btn btn-cozy btn-sm mt-2">Post Comment</button>
                        </form>
                    <?php else: ?>
                        <p class="mt-3 mb-0"><a href="login.php">Log in</a> to leave a comment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
