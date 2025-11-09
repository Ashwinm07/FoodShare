<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reqID = $_POST['request_id'];
    $volID = $_POST['volunteer_id'];

    // Update volunteer's record
    $conn->query("UPDATE volunteer SET AssignedRequests='$reqID', PickupStatus='In Progress' WHERE VolunteerID='$volID'");

    // Update request status
    $conn->query("UPDATE food_request SET Status='Assigned' WHERE RequestID='$reqID'");

    // Log activity
    if (isset($_SESSION['Name'])) {
        $admin = $_SESSION['Name'];
        $activity = "Assigned volunteer #$volID to request #$reqID";
        $conn->query("INSERT INTO admin_logs (Name, Email, Activity) VALUES ('$admin', '', '$activity')");
    }

    header("Location: admin_view_requests.php");
    exit();
}
?>
