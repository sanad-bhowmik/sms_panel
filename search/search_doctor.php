<?php
require_once("../include/dbcon.php");



if(isset($_POST['query'])){


$text = $_POST['query'];

$sql  = "select *,CONCAT(DOCID,':',DocName) as oid_name from tbl_doctor where DocName like '%$text%' and Active ='1' ";
$result = mysqli_query($GLOBALS['con'],$sql);

$output='';
if(mysqli_num_rows($result)>0){
    $output.='<ul style="margin-left:-45px;">';
    while($res=mysqli_fetch_assoc($result)){

    
    $output.='<li class="list-group-item list-group-item-action dn">'.$res['oid_name'].'</li>';
  }
     $output.='</ul>';
  }
else{

    $output.='<p class="list-group-item list-group-item-action">No Result</p>';

}
echo $output;
}

?>