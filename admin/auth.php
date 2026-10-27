<?php
/**
 * Smart Choice CMS - Authentication & Session Security Guard
 */

require_once dirname(__DIR__) . '/includes/cms-engine.php';

// Secure, HttpOnly, SameSite=Lax session cookie (see cms_session_start)
cms_session_start();

class AdminAuth
{
    private static $usersFile = CMS_DATA_DIR . '/users.json';
    private static $throttleFile = CMS_DATA_DIR . '/login_attempts.json';

    const MAX_FAILED_ATTEMPTS = 5;
    const THROTTLE_WINDOW = 900; // 15 minutes

    /** Reason for the last failed login: 'invalid' or 'throttled' */
    public static $lastError = '';

    /**
     * Record or check failed login attempts per IP + username in an ignored JSON file.
     * Returns the number of recent failures, or null when the store is unusable (callers fail closed).
     */
    private static function throttle(string $username, bool $recordFailure = false, bool $clear = false): ?int
    {
        $key = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . '|' . strtolower($username));
        $fh = @fopen(self::$throttleFile, 'c+');
        if (!$fh) {
            return null;
        }
        if (!flock($fh, LOCK_EX)) {
            fclose($fh);
            return null;
        }

        $raw = stream_get_contents($fh);
        $data = $raw ? json_decode($raw, true) : [];
        if (!is_array($data)) {
            $data = [];
        }

        // Drop attempts outside the window
        $cutoff = time() - self::THROTTLE_WINDOW;
        foreach ($data as $k => $times) {
            $data[$k] = array_values(array_filter((array)$times, function ($t) use ($cutoff) {
                return (int)$t > $cutoff;
            }));
            if (empty($data[$k])) {
                unset($data[$k]);
            }
        }

        if ($clear) {
            unset($data[$key]);
        } elseif ($recordFailure) {
            $data[$key][] = time();
        }
        $count = count($data[$key] ?? []);

        ftruncate($fh, 0);
        rewind($fh);
        $ok = fwrite($fh, json_encode($data)) !== false;
        fflush($fh);
        flock($fh, LOCK_UN);
        fclose($fh);

        return $ok ? $count : null;
    }

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
        self::$lastError = 'invalid';
        $username = trim($username);
        if ($username === '' || $password === '') {
            return false;
        }

        // Throttle before verifying credentials; fail closed if the attempt store is unavailable
        $recent = self::throttle($username);
        if ($recent === null || $recent >= self::MAX_FAILED_ATTEMPTS) {
            self::$lastError = 'throttled';
            return false;
        }

        if (!file_exists(self::$usersFile)) {
            self::throttle($username, true);
            return false;
        }

        $users = json_decode(@file_get_contents(self::$usersFile), true);
        if (!is_array($users)) {
            self::throttle($username, true);
            return false;
        }

        foreach ($users as $u) {
            if (
                (strcasecmp($u['username'], $username) === 0 || strcasecmp($u['email'], $username) === 0)
                && password_verify($password, $u['password'])
            ) {
                self::throttle($username, false, true);
                self::$lastError = '';

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

        self::throttle($username, true);
        return false;
    }

    /**
     * Accept only same-site relative paths ("/admin/...") as post-login redirect targets
     */
    public static function safeRedirect(?string $target, string $fallback = 'index.php'): string
    {
        $target = (string)$target;
        if (
            $target === ''
            || $target[0] !== '/'
            || (isset($target[1]) && ($target[1] === '/' || $target[1] === '\\'))
            || strpos($target, '\\') !== false
            || preg_match('/[\x00-\x1F\x7F]/', $target)
            || stripos($target, 'login.php') !== false
        ) {
            return $fallback;
        }
        $parts = parse_url($target);
        if ($parts === false || isset($parts['scheme']) || isset($parts['host'])) {
            return $fallback;
        }
        return $target;
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
