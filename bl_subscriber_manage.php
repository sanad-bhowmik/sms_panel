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

$msisdn = isset($_REQUEST['msisdn']) ? $_REQUEST['msisdn'] : '';
$keyword = isset($_REQUEST['keyword']) ? urldecode($_REQUEST['keyword']) : '';
$suffix = substr($keyword, -3);

// Log the received data
$logFilePath = "log/Subscriber_HIT_" . $today . ".txt";
$ftp222 = fopen($logFilePath, 'a+');
fwrite($ftp222, "msisdn=" . $msisdn . "&keyword=" . $keyword . "-date-" . $datenn . "\n");
fclose($ftp222);

echo "Received data: MSISDN=$msisdn, Keyword=$keyword\n";

if ($msisdn != '' && $keyword != '') {
    $check_stmt = $conn->prepare("SELECT id, keyword FROM subscribers WHERE number = ?");
    $check_stmt->bind_param("s", $msisdn);
    $check_stmt->execute();
    $check_stmt->bind_result($id, $existing_keyword);

    $update_id = null;

    while ($check_stmt->fetch()) {
        if (substr($existing_keyword, -3) == $suffix) {
            $update_id = $id;
            break;
        }
    }
    $check_stmt->close();

    $status = (strpos($keyword, 'STOP') === 0) ? 0 : 1;

    if ($update_id) {
        // Update the existing record
        $update_stmt = $conn->prepare("UPDATE subscribers SET keyword = ?, status = ?, updated_at = NOW(), telcoID = 3 WHERE id = ?");
        $update_stmt->bind_param("sii", $keyword, $status, $update_id);

        if ($update_stmt->execute()) {
            echo "Status and keyword updated to $keyword for MSISDN: $msisdn\n";
        } else {
            echo "Error updating status and keyword to $keyword: " . $update_stmt->error . "\n";
        }

        $update_stmt->close();
    } else {
        // Insert a new record
        $insert_stmt = $conn->prepare("INSERT INTO subscribers (number, keyword, status, created_at, updated_at, telcoID) VALUES (?, ?, ?, NOW(), NOW(), 3)");
        $insert_stmt->bind_param("ssi", $msisdn, $keyword, $status);

        if ($insert_stmt->execute()) {
            echo "Data inserted successfully for MSISDN: $msisdn with keyword: $keyword\n";
        } else {
            echo "Error inserting data: " . $insert_stmt->error . "\n";
        }

        $insert_stmt->close();
    }
} else {
    echo "Invalid data: MSISDN=$msisdn, Keyword=$keyword\n";
}

$conn->close();
