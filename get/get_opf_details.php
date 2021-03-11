<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");

					

					
if(isset($_POST['id'])){

    $Id = $_POST['id'];
    $Details = get_opf_details_fetched($Id);
  
  
  
  
    $output   ='<div class="modal-body ">';



    $output .='<div class="row">
    <div class="col-md-12">
    
    <input id="oid" type="hidden" name="oid" value="'.$Details['OID'].'">

    <input class="form-control" type="text" name="name" value="'.$Details['Professional'].'">
    
    </div>
    
    </div>';
    $output .='</div>'; 


    echo $output;




}






 ?>