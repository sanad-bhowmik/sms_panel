<?php 
require_once("include/dbcon.php");
date_default_timezone_set("Asia/Dhaka");



$date =date("Y-m-d");
$sql = "update tbl_appointment set Status='overdue'   where Status='pending' and   	AppointmentDate<'{$date}' ";
$result = mysqli_query($GLOBALS['con'],$sql);

                  if($result){
                     echo "Update success. Total : ". mysqli_num_rows($result) ."Rows updated";

                 }
                 else{
                    echo   "Update failed " ;
              }



 

?>