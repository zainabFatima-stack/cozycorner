<?php
/**
 * view_blog.php
 * Lists every blog post with its comments.
 * Fixed: every piece of user content is now escaped with e()
 * before being printed, closing the old XSS hole.
 */
require_once 'includes/functions.php';

$blogs = $conn->query('SELECT * FROM blogs ORDER BY id DESC');

$pageTitle = 'Cozy Corner Blogs';
require 'includes/header.php';
?>

<div class="container" style="padding-top:120px; padding-bottom:50px;">
    <h1 class="text-center mb-5" style="color:var(--cozy-mauve-deep);">💖 Cozy Corner Blogs</h1>

    <?php if (isset($_GET['published'])): ?>
        <div class="alert alert-success text-center">Your blog has been published! 🎉</div>
    <?php endif; ?>

    <?php if ($blogs->num_rows === 0): ?>
        <p class="text-center">No blogs yet. <a href="publish_blog.php">Be the first to write one!</a></p>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <?php while ($blog = $blogs->fetch_assoc()): ?>
                <div class="blog-card">
                    <?php if (!empty($blog['image'])): ?>
                        <img src="<?= e($blog['image']) ?>" alt="<?= e($blog['title']) ?>" loading="lazy">
                    <?php endif; ?>

                    <div class="blog-card-body">
                        <h2><a href="single_blog.php?id=<?= (int) $blog['id'] ?>"><?= e($blog['title']) ?></a></h2>

                        <p><?= e(substr($blog['content'], 0, 150)) ?><?= strlen($blog['content']) > 150 ? '…' : '' ?></p>

                        <a href="single_blog.php?id=<?= (int) $blog['id'] ?>" class="fw-semibold">Read More →</a>
                        <p class="author mt-2">By: <?= e($blog['author']) ?></p>

                        <div class="comment-box">
                            <h3 class="h6">Comments</h3>

                            <?php
                            $blogId = (int) $blog['id'];
                            $stmt = $conn->prepare('SELECT * FROM comments WHERE blog_id = ? ORDER BY id DESC LIMIT 5');
                            $stmt->bind_param('i', $blogId);
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
                                <form action="add_comment.php" method="POST" class="mt-2">
                                    <input type="hidden" name="blog_id" value="<?= $blogId ?>">
                                    <textarea name="comment" class="form-control" rows="2"
                                              maxlength="300" placeholder="Write a comment..." required></textarea>
                                    <button type="submit" name="send_comment" class="btn btn-cozy btn-sm mt-2">Post Comment</button>
                                </form>
                            <?php else: ?>
                                <p class="mt-2 mb-0"><a href="login.php">Log in</a> to leave a comment.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
