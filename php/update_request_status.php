<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reqID = $_POST['request_id'];
    $status = $_POST['status'];

    $conn->query("UPDATE food_request SET Status='$status' WHERE RequestID='$reqID'");

    // Log admin action (optional)
    if (isset($_SESSION['Name'])) {
        $admin = $_SESSION['Name'];
        $activity = "Set request #$reqID as $status";
        $conn->query("INSERT INTO admin_logs (Name, Email, Activity) VALUES ('$admin', '', '$activity')");
    }

    header("Location: admin_view_requests.php");
    exit();
}
?>
