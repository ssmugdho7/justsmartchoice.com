<?php
/**
 * Smart Choice CMS - Authentication & Session Security Guard
 */

if (session_status() === PHP_SESSION_NONE) {
    // Secure cookie parameters
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    session_set_cookie_params([
        'lifetime' => 86400 * 7, // 7 days
        'path'     => '/',
        'domain'   => '',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

require_once dirname(__DIR__) . '/includes/cms-engine.php';

class AdminAuth
{
    private static $usersFile = CMS_DATA_DIR . '/users.json';

    public static function check(): bool
    {
        return !empty($_SESSION['cms_user_id']) && !empty($_SESSION['cms_logged_in']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            $redirect = urlencode($_SERVER['REQUEST_URI'] ?? 'index.php');
            header('Location: login.php?redirect=' . $redirect);
            exit;
        }
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        return [
            'id'       => $_SESSION['cms_user_id'] ?? '',
            'username' => $_SESSION['cms_username'] ?? 'admin',
            'name'     => $_SESSION['cms_name'] ?? 'Administrator',
            'email'    => $_SESSION['cms_email'] ?? '',
            'role'     => $_SESSION['cms_role'] ?? 'admin'
        ];
    }

    public static function login(string $username, string $password): bool
    {
        $username = trim($username);
        if ($username === '' || $password === '') {
            return false;
        }

        if (!file_exists(self::$usersFile)) {
            return false;
        }

        $users = json_decode(@file_get_contents(self::$usersFile), true);
        if (!is_array($users)) {
            return false;
        }

        foreach ($users as $u) {
            if (
                (strcasecmp($u['username'], $username) === 0 || strcasecmp($u['email'], $username) === 0)
                && password_verify($password, $u['password'])
            ) {
                // Regenerate session ID for security against session fixation
                session_regenerate_id(true);

                $_SESSION['cms_logged_in'] = true;
                $_SESSION['cms_user_id'] = $u['id'];
                $_SESSION['cms_username'] = $u['username'];
                $_SESSION['cms_name'] = $u['name'] ?? $u['username'];
                $_SESSION['cms_email'] = $u['email'] ?? '';
                $_SESSION['cms_role'] = $u['role'] ?? 'admin';
                $_SESSION['cms_admin_preview'] = true; // Enables draft preview capability

                return true;
            }
        }

        return false;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }

    public static function csrfToken(): string
    {
        if (empty($_SESSION['cms_csrf_token'])) {
            $_SESSION['cms_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['cms_csrf_token'];
    }

    public static function verifyCsrf(?string $token): bool
    {
        if (empty($token) || empty($_SESSION['cms_csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['cms_csrf_token'], $token);
    }
}
