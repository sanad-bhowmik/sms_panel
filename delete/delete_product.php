<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['pid'])){



  $pid = trim($_POST['pid']);

 

  $sql  = "update products set active_status=2 where id ='$pid' limit 1 ";

  $result = mysqli_query($GLOBALS['con'],$sql);

  if($result){
   echo  "Removed successfully !!";

 }
 else{

  echo  "Somthing went wrong !!";

}





}






?>