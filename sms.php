<?php
//echo "test sms";

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$msisdn = isset($_GET['msisdn']) ? $_GET['msisdn'] : '';
$text = isset($_GET['text']) ? $_GET['text'] : '';
$msgid = isset($_GET['msgid']) ? $_GET['msgid'] : '';
$telcoid = isset($_GET['telcoid']) ? $_GET['telcoid'] : '';
$shortcode = isset($_GET['shortcode']) ? $_GET['shortcode'] : '';
$datetime = isset($_GET['datetime']) ? $_GET['datetime'] : '';
//var_dump($keyword);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelnew";
$date = date('Y-m-d');
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = $conn->prepare("SELECT sms FROM sms WHERE keyword = ?  ORDER BY id DESC LIMIT 1");
$sql->bind_param("s", $keyword);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['sms'];
if($telcoid==3){
$registerMO_url='http://103.228.39.36/smppsend/blsmpp_test.php';
$registerMO_param="?msisdn=$msisdn&message=".urlencode($row['sms'])."";
$ftp222 =fopen("log/contentsms_".$date.".txt",'a+');
        fwrite($ftp222,$registerMO_url."?".$registerMO_param."-".$datetime."\n");
        fclose($ftp222);
$response	=HttpRequest($registerMO_url,$registerMO_param);	
}		


		
    }
} else {
    echo "No SMS found for the keyword: " . htmlspecialchars($keyword);
}

$conn->close();




function HttpRequest($url,$param) { 
    $URL_STR =$url.$param;
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$URL_STR);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,false);
    curl_exec($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $response;
} 


?>