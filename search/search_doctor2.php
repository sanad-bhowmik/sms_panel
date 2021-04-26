<?php
require_once("../include/dbcon.php");



if(isset($_POST['id'])){


$id = $_POST['id'];

$sql  = "select *  from tbl_doctor where DOCID  ='$id' and Active ='1' ";
$result = mysqli_query($GLOBALS['con'],$sql);

$output;
if(mysqli_num_rows($result)>0){
   
    $res=mysqli_fetch_assoc($result);

   $output= json_encode($res);
  }
else{

    $output="";

}
echo $output;
}

?>