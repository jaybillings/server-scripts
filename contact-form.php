<?php
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

// Honeypot filled
if (!empty($json_obj['address'])) {
    echo json_encode(array('status' => 0, 'reason' => 'Invalid address format.'));
    return;
}

if (empty($json_obj['name']) || empty($json_obj['email']) || empty($json_obj['message'])) {
    echo json_encode(array('status' => 0, 'reason' => 'Missing required field.'));
    return;
}

$name = $json_obj['name'];
$email = $json_obj['email'];
$message = $json_obj['message'];

$to = "contact@cedarvine.tech"; // Change this on prod machine
$subject = "Information Request from $name";
$body = "From: $name\n E-Mail: $email\n Message:\n $message";
$from = "From: $email";

try {
    mail($to, $subject, $body, $from);
    echo json_encode(array('status' => 1));
    return;
} catch (Exception $err) {
    echo json_encode(array('status' => 0, 'reason' => err.reason));
    return;
}
?>
