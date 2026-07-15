<?php
/**
 * save_feedback.php
 * Fixed: feedback used to be appended to a plain text file
 * (feedbacks.txt) with no escaping and no validation. It's now
 * saved properly to the database, just like the rest of the site's data.
 */
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: feedback.php');
    exit();
}

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$feedback = trim($_POST['feedback'] ?? '');

if ($name === '' || $feedback === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: feedback.php?error=1');
    exit();
}

$stmt = $conn->prepare('INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $name, $email, $feedback);
$stmt->execute();
$stmt->close();

header('Location: view_feedback.php?submitted=1');
exit();
