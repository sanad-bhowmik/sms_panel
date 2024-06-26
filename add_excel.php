<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");
require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $service_type = $_POST['service_type'];
    $keywords = $_POST['keywords'];

    $connection = mysqli_connect("localhost", "root", "", "smspanelNew");

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $serviceQuery = "SELECT id FROM service WHERE service_type = '$service_type'";
    $serviceResult = mysqli_query($connection, $serviceQuery);

    if ($serviceResult && mysqli_num_rows($serviceResult) > 0) {
        $serviceRow = mysqli_fetch_assoc($serviceResult);
        $service_id = $serviceRow['id'];
    } else {
        echo "Error fetching service_id: " . mysqli_error($connection);
        exit;
    }

    if ($_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $_FILES['excelFile']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tempFilePath);
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            $isBlankRow = true;

            foreach ($cellIterator as $cell) {
                $cellValue = mysqli_real_escape_string($connection, $cell->getValue());
                $rowData[] = $cellValue;

                if (!empty($cellValue)) {
                    $isBlankRow = false;
                }
            }

            if (!$isBlankRow) {
                $query = "INSERT INTO sms (service_id, service_type, keywords, sms) VALUES ('$service_id', '$service_type', '$keywords', '$rowData[0]')";
                if (!mysqli_query($connection, $query)) {
                    echo "Error inserting row: " . mysqli_error($connection);
                }
            }
        }
    } else {
        echo "File upload error: " . $_FILES['excelFile']['error'];
    }

    mysqli_close($connection);

    echo '<script>toastr.success("SMS added successfully!");</script>';
}

$connection = mysqli_connect("localhost", "root", "", "smspanelNew");
$serviceTypeQuery = "SELECT DISTINCT service_type FROM service";
$keywordsQuery = "SELECT DISTINCT keywords FROM service";

$serviceTypeResult = mysqli_query($connection, $serviceTypeQuery);
$keywordsResult = mysqli_query($connection, $keywordsQuery);

mysqli_close($connection);
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

    .file-upload {
        display: inline-block;
        margin-bottom: 2%;
    }

    .file-upload label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <!-- Main content -->
    <div class="app-main__inner">

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Add SMS</div>
                    <div class="card-body">

                        <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                            <div class="position-relative column  form-group  p-t-10">
                                <div class="col-sm-4" style="margin-bottom: 2%">
                                    <label class="text" for="service_type">Service Type</label>
                                    <select required="true" name="service_type" class="form-control" style="font-size: 13px;" required>
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
                                    <select required="true" name="keywords" class="form-control" style="font-size: 13px;" required>
                                        <option value="" disabled selected>Select a Keywords</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($keywordsResult)) {
                                            echo "<option value=\"" . $row['keywords'] . "\">" . $row['keywords'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-sm-4 file-upload">
                                    <label class="text" for="excelFile">Upload Excel File</label>
                                    <input type="file" name="excelFile" id="excelFile" required>
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
</body>

</html>
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