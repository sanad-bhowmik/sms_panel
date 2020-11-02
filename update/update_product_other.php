<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 

if(isset($_POST['pid'])){

  $pid = $_POST['pid'];

  $productDetails = get_fetched_product_details_data_by_product_id($pid);
  
  $cat_id = $_POST['cat_id'];
  $sub_cat_id =$_POST['sub_cat_id'];
  $product_model =$_POST['product_model'];
  $product_price =$_POST['price'];
  $product_status =$_POST['product_status'];
  $short_des =$_POST['short_des'];
  $features =$_POST['features'];
  $gm1="";
  $gm2="";
  $gm3="";
  $gm4="";

//image manipulation


  if((isset($_FILES["gm1"]) && $_FILES["gm1"]["error"] == 0 ) )
  {
   $app_gm1_name = $_FILES["gm1"]["name"];
   $app_gm1_name = str_replace(' ', '',$app_gm1_name);

   $app_gm1_type = $_FILES["gm1"]["type"];
   $app_gm1_size = $_FILES["gm1"]["size"];
   $app_gm1      = $_FILES["gm1"]["tmp_name"];
   $app_gm1_mb   = $app_gm1_size/1024/1024;
   $app_gm1_mb   = $app_gm1_mb ." "."mb";
   $app_gm1_path = '../../resource/product/';


   if(file_exists($app_gm1_path.$app_gm1_name)){
    $gm1 = uniqid().time().$app_gm1_name;
  }else{
    $gm1 = uniqid().time().$app_gm1_name;
  }
  $gm1 =  str_replace(' ', '_', $gm1);
  if(move_uploaded_file($app_gm1,  $app_gm1_path.$gm1 )){

    if ( is_file('../../resource/product/'.$productDetails['img1']) ) {



     chmod ( '../../resource/product/'.$productDetails['img1'],0777);
    
     if(unlink ('../../resource/product/'.$productDetails['img1'])){

      $file = fopen("../log/unlink.txt","w");
      echo fwrite($file,'../../resource/product/'.$productDetails['img1']);
      fclose($file);

     }




   }

    //$upload_msg .="Gallery Image 1".$gm1;
 }
 else{
  $gm1="";
 }

}// end img1


if(isset($_FILES["gm2"]) && $_FILES["gm2"]["error"] == 0){

  $app_gm2_name = $_FILES["gm2"]["name"];
  $app_gm2_name = str_replace(' ', '',$app_gm2_name);
  $app_gm2_type = $_FILES["gm2"]["type"];
  $app_gm2_size = $_FILES["gm2"]["size"];
  $app_gm2      = $_FILES["gm2"]["tmp_name"];
  $app_gm2_mb   = $app_gm2_size/1024/1024;
  $app_gm2_mb   = $app_gm2_mb ." "."mb";
  $app_gm2_path = '../../resource/product/';

  if(file_exists($app_gm2_path.$app_gm2_name)){
    $gm2 =uniqid().time().$app_gm2_name;
  }
  else{
   $gm2 =uniqid().time().$app_gm2_name;
 }
 $gm2 =  str_replace(' ', '_', $gm2);
 if(move_uploaded_file($app_gm2,  $app_gm2_path.$gm2)){


  if ( is_file( '../../resource/product/' . $productDetails['img2'] ) ) {
   chmod ( '../../resource/product/' . $productDetails['img2'] ,0777 );
   unlink ( '../../resource/product/' . $productDetails['img2'] );

 }
 // $upload_msg .="Gallery Image 2".$app_gm2_name;
}
 else{
       // $upload_msg .=" Gallery Image 2 uploading failed ";
   $gm2="";
 }

}//end img2


if(isset($_FILES["gm3"]) && $_FILES["gm3"]["error"] == 0){

  $app_gm3_name = $_FILES["gm3"]["name"];
  $app_gm3_name = str_replace(' ', '',$app_gm3_name);
  $app_gm3_type = $_FILES["gm3"]["type"];
  $app_gm3_size = $_FILES["gm3"]["size"];
  $app_gm3      = $_FILES["gm3"]["tmp_name"];
  $app_gm3_mb   = $app_gm3_size/1024/1024;
  $app_gm3_mb   = $app_gm3_mb ." "."mb";
  $app_gm3_path = '../../resource/product/';

  if(file_exists($app_gm3_path.$app_gm3_name)){
    $gm3 =uniqid().time().$app_gm3_name;
  }
  else{
   $gm3 =uniqid().time().$app_gm3_name;
 }
 $gm3 =  str_replace(' ', '_', $gm3);
 if(move_uploaded_file($app_gm3,  $app_gm3_path.$gm3)){
  if ( is_file( '../../resource/product/' . $productDetails['img3'] ) ) {
   chmod ( '../../resource/product/' . $productDetails['img3'] , 0777 );
   unlink ( '../../resource/product/' . $productDetails['img3'] );
 }
 // $upload_msg .="Gallery Image 3".$app_gm3_name;
 }
 else{
 // $upload_msg .=" Gallery Image 3 uploading failed ";
  $gm3 ="";
 }

} // end img3

if(isset($_FILES["gm4"]) && $_FILES["gm4"]["error"] == 0){
  $app_gm4_name = $_FILES["gm4"]["name"];
  $app_gm4_name = str_replace(' ', '',$app_gm4_name);
  $app_gm4_type = $_FILES["gm4"]["type"];
  $app_gm4_size = $_FILES["gm4"]["size"];
  $app_gm4      = $_FILES["gm4"]["tmp_name"];
  $app_gm4_mb   = $app_gm4_size/1024/1024;
  $app_gm4_mb   = $app_gm4_mb ." "."mb";
  $app_gm4_path = '../../resource/product/';

  if(file_exists($app_gm4_path.$app_gm4_name)){
    $gm4 =uniqid().time().$app_gm4_name;
  }
  else{
   $gm4 =uniqid().time().$app_gm4_name;
 }
 $gm4 =  str_replace(' ', '_', $gm4);
 if(move_uploaded_file($app_gm4,  $app_gm4_path.$gm4)){

  if ( is_file( '../../resource/product/' . $productDetails['img4'] ) ) {
   chmod ( '../../resource/product/' . $productDetails['img4'] , 0777 );
   unlink ( '../../resource/product/' . $productDetails['img4'] );
  }
 // $upload_msg .="Gallery Image 4".$app_gm4_name;
 }
 else{
 // $upload_msg .=" Gallery Image 4 uploading failed ";

  $gm4 ="";
 }

}// end img4

//end image manipulation

if($gm1==""){
  $gm1 =$productDetails['img1'];
} 
if($gm2==""){
  $gm2 =$productDetails['img2'];
} 
if($gm3==""){
  $gm3 =$productDetails['img3'];
} 
if($gm3==""){
  $gm3 =$productDetails['img3'];
} 
if($gm4==""){
  $gm4 =$productDetails['img4'];
} 



$udate = date("Y-m-d H:i:s");
$user = $_SESSION['user'];

$sql  = "update products " ;

$sql .= "set cat_id='$cat_id' , sub_cat_id = '$sub_cat_id' ,model = '$product_model' ,price = '$product_price' , ";
$sql .= "product_status='$product_status' , short_description = '$short_des' ,features = '$features' , ";
$sql .= "img1='$gm1' , img2 = '$gm2' ,img3= '$gm3' , img4 ='$gm4' , ";
$sql .= "updated_date='$udate' , updated_by ='$user' where id='$pid'  limit 1";


$result = mysqli_query($GLOBALS['con'],$sql);

if($result){
  echo $pid;
}
else{
  //echo $sql;

  echo "Error!!";
}


}
else{

  echo "failed";

}

?>