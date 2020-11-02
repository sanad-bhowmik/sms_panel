<?php 
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 



if(isset($_POST['special'])){



  $special = $_POST['special'];
 
  $datetime = date("Y-m-d H:i:s");

  $sql  = " INSERT INTO tbl_specialist (Specialization) ";
  $sql .= " values('$special') ";

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
