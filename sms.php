<?php
//echo "test sms";

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$msisdn = isset($_GET['msisdn']) ? $_GET['msisdn'] : '';
$text = isset($_GET['text']) ? $_GET['text'] : '';
$msgid = isset($_GET['msgid']) ? $_GET['msgid'] : '';
$telcoid = isset($_GET['telcoid']) ? $_GET['telcoid'] : '';  // Get telcoid from URL parameters
$shortcode = isset($_GET['shortcode']) ? $_GET['shortcode'] : '';
$datetime = isset($_GET['datetime']) ? $_GET['datetime'] : '';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelnew";
$date = date('Y-m-d');
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use $telcoid in the SQL query
$sql = $conn->prepare("SELECT sms FROM sms WHERE keyword = ? AND telcoID = ? ORDER BY id DESC LIMIT 1");
$sql->bind_param("si", $keyword, $telcoid);  // 'i' for integer type
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($keyword != "" && $msisdn != "") {
            if ($telcoid == 3) {
                // For telcoid = 3, use the original URL
                $registerMO_url = 'http://103.228.39.36/smppsend/blsmpp_test.php';
                $registerMO_param = "msisdn=$msisdn&keyword=$keyword&shortcode=$shortcode&message=" . urlencode($row['sms']);
            } elseif ($telcoid == 1) {
                // For telcoid = 1, use the new URL and parameters
                $skey = "your_secret_key"; // Add your actual secret key here
                $registerMO_url = 'http://103.228.39.36:9090/iod_mt_mtips_gp.php';
                $registerMO_param = "msisdn=" . urlencode($msisdn) . "&content=" . urlencode($row['sms']) . "&skey=" . urlencode($skey) . "&shortcode=" . urlencode($shortcode) . "&telcoid=" . urlencode($telcoid) . "&contentsession=" . urlencode($msgid);
            }

            // Log the URL and parameters
            $ftp222 = fopen("log/contentsms_" . $date . ".txt", 'a+');
            fwrite($ftp222, $registerMO_url . "?" . $registerMO_param . "-" . $datetime . "\n");
            fclose($ftp222);

            // Send the HTTP request
            try {
                $response = HttpRequest($registerMO_url, $registerMO_param);
                echo 200;
            } catch (Exception $e) {
                echo 500;
                $ftp222 = fopen("log/contentsms_" . $date . ".txt", 'a+');
                fwrite($ftp222, $registerMO_url . "?" . $registerMO_param . "-" . $datetime . " error:" . $e . "\n");
                fclose($ftp222);
            }
        }
    }
} else {
    echo 404;
}

$conn->close();

function HttpRequest($url, $param)
{
    $URL_STR = $url . $param;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL_STR);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_exec($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $response;
}
?>
