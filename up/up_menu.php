<?php 
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 



if(isset($_POST['menu_name'])){



  $menu_name = $_POST['menu_name'];
 
  $icon_class = $_POST['icon_class'];
  $notification =$_POST['notification'];
 
  $status =1;

  $edate = date("Y-m-d H:i:s");

  $sql  = " INSERT INTO tbl_menu (menu_name,icon_class,status,notification,edate) ";
  $sql .= " values('$menu_name','$icon_class','$status','$notification','$edate') ";

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
