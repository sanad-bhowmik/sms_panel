<?php 
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 



if(isset($_POST['coupon_code'])){



  $coupon_code = $_POST['coupon_code'];
  $coupon_discount = $_POST['discount'];
  $coupon_type = $_POST['type'];
  $expiry_date = $_POST['expiry_date'];
  $doctor_type = $_POST['doctor_type'];
 
  $status =1;

  $edate = date("Y-m-d H:i:s");

  $sql  = " INSERT INTO tbl_coupons (coupon_code,discount_percent,discount_type,doctor_type,coupon_status,expiry_date) ";
  $sql .= " values('$coupon_code','$coupon_discount','$coupon_type','$doctor_type','$status','$expiry_date') ";

  $result = mysqli_query($GLOBALS['con'],$sql);

  if($result){
    echo  "Your data added successfully !!";
 }
 else{
  echo  $sql;
 }


}
else{

  echo "Something Went Wrong !!";
}




















?>
