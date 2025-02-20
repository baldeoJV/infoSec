<?php
session_start();

$session_timeout = 601; // 10 minutes
$response = ["expired" => false];

if (isset($_SESSION['LAST_ACTIVITY'])) {
    $session_lifetime = time() - $_SESSION['LAST_ACTIVITY'];
    
    if ($session_lifetime > $session_timeout) {
        session_unset();
        session_destroy();
        $response["expired"] = true; // Mark session as expired
    }
}

header("Content-Type: application/json");
echo json_encode($response);
?>
