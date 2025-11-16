<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'], $_POST['new_status'], $_POST['volunteer_id'])) {
    
    // Sanitize and validate inputs
    $reqID = intval($_POST['request_id']);
    $volID = intval($_POST['volunteer_id']);
    $newStatus = $_POST['new_status']; // 'Picked Up' or 'Delivered'
    $volunteerName = $_SESSION['Name']; 

    // --- 1. Update food_request status using prepared statement ---
    $stmt_req_update = $conn->prepare("UPDATE food_request SET Status=? WHERE RequestID=?");
    $stmt_req_update->bind_param("si", $newStatus, $reqID);
    
    if ($stmt_req_update->execute()) {
        $stmt_req_update->close();

        // --- 2. Update volunteer's pickup status using prepared statement ---
        $stmt_vol_update = $conn->prepare("UPDATE volunteer SET PickupStatus=? WHERE VolunteerID=?");
        $stmt_vol_update->bind_param("si", $newStatus, $volID);
        $stmt_vol_update->execute();
        $stmt_vol_update->close();

        // --- 3. Optional: Clear AssignedRequests if delivered ---
        if ($newStatus == 'Delivered') {
            $stmt_clear_assigned = $conn->prepare("UPDATE volunteer SET AssignedRequests=NULL WHERE VolunteerID=?");
            $stmt_clear_assigned->bind_param("i", $volID);
            $stmt_clear_assigned->execute();
            $stmt_clear_assigned->close();
        }

        // Redirect back to the volunteer dashboard to see updated list
        header("Location: ../volunteer_dashboard.php?status_updated=true&req={$reqID}&new={$newStatus}");
        exit();
    } else {
        // Handle error
        error_log("Delivery status update failed: " . $conn->error);
        header("Location: ../volunteer_dashboard.php?status_updated=false");
        exit();
    }
}

// Fallback redirect
header("Location: ../volunteer_dashboard.php");
exit();
?>