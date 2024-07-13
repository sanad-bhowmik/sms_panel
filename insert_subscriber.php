<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelnew";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$msisdn = isset($_POST['msisdn']) ? $_POST['msisdn'] : '';

if ($msisdn != '') {
    $stmt = $conn->prepare("INSERT INTO subscribers (number, status, created_at, updated_at) VALUES (?, 1, NOW(), NOW())");
    $stmt->bind_param("s", $msisdn);
    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid data";
}

$conn->close();
?>
