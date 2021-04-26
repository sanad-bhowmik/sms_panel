<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");

					

					
if(isset($_POST['docID'])){

    $docID = $_POST['docID'];
    $date = $_POST['date'];
    
    
    $sql  = "select Appointment_Time from appointmentview where DOCID='$docID' and AppointmentDate ='$date'  ";
    $result = mysqli_query($GLOBALS['con'],$sql);
    
    $output='';
    if(mysqli_num_rows($result)>0){
        $output.='<ul style="margin-left:-45px;">';
        while($res=mysqli_fetch_assoc($result)){
    
        
        $output.='<li class="list-group-item list-group-item-action dn">'.$res['Appointment_Time'].'</li>';
      }
         $output.='</ul>';
      }
    else{
    
        $output.='<p class="list-group-item list-group-item-action">No Result</p>';
    
    }
    echo $output;
    }


 ?>