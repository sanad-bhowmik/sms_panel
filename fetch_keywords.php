<?php
$connection = mysqli_connect("localhost", "root", "", "smspanelNew");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['service_type'])) {
    $service_type = $_POST['service_type'];
    $telcoID = 1; // Filter by telcoID 1

    $query = "SELECT keywords FROM service WHERE service_type = ? AND telcoID = ?";

    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $service_type, $telcoID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $keywords);

        $keywordOptions = "<option value='' disabled selected>Select a Keywords</option>";
        while (mysqli_stmt_fetch($stmt)) {
            $keywordOptions .= "<option value=\"" . htmlspecialchars($keywords) . "\">" . htmlspecialchars($keywords) . "</option>";
        }

        echo $keywordOptions;
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connection);
?>
