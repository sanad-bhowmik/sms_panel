<?php
include_once("include/initialize.php");
date_default_timezone_set("Asia/Dhaka");
include_once("include/header.php");
require 'vendor/autoload.php';

$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Prepare SQL query with filters
$whereClauses = [];
$params = [];
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $whereClauses[] = "keyword = ?";
    $params[] = $_GET['keyword'];
}
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $whereClauses[] = "DATE(created_at) = ?";
    $params[] = $_GET['date'];
}
if (isset($_GET['msisdn']) && !empty($_GET['msisdn'])) {
    $whereClauses[] = "msisdn = ?";
    $params[] = $_GET['msisdn'];
}

$sql = "SELECT * FROM sms_outbox";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$sql .= " ORDER BY created_at DESC";

$stmt = mysqli_prepare($connection, $sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch unique keywords for the dropdown
$keywordQuery = "SELECT DISTINCT keyword FROM sms_outbox";
$keywordResult = mysqli_query($connection, $keywordQuery);
$keywords = [];
while ($row = mysqli_fetch_assoc($keywordResult)) {
    $keywords[] = $row['keyword'];
}

?>

<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Outbox Data</div>
                <div class="card-body">
                    <form id="filter-form" class="mb-3">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <label for="keyword">Keyword:</label>
                                <select id="keyword" name="keyword" class="form-control">
                                    <option value="">Select Keyword</option>
                                    <?php foreach ($keywords as $keyword): ?>
                                        <option value="<?php echo htmlspecialchars($keyword, ENT_QUOTES); ?>" <?php echo (isset($_GET['keyword']) && $_GET['keyword'] == $keyword) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($keyword, ENT_QUOTES); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-auto">
                                <label for="date">Date:</label>
                                <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($_GET['date'] ?? '', ENT_QUOTES); ?>">
                            </div>
                            <div class="col-auto">
                                <label for="msisdn">Phone:</label>
                                <input type="text" id="msisdn" name="msisdn" class="form-control" value="<?php echo htmlspecialchars($_GET['msisdn'] ?? '', ENT_QUOTES); ?>">
                            </div>
                            <div class="col-auto"style="margin-top: 22px;">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <button type="button" id="clear-filters" class="btn btn-secondary">Clear</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Phone</th>
                                <th>Keyword</th>
                                <th>SMS</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['msisdn'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($row['keyword'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($row['sms'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($row['updated_at'], ENT_QUOTES); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#filter-form').on('submit', function(event) {
        event.preventDefault();
        var phoneInput = $('#msisdn').val();
        if (phoneInput && !phoneInput.startsWith('88')) {
            $('#msisdn').val('88' + phoneInput);
        }
        var queryString = $(this).serialize();
        window.location.href = '?' + queryString;
    });

    $('#clear-filters').on('click', function() {
        $('#filter-form')[0].reset();
        window.location.href = window.location.pathname;
    });
});
</script>

<?php
mysqli_close($connection);
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