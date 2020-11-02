<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['url'])){

  $url = $_POST['url'];

  $role_id = $_SESSION['role_id'];



  $result = check_permission_with_url_role_id($url,$role_id);
 
  

  if($result>0){

    echo 1;
  }
  else{

    echo 0;
  }

}
else{

  echo 0;

}

?>

