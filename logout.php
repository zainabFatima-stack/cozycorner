<?php
/**
 * logout.php
 * Ends the visitor's session and sends them home.
 */
require_once 'includes/functions.php';

$_SESSION = [];
session_destroy();

header('Location: index.php?loggedout=1');
exit();
