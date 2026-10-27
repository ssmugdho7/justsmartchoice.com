<?php
require_once __DIR__ . '/auth.php';
AdminAuth::logout();
header('Location: login.php');
exit;
