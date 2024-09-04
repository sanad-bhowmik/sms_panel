<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");
require 'vendor/autoload.php';

$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$dataQuery = "SELECT * FROM sms ORDER BY datetime DESC";
$dataResult = mysqli_query($connection, $dataQuery);

$serviceQuery = "SELECT DISTINCT service_type FROM service";
$serviceResult = mysqli_query($connection, $serviceQuery);

$keywordsQuery = "SELECT DISTINCT keywords FROM service";
$keywordsResult = mysqli_query($connection, $keywordsQuery);

$telcoQuery = "SELECT DISTINCT telcoID FROM service";
$telcoResult = mysqli_query($connection, $telcoQuery);

mysqli_close($connection);
?>

<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">SMS Data</div>
                <div class="panelDrop">
                    <div class="dropdown">
                        <select id="serviceTypeSelect" name="service_type">
                            <option value="" disabled selected>Select Service</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($serviceResult)) {
                                echo '<option value="' . $row['service_type'] . '">' . $row['service_type'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="dropdown">
                        <select id="keywordsSelect" name="keyword">
                            <option value="" disabled selected>Select Keywords</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($keywordsResult)) {
                                echo '<option value="' . $row['keywords'] . '">' . $row['keywords'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="dropdown">
                        <input type="date" id="startDate" name="startDate">
                    </div>
                    <div class="dropdown">
                        <select id="telcoIDSelect" name="telcoID">
                            <option value="" disabled selected>Select Telco</option>
                            <option value="1">Grameen Phone</option>
                            <option value="3">Banglalink</option>
                        </select>
                    </div>
                    <button id="filterButton" class="btn btn-success button">Search</button>
                    <button id="clearButton" class="btn btn-danger button">Clear</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service Type</th>
                                    <th>Keywords</th>
                                    <th>SMS</th>
                                    <th>Telco</th>
                                    <th>Date Time</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php
                                $index = 1; // Initialize index number
                                while ($row = mysqli_fetch_assoc($dataResult)) {
                                    $telcoName = ($row['telcoID'] == 1) ? "Grameen Phone" : "Banglalink";
                                    echo "<tr data-service-type='" . $row['service_type'] . "' data-keywords='" . $row['keyword'] . "' data-datetime='" . $row['datetime'] . "' data-telco-id='" . $row['telcoID'] . "'>";
                                    echo "<td>" . $index . "</td>"; // Display index number
                                    echo "<td>" . $row['service_type'] . "</td>";
                                    echo "<td>" . $row['keyword'] . "</td>";
                                    echo "<td>" . $row['sms'] . "</td>";
                                    echo "<td>" . $row['datetime'] . "</td>";
                                    echo "<td>" . $telcoName . "</td>";
                                    echo "</tr>";
                                    $index++; // Increment index number
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#filterButton").click(function() {
            var selectedServiceType = $("#serviceTypeSelect").val();
            var selectedKeywords = $("#keywordsSelect").val();
            var selectedStartDate = $("#startDate").val();
            var selectedTelcoID = $("#telcoIDSelect").val();

            $("#tableBody tr").each(function() {
                var serviceType = $(this).data('service-type');
                var keywords = $(this).data('keywords');
                var datetime = $(this).data('datetime');
                var telcoID = $(this).data('telco-id');

                var matchesServiceType = selectedServiceType ? serviceType === selectedServiceType : true;
                var matchesKeywords = selectedKeywords ? keywords === selectedKeywords : true;
                var matchesStartDate = selectedStartDate ? datetime >= selectedStartDate : true;
                var matchesTelcoID = selectedTelcoID ? telcoID == selectedTelcoID : true;

                if (matchesServiceType && matchesKeywords && matchesStartDate && matchesTelcoID) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $("#clearButton").click(function() {
            $("#serviceTypeSelect").val('');
            $("#keywordsSelect").val('');
            $("#startDate").val('');
            $("#telcoIDSelect").val('');

            $("#tableBody tr").show();
        });
    });
</script>

<?php
include_once("include/footer.php");
?>



<style>
    .dropdown {
        position: relative;
        display: inline-block;
        margin-right: 30px;
        margin-top: 20px;
    }

    .dropdown-button {
        background-color: #35A29F;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #E2F6CA;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
        background-color: #ffffff;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        text-align: left;
    }

    .table th {
        background: rgb(0, 27, 36);
        background: radial-gradient(circle, rgba(0, 27, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(11, 7, 66, 1) 100%);
        font-weight: 600;
        text-transform: uppercase;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .panelDrop {
        margin-left: 14%;
        margin-top: 10px;
    }

    .arrow-icon {
        height: 20px;
        transition: transform 0.9s;
    }

    .dropdown:hover .arrow-icon {
        transform: rotate(180deg);
    }

    #serviceTypeSelect,
    #keywordsSelect,
    #telcoIDSelect {
        border: 1px solid darkgrey;
        padding: 8px;
        border-radius: 6%;
    }

    #startDate {
        border: 1px solid darkgrey;
        padding: 7px;
        border-radius: 5%;
    }
</style>