<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");

$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $service_type = $_POST['service_type'];
    $keywords = $_POST['keywords'];
    $sms = $_POST['sms'];

    $service_id_query = "SELECT id FROM service WHERE service_type = '$service_type' AND keywords = '$keywords'";
    $service_id_result = mysqli_query($connection, $service_id_query);

    if ($service_id_row = mysqli_fetch_assoc($service_id_result)) {
        $service_id = $service_id_row['id'];

        $query = "INSERT INTO sms (service_id, service_type, keywords, sms) VALUES ('$service_id', '$service_type', '$keywords', '$sms')";

        if (mysqli_query($connection, $query)) {
            echo '<script>toastr.success("SMS added successfully!");</script>';
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    } else {
        echo '<script>toastr.error("Service not found!");</script>';
    }
}

$serviceTypeQuery = "SELECT DISTINCT service_type FROM service";
$keywordsQuery = "SELECT DISTINCT keywords FROM service";

$serviceTypeResult = mysqli_query($connection, $serviceTypeQuery);
$keywordsResult = mysqli_query($connection, $keywordsQuery);
?>

<style>
      #uploadForm {
          box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
          background: #F6F4EB;
          padding: 10px;
      }
      
      #uploadForm label {
          margin: 2px;
          font-size: 1em;
          font-weight: bold;
      }
      
      .demoInputBox {
          padding: 5px;
          border: #F0F0F0 1px solid;
          border-radius: 4px;
          background-color: #FFF;
      }
      
      .btnSubmit {
          background-color: #09f;
          border: 0;
          padding: 10px 40px;
          color: #FFF;
          border: #F0F0F0 1px solid;
          border-radius: 4px;
      }
      
      #progress-div {
          border: #0FA015 1px solid;
          padding: 5px 0px;
          margin: 30px 0px;
          border-radius: 4px;
          text-align: center;
      }
      
      #targetLayer {
          width: 100%;
          text-align: center;
      }
      
      .text {
          font-weight: bold;
      
      }
      
      .form-group {
          font-size: 15px;
      }
</style>


<!-- Main content -->
<div class="app-main__inner">

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Add SMS</div>
                <div class="card-body">

                    <form id="uploadForm" action="" method="post">
                        <div class="position-relative column  form-group  p-t-10">
                            <div class="col-sm-4" style="margin-bottom: 2%">
                                <label class="text" for="service_type">Service Type</label>
                                <select required="true" name="service_type" class="form-control"
                                    style="font-size: 13px;">
                                    <option value="" disabled selected>Select a Type</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($serviceTypeResult)) {
                                        echo "<option value=\"" . $row['service_type'] . "\">" . $row['service_type'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-4" style="margin-bottom: 2%">
                                <label class="text" for="keywords">Keywords</label>
                                <select required="true" name="keywords" class="form-control" style="font-size: 13px;">
                                    <option value="" disabled selected>Select a Keywords</option>
                                    <?php
                                   while ($row = mysqli_fetch_assoc($keywordsResult)) {
                                       echo "<option value=\"" . $row['keywords'] . "\">" . $row['keywords'] . "</option>";
                                   }
                                   ?>
                                </select>
                            </div>

                            <div class="col-sm-4 animated-input" style="margin-bottom: 2%">
                                <label class="text" for="sms">SMS</label>
                                <textarea required="true" name="sms" class="form-control" id="sms"
                                    placeholder="Type here..." style="font-size: 13px;"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="position-relative row form-group p-t-10 ">
                            <div class="col-sm-4 ">
                                <button type="submit" name="submit" class="btn btn-secondary">Upload</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div id="loader-icon" style="display:none;"><img src="LoaderIcon.gif" /></div>

            </div>
        </div>
    </div>
    <!--end row -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
// Initialize toastr options
toastr.options = {
    "positionClass": "toast-top-center",
    "closeButton": true,
    "progressBar": true,
};
</script>
    <?php
include_once("include/footer.php");
?>