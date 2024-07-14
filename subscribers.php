<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");
require 'vendor/autoload.php';

// Establish database connection
$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

// Check connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Query to fetch subscribers data
$query = "SELECT * FROM subscribers";
$result = mysqli_query($connection, $query);

// Check if query executed successfully
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<style>
    .app-main__inner {
        padding: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        font-family: Arial, sans-serif;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        text-align: left;
    }

    .table th {
        background: #007BFF;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    Subscribers
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Number</th>
                                    <th>Keyword</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['number']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['keyword']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
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

<?php
mysqli_close($connection);
include_once("include/footer.php");
?>