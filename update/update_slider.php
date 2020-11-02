<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 

if(isset($_POST['sid'])){

  $link   ="";
  $status ="";
  $heading="";
  $title="";
  $details="";
  $img ="";
  $sid = $_POST['sid'];
  if(isset($_POST['link'])){
     $link     =   $_POST['link'];
  }
  if(isset($_POST['status'])){
      $status   = $_POST['status'];
  }

 if(isset($_POST['heading'])){
      $heading   = $_POST['heading'];
  }

   if(isset($_POST['title'])){
      $title   = $_POST['title'];
  }

   if(isset($_POST['details'])){
      $details   = $_POST['details'];
  }
 
 
 

 
  if(isset($_POST['simg']) && $_POST['simg'] != ""){
    $img =  $_POST['simg'];
  }
  echo "string";

  //$sliderDetails =  get_fetched_slider_details_data_by_id($sid);
  

  $gm1="";

//image manipulation


  if((isset($_FILES["gm1"]) && $_FILES["gm1"]["error"] == 0 ) )
  {

    //echo $_FILES["gm1"]["name"];
    //die;
   $app_gm1_name = $_FILES["gm1"]["name"];
   $app_gm1_name = str_replace(' ', '',$app_gm1_name);

   $app_gm1_type = $_FILES["gm1"]["type"];
   $app_gm1_size = $_FILES["gm1"]["size"];
   $app_gm1      = $_FILES["gm1"]["tmp_name"];
   $app_gm1_mb   = $app_gm1_size/1024/1024;
   $app_gm1_mb   = $app_gm1_mb ." "."mb";
   $app_gm1_path = '../../resource/banner/';


   if(file_exists($app_gm1_path.$app_gm1_name)){
    $gm1 = uniqid().time().$app_gm1_name;
  }else{
    $gm1 = uniqid().time().$app_gm1_name;
  }
  $gm1 =  str_replace(' ', '_', $gm1);
  if(move_uploaded_file($app_gm1,  $app_gm1_path.$gm1 )){

    if ( is_file('../../resource/banner/'.$img) ) {



     chmod ( '../../resource/banner/'.$img,0777);
    
     if(unlink ('../../resource/banner/'.$img)){

      $file = fopen("../log/unlink.txt","w");
      echo fwrite($file,'../../resource/banner/'.$img);
      fclose($file);

     }




   }

    //$upload_msg .="Gallery Image 1".$gm1;
 }
 else{
  $gm1="";
 }

}// end img1


//end image manipulation

if($gm1==""){
  $gm1 = $img;
} 


$udate = date("Y-m-d");


$sql  = "update sliders " ;

$sql .= "set slider_img='$gm1' ,heading ='$heading',title='$title',details='$details',link = '$link' ,status = '$status',  ";

$sql .= " edate='$udate' where id='$sid'  limit 1";


$result = mysqli_query($GLOBALS['con'],$sql);

if($result){
  // echo $sql;
  echo "success";
}
else{
 // echo $sql;

  echo "failed";
}


}
else{

  echo "failed";

}

?>