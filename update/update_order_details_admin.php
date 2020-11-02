<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 


if(isset($_POST['order_id'])){


  $order_id = mysqli_real_escape_string($GLOBALS['con'],$_POST['order_id']);
  $order_status = mysqli_real_escape_string($GLOBALS['con'],$_POST['order_status']);
  $order_remarks = mysqli_real_escape_string($GLOBALS['con'],$_POST['order_remarks']);
  $user = $_SESSION['user'];

  $date = date("Y-m-d H:i:s");

  $sql  = "update order_details set order_status='$order_status' , remarks='$order_remarks',status_changed='$date',updated_by='$user'  where id='$order_id' limit 1";

  $result = mysqli_query($GLOBALS['con'],$sql);

  if($result){
   echo $order_id ;

 }
 else{

  echo  "failed";

}





}






?>