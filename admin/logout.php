<?php
require_once __DIR__ . '/auth.php';

// Logout is a state change: require POST + CSRF token
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST' || !AdminAuth::verifyCsrf($_POST['csrf_token'] ?? '')) {
    header('Location: ' . (AdminAuth::check() ? 'index.php' : 'login.php'));
    exit;
}

AdminAuth::logout();
header('Location: login.php');
exit;
