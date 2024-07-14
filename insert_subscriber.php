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

$ftp222 = fopen("log\\Subscriber_HIT_" . $today . ".txt", 'a+');
fwrite($ftp222, "msisdn=" . $msisdn . "&keyword=" . $keyword . "-date-" . $datenn . "\n");
fclose($ftp222);

echo "Received data: MSISDN=$msisdn, Keyword=$keyword\n";

if ($msisdn != '' && $keyword != '') {
    // Check if the msisdn already exists in the database
    $check_stmt = $conn->prepare("SELECT id FROM subscribers WHERE number = ?");
    $check_stmt->bind_param("s", $msisdn);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // MSISDN exists, update based on keyword
        if ($keyword === 'STOP CNS') {
            // Update the status to 0 and keyword for the given msisdn
            $update_stmt = $conn->prepare("UPDATE subscribers SET status = 0, keyword = ?, updated_at = NOW() WHERE number = ?");
            $update_stmt->bind_param("ss", $keyword, $msisdn);

            if ($update_stmt->execute()) {
                echo "Status and keyword updated to STOP CNS for MSISDN: $msisdn\n";
            } else {
                echo "Error updating status and keyword to STOP CNS: " . $update_stmt->error . "\n";
            }

            $update_stmt->close();
        } elseif ($keyword === 'START CNS') {
            // Update the status to 1 and keyword for the given msisdn
            $update_stmt = $conn->prepare("UPDATE subscribers SET status = 1, keyword = ?, updated_at = NOW() WHERE number = ?");
            $update_stmt->bind_param("ss", $keyword, $msisdn);

            if ($update_stmt->execute()) {
                echo "Status and keyword updated to START CNS for MSISDN: $msisdn\n";
            } else {
                echo "Error updating status and keyword to START CNS: " . $update_stmt->error . "\n";
            }

            $update_stmt->close();
        } else {
            echo "Invalid keyword for existing MSISDN.\n";
        }
    } else {
        // MSISDN does not exist, insert new subscriber
        $insert_stmt = $conn->prepare("INSERT INTO subscribers (number, keyword, status, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $status = ($keyword === 'STOP CNS') ? 0 : 1;
        $insert_stmt->bind_param("ssi", $msisdn, $keyword, $status);

        if ($insert_stmt->execute()) {
            echo "Data inserted successfully for MSISDN: $msisdn\n";
        } else {
            echo "Error inserting data: " . $insert_stmt->error . "\n";
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
} else {
    echo "Invalid data: MSISDN=$msisdn, Keyword=$keyword\n";
}

$conn->close();
