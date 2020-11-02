<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){	

        
    $title=$_POST['title'];
    $message=$_POST['message'];
	
        
        
 define( 'API_ACCESS_KEY', 'AAAACTpUQr4:APA91bF9JqLF4_iX6dCAvC04J88zYGbqwjh7iYZjEnfjefDnPRaZjmmmveVeivjHi5TN2e_FP7KZaUDOQ8ySZg7oRGXy3uN5K94gLqCx17bD5BSJ5G_oZtHNBwgsylAv_watGAsdMO1r');
$msg = array
(
    'body'   =>$message,
    'title'     => $title
  
);
$fields = array
(
    'to'            => "/topics/General",
    'notification'          => $msg


);

$headers = array
(
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
);

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );






   echo json_decode($result);



}else{
	echo "failed";
}

//echo json_encode($response);