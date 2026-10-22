<?php
// The secret lives outside the document root and is never returned to the browser.
function sc_contact_recaptcha_valid($token, $transport = null, $configPath = '/home2/scusawco/private/contact-recaptcha.json')
{
    if (!is_string($token) || trim($token) === '' || strlen($token) > 8192) {
        return false;
    }
    $config = is_readable($configPath) ? json_decode(file_get_contents($configPath), true) : null;
    if (!is_array($config) || empty($config['secret']) || empty($config['hostnames'])) {
        return false;
    }
    if ($transport === null) {
        $transport = static function ($fields) {
            if (!function_exists('curl_init')) { return null; }
            $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
            curl_setopt_array($ch, [
                CURLOPT_POST => true, CURLOPT_POSTFIELDS => http_build_query($fields),
                CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_TIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSL_VERIFYHOST => 2,
            ]);
            $body = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $status === 200 && is_string($body) ? json_decode($body, true) : null;
        };
    }
    $result = $transport(['secret' => $config['secret'], 'response' => $token]);
    return is_array($result) && ($result['success'] ?? false) === true
        && in_array(strtolower($result['hostname'] ?? ''), $config['hostnames'], true);
}
