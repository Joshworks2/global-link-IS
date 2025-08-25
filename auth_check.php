<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

// Optional: Restrict based on role
function requireRole($role) {
    if ($_SESSION["role"] !== $role) {
        header("Location: login.php");
        exit();
    }
}
