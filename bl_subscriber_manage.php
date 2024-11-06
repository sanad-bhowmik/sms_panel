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

$msisdn = isset($_REQUEST['msisdn']) ? urldecode(trim($_REQUEST['msisdn'])) : '';
$keyword = isset($_REQUEST['keyword']) ? urldecode(trim($_REQUEST['keyword'])) : '';
$telcoID = isset($_REQUEST['telcoid']) ? intval($_REQUEST['telcoid']) : 0;
$text = isset($_REQUEST['text']) ? urldecode(trim($_REQUEST['text'])) : '';

$logFilePath = "log/Subscriber_HIT_" . $today . ".txt";
$ftp222 = fopen($logFilePath, 'a+');
fwrite($ftp222, "msisdn=" . $msisdn . "&keyword=" . $keyword . "&telcoID=" . $telcoID . "&text=" . $text . "-date-" . $datenn . "\n");
fclose($ftp222);

//echo "Received data: MSISDN=$msisdn, Keyword=$keyword, TelcoID=$telcoID, Text=$text\n";

$msisdn = str_replace("-", "", $msisdn);
$sms_slice = explode(" ", $text);
$first_prefix = isset($sms_slice[0]) ? $sms_slice[0] : '';
$status = ($first_prefix === 'STOP') ? 0 : 1;

// Direct SQL query to check if subscriber exists
$sql = "SELECT id FROM subscribers WHERE number = '$msisdn' AND keyword = '$keyword'";
$result = $conn->query($sql);

// Count the number of rows
$num_rows = $result->num_rows;

echo $num_rows;

// Log the SQL query and results
$logFilePath = "log/GP_URL_Subscriber_HIT_" . $today . ".txt";
$ftp222 = fopen($logFilePath, 'a+');
fwrite($ftp222, "SQL=" . $sql . " | num_rows=" . $num_rows . " -date-" . $datenn . "\n");
fclose($ftp222);

if ($num_rows > 0) {
    $sql_update = "UPDATE subscribers SET status = $status, updated_at = NOW() WHERE number = '$msisdn' AND keyword = '$keyword'";

    // Execute the query and check for success
    if ($conn->query($sql_update) === TRUE) {
        echo "Status and keyword updated to $keyword for MSISDN: $msisdn and Status: $status\n";
    } else {
        echo "Error updating status and keyword: " . $conn->error . "\n";
    }

    // Log the SQL update query
    $logFilePath = "log/GP_URL_Subscriber_HIT_" . $today . ".txt";
    $ftp222 = fopen($logFilePath, 'a+');
    fwrite($ftp222, "SQL_Update=" . $sql_update . " -date-" . $datenn . "\n");
    fclose($ftp222);
} else {
    $sql_insert = "INSERT INTO subscribers (number, keyword, status, created_at, updated_at, telcoID) 
               VALUES ('$msisdn', '$keyword', $status, NOW(), NOW(), $telcoID)";

    // Execute the query and check for success
    if ($conn->query($sql_insert) === TRUE) {
        echo "Data inserted successfully for MSISDN: $msisdn with keyword: $keyword\n";
    } else {
        echo "Error inserting data: " . $conn->error . "\n";
    }

    // Log the SQL insert query
    $logFilePath = "log/GP_URL_Subscriber_HIT_" . $today . ".txt";
    $ftp222 = fopen($logFilePath, 'a+');
    fwrite($ftp222, "SQL_Insert=" . $sql_insert . " -date-" . $datenn . "\n");
    fclose($ftp222);
}

$conn->close();
