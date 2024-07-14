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
$keyword = isset($_REQUEST['keyword']) ? urldecode($_REQUEST['keyword']) : ''; // Decode the URL-encoded keyword
$keyword_suffix = substr($keyword, -3); // Extract the last three characters of the keyword

$ftp222 = fopen("log\\Subscriber_HIT_" . $today . ".txt", 'a+');
fwrite($ftp222, "msisdn=" . $msisdn . "&keyword=" . $keyword . "-date-" . $datenn . "\n");
fclose($ftp222);

echo "Received data: MSISDN=$msisdn, Keyword=$keyword\n";

if ($msisdn != '' && $keyword != '') {
    $check_stmt = $conn->prepare("SELECT id, keyword FROM subscribers WHERE number = ?");
    $check_stmt->bind_param("s", $msisdn);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $check_stmt->bind_result($id, $existing_keyword);
        $check_stmt->fetch();

        //START TNS 
        // $existing_suffix = substr($existing_keyword, -3);
        // var_dump($existing_suffix);
        // var_dump($keyword_suffix);
        // die();
        if ($existing_suffix == $keyword_suffix) {

            die("keyword exits");
            // Update the record if the keyword suffix matches
            if (in_array($keyword, ['STOP CNS', 'STOP FNS', 'STOP BNS', 'STOP LSU', 'STOP MWP'])) {
                $update_stmt = $conn->prepare("UPDATE subscribers SET status = 0, keyword = ?, updated_at = NOW() WHERE number = ?");
                $update_stmt->bind_param("ss", $keyword, $msisdn);

                if ($update_stmt->execute()) {
                    echo "Status and keyword updated to $keyword for MSISDN: $msisdn\n";
                } else {
                    echo "Error updating status and keyword to $keyword: " . $update_stmt->error . "\n";
                }

                $update_stmt->close();
            } elseif (in_array($keyword, ['START CNS', 'START FNS', 'START BNS', 'START LSU', 'START MWP'])) {
                $update_stmt = $conn->prepare("UPDATE subscribers SET status = 1, keyword = ?, updated_at = NOW() WHERE number = ?");
                $update_stmt->bind_param("ss", $keyword, $msisdn);

                if ($update_stmt->execute()) {
                    echo "Status and keyword updated to $keyword for MSISDN: $msisdn\n";
                } else {
                    echo "Error updating status and keyword to $keyword: " . $update_stmt->error . "\n";
                }

                $update_stmt->close();
            } else {
                echo "Invalid keyword for existing MSISDN.\n";
            }
        } else {

            //die("number found but KNS not found");
            // Insert a new record if the keyword suffix does not match
            $insert_stmt = $conn->prepare("INSERT INTO subscribers (number, keyword, status, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $status = (strpos($keyword, 'STOP') === 0) ? 0 : 1;
            $insert_stmt->bind_param("ssi", $msisdn, $keyword, $status);

            if ($insert_stmt->execute()) {
                echo "New record inserted for MSISDN: $msisdn with keyword $keyword\n";
            } else {
                echo "Error inserting data: " . $insert_stmt->error . "\n";
            }

            $insert_stmt->close();
        }
    } else {

        //	die("KNS number  not found");
        // Insert a new record if there are no existing records for the MSISDN
        $insert_stmt = $conn->prepare("INSERT INTO subscribers (number, keyword, status, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $status = (strpos($keyword, 'STOP') === 0) ? 0 : 1;
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
