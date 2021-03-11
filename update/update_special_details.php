<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['oid'])){



  $pid = trim($_POST['oid']);

  $name = $_POST['name'];

  $sql  = "update tbl_specialist set Specialization='".$name."' where OID ='$pid' limit 1 ";

  $result = mysqli_query($GLOBALS['con'],$sql);

  if($result){
   echo  "200";

 }
 else{

  echo  "failed";

}


}else{

  echo "error";
}






?>