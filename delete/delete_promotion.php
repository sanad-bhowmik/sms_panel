<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['pid'])){



  $pid = trim($_POST['pid']);

 

  $sql  = " DELETE FROM  promotions where id ='$pid' limit 1 ";

  $result = mysqli_query($GLOBALS['con'],$sql);

  if($result){
   echo  "Deleted successfully !!";

 }
 else{

  echo  "Somthing went wrong !!";

}





}






?>