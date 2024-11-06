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
    $keyword = $_POST['keywords'];
    $sms = $_POST['sms'];

    // Prepare query to get 'service_id'
    $service_id_query = "SELECT id FROM service WHERE service_type = ? AND keywords = ?";
    if ($service_id_stmt = mysqli_prepare($connection, $service_id_query)) {
        mysqli_stmt_bind_param($service_id_stmt, "ss", $service_type, $keyword);
        mysqli_stmt_execute($service_id_stmt);
        mysqli_stmt_bind_result($service_id_stmt, $service_id);
        mysqli_stmt_fetch($service_id_stmt);
        mysqli_stmt_close($service_id_stmt);
    }

    // Prepare query to insert data into 'sms' table
    $query = "INSERT INTO sms (service_id, service_type, keyword, sms, telcoID) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($connection, $query)) {
        $telcoID = 1;

        // Bind parameters for the 'sms' table insert
        mysqli_stmt_bind_param($stmt, "isssi", $service_id, $service_type, $keyword, $sms, $telcoID);

        // Make the HTTP request
        $url = "http://103.228.39.36/GP_DPDP/send_gp_sms.php?keyword=" . urlencode($keyword) . "&content=" . urlencode($sms);
        $response = file_get_contents($url);

        if ($response !== false && strpos($http_response_header[0], '200') !== false) {
            // Response code is 200, insert data into the database
            if (mysqli_stmt_execute($stmt)) {
                $logFile = "C:\\xampp\\htdocs\\smsPanel\\log\\GP_Add_sms__log.txt";
                $datetime = date('Y-m-d H:i:s');
                $logContent = "URL: " . $url . " - DateTime: " . $datetime . "\n";
                file_put_contents($logFile, $logContent, FILE_APPEND);

                echo '<script>toastr.success("SMS added successfully");</script>';
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
        } else {
            // Response code is not 200, log the error and show error toastr
            $logFile = "C:\\xampp\\htdocs\\smsPanel\\log\\GP_sms_error_log.txt";
            $datetime = date('Y-m-d H:i:s');
            $logContent = "URL: " . $url . " - DateTime: " . $datetime . " - Error: Response code was not 200\n";
            file_put_contents($logFile, $logContent, FILE_APPEND);

            echo '<script>toastr.error("Unsuccessfull! to Add sms");</script>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

$serviceTypeQuery = "SELECT DISTINCT service_type FROM service";
$keywordsQuery = "SELECT DISTINCT keywords FROM service";

$serviceTypeResult = mysqli_query($connection, $serviceTypeQuery);
$keywordsResult = mysqli_query($connection, $keywordsQuery);

?>

<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Add GP SMS</div>
                <div class="card-body" >
                    <form id="uploadForm" action="" method="post">
                        <div class="position-relative column form-group p-t-10">
                            <div class="col-sm-4" style="margin-bottom: 2%">
                                <label class="text" for="service_type">Service Type</label>
                                <select required="true" id="service_type" name="service_type" class="form-control" style="font-size: 13px;">
                                    <option value="" disabled selected>Select a Type</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($serviceTypeResult)) {
                                        echo "<option value=\"" . htmlspecialchars($row['service_type']) . "\">" . htmlspecialchars($row['service_type']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-4" style="margin-bottom: 2%">
                                <label class="text" for="keywords">Keywords</label>
                                <select required="true" id="keywords" name="keywords" class="form-control" style="font-size: 13px;">
                                    <option value="" disabled selected>Select a Keywords</option>
                                    <?php
                                    // Initially, keep this empty or populate with all keywords
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-4 animated-input" style="margin-bottom: 2%">
                                <label class="text" for="sms">SMS</label>
                                <textarea required="true" name="sms" class="form-control" id="sms" placeholder="Type here..." style="font-size: 13px;"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="position-relative row form-group p-t-10">
                            <div class="col-sm-4">
                                <button type="submit" name="submit" class="btn btn-secondary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="loader-icon" style="display:none;"><img src="LoaderIcon.gif" /></div>
            </div>
        </div>
    </div>
</div>
<!-- Main content end -->

<!-- JavaScript libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Initialize toastr options
    toastr.options = {
        "positionClass": "toast-top-center",
        "closeButton": true,
        "progressBar": true,
    };
</script>
<script>
    document.getElementById('service_type').addEventListener('change', function() {
        var serviceType = this.value;
        var keywordsDropdown = document.getElementById('keywords');

        if (serviceType) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_keywords.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    keywordsDropdown.innerHTML = xhr.responseText;
                }
            };
            xhr.send("service_type=" + serviceType);
        } else {
            // Reset the keywords dropdown
            keywordsDropdown.innerHTML = "<option value=\"\" disabled selected>Select a Keywords</option>";
        }
    });
</script>

<?php
include_once("include/footer.php");
?>
