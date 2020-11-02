<?php

session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 



if((isset($_FILES["app_file"]) && $_FILES["app_file"]["error"] == 0)  && (isset($_FILES["ai"]) && $_FILES["ai"]["error"] == 0)  && (isset($_FILES["gm1"]) && $_FILES["gm1"]["error"] == 0 ) )
  {
      $gm1="";
      $gm2="";
      $gm3="";
      $gm4="";
      $ai="";
      $appUp="";
      $gallery='applications/gallery/';

      $upload_msg ="";


      // app moviung ================
      $app_file_name = $_FILES["app_file"]["name"];


      $app_file_name = str_replace(' ', '',$app_file_name);

      $app_file_type = $_FILES["app_file"]["type"];
      $app_file_size = $_FILES["app_file"]["size"];
      $app_file      = $_FILES["app_file"]["tmp_name"];
      $app_file_mb   = number_format(($app_file_size/1024/1024), 2);
      $app_file_mb   = $app_file_mb ." "."mb";
      $app_file_path = '../applications/apk/';


      if(file_exists($app_file_path.$app_file_name)){

        $appUp = uniqid().time().$app_file_name;
      
      }else{
        $appUp = uniqid().time().$app_file_name;
      }
       $appUp =  str_replace(' ', '_', $appUp);

      if(move_uploaded_file($app_file,$app_file_path.$appUp)){

       $upload_msg .="-App  ".$appUp;
      }
      else{
        $upload_msg .=" -App  uploading failed ";
      }


      $appUp= 'applications/apk/'.$appUp;
      $app_size  =$app_file_mb;






      //==================app icon 
     
      $app_icon_name = $_FILES["ai"]["name"];
      $app_icon_name = str_replace(' ', '', $app_icon_name);

      $app_icon_type = $_FILES["ai"]["type"];
      $app_icon_size = $_FILES["ai"]["size"];
      $app_icon      = $_FILES["ai"]["tmp_name"];
      $app_icon_mb   = $app_icon_size/1024/1024;
      $app_icon_mb   = $app_icon_mb ." "."mb";
      $app_icon_path = '../applications/icon/';
     
      
      if(file_exists($app_icon_path.$app_icon_name)){
        $ai = uniqid().time().$app_icon_name;
      }else{
        $ai = uniqid().time().$app_icon_name;
      }
       $ai =  str_replace(' ', '_', $ai);

      if(move_uploaded_file($app_icon,$app_icon_path.$ai)){

       $upload_msg .="-App Icon ".$ai;
      }
      else{
        $upload_msg .=" -App Icon uploading failed ";
      }


      $ai= 'applications/icon/'.$ai;



//=================================ai end





      // gallary image 1=============================

      $app_gm1_name = $_FILES["gm1"]["name"];
      $app_gm1_type = $_FILES["gm1"]["type"];
      $app_gm1_size = $_FILES["gm1"]["size"];
      $app_gm1      = $_FILES["gm1"]["tmp_name"];
      $app_gm1_mb   = $app_gm1_size/1024/1024;
      $app_gm1_mb   = $app_gm1_mb ." "."mb";
      $app_gm1_path = '../applications/gallery/';

    
      if(file_exists($app_gm1_path.$app_gm1_name)){
        $gm1 = uniqid().time().$app_gm1_name;
      }else{
        $gm1 = uniqid().time().$app_gm1_name;
      }
       $gm1 =  str_replace(' ', '_', $gm1);

      if(move_uploaded_file($app_gm1,  $app_gm1_path.$gm1 )){

       $upload_msg .="-Gallery Image 1".$gm1;
      }
      else{
        $upload_msg .=" -Gallery Image 1 uploading failed ";
      }


      $gm1 = $gallery.$gm1;

    

//============================================================



      if(isset($_FILES["gm2"]) && $_FILES["gm2"]["error"] == 0){

      $app_gm2_name = $_FILES["gm2"]["name"];
      $app_gm2_name = str_replace(' ', '',$app_gm2_name);
      $app_gm2_type = $_FILES["gm2"]["type"];
      $app_gm2_size = $_FILES["gm2"]["size"];
      $app_gm2      = $_FILES["gm2"]["tmp_name"];
      $app_gm2_mb   = $app_gm2_size/1024/1024;
      $app_gm2_mb   = $app_gm2_mb ." "."mb";
      $app_gm2_path = '../applications/gallery/';


      if(file_exists($app_gm2_path.$app_gm2_name)){
        $gm2 = time().$app_gm2_name;
      }else{
        $gm2 = time().$app_gm2_name;
      }
       $gm2 =  str_replace(' ', '_', $gm2);

      if(move_uploaded_file($app_gm2,  $app_gm2_path.$gm2 )){

       $upload_msg .="-Gallery Image 2".$gm2;
      }
      else{
        $upload_msg .=" -Gallery Image 2 uploading failed ";
      }


      $gm2 =$gallery.$gm2;




      }// end is set

      //gallary 3===========================

      if(isset($_FILES["gm3"]) && $_FILES["gm3"]["error"] == 0){

      $app_gm3_name = $_FILES["gm3"]["name"];
      $app_gm3_name = str_replace(' ', '',$app_gm3_name);
      $app_gm3_type = $_FILES["gm3"]["type"];
      $app_gm3_size = $_FILES["gm3"]["size"];
      $app_gm3      = $_FILES["gm3"]["tmp_name"];
      $app_gm3_mb   = $app_gm3_size/1024/1024;
      $app_gm3_mb   = $app_gm3_mb ." "."mb";
      $app_gm3_path = '../applications/gallery/';



      if(file_exists($app_gm3_path.$app_gm3_name)){
        $gm3 = uniqid().time().$app_gm3_name;
      }else{
        $gm3 = uniqid().time().$app_gm3_name;
      }
       $gm3 =  str_replace(' ', '_', $gm3);

      if(move_uploaded_file($app_gm3,  $app_gm3_path.$gm3 )){

       $upload_msg .="-Gallery Image 3".$gm3;
      }
      else{
        $upload_msg .=" -Gallery Image 3 uploading failed ";
      }


      $gm3 = $gallery.$gm3;

      }// end is set 3

      if(isset($_FILES["gm4"]) && $_FILES["gm4"]["error"] == 0){

      $app_gm4_name = $_FILES["gm4"]["name"];
      $app_gm4_name = str_replace(' ', '',$app_gm4_name);

      $app_gm4_type = $_FILES["gm4"]["type"];
      $app_gm4_size = $_FILES["gm4"]["size"];
      $app_gm4      = $_FILES["gm4"]["tmp_name"];
      $app_gm4_mb   = $app_gm4_size/1024/1024;
      $app_gm4_mb   = $app_gm4_mb ." "."mb";
      $app_gm4_path = '../applications/gallery/';


     if(file_exists($app_gm4_path.$app_gm4_name)){
        $gm4 = uniqid().time().$app_gm4_name;
      }else{
        $gm4 = uniqid().time().$app_gm4_name;
      }
       $gm4 =  str_replace(' ', '_', $gm4);

      if(move_uploaded_file($app_gm4,  $app_gm4_path.$gm4 )){

       $upload_msg .="-Gallery Image 4".$gm4;
      }
      else{
        $upload_msg .=" -Gallery Image 4 uploading failed ";
      }


      $gm4 =$gallery.$gm4;

      }//end is set 4

      $app_name="";
      $app_description="";
      $app_category="";
      $app_home_category="";
      $app_price ="";
      
      $date = date("Y-m-d H:i:s");

      if(isset($_POST['app_name'])){
         $app_name=$_POST['app_name'];
      }
      if(isset($_POST['cat_id'])){
         $app_category=$_POST['cat_id'];
      }
      if(isset($_POST['cat_id'])){
         $app_category=$_POST['cat_id'];
      }
      if(isset($_POST['home_cat_id'])){
         $app_home_category=$_POST['home_cat_id'];
      }
      if(isset($_POST['price_id'])){
         $app_price= $_POST['price_id'];
      }
      if(isset($_POST['description'])){
         $app_description = mysqli_real_escape_string($GLOBALS['con'], $_POST['description']) ;
      }
      
      $user_id = $_SESSION['user_id'];
      $company_id = $_SESSION['company_id'];
  
      
      $price_value = get_price_by_id($app_price);
      $sql  = " INSERT INTO applications ";
      $sql .= "(cat_id,user_id,company_id,home_cat_id,file_name,file_path,size,title,icon,gallery_img1,gallery_img2,gallery_img3,gallery_img4,description,price,price_id,datetime) ";

      $sql .=" values('$app_category','$user_id','$company_id','0','$app_file_name','$appUp','$app_size','$app_name','$ai','$gm1','$gm2','$gm3','$gm4','$app_description','$price_value','$app_price','$date') ";

      $result = mysqli_query($GLOBALS['con'],$sql);

                  if($result){
                     echo "Data Added & " .$upload_msg ."---ALL success !!";

                 }
                 else{
                    echo   "Data Added failed & " .$upload_msg.'---';
              }
     // Verify MYME type of the file
       // uniqid() .
      
  






  }

    else{
        echo "Error: File: ".  $_FILES["app_file"]["error"]." APP Icon". $_FILES["ai"]["error"]    ;
    }


?>