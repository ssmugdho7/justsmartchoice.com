```php
<?php

/*
 * Smart Choice Contractors USA
 * Twilio Voice Integrity Callback
 */

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('X-Content-Type-Options: nosniff');

$notificationEmail = 'admin@justsmartchoice.com';
$fromEmail = 'noreply@justsmartchoice.com';

$method = isset($_SERVER['REQUEST_METHOD'])
    ? strtoupper($_SERVER['REQUEST_METHOD'])
    : 'GET';

if ($method !== 'GET' && $method !== 'POST') {
    http_response_code(405);

    echo json_encode(array(
        'success' => false,
        'message' => 'Method not allowed.'
    ));

    exit;
}

$rawBody = file_get_contents('php://input');

if ($rawBody === false) {
    $rawBody = '';
}

$contentType = isset($_SERVER['CONTENT_TYPE'])
    ? strtolower($_SERVER['CONTENT_TYPE'])
    : '';

$payload = array();

/*
 * Accept JSON payloads.
 */
if (
    $rawBody !== ''
    && strpos($contentType, 'application/json') !== false
) {
    $decoded = json_decode($rawBody, true);

    if (is_array($decoded)) {
        $payload = $decoded;
    }
}

/*
 * Accept standard form POST payloads.
 */
if (empty($payload) && !empty($_POST)) {
    $payload = $_POST;
}

/*
 * Include query-string values.
 */
if (!empty($_GET)) {
    $payload['_query'] = $_GET;
}

/*
 * Preserve unrecognized raw data.
 */
if ($rawBody !== '' && empty($payload)) {
    $payload['_raw_body'] = $rawBody;
}

function smartChoiceCallbackValue($payload, $keys)
{
    foreach ($keys as $key) {
        if (
            isset($payload[$key])
            && !is_array($payload[$key])
            && !is_object($payload[$key])
        ) {
            return trim((string) $payload[$key]);
        }
    }

    return '';
}

$status = smartChoiceCallbackValue($payload, array(
    'Status',
    'status',
    'RegistrationStatus',
    'registration_status',
    'EvaluationStatus',
    'evaluation_status'
));

$registrationSid = smartChoiceCallbackValue($payload, array(
    'RegistrationSid',
    'registration_sid',
    'TrustProductSid',
    'trust_product_sid',
    'Sid',
    'sid'
));

$accountSid = smartChoiceCallbackValue($payload, array(
    'AccountSid',
    'account_sid'
));

$errorCode = smartChoiceCallbackValue($payload, array(
    'ErrorCode',
    'error_code'
));

$errorMessage = smartChoiceCallbackValue($payload, array(
    'ErrorMessage',
    'error_message',
    'Message',
    'message'
));

$receivedAt = gmdate('Y-m-d H:i:s') . ' UTC';

$remoteIp = 'Unknown';

if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $remoteIp = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $remoteIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
    $remoteIp = $_SERVER['REMOTE_ADDR'];
}

if (strpos($remoteIp, ',') !== false) {
    $ipParts = explode(',', $remoteIp);
    $remoteIp = trim($ipParts[0]);
}

/*
 * Store logs in a protected folder.
 */
$logDirectory = __DIR__ . '/private-logs/twilio';
$logFile = $logDirectory . '/voice-integrity-callback.log';

if (!is_dir($logDirectory)) {
    @mkdir($logDirectory, 0755, true);
}

$logData = array(
    'received_at' => $receivedAt,
    'method' => $method,
    'remote_ip' => $remoteIp,
    'status' => $status,
    'registration_sid' => $registrationSid,
    'account_sid' => $accountSid,
    'error_code' => $errorCode,
    'error_message' => $errorMessage,
    'payload' => $payload
);

$logWritten = false;

$encodedLog = json_encode(
    $logData,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
);

if ($encodedLog !== false && is_dir($logDirectory)) {
    $logWritten = @file_put_contents(
        $logFile,
        str_repeat('=', 70)
        . PHP_EOL
        . $encodedLog
        . PHP_EOL,
        FILE_APPEND | LOCK_EX
    ) !== false;
}

/*
 * Send notification email only when Twilio submits actual callback data.
 * Opening the page manually will not send an unnecessary email.
 */
$emailSent = false;

if (
    $method === 'POST'
    || $status !== ''
    || $registrationSid !== ''
    || $errorCode !== ''
) {
    $subjectStatus = $status !== ''
        ? strtoupper($status)
        : 'STATUS UPDATE';

    $emailSubject = 'Twilio Voice Integrity: ' . $subjectStatus;

    $emailBody = "Twilio Voice Integrity Callback Received\n";
    $emailBody .= "========================================\n\n";
    $emailBody .= "Received: " . $receivedAt . "\n";
    $emailBody .= "Status: "
        . ($status !== '' ? $status : 'Not provided')
        . "\n";
    $emailBody .= "Registration SID: "
        . ($registrationSid !== '' ? $registrationSid : 'Not provided')
        . "\n";
    $emailBody .= "Account SID: "
        . ($accountSid !== '' ? $accountSid : 'Not provided')
        . "\n";
    $emailBody .= "Error Code: "
        . ($errorCode !== '' ? $errorCode : 'None')
        . "\n";
    $emailBody .= "Error Message: "
        . ($errorMessage !== '' ? $errorMessage : 'None')
        . "\n";
    $emailBody .= "Source IP: " . $remoteIp . "\n\n";
    $emailBody .= "Payload:\n";
    $emailBody .= print_r($payload, true);

    $headers = array();
    $headers[] = 'From: Smart Choice CRM <' . $fromEmail . '>';
    $headers[] = 'Reply-To: ' . $notificationEmail;
    $headers[] = 'Content-Type: text/plain; charset=UTF-8';

    $emailSent = @mail(
        $notificationEmail,
        $emailSubject,
        $emailBody,
        implode("\r\n", $headers)
    );
}

http_response_code(200);

echo json_encode(array(
    'success' => true,
    'message' => 'Smart Choice Twilio callback endpoint is active.',
    'received_at' => $receivedAt,
    'status' => $status !== '' ? $status : null,
    'registration_sid' => $registrationSid !== ''
        ? $registrationSid
        : null,
    'logged' => $logWritten,
    'notification_sent' => $emailSent
), JSON_UNESCAPED_SLASHES);
```
