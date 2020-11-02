<?php
include_once("include/header.php");
?> 
<style>

#uploadForm {border-top:#F0F0F0 2px solid;background:#FAF8F8;padding:10px;}
#uploadForm label {margin:2px; font-size:1em; font-weight:bold;}
.demoInputBox{padding:5px; border:#F0F0F0 1px solid; border-radius:4px; background-color:#FFF;}
#progress-bar {background-color: #12CC1A;height:20px;color: #FFFFFF;width:0%;-webkit-transition: width .3s;-moz-transition: width .3s;transition: width .3s;}
.btnSubmit{background-color:#09f;border:0;padding:10px 40px;color:#FFF;border:#F0F0F0 1px solid; border-radius:4px;}
#progress-div {border:#0FA015 1px solid;padding: 5px 0px;margin:30px 0px;border-radius:4px;text-align:center;}
#targetLayer{width:100%;text-align:center;}

</style>



<!-- Main content -->
<div class="app-main__inner">


    <div class="row">
      <div class="col-md-12">
        <div class="main-card mb-3 card">
          <div class="card-header">Notifications</div>
          <div class="card-body">
            

            <form id="PushNotification"  action="" method="post" enctype="multipart/form-data">




              <div class="position-relative row  form-group">
                <label for="name"  class="col-sm-2 col-form-label" >Notification title</label>
                <div class="col-sm-4">
                 <input type="text" required="true" name="title" class="form-control" id="title" placeholder="Title">
               </div>
             </div>

             <div class="position-relative row  form-group">
              <label for="cat_icon"  class="col-sm-2 col-form-label"  >Notification Body</label>
              <div class="col-sm-4">
               <input type="text" required="true" name="message" class="form-control" id="message" placeholder="Notification Body">
                
              </div>



                <div class="position-relative row form-check">
                  <div class="col-sm-4 offset-sm-2">

                   <button type="submit"    name="submit" class="btn btn-secondary">Submit</button>


                 </div>
               </div>


             </form>
          </div> 
            

          </div>
        </div>
      </div>
    </div><!--end row -->


  <div class="row">
    <div class="col-md-12">
      <div class="main-card mb-3 card">
        <div class="card-header">Notification List
         
        </div>

            <?php
          $sql_get_data ="select * from tbl_notification ";
      
      $result = mysqli_query($GLOBALS['con'],$sql_get_data);
      ?>



        <div class="table-responsive">
          <table class="align-middle mb-0 table table-borderless table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Notification Title</th>
                <th class="text-center">Notification Message</th>
                <th class="text-center">Message ID</th>
                <th class="text-center">Date</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0; while ($rs = mysqli_fetch_array($result)) { $i++;?>
                <tr>


                 <td class="text-muted text-center" >
                  <?php echo $i; ?>
                </td>
                <td class="text-center">
                  <?php echo $rs['title']; ?>
                </td>
               
                <td class="text-center">
                  <?php  echo $rs['message']; ?>
                </td>
                <td class="text-center">
                  <?php  echo $rs['message_id']; ?>
                </td>
                <td class="text-center">
                  <?php  echo $rs['edate']; ?>
                </td>

              </tr>
            <?php } ?> 
          </tbody>
            </table>
          </div>
     
        </div>
      </div>

     </div> 







</div> <!-- app inner main -->












<?php
include_once("include/footer.php");
?>
<script>
$(document).ready(function() { 
     $('#PushNotification').on('submit',function(event){
      event.preventDefault(); 
      console.log("hello");

       $.ajax({
            url:"send/send_to_all.php",
            method:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
           
            success:function(data)
            {   
                if(data==='failed'){
                    alert('Something went wrong');
                  //  console.log(data);

                }
                else{
                  //alert(data);
                   //console.log(data);
                   // $(".bd-example-modal-lg").modal('hide');
                //    $('#pdt').html('<span style="color:red;">Update success !! </span>');

                $('#PushNotification')[0].reset();

              $.alert({
              title: 'Notification Sent!',
              content: 'successfully !!',
              type: 'Green',
              typeAnimated: true
          
            });
                   // loadProductDetailsAdmin(data);
                 // $(".bd-example-modal-lg").modal('show');
                  //  $('#pdt').html('<span >Product Details </span>');
                }//end else
                

            }
        });

    });

});

</script>