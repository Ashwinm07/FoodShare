<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../donor_dashboard.php");
    exit();
}

if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Donor') {
    echo "Access Denied.";
    exit();
}

$donor_id = $_SESSION['UserID'];
$donation_id = intval($_POST['donation_id']);

/*
 * --- THE FIX ---
 * We change the query from DELETE to UPDATE.
 * Instead of deleting the row (which causes a foreign key error
 * if a request is linked to it), we "soft delete" it by
 * setting its Status to 'Unavailable'.
 * This hides it from all lists and achieves the same goal.
 */
$stmt = $conn->prepare("UPDATE food_donation 
                        SET Status = 'Unavailable'
                        WHERE DonationID = ? 
                        AND DonorID = ? 
                        AND Status = 'Available'");
$stmt->bind_param("ii", $donation_id, $donor_id);

if ($stmt->execute()) {
    // Successfully "deleted" (hidden)
} else {
    // Handle error (optional)
    error_log("Failed to soft-delete donation: " . $conn->error);
}
$stmt->close();

// Redirect back to the main dashboard (breaks out of iframe)
header("Location: ../donor_dashboard.php");
exit();
?>