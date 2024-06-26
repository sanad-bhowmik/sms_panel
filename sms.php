<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelnew";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchMessageFromQueue() {
    return 'TTS';
}

$keywordFromQueue = fetchMessageFromQueue();
$keywordParam = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if ($keywordFromQueue) {
    $keywordParam = $keywordFromQueue;
}

$sql = "SELECT sms FROM sms WHERE keyword = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
}

$stmt->bind_param("s", $keywordParam);
$stmt->execute();
$stmt->bind_result($sms);



while ($stmt->fetch()) {
    echo "$sms";
}


$stmt->close();
$conn->close();
?>
