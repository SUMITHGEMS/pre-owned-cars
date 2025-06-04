<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// DB credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pre_owned_cars";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$state = $_POST['state'] ?? '';

// Insert into DB
if ($name && $email && $phone && $state) {
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, state) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $state);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing required fields";
}

$conn->close();
?>
