<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 




if(isset($_POST['hospitalName'])){

                  $HospitalName  = $_POST['hospitalName'];

                  $date = date("Y-m-d H:i:s");

                  $sql  = " INSERT INTO tbl_hospital (HospitalName,DateTime) values('$HospitalName','$date') ";

                  $result = mysqli_query($GLOBALS['con'],$sql);

                  if($result){
                     echo  "Added successfully.";

                 }
                 else{
                    echo  "Add unuccessful.";
              }

}else{

  echo 'failed';
}


?>