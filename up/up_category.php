<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");
date_default_timezone_set("Asia/Dhaka"); 




if(isset($_FILES["cat_icon"]) && $_FILES["cat_icon"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["cat_icon"]["name"];
        $filetype = $_FILES["cat_icon"]["type"];
        $filesize = $_FILES["cat_icon"]["size"];
        $file = $_FILES['cat_icon']['tmp_name'];
        $name = $_FILES['cat_icon']['name'];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file

          $path = 'imgs/cat_img/';
         $fullpath =$path.$filename;
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists($path . $filename)){
                echo $filename . " is already exists.";
            } else{
                

                if(move_uploaded_file($file, $fullpath)){


                  $cat_name  = trim($_POST['name']);

                  $date = date("Y-m-d H:i:s");

                  $sql  = " INSERT INTO category (cat_name,icon,datetime) values('$cat_name','$fullpath','$date') ";

                  $result = mysql_query($sql);

                  if($result){
                     echo  "Your file was uploaded successfully.";

                 }
                 else{
                    echo  " upload unuccessful.";
              }



                }







               
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
        echo "Error: " . $_FILES["cat_icon"]["error"];
    }


?>