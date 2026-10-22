<?php
// /public_html/justsmartchoice.com/ai/lead.php
// Receives JSON: {name, phone, email, transcript}
// Sends an email to site admin with the info.

error_reporting(0);
ini_set('display_errors', 0);
header("Content-Type: application/json; charset=utf-8");

$LEAD_EMAIL = "admin@justsmartchoice.com"; // <<< CHANGE if you prefer another inbox
$FROM_EMAIL = "no-reply@justsmartchoice.com";
$SUBJECT    = "New Website Lead (Chatbot) - Smart Choice Contractors USA";

function jreply($arr) {
  echo json_encode($arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  exit;
}

$raw = file_get_contents("php://input");
$payload = json_decode($raw, true);
if (!is_array($payload)) {
  jreply(["ok"=>false, "msg"=>"Invalid request"]);
}

$name = trim((string)($payload['name'] ?? ''));
$phone = trim((string)($payload['phone'] ?? ''));
$email = trim((string)($payload['email'] ?? ''));
$transcript = trim((string)($payload['transcript'] ?? ''));

if ($name === "" || $phone === "" || $email === "") {
  jreply(["ok"=>false, "msg"=>"Please fill name, phone and email."]);
}

$body = "New Lead from Chatbot\n\n".
        "Name:  {$name}\n".
        "Phone: {$phone}\n".
        "Email: {$email}\n\n".
        "Transcript:\n".
        "-------------------------------------\n".
        $transcript."\n".
        "-------------------------------------\n";

$headers = "From: Smart Choice Bots <{$FROM_EMAIL}>\r\n".
           "Reply-To: {$email}\r\n".
           "MIME-Version: 1.0\r\n".
           "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = @mail($LEAD_EMAIL, $SUBJECT, $body, $headers);

if ($sent) {
  jreply(["ok"=>true, "msg"=>"Thanks! We’ll reach out shortly."]);
} else {
  jreply(["ok"=>false, "msg"=>"Could not send email. Please try again or call us."]);
}
