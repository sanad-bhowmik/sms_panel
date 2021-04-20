<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['doc_id'])){



  $id = trim($_POST['doc_id']);
  $value = trim($_POST['ordering']);

 

  $sql  = "update tbl_doctor set ordering='$value' where DOCID ='$id' limit 1 ";

  $result = mysqli_query($GLOBALS['con'],$sql);

  if($result){
   echo  "updated successfully !!";

 }
 else{

  echo  "Somthing went wrong !!";

}





}






?>