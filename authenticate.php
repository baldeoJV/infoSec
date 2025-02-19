<?php
session_start();
// include "db_connect.php"; // Ensure you have a connection file

$host = "localhost";
$user = "root";
$password = "";
$database = "travel_db";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password_hash FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($password_hash);
    $stmt->fetch();
    $stmt->close();


    if ($password_hash) {
        // Hash the input password with SHA-256 before comparing
        $hashed_input_password = hash("sha256", $password);

        if ($hashed_input_password === $password_hash) {
            $_SESSION['admin_logged_in'] = true;
            echo "success";
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

