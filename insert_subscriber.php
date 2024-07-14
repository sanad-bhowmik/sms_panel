<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelnew";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$datenn = date('Y-m-d H:i:s');
$today = date("Y-m-d");
// Get data from POST request
$msisdn = isset($_POST['msisdn']) ? $_POST['msisdn'] : '';
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

$ftp222 = fopen("log\Subscriber_HIT_" . $today . ".txt", 'a+');
fwrite($ftp222, "msisdn=" . $msisdn . "&keyword=" . $keyword . "-date-" . $datenn . "\n");
fclose($ftp222);

if ($msisdn != '' && $keyword != '') {
    // Check if the msisdn already exists in the database
    $check_stmt = $conn->prepare("SELECT id FROM subscribers WHERE number = ?");
    $check_stmt->bind_param("s", $msisdn);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Duplicate entry: MSISDN already exists.";
    } else {
        // Insert new subscriber into the database
        $insert_stmt = $conn->prepare("INSERT INTO subscribers (number, keyword, status, created_at, updated_at) VALUES (?, ?, 1, NOW(), NOW())");
        $insert_stmt->bind_param("ss", $msisdn, $keyword);

        if ($insert_stmt->execute()) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . $insert_stmt->error;
        }
    }

    $check_stmt->close();
    $insert_stmt->close();
} else {
    echo "Invalid data";
}

$conn->close();
