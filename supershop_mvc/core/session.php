<?php
// core/session.php

// Start session only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Regenerate session ID safely (call after login only)
 */
function regenerateSession()
{
    session_regenerate_id(true);
}

/**
 * Check if user is logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

/**
 * Redirect if not logged in
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: /supershop_mvc/auth/login.php");
        exit;
    }
}

/**
 * Get logged-in user role
 */
function getUserRole()
{
    return $_SESSION['role'] ?? null;
}

/**
 * Allow only specific roles
 */
function requireRole(array $allowedRoles)
{
    if (!isLoggedIn() || !in_array(getUserRole(), $allowedRoles, true)) {
        header("Location: /supershop_mvc/unauthorized.php");
        exit;
    }
}