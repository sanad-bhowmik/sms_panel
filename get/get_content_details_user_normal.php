<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['content_id'])){

  $contentId = $_POST['content_id'];

  //update_to_seen_by_id($contentId);


  $contentDetails = get_fetched_content_details_data_by_content_id($contentId);




  $output   ='<div class="modal-body">';
  $output .='<div class="row ">
 
  <div class="col-md-4">
Publisher Company : '.$contentDetails['company_name'].' 

</div>
<div class="col-md-4">
Uploader : '.$contentDetails['first_name'].' '.$contentDetails['last_name'].' 
</div>
<div class="col-md-4">
Upload On : '.$contentDetails['upload_date'].' 
</div>

  ';

  $output .='</div><hr>';


$output .='<input type="hidden"  id="aid"  name="aid" value="'.$contentDetails['app_id'].'"  >';

$output .='<div class="row ">
 
  <div class="col-md-3">
Content Title : <input type="text" required  readonly   id="title"  name="title" value="'.$contentDetails['title'].'"  >

</div>

<div class="col-md-3">
Description: <input type="text" required  readonly   id="des"  name="des" value="'.$contentDetails['description'].'"  >  
</div>



<div class="col-md-3">
Category:  <select required disabled  id="cat_id" name="cat_id">  <option value="">------Select------</option>            ';

    
    foreach($categorys =get_all_category() as $cat ){
      $selected = ($cat['id']==$contentDetails['cat_id']) ? "selected":"";

      $output .='<option '.$selected.' value="'.$cat['id'].'">'.$cat['cat_name'].'</option>';

        }



$output .='</select>






</div>

<div class="col-md-3">
Content Price : 
 <select disabled    required id="price_id" name="price_id">  <option value="">------Select------</option>            ';

    
    foreach($prices =get_all_price() as $price ){
      $selected = ($price['id']==$contentDetails['price_id']) ? "selected":"";

      $output .='<option '.$selected.' value="'.$price['id'].'">'.$price['price_name']." : ".$price['price'].'</option>';

        }



$output .='</select>



</div>';


  $output .='</div><hr>';  



$output .='<div class="row ">
 
  <div class="col-md-3">
File Name: '.$contentDetails['file_name'].' 

</div>

<div class="col-md-3">
File Size: '.$contentDetails['size'].' 
</div>

<div class="col-md-3">
Content Link : <a href="'.$contentDetails['file_path'].'"><span class="blinking">Click Here </span></a>
</div>

<div class="col-md-3">
Status : '.$contentDetails['approve_status'].'
</div>

  ';
  $output .='</div><hr>'; 

  $output .='<div class="row">';

  $output .='<div class="col-md-4">
   Icon: <img class="myImg" width="80%" height="100px" style="border: 1px solid black;"  id="g1"  height="130px" src="'.$contentDetails['app_icon'].'" alt=" No Image">
    </div>

<div class="col-md-4">
    <input  accept="image/*" name="ai" type="hidden" id="gi">
 </div> 

          <div class="col-md-4">
            <input type="hidden" name="app_file" class="custom-file-input" id="gameFile" accept=".apk">
                        


          </div>';

  $output .='</div> <hr>' ;



$output .='<div class="row">

<div class="col-md-3">
Img 1 <img class="myImg" width="150px" style="border: 1px solid black;"  id="g1"  height="130px" src="'.$contentDetails['gallery_img1'].'" alt=" No Image">
<input  type="hidden" name="gm1" onchange="readURL(this)" accept="image/*"  id="gm1">
</div>
<div class="col-md-3">
Img 2 <img class="myImg"  width="150px"style="border: 1px solid black;"  id="g2"  height="130px" src="'.$contentDetails['gallery_img2'].'" alt=" No Image">
<input  type="hidden" name="gm2" onchange="readURL(this)" accept="image/*"  id="gm2">

</div>
<div class="col-md-3">
Img 3  <img class="myImg"  width="150px"style="border: 1px solid black;"  id="g3"  height="130px" src="'.$contentDetails['gallery_img3'].'" alt=" No Image">
<input type="hidden" name="gm3" onchange="readURL(this)" accept="image/*"  id="gm3">
</div>

<div class="col-md-3">
Img 4 <img class="myImg"  width="150px"style="border: 1px solid black;"  id="g4"  height="130px" src="'.$contentDetails['gallery_img4'].'" alt=" No Image">
<input type="hidden" name="gm4" onchange="readURL(this)" accept="image/*"  id="gm4">
</div>


</div>
<hr>
';

$output .='<div class="row">

  <div class="col-md-3">
       Approved By: '.$contentDetails['approve_by'].'

  </div>
  <div class="col-md-3">
        Approve Date: '.$contentDetails['approve_date'].'

  </div>
      <div class="col-md-3">
        Admin Remarks:  '.trim($contentDetails['admin_remarks']).'
       

  </div>
    <div class="col-md-3">
        User Remarks: <textarea id="remarks" readonly   rows="1" cols="20"   name="user_remarks">

            '.trim($contentDetails['user_remarks']).'
        </textarea>

  </div>

</div>';




$output .='</div>'; 

$output .='
<div id="myImgModal" class="ImgModal">
  <span class="Imgclose">&times;</span>
  <img class="img-modal-content" src="" id="img01">
  <div id="caption"></div>
</div>






';




      echo $output;

}
else{

  echo " Somthing went wrong !!";

}

?>

