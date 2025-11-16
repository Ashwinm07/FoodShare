<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $reqID = intval($_POST['request_id']);
    $volID = intval($_POST['volunteer_id']);
    $admin = $_SESSION['Name'];

    // --- 1. (OLD LOGIC REMOVED) ---
    // We no longer update the volunteer's table with the request ID.

    // --- 2. (NEW LOGIC) Update the food_request table ---
    // We set the status to 'Assigned' AND add the 'VolunteerID'
    $req_status = 'Assigned';
    $stmt_req_update = $conn->prepare("UPDATE food_request SET Status = ?, VolunteerID = ? WHERE RequestID = ?");
    $stmt_req_update->bind_param("sii", $req_status, $volID, $reqID);
    $stmt_req_update->execute();
    $stmt_req_update->close();
    
    // --- 3. (OPTIONAL) We can still update the volunteer's status ---
    // This tells us if the volunteer is 'Available' or 'In Progress'
    $status_inprogress = 'In Progress';
    $stmt_vol_update = $conn->prepare("UPDATE volunteer SET PickupStatus = ? WHERE VolunteerID = ?");
    $stmt_vol_update->bind_param("si", $status_inprogress, $volID);
    $stmt_vol_update->execute();
    $stmt_vol_update->close();


    // --- 4. Log activity automatically (Security Fix) ---
    $activity = "Assigned volunteer #$volID to request #$reqID";
    $stmt_log = $conn->prepare("INSERT INTO admin_logs (Name, Email, Activity) VALUES (?, '', ?)");
    $stmt_log->bind_param("ss", $admin, $activity);
    $stmt_log->execute();
    $stmt_log->close();

    // FIX: Use JavaScript to redirect the parent window to break out of the iframe
    echo '<script type="text/javascript">window.parent.location.href = "../admin_dashboard.php";</script>';
    exit();
}
// Fallback redirect
echo '<script type="text/javascript">window.parent.location.href = "../admin_dashboard.php";</script>';
exit();
?>