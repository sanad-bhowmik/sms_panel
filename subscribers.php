<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");
require 'vendor/autoload.php';

$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle form submission
$search_number = isset($_POST['search_number']) ? $_POST['search_number'] : '';
$search_keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';
$search_status = isset($_POST['search_status']) ? $_POST['search_status'] : '';
$search_date = isset($_POST['search_date']) ? $_POST['search_date'] : '';

if (isset($_POST['clear_search'])) {
    $search_number = '';
    $search_keyword = '';
    $search_status = '';
    $search_date = '';
}

// Fetch distinct keywords from the subscribers table
$keyword_query = "SELECT DISTINCT keyword FROM subscribers WHERE keyword IS NOT NULL AND keyword != ''";
$keyword_result = mysqli_query($connection, $keyword_query);

if (!$keyword_result) {
    die("Query failed: " . mysqli_error($connection));
}

// Fetch counts of active and inactive subscribers
$count_active_query = "SELECT COUNT(*) as active_count FROM subscribers WHERE status = 1";
$count_inactive_query = "SELECT COUNT(*) as inactive_count FROM subscribers WHERE status = 0";

$count_active_result = mysqli_query($connection, $count_active_query);
$count_inactive_result = mysqli_query($connection, $count_inactive_query);

if (!$count_active_result || !$count_inactive_result) {
    die("Query failed: " . mysqli_error($connection));
}

$count_active_row = mysqli_fetch_assoc($count_active_result);
$count_inactive_row = mysqli_fetch_assoc($count_inactive_result);

$active_count = $count_active_row['active_count'];
$inactive_count = $count_inactive_row['inactive_count'];

// Pagination settings
$limit = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Build the query with filters
$query = "SELECT * FROM subscribers WHERE 1=1";

if (!empty($search_number)) {
    $search_number = mysqli_real_escape_string($connection, $search_number);
    $query .= " AND number LIKE '%$search_number%'";
}

if (!empty($search_keyword)) {
    $search_keyword = mysqli_real_escape_string($connection, $search_keyword);
    $query .= " AND keyword = '$search_keyword'";
}

if ($search_status !== '') { // '' means it was not set, so this handles both 0 and 1 as valid values
    $search_status = mysqli_real_escape_string($connection, $search_status);
    $query .= " AND status = '$search_status'";
}

if (!empty($search_date)) {
    $search_date = mysqli_real_escape_string($connection, $search_date);
    $query .= " AND DATE(created_at) = '$search_date'";
}

$query .= " ORDER BY created_at DESC";
$query .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Get the total number of records for pagination
$count_query = "SELECT COUNT(*) as total FROM subscribers WHERE 1=1";

if (!empty($search_number)) {
    $count_query .= " AND number LIKE '%$search_number%'";
}

if (!empty($search_keyword)) {
    $count_query .= " AND keyword = '$search_keyword'";
}

if ($search_status !== '') {
    $count_query .= " AND status = '$search_status'";
}

if (!empty($search_date)) {
    $count_query .= " AND DATE(created_at) = '$search_date'";
}

$count_result = mysqli_query($connection, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);
?>

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
                            <input type="text" name="search_number" placeholder="Search by number" value="<?php echo htmlspecialchars($search_number); ?>" style="margin-right: 2%;">

                            <select name="search_keyword" style="margin-right: 2%;">
                                <option value="">Select Keyword</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($keyword_result)) {
                                    $selected = ($row['keyword'] == $search_keyword) ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($row['keyword']) . "\" $selected>" . htmlspecialchars($row['keyword']) . "</option>";
                                }
                                ?>
                            </select>

                            <select name="search_status" style="margin-right: 2%;">
                                <option value="">Select Status</option>
                                <option value="1" <?php if ($search_status === '1') echo 'selected'; ?>>Active</option>
                                <option value="0" <?php if ($search_status === '0') echo 'selected'; ?>>Inactive</option>
                            </select>

                            <input type="date" name="search_date" value="<?php echo htmlspecialchars($search_date); ?>" style="margin-right: 2%;">

                            <button type="submit">Search</button>
                            <button type="submit" name="clear_search" class="clear-btn" onclick="clearForm()">Clear</button>
                            <!-- Active: <?php echo htmlspecialchars($active_count); ?> -->
                        </form>
                        <section style="margin-bottom: 13px;">
                            <!-- Display active and inactive counts -->
                            <div style="position: relative;display: inline-block;padding: 7px;border-radius: 10px;border: 1px solid #e4dfdf;margin-right: 2%;font-size: larger;font-family: math;">
                                <div style="display: inline-flex; align-items: center;">
                                    <div>
                                        <strong>Active : <?php echo htmlspecialchars($active_count); ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div style="position: relative;display: inline-block;padding: 7px;border-radius: 10px;border: 1px solid #e4dfdf;margin-right: 2%;font-size: larger;font-family: math;">
                                <div style="display: inline-flex; align-items: center;">
                                    <div>
                                        <strong>Inactive : <?php echo htmlspecialchars($inactive_count); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                    echo "<td>" . ($row['status'] == 1 ? "Active" : "Inactive") . "</td>";
                                    $date = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                                    $date->setTimezone(new DateTimeZone('Asia/Dhaka'));
                                    $formattedDate = $date->format('Y-m-d g:i a');
                                    echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <?php
                        if ($total_pages > 1) {
                            if ($page > 1) {
                                echo "<a href='?page=1'><<</a>";
                            }

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




<script>
    function clearForm() {
        window.location.href = '<?php echo basename($_SERVER['PHP_SELF']); ?>';
    }
</script>



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
        margin-left: 8%;
    }

    .search-form input[type="text"],
    .search-form select,
    .search-form input {
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
<?php
mysqli_close($connection);
include_once("include/footer.php");
?>