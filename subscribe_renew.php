<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelnew";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM subscribers WHERE status = 1";
$result = $conn->query($sql);

$subscribers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subscribers[] = $row;
    }
} else {
    echo json_encode(["debug" => "0 results found in the database query."]);
    exit;
}
$conn->close();

echo json_encode($subscribers);
?>