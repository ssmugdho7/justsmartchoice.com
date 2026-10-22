<?php
/**
 * PHPMailer SPL autoloader patched for PHP 8+ compatibility.
 */
function PHPMailerAutoload($classname)
{
    $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'class.' . strtolower($classname) . '.php';
    if (is_readable($filename)) {
        require $filename;
    }
}

if (function_exists('spl_autoload_register')) {
    spl_autoload_register('PHPMailerAutoload', true, true);
}
