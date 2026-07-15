<?php
/**
 * includes/db.php
 * -------------------------------------------------------
 * Opens one shared database connection ($conn) that every
 * page can use.
 * -------------------------------------------------------
 */

require_once __DIR__ . '/../config.php';

// On modern PHP, mysqli throws an exception on a failed connection
// by default. Turning reporting off keeps things simple: a failed
// connection just returns false, like it always used to.
mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    // Don't show the raw database error to visitors - just log it
    // for the developer and show one simple, friendly message.
    error_log('Database connection failed: ' . mysqli_connect_error());
    die('Sorry, CozyCorner could not connect to the database. Please make sure MySQL is running and that database/cozycorner.sql has been imported.');
}

mysqli_set_charset($conn, 'utf8mb4');
