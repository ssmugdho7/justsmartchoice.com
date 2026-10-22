<?php
// mlnotifications.php
// Endpoint para recibir webhooks de Mercado Libre.
// ----------------------------------------------------------------
// Configura en tu App Dev la Callback URL de Notificaciones:
// https://justsmartchoice.com/mlnotifications.php
// Asegúrate de que el servidor responda HTTP 200 rápidamente.
// ----------------------------------------------------------------

date_default_timezone_set('America/New_York');

// Leer body raw
$body = file_get_contents('php://input');
$headers = getallheaders();
$time = date('Y-m-d H:i:s');

$logEntry = "=== NOTIF @ $time ===\nHEADERS:\n" . json_encode($headers, JSON_PRETTY_PRINT) . "\nBODY:\n" . $body . "\n\n";

// Guardar en archivo de log (append)
file_put_contents(__DIR__ . '/ml_notifications.log', $logEntry, FILE_APPEND | LOCK_EX);

// Opcional: puedes verificar la firma si Mercado Libre la envía (consultar documentación para el header exacto).
// Respondemos 200 OK inmediatamente para evitar reintentos.
http_response_code(200);
echo json_encode(['ok' => true]);
