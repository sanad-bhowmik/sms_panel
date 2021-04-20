<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['oid'])){



  $id = trim($_POST['oid']);
  $value = trim($_POST['ordering']);

 

  $sql  = "update tbl_specialist set ordering='$value' where OID ='$id' limit 1 ";

  $result = mysqli_query($GLOBALS['con'],$sql);

  if($result){
   echo  "updated successfully !!";

 }
 else{

  echo  "Somthing went wrong !!";

}





}






?>