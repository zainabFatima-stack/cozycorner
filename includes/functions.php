<?php
/**
 * includes/functions.php
 * -------------------------------------------------------
 * Small helper functions used across the whole site.
 * Include this ONE file at the top of a page and you get
 * the database connection + session + the basics below.
 * -------------------------------------------------------
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

/* ---------------------------------------------------------
 |  Output escaping
 |  Wrap ANY value that came from a user (or the database)
 |  with e() before printing it in HTML. This stops XSS -
 |  i.e. someone typing <script> tags into a comment box.
 * --------------------------------------------------------*/
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/* ---------------------------------------------------------
 |  Simple login helpers
 * --------------------------------------------------------*/
function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function current_username(): ?string
{
    return $_SESSION['user'] ?? null;
}

// Which nav link should be highlighted as "active"?
function is_active_page(string $page): string
{
    return (basename($_SERVER['PHP_SELF']) === $page) ? 'active' : '';
}
