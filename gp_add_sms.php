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

    // Prepare statement for inserting SMS data
    $query = "INSERT INTO sms (service_id, service_type, keyword, sms) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connection, $query)) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "isss", $service_id, $service_type, $keyword, $sms);

        // Get service ID based on service type and keyword
        $service_id_query = "SELECT id FROM service WHERE service_type = ? AND keywords = ?";
        if ($service_id_stmt = mysqli_prepare($connection, $service_id_query)) {
            mysqli_stmt_bind_param($service_id_stmt, "ss", $service_type, $keyword);
            mysqli_stmt_execute($service_id_stmt);
            mysqli_stmt_bind_result($service_id_stmt, $service_id);
            mysqli_stmt_fetch($service_id_stmt);
            mysqli_stmt_close($service_id_stmt);
        }

        // Execute the prepared statement to insert SMS data
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>toastr.success("SMS added successfully!");</script>';
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Fetch service types and keywords for dropdowns
$serviceTypeQuery = "SELECT DISTINCT service_type FROM service";
$keywordsQuery = "SELECT DISTINCT keywords FROM service";

$serviceTypeResult = mysqli_query($connection, $serviceTypeQuery);
$keywordsResult = mysqli_query($connection, $keywordsQuery);

?>
<!-- Main content -->
<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Add GP SMS</div>
                <div class="card-body" style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Grameenphone_Logo_GP_Logo.svg/800px-Grameenphone_Logo_GP_Logo.svg.png);background-repeat: no-repeat;">
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
            // AJAX request to fetch keywords
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