<?php
/**
 * add_comment.php
 * Fixed: requires login (uses the real account username instead
 * of a free-text field anyone could fake), validates the blog
 * exists, and uses a prepared statement instead of string-glued SQL.
 */
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['send_comment'])) {
    header('Location: view_blog.php');
    exit();
}

$blogId  = (int) ($_POST['blog_id'] ?? 0);
$comment = trim($_POST['comment'] ?? '');
$referer = $_SERVER['HTTP_REFERER'] ?? 'view_blog.php';

if ($comment === '') {
    header('Location: ' . $referer);
    exit();
}

// Make sure the blog actually exists before attaching a comment to it.
$check = $conn->prepare('SELECT id FROM blogs WHERE id = ?');
$check->bind_param('i', $blogId);
$check->execute();
if ($check->get_result()->num_rows === 0) {
    $check->close();
    header('Location: view_blog.php');
    exit();
}
$check->close();

$stmt = $conn->prepare('INSERT INTO comments (blog_id, username, comment) VALUES (?, ?, ?)');
$stmt->bind_param('iss', $blogId, $_SESSION['user'], $comment);
$stmt->execute();
$stmt->close();

header('Location: ' . $referer);
exit();
