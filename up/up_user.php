<?php 
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 



if(isset($_POST['user_name'])){



  $user_name = $_POST['user_name'];
  $password = base64_encode($_POST['password']);
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $mobile =$_POST['mobile'];
  $email = $_POST['email'];
  $user_role_id = $_POST['user_role'];
  $company_id = 1;
  $status =1;

  $datetime = date("Y-m-d H:i:s");

  $sql  = " INSERT INTO tbl_users (user_name,company_id,password,first_name,last_name,mobile,email,user_role_id,status,datetime) ";
  $sql .= " values('$user_name','$company_id','$password','$first_name','$last_name','$mobile','$email','$user_role_id',$status,'$datetime') ";

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
