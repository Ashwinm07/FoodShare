<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $reqID = intval($_POST['request_id']);
    $status = $_POST['status']; 
    $admin = $_SESSION['Name']; 
    
    // --- 1. UPDATE food_request status using prepared statement (Security Fix) ---
    $stmt_update = $conn->prepare("UPDATE food_request SET Status=? WHERE RequestID=?");
    $stmt_update->bind_param("si", $status, $reqID);
    
    if ($stmt_update->execute()) {
        $stmt_update->close();

        // --- 2. Log admin action automatically (Security Fix) ---
        $activity = "Set request #$reqID status to '$status'"; 
        
        $stmt_log = $conn->prepare("INSERT INTO admin_logs (Name, Email, Activity) VALUES (?, '', ?)");
        $stmt_log->bind_param("ss", $admin, $activity);
        $stmt_log->execute();
        $stmt_log->close();

        // FIX: Use JavaScript to redirect the parent window to break out of the iframe
        echo '<script type="text/javascript">window.parent.location.href = "../admin_dashboard.php";</script>';
        exit();
    } else {
        error_log("Request status update failed: " . $conn->error);
        // Fallback or error message redirect if needed
        echo '<script type="text/javascript">window.parent.location.href = "../admin_dashboard.php";</script>';
        exit();
    }
}
// Fallback redirect
echo '<script type="text/javascript">window.parent.location.href = "../admin_dashboard.php";</script>';
exit();
?>