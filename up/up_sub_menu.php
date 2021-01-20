<?php 
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 



if(isset($_POST['menu_id'])){



  $menu_id = $_POST['menu_id'];
 
  $sub_menu_name = $_POST['sub_menu_name'];
  $page_url = $_POST['page_url'];
  $notification =$_POST['notification'];
  $user_name= $_SESSION['name'];
  $user_id= $_SESSION['user_id'];
  $status =1;

  $edate = date("Y-m-d H:i:s");

  $sql  = " INSERT INTO tbl_sub_menu (menu_id,sub_menu_name,page_url,status,notification,added_by,user_id,edate) ";
  $sql .= " values('$menu_id','$sub_menu_name','$page_url','$status','$notification','$user_name','$user_id','$edate') ";

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
