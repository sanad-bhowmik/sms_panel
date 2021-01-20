<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['doc_id'])){

  $docId = $_POST['doc_id'];
  $docDetails = get_fetched_doctor_details_data_by_doc_id($docId);



  $docDayTime = json_decode($docDetails['JsonTime']);

 //var_dump($docDayTime);
/*  if(isset($docDayTime->Sunday)){

  echo "string";
 };
  die;
*/



  $output   ='<div class="modal-body ">';







  $output .='<div class="row">

  <input type="hidden" id="docid" name="docID" value="'.$docDetails['DOCID'].'">
 


  </div>
  ';



  $output .=' <div class="row  form-group">

  <div class="col-sm-3">


  Hospital:  <input type="text" required="" value="'.$docDetails['HospitalID'].'"" class="form-control" name="docHospital">

  </div>




  <div class="col-sm-3">
  DocType: <select  id="DocType" class="form-control" name="DocType" >';



  $output3 ='';
  $result4 = get_all_docType();
  
  while ($values=mysqli_fetch_array($result4)) {

    if($docDetails['DocType']==$values['docType']){

      $output3 .="<option selected value='".$values['docType']."'>".$values['docTypeName']."</option>";

    }else{

      $output3 .="<option  value='".$values['docType']."'>".$values['docTypeName']."</option>";
    }




  }
  $output .=$output3; 

  $output .='</select>

  </div>




  <div class="col-sm-3">


  Speciality:  <select  id="speciality" class="form-control selectpicker" name="speciality[]" multiple data-live-search="true">
  <option value="">--Speciality--</option>

  </select>



  </div>

  <div class="col-sm-3">
  General Practice:  <input class="form-control"  id="gen_prac" type="text" readonly="true"  name="gen_prac" value="'.$docDetails['Gen_Prac'].'" value="Y">

  </div>






  </div>

  <div class="row  form-group p-t-10">
  <div class="col-sm-2">    

  Doctor Name:  <input class="form-control" required="" value="'.$docDetails['DocName'].'"  type="text" name="docName"  id="docName">



  </div>
  <div class="col-sm-2">    

  BMDC REG:  <input class="form-control" value="'.$docDetails['BmdcReg'].'" type="text" name="bmdcReg"  id="bmdcReg">



  </div>
  <div class="col-sm-2">    

  Doctor Degree: <input class="form-control" value="'.$docDetails['DocDegree'].'" required=""  type="text" name="docDegree"  id="docDegree">




  </div>
  <div class="col-sm-2">    

  Doctor Payment: <input class="form-control" value="'.$docDetails['Payment'].'" min="0"  type="number" name="docPayment"  id="docpayment">




  </div>
  <div class="col-sm-2">    

  Report Show Fee: <input class="form-control" value="'.$docDetails['report_showing_payment'].'" min="0"  type="number" name="report_showing_payment"  id="report_showing_payment">




  </div>
  <div class="col-sm-2">    

  FollowUp Fee: <input class="form-control" value="'.$docDetails['followup_payment'].'" min="0"  type="number" name="followup_payment"  id="followup_payment">




  </div>


  </div>


  <div class="row  form-group p-t-10">
  <div class="col-sm-3">    

  Doctor Mobile (Login):  <input required="" value="'.$docDetails['MobileNum'].'"  class="form-control"  type="text" name="docNumber"  id="docNumber">



  </div>
  <div class="col-sm-3">    

  Doctor Password: <input class="form-control" value="'.$docDetails['Password'].'" required=""  type="text" name="docPass"  id="docPass">



  </div>
  <div class="col-sm-3">    

  Doctor Address: <textarea id="docAddress" value="'.$docDetails['DocAddress'].'" class="form-control" name="docAddress" cols="35" rows="1"></textarea>




  </div>
  <div class="col-sm-3">    

  Doctor Remarks: <input class="form-control" value="'.$docDetails['Remarks'].'"   type="text" name="docRemarks"  id="docRemarks">




  </div>


  </div>
  <div class="row  form-group p-t-10">


  <div class="col-sm-3">
  Other Professional: <select   name="op[]" id="op" class="form-control selectpicker" multiple data-live-search="true" >';

  $output3 ='';
  $opfid  =explode(",",$docDetails['OtherPfID']);
  $result4 = get_all_op();
  while ($values=mysqli_fetch_array($result4)) {

    if(in_array($values['OID'], $opfid)) {
      $output3 .="<option selected value='".$values['OID']."'>".strtoupper($values['Professional'])."</option>";
    }
    else{
      $output3 .="<option  value='".$values['OID']."'>".strtoupper($values['Professional'])."</option>";
    }


  }
  $output .=$output3; 

  $output .='</select> 

  </div>
  <div class="col-sm-3">
  Gender: <select  name="gender" id="gender" class="form-control" >';

  if($docDetails['Gender']=='Male'){

    $output .=' <option selected value="Male">Male</option>
    <option value="Female">Female</option>';
  }else{
    $output .=' <option value="Male">Male</option>
    <option selected  value="Female">Female</option>';
  }


  $output .='<option value="Others">Others</option> </select> 

  </div>
  <div class="col-sm-3">
  Date Of Birth: <input required type="date" value="'.$docDetails['DOB'].'" class="form-control" name="dob">
  </div>

  <div class="col-sm-3">
  Email: <input type="email" class="form-control"  value="'.$docDetails['Email'].'" name="email">
  </div>






  </div>';


  $output .='<div class="row">



  <div class="col-sm-4"> 
  <div class="input-group mb-2">
  <div class="input-group-prepend">
  <div class="input-group-text">';
  $checked="";
  if(isset($docDayTime->Saturday)){
    $checked="checked";
  }
  $output .=' <input type="checkbox" '. $checked.' id="Saturday" name="saturday[day]" value="Saturday">
  <label for="Saturday"> &nbsp; Saturday</label></div>
  </div>
  <select  id="st2"  name="saturday[st]" class="st" >';


  $output .='<option value="">Start Time</option>';
  $result2 = get_times();
  while ($values=mysqli_fetch_array($result2)) {

   if(isset($docDayTime->Saturday)){
    $selected="";

    if(strtotime($docDayTime->Saturday->StartTime)==strtotime($values['time'])){

      $selected="selected";
    } 
    $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

  };
}

$output .=' </select> 

<select id="et2"  name="saturday[et]" class="et" >';


$output .='<option value="">End Time</option>';
$result2 =get_times();
while ($values=mysqli_fetch_array($result2)) {

 if(isset($docDayTime->Saturday)){
  $selected="";

  if(strtotime($docDayTime->Saturday->EndTime)==strtotime($values['time'])){

    $selected="selected";
  } 
  $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

}

}

$output .=' </select>
</div>
</div>

<div class="col-sm-4"> 


<div class="input-group mb-2">
<div class="input-group-prepend">
<div class="input-group-text">';
$checked="";
if(isset($docDayTime->Sunday)){
  $checked="checked";
}
$output .='<input type="checkbox" '. $checked.' id="Sunday" name="sunday[day]" value="Sunday">
<label for="Sunday">&nbsp;Sunday</label>
</div>
</div>





<select  id="st3"  name="sunday[st]" class="st" >';


$output .='<option value="">Start Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

  if(isset($docDayTime->Sunday)){
    $selected="";

    if(strtotime($docDayTime->Sunday->StartTime)==strtotime($values['time'])){

      $selected="selected";
    } 
    $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

  }

}

$output .='</select> 


<select  id="et3"  name="sunday[et]" class="et" >';

$output .='<option value="">End Time</option>';
$result2 =get_times();
while ($values=mysqli_fetch_array($result2)) {

  if(isset($docDayTime->Sunday)){
    $selected="";

    if(strtotime($docDayTime->Sunday->EndTime)==strtotime($values['time'])){

      $selected="selected";
    } 
    $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

  }
}

$output .=' </select>

</div>
</div>

<div class="col-sm-4"> 
<div class="input-group mb-2">
<div class="input-group-prepend">
<div class="input-group-text">';
$checked="";
if(isset($docDayTime->Monday)){
  $checked="checked";
}
$output .='<input '.$checked.'  type="checkbox" id="Monday" name="monday[day]" value="Monday">
<label for="Monday">&nbsp;Monday</label>
</div>
</div>



<select  id="st4" name="monday[st]" class="st" >';


$output .='<option value="">Start Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {
  if(isset($docDayTime->Monday)){
    $selected="";

    if(strtotime($docDayTime->Monday->StartTime)==strtotime($values['time'])){

      $selected="selected";
    } 
    $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

  }

}

$output .='  </select> 
<select  id="et4" name="monday[et]" class="et" >';


$output .='<option value="">End Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

 if(isset($docDayTime->Monday)){
  $selected="";

  if(strtotime($docDayTime->Monday->EndTime)==strtotime($values['time'])){

    $selected="selected";
  } 
  $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

}
}

$output .='  </select>
</div>
</div>
</div>';

$output .='<div class="row form-group">


<div class="col-sm-4"> 
<div class="input-group mb-2">
<div class="input-group-prepend">
<div class="input-group-text">';
$checked="";
if(isset($docDayTime->Tuesday)){
  $checked="checked";
}
$output .='<input '.$checked.'  type="checkbox" id="Tuesday" name="tuesday[day]" value="Tuesday">
<label for="Tuesday">Tuesday&nbsp;</label>
</div>
</div>




<select  id="st5" name="tuesday[st]" class="st" >';


$output .='<option value="">Start Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

  if(isset($docDayTime->Tuesday)){
    $selected="";

    if(strtotime($docDayTime->Tuesday->StartTime)==strtotime($values['time'])){

      $selected="selected";
    } 
    $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

  }
}

$output .='  </select> 
<select  id="et5" name="tuesday[et]" class="et" >';


$output .='<option value="">End Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {
 if(isset($docDayTime->Tuesday)){
  $selected="";

  if(strtotime($docDayTime->Tuesday->EndTime)==strtotime($values['time'])){

    $selected="selected";
  } 
  $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

}

}

$output .=' </select>

</div>
</div>


<div class="col-sm-4"> 
<div class="input-group mb-2">
<div class="input-group-prepend">
<div class="input-group-text">';
$checked="";
if(isset($docDayTime->Wednesday)){
  $checked="checked";
}
$output .='<input  '.$checked.' type="checkbox" id="Wednesday" name="wednesday[day]" value="Wednesday">
<label for="Wednesday">Wednesday</label>
</div>
</div>


<select id="st6" name="wednesday[st]" class="st" >';


$output .='<option value="">Start Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

  if(isset($docDayTime->Wednesday)){
    $selected="";

    if(strtotime($docDayTime->Wednesday->StartTime)==strtotime($values['time'])){

      $selected="selected";
    } 
    $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

  }

}

$output .='</select> 
<select   id="st6" name="wednesday[et]" class="et" >';


$output .='<option value="">End Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

 if(isset($docDayTime->Wednesday)){
  $selected="";

  if(strtotime($docDayTime->Wednesday->EndTime)==strtotime($values['time'])){

    $selected="selected";
  } 
  $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

}
}

$output .='</select>
</div>
</div>


<div class="col-sm-4"> 
<div class="input-group mb-2">
<div class="input-group-prepend">
<div class="input-group-text">';
$checked="";
if(isset($docDayTime->Thursday)){
  $checked="checked";
}
$output .='<input  '.$checked.' type="checkbox" id="Thursday" name="thursday[day]" value="Thursday">
<label for="Thursday">Thursday</label>
</div>
</div>



<select  id="st7" name="thursday[st]" class="st" >';

$output .='<option value="">Start Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

  if(isset($docDayTime->Thursday)){
    $selected="";

    if(strtotime($docDayTime->Thursday->StartTime)==strtotime($values['time'])){

      $selected="selected";
    } 
    $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

  }
  
}

$output .='</select> 
<select id="et7" name="thursday[et]" class="et" >';


$output .='<option value="">End Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

 if(isset($docDayTime->Thursday)){
  $selected="";

  if(strtotime($docDayTime->Thursday->EndTime)==strtotime($values['time'])){

    $selected="selected";
  } 
  $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

}
}

$output .='</select>
</div>
</div>



<div class="col-sm-4"> 
<div class="input-group mb-2">
<div class="input-group-prepend">
<div class="input-group-text">';
$checked="";
if(isset($docDayTime->Friday)){
  $checked="checked";
}
$output .='<input  '.$checked.'  type="checkbox" id="Friday" name="friday[day]" value="Friday">
<label for="Friday">Friday&nbsp;&nbsp;&nbsp;&nbsp;</label>
</div>
</div>


<select id="st8" name="friday[st]" class="st" >';


$output  .='<option value="">Start Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

 if(isset($docDayTime->Friday)){
  $selected="";

  if(strtotime($docDayTime->Friday->StartTime)==strtotime($values['time'])){

    $selected="selected";
  } 
  $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

}

}

$output .='</select> 
<select   id="et8" name="friday[et]" class="et" >';


$output .='<option value="">End Time</option>';
$result2 = get_times();
while ($values=mysqli_fetch_array($result2)) {

 if(isset($docDayTime->Friday)){
  $selected="";

  if(strtotime($docDayTime->Friday->EndTime)==strtotime($values['time'])){

    $selected="selected";
  } 
  $output .="<option  ".$selected." value='".$values['time']."'>".strtoupper($values['12hr_time'])."</option>";

}

}

$output .='</select>


</div>
</div>


</div>';


$output .='<hr><div class="row">

<div class="col-md-6">
Profile: <img width="150px" class="myImg" style="border: 1px solid black;"  id="g1"  height="130px" src="'.$docDetails['DocImage'].'" alt=" No Image">
<input type="file" name="gm1" onchange="readURL(this)" accept="image/*"  id="gm1">
</div>
<div class="col-md-6">
Signature: <img width="150px"style="border: 1px solid black;"  id="g2" class="myImg"  height="130px" src="'.$docDetails['DocSignature'].'" alt=" No Image">
<input type="file" name="gm2" onchange="readURL(this)" accept="image/*"  id="gm2">

</div>



</div>
<hr>
';





$output .='</div>'; 

$output .='
<div id="myImgModal" class="ImgModal">
<span class="Imgclose">&times;</span>
<img class="img-modal-content" src="" id="img01">
<div id="caption"></div>
</div>






';
$output .='

<script>

$(document).ready(function(){


 $("#Saturday").click(function(){
  console.log("saturday");
  this.checked ? $("#st2").prop("required", true) : $("#st2").prop("required", false);
  this.checked ? $("#et2").prop("required", true) : $("#et2").prop("required", false);
// this.checked ? $("#et2").attr("required",1) : $("#et2").attr("required",0);
//console.log($("#st2"));
  });
  $("#Sunday").click(function(){
    this.checked ? $("#st3").prop("required", true) : $("#st3").prop("required", false);
    this.checked ? $("#et3").prop("required", true) : $("#et3").prop("required", false);
// this.checked ? $("#et2").attr("required",1) : $("#et2").attr("required",0);
//console.log($("#st2"));
    });
    $("#Monday").click(function(){
      this.checked ? $("#st4").prop("required", true) : $("#st4").prop("required", false);
      this.checked ? $("#et4").prop("required", true) : $("#et4").prop("required", false);
// this.checked ? $("#et2").attr("required",1) : $("#et2").attr("required",0);
//console.log($("#st2"));
      });
      $("#Tuesday").click(function(){
        this.checked ? $("#st5").prop("required", true) : $("#st5").prop("required", false);
        this.checked ? $("#et5").prop("required", true) : $("#et5").prop("required", false);
// this.checked ? $("#et2").attr("required",1) : $("#et2").attr("required",0);
//console.log($("#st2"));
        });
        $("#Wednesday").click(function(){
          this.checked ? $("#st6").prop("required", true) : $("#st6").prop("required", false);
          this.checked ? $("#et6").prop("required", true) : $("#et6").prop("required", false);
// this.checked ? $("#et2").attr("required",1) : $("#et2").attr("required",0);
//console.log($("#st2"));
          });
          $("#Thursday").click(function(){
            this.checked ? $("#st7").prop("required", true) : $("#st7").prop("required", false);
            this.checked ? $("#et7").prop("required", true) : $("#et7").prop("required", false);
// this.checked ? $("#et2").attr("required",1) : $("#et2").attr("required",0);
//console.log($("#st2"));
            });
            $("#Friday").click(function(){
              this.checked ? $("#st8").prop("required", true) : $("#st8").prop("required", false);
              this.checked ? $("#et8").prop("required", true) : $("#et8").prop("required", false);
// this.checked ? $("#et2").attr("required",1) : $("#et2").attr("required",0);
//console.log($("#st2"));
              });

  //=========================================

              if($("#DocType").val()=="Specialist"){

                $.ajax({
                  url:"get/get_speciality_edit.php?docID='.$docDetails['DOCID'].'",

                  type:"GET",
                  success:function(response) {
           // console.log(response);
                   var resp = $.trim(response);
                   $("#speciality").html(resp);
                 }
                 });

               }

               $("#DocType").change(function() {


   // console.log("1");
                 var sub = $(this).val();
                 if(sub =="Specialist") {

                  $("#gen_prac").val("N");

                  $.ajax({

                    url:"get/get_speciality_edit.php?docID='.$docDetails['DOCID'].'",

                    type:"GET",
                    success:function(response) {
           // console.log(response);
                     var resp = $.trim(response);
                     $("#speciality").html(resp);
                   }
                   });
                 }
                 else if(sub =="General Practitioner"){

                  $("#speciality").html("<option >--Speciality--</option>");
                  $("#gen_prac").val("Y");




                }
                else{

                  $("#speciality").html("<option >--Speciality--</option>");
                  $("#gen_prac").val("N");
                }




                });







//======================================

                });// end document ready














                </script>
                ';




                echo $output;

              }
              else{

                echo " Somthing went wrong !!";

              }

              ?>

