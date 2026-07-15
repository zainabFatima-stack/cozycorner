<?php
/**
 * send_letter.php
 * Handles the POST from letter.php.
 *
 * Bugs fixed from the original:
 *  - this file had NO login check, even though letter.php did -
 *    meaning anyone could bypass the check by posting here directly.
 *  - the SQL query built the INSERT by gluing strings together,
 *    which is a classic SQL-injection hole. Now uses a prepared statement.
 */
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['send'])) {
    header('Location: letter.php');
    exit();
}

$to      = trim($_POST['to'] ?? '');
$from    = trim($_POST['from'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($to === '') $to = 'Someone special';
if ($from === '') $from = 'Anonymous';

if ($message === '') {
    header('Location: letter.php?error=empty');
    exit();
}

$stmt = $conn->prepare('INSERT INTO letters (to_user, from_user, message) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $to, $from, $message);
$stmt->execute();
$stmt->close();

header('Location: letter.php?sent=1');
exit();
