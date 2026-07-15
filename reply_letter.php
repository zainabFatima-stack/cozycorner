<?php
/**
 * reply_letter.php
 * Saves a reply to an existing letter.
 */
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: view_letters.php');
    exit();
}

$letterId = (int) ($_POST['letter_id'] ?? 0);
$reply    = trim($_POST['reply'] ?? '');

if ($letterId <= 0 || $reply === '') {
    header('Location: view_letters.php?error=empty');
    exit();
}

// Only fill in the reply if this letter doesn't already have one,
// so two people can't overwrite each other's reply by mistake.
$stmt = $conn->prepare(
    "UPDATE letters SET reply = ?, reply_from = ? WHERE id = ? AND (reply IS NULL OR reply = '')"
);
$stmt->bind_param('ssi', $reply, $_SESSION['user'], $letterId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header('Location: view_letters.php?replied=1');
} else {
    header('Location: view_letters.php?error=already');
}
$stmt->close();
exit();
