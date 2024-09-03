// fetch_keywords.php
<?php
$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['service_type'])) {
    $service_type = $_POST['service_type'];
    $query = "SELECT keywords FROM service WHERE service_type = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $service_type);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $keywords);

        $keywordOptions = "";
        while (mysqli_stmt_fetch($stmt)) {
            $keywordOptions .= "<option value=\"" . htmlspecialchars($keywords) . "\">" . htmlspecialchars($keywords) . "</option>";
        }

        echo $keywordOptions;
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connection);
?>
