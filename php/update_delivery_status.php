<?php
include('db_connect.php');
// Ensure the script is only run by a logged-in Volunteer
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Volunteer') { 
    echo '<script type="text/javascript">window.parent.location.href = "../login.php";</script>';
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'])) {
    $reqID = intval($_POST['request_id']);
    $newStatus = $_POST['new_status'];
    $volunteerName = $_SESSION['Name'];
    $volunteer_user_id = $_SESSION['UserID']; // Get the logged-in volunteer's ID

    $conn->begin_transaction();

    try {
        // --- 1. Update food_request status ---
        // We also double-check that this request IS assigned to this volunteer
        $stmt_req = $conn->prepare("UPDATE food_request SET Status=? WHERE RequestID=? AND VolunteerID = ?");
        $stmt_req->bind_param("sii", $newStatus, $reqID, $volunteer_user_id);
        $stmt_req->execute();
        $stmt_req->close();

        // --- 2. Update volunteer's GENERAL status ---
        if ($newStatus == 'Delivered') {
            // This volunteer is now 'Available' for new tasks
            $stmt_vol_clear = $conn->prepare("UPDATE volunteer SET PickupStatus='Available' WHERE VolunteerID=?");
            $stmt_vol_clear->bind_param("i", $volunteer_user_id);
            $stmt_vol_clear->execute();
            $stmt_vol_clear->close();
            
            $activity = "Marked delivery for request #$reqID as Delivered.";
        } else {
            // For 'Picked Up', their status remains 'In Progress'
            $activity = "Marked pickup for request #$reqID as Picked Up.";
        }

        // --- 3. Log the activity ---
        $stmt_log = $conn->prepare("INSERT INTO admin_logs (Name, Email, Activity) VALUES (?, '', ?)");
        $stmt_log->bind_param("ss", $volunteerName, $activity);
        $stmt_log->execute();
        $stmt_log->close();

        $conn->commit();

        // FIX: Use JavaScript redirect to refresh the parent dashboard
        echo '<script type="text/javascript">window.parent.location.href = "../volunteer_dashboard.php";</script>';
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Volunteer update failed: " . $e->getMessage());
        echo '<script type="text/javascript">window.parent.location.href = "../volunteer_dashboard.php?error=update_failed";</script>';
        exit();
    }
}
// Fallback if not POST or required data missing
echo '<script type="text/javascript">window.parent.location.href = "../volunteer_dashboard.php";</script>';
exit();
?>