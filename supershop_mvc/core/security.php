<?php
// core/security.php

/**
 * Clean input to prevent XSS
 */
function cleanInput($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Hash password securely
 */
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password
 */
function verifyPassword($password, $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}

/**
 * Check required field
 */
function isRequired($value)
{
    return !empty(trim($value));
}
