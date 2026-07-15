<?php
require_once 'includes/functions.php';
$pageTitle = 'Cozy Blogs';
require 'includes/header.php';
?>

<div class="blog-intro" style="padding-top:120px;">
    <h1>✨ Cozy Blogs</h1>
    <p>
        Share your thoughts, baking stories, cozy memories, and creative ideas with
        everyone. Read blogs from other members and connect through warm conversations
        and comments.
    </p>
</div>

<div class="container pb-5">
    <div class="row g-4 stagger">
        <div class="col-12 col-md-6">
            <div class="blog-box">
                <h2>📝 Publish Blog</h2>
                <p>Write your own cozy blog and share your creativity, recipes, memories, and experiences with others.</p>
                <a class="btn btn-cozy" href="publish_blog.php">Publish Blog</a>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="blog-box">
                <h2>📚 View Blogs</h2>
                <p>Explore beautiful blogs written by other members, open full posts, and leave comments.</p>
                <a class="btn btn-cozy" href="view_blog.php">View Blogs</a>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
