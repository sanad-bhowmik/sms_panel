<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");
require 'vendor/autoload.php';

$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$serviceTypesQuery = "SELECT DISTINCT service_type FROM service";
$serviceTypesResult = mysqli_query($connection, $serviceTypesQuery);

$keywordsQuery = "SELECT DISTINCT keywords FROM service";
$keywordsResult = mysqli_query($connection, $keywordsQuery);

$serviceTypeFilter = '';
$keywordFilter = '';
$dateFilter = '';

if (isset($_GET['service_type']) && $_GET['service_type'] != '') {
    $serviceTypeFilter = mysqli_real_escape_string($connection, $_GET['service_type']);
}

if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
    $keywordFilter = mysqli_real_escape_string($connection, $_GET['keyword']);
}

if (isset($_GET['date']) && $_GET['date'] != '') {
    $dateFilter = mysqli_real_escape_string($connection, $_GET['date']);
}

$filterQuery = "SELECT * FROM service WHERE 1=1";

if ($serviceTypeFilter != '') {
    $filterQuery .= " AND service_type = '$serviceTypeFilter'";
}

if ($keywordFilter != '') {
    $filterQuery .= " AND keywords = '$keywordFilter'";
}

if ($dateFilter != '') {
    $filterQuery .= " AND DATE(created_at) = '$dateFilter'";
}

$dataResult = mysqli_query($connection, $filterQuery);

mysqli_close($connection);
?>

<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Service List</div>
                <div class="panelDrop">
                    <form method="GET" action="">
                        <div class="dropdown">
                            <label for="serviceType" style=" font-size: medium;font-weight: 600;font-family: cursive;">Service :</label>
                            <select id="serviceType" name="service_type" style="padding: 6px;">
                                <option value="">All</option>
                                <?php
                                if (mysqli_num_rows($serviceTypesResult) > 0) {
                                    while ($row = mysqli_fetch_assoc($serviceTypesResult)) {
                                        $selected = ($row['service_type'] == $serviceTypeFilter) ? "selected" : "";
                                        echo "<option value='" . $row['service_type'] . "' $selected>" . $row['service_type'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="dropdown">
                            <label for="keyword" style=" font-size: medium;font-weight: 600;font-family: cursive;">Keyword:</label>
                            <select id="keyword" name="keyword" style="padding: 6px;">
                                <option value="">All</option>
                                <?php
                                if (mysqli_num_rows($keywordsResult) > 0) {
                                    while ($row = mysqli_fetch_assoc($keywordsResult)) {
                                        $selected = ($row['keywords'] == $keywordFilter) ? "selected" : "";
                                        echo "<option value='" . $row['keywords'] . "' $selected>" . $row['keywords'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="dropdown">
                            <label for="date" style=" font-size: medium;font-weight: 600;font-family: cursive;">Date:</label>
                            <input type="date" id="date" name="date" value="<?php echo $dateFilter; ?>" style="padding: 6px;">
                        </div>
                        <button type="submit" class="btn btn-success button">Search</button>
                        <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="btn btn-danger">Clear</a>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th> <!-- Index Column Header -->
                                    <th>Service Name</th>
                                    <th>Service Type</th>
                                    <th>Keywords</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($dataResult) > 0) {
                                    $index = 1; // Initialize index number
                                    while ($row = mysqli_fetch_assoc($dataResult)) {
                                        echo "<tr>";
                                        echo "<td>" . $index++ . "</td>"; // Display index number and increment
                                        echo "<td>" . $row['service_name'] . "</td>";
                                        echo "<td>" . $row['service_type'] . "</td>";
                                        echo "<td>" . $row['keywords'] . "</td>";
                                        echo "<td>" . $row['created_at'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No data found</td></tr>"; // Adjust colspan to match the number of columns
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
        $('#filterButton').click(function() {
            var startDate = $('#startDate').val();
            // Add filtering logic here
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
        background-color: #f8f9fa;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        text-align: left;
    }

    .table th {
        background: linear-gradient(135deg, #2b5876 0%, #4e4376 100%);
        font-weight: 600;
        text-transform: uppercase;
        color: white;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #e9ecef;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: #dae0e5;
    }

    .panelDrop {
        margin-left: 17%;
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

    @media (max-width: 768px) {
        .panelDrop {
            margin-left: 0;
            text-align: center;
        }

        .dropdown {
            margin-bottom: 10px;
        }
    }

    @media (max-width: 576px) {

        .table th,
        .table td {
            padding: 8px 10px;
        }
    }
</style>