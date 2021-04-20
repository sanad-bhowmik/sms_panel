<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");

					

					
if(isset($_POST['id'])){

    $Id = $_POST['id'];
    $Details = get_special_details_fetched($Id);
  
  
  
  
    $output   ='<div class="modal-body ">';



    $output .='<div class="row">
    <div class="col-md-12">
    
    <input id="oid" type="hidden" name="oid" value="'.$Details['OID'].'">

    <input class="form-control" type="text" name="name" value="'.$Details['Specialization'].'">
    
    </div>
    
    </div> <hr>';
    $output .= '<div class="col-md-12">
   
    <input type="hidden" name="simg" id="sid"  value="'.$Details['ImagePath'].'">
    <img width="300px" style="border: 1px solid black;"  id="g1"  height="300px" src="'.$Details['ImagePath'].'" alt=" No Image">
    <input type="file" name="gm1" onchange="readURL(this)" accept="image/*"  id="gm1"> Suitable
  
  
    </div>
    </div>
  
    <hr>
    ';





    $output .='</div>'; 


    echo $output;




}






 ?>