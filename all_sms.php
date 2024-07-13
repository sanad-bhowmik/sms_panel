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

// Fetch service types from the "service" table
$serviceQuery = "SELECT DISTINCT service_type FROM service";
$serviceResult = mysqli_query($connection, $serviceQuery);

// Fetch keywords from the "keywords" table
$keywordsQuery = "SELECT DISTINCT keywords FROM service";
$keywordsResult = mysqli_query($connection, $keywordsQuery);

mysqli_close($connection);
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
        margin-left: 25%;
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
    #keywordsSelect {
        background-color: #F3FDE8;
        padding: 8px;
        border-radius: 3%;
    }

    #startDate {
        padding: 7px;
    }
</style>

<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">SMS Data</div>
                <div class="panelDrop">
                    <div class="dropdown">
                        <select id="serviceTypeSelect" name="service_type">
                            <option value="" disabled selected>Select Option</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($serviceResult)) {
                                echo '<option value="' . $row['service_type'] . '">' . $row['service_type'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="dropdown">
                        <select id="keywordsSelect" name="keyword">
                            <option value="" disabled selected>Select Option</option>
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

                    <button id="filterButton" class="btn btn-primary button">Filter</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Service Type</th>
                                    <th>Keywords</th>
                                    <th>SMS</th>
                                    <th>Date Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php
                                while ($row = mysqli_fetch_assoc($dataResult)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['service_type'] . "</td>";
                                    echo "<td>" . $row['keyword'] . "</td>";
                                    echo "<td>" . $row['sms'] . "</td>";
                                    echo "<td>" . $row['datetime'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "</tr>";
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

            $.ajax({
                type: "GET",
                url: "filter_data.php",
                data: {
                    service_type: selectedServiceType,
                    keywords: selectedKeywords,
                    start_date: selectedStartDate
                },
                success: function(data) {
                    $("#tableBody").empty();

                    data.forEach(function(row) {
                        var newRow = "<tr>" +
                            "<td>" + row.service_type + "</td>" +
                            "<td>" + row.keywords + "</td>" +
                            "<td>" + row.sms + "</td>" +
                            "<td>" + row.datetime + "</td>" +
                            "<td>" + row.status + "</td>" +
                            "</tr>";
                        $("#tableBody").append(newRow);
                    });
                }
            });
        });
    });
</script>



<?php
include_once("include/footer.php");
?>