<?php
// Set timezone
date_default_timezone_set('Asia/Dhaka');
$date = date('Y-m-d');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelnew";

// Get parameters
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$msisdn = isset($_GET['msisdn']) ? $_GET['msisdn'] : '';
$text = isset($_GET['text']) ? $_GET['text'] : '';
$msgid = isset($_GET['msgid']) ? $_GET['msgid'] : '';
$telcoid = isset($_GET['telcoid']) ? $_GET['telcoid'] : '';
$shortcode = isset($_GET['shortcode']) ? $_GET['shortcode'] : '';
$skey = isset($_GET['skey']) ? $_GET['skey'] : '';
$datetime = isset($_GET['datetime']) ? $_GET['datetime'] : '';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = $conn->prepare("SELECT sms FROM sms WHERE keyword = ?  ORDER BY id DESC LIMIT 1");
$sql->bind_param("s", $keyword);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($telcoid == 1 && $keyword != "" && $msisdn != "") {
		
		//content=$content&msisdn=$msisdn&contentsession=$msgTransactionId&skey=$skey&shortcode=19283&telcoid=1&skey=$skey";
		
		
        $registerMO_url = 'http://103.228.39.36:9090/iod_mt_mtips_gp.php';
        $registerMO_param = "?msisdn=" . urlencode($msisdn) . "&content=" . urlencode($row['sms']) . "&skey=" .urldecode($skey) . "&shortcode=" .urldecode($shortcode). "&telcoid=" .urldecode($telcoid) . "&contentsession=" .urldecode($msgid);
        $logContent = $registerMO_url . "?" . $registerMO_param . "-" . $datetime . "\n";
       
	   $ftp2 = fopen("C:/xampp/htdocs/smsPanel/log/gp_Push_log_" .date('Y-m-d').".txt", 'a+');
            fwrite($ftp2, $logContent ."---".date('Y-m-d H:i:s')."\n");
           
            fclose($ftp2);

		try {
            $response = HttpRequest($registerMO_url, $registerMO_param);
            echo 200;
        } catch (Exception $e) {
            echo 500;
            $logContent = $registerMO_url . "?" . $registerMO_param . "-" . $datetime . " error:" . $e . "\n";
           	   $ftp2 = fopen("C:/xampp/htdocs/smsPanel/log/gp_exception_log_" .date('Y-m-d').".txt", 'a+');
            fwrite($ftp2, "ExceptionLog-".$logContent ."---".date('Y-m-d H:i:s')."\n");
           
            fclose($ftp2);
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
