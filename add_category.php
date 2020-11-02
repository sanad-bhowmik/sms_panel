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
<script>
$(document).ready(function() { 
    $('#uploadForm').submit(function(e) { 


        if($('#cat_icon').val()) {

            e.preventDefault();
            $('#loader-icon').show();
            $(this).ajaxSubmit({ 
                target:   '#targetLayer', 
                beforeSubmit: function() {
                    $("#progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){ 

                    console.log(percentComplete);
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
                },
                success:function (){
                    $('#loader-icon').hide();
                },
                resetForm: true 
            }); 
            return false; 
        }
    });
});
</script>


<!-- Main content -->
<div class="app-main__inner">


    <div class="row">
      <div class="col-md-12">
        <div class="main-card mb-3 card">
          <div class="card-header">Add Category</div>
          <div class="card-body">
            

            <form id="uploadForm"  action="up_category.php" method="post" enctype="multipart/form-data">




              <div class="position-relative row  form-group">
                <label for="name"  class="col-sm-2 col-form-label"  >Category Name</label>
                <div class="col-sm-4">
                 <input type="text" required="true" name="name" class="form-control" id="cat_name" placeholder="Name">
               </div>
             </div>

             <div class="position-relative row  form-group">
              <label for="cat_icon"  class="col-sm-2 col-form-label"  >Category Icon</label>
              <div class="col-sm-4">
                <input type="file" name="cat_icon" required class="form-control" id="cat_icon" >
                <div id="progress-div"><div id="progress-bar"></div></div>
                <div id="targetLayer"></div>
              </div>



                <div class="position-relative row form-check">
                  <div class="col-sm-4 offset-sm-2">

                   <button type="submit"    name="submit" class="btn btn-secondary">Submit</button>


                 </div>
               </div>


             </form>
          </div> 
             <div id="loader-icon" style="display:none;"><img src="LoaderIcon.gif" /></div>

          </div>
        </div>
      </div>
    </div><!--end row -->


  <div class="row">
    <div class="col-md-12">
      <div class="main-card mb-3 card">
        <div class="card-header">Category List
         
        </div>

            <?php
          $sql_get_data ="select * from category order by cat_name ASC";
      
      $result = mysqli_query($GLOBALS['con'],$sql_get_data);
      ?>



        <div class="table-responsive">
          <table class="align-middle mb-0 table table-borderless table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Name</th>
                <th class="text-center">Icon</th>
                <th class="text-center">Date Time</th>
                <th class="text-center">Option</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0; while ($rs = mysqli_fetch_array($result)) { $i++;?>
                <tr>


                 <td class="text-muted text-center" >
                  <?php echo $i; ?>
                </td>
                <td class="text-center">
                  <?php echo $rs['cat_name']; ?>
                </td>
                <td class="text-center cat-icon">
                  <img src='<?= $rs['icon'] ?>' />
                </td>
                <td class="text-center">
                  <?php  echo $rs['datetime']; ?>
                </td>
                <td class="text-center">
                  <?php  echo "r" ?>
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
