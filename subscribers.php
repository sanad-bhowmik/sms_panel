<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");
require 'vendor/autoload.php';

$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['clear_search'])) {
    $search_number = '';
} else {
    $search_number = isset($_POST['search_number']) ? $_POST['search_number'] : '';
}

// Pagination settings
$limit = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM subscribers";
if (!empty($search_number)) {
    $search_number = mysqli_real_escape_string($connection, $search_number);
    $query .= " WHERE number LIKE '%$search_number%'";
}
$query .= " ORDER BY created_at DESC";
$query .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Get the total number of records
$count_query = "SELECT COUNT(*) as total FROM subscribers";
if (!empty($search_number)) {
    $count_query .= " WHERE number LIKE '%$search_number%'";
}
$count_result = mysqli_query($connection, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);
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

    .search-form {
        margin-bottom: 20px;
    }

    .search-form input[type="text"] {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .search-form button {
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        background: #007BFF;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-form button:hover {
        background: #0056b3;
    }

    .search-form .clear-btn {
        background: #6c757d;
    }

    .search-form .clear-btn:hover {
        background: #5a6268;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        color: #007BFF;
        text-decoration: none;
        margin: 0 5px;
        border-radius: 4px;
    }

    .pagination a:hover {
        background: #007BFF;
        color: white;
    }

    .pagination a.active {
        background: #007BFF;
        color: white;
        pointer-events: none;
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
                        <form class="search-form" method="post" action="">
                            <input type="text" name="search_number" placeholder="Search by number" value="<?php echo htmlspecialchars($search_number); ?>">
                            <button type="submit">Search</button>
                            <button type="submit" name="clear_search" class="clear-btn">Clear</button>
                        </form>
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
                                $index = $offset + 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($index++) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['number']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['keyword']) . "</td>";

                                    // Displaying status as Active or Inactive based on its value
                                    echo "<td>" . ($row['status'] == 1 ? "Active" : "Inactive") . "</td>";

                                    echo "<td>" . htmlspecialchars(date("Y-m-d", strtotime($row['created_at']))) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <?php
                        if ($total_pages > 1) {
                            // First page link
                            if ($page > 1) {
                                echo "<a href='?page=1'><<</a>";
                            }

                            // Pages loop with ellipsis
                            $ellipsis = false;
                            for ($i = 1; $i <= $total_pages; $i++) {
                                if ($i == $page) {
                                    echo "<a href='?page=$i' class='active'>$i</a>";
                                } else {
                                    if ($i <= 2 || $i > $total_pages - 2 || abs($i - $page) <= 1) {
                                        echo "<a href='?page=$i'>$i</a>";
                                    } elseif (!$ellipsis) {
                                        echo "<span>...</span>";
                                        $ellipsis = true;
                                    }
                                }
                            }

                            // Last page link
                            if ($page < $total_pages) {
                                echo "<a href='?page=$total_pages'>>></a>";
                            }
                        }
                        ?>
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