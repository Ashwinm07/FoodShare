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

// SECURE DELETE: 
// We must check that the DonationID belongs to the logged-in DonorID
// AND that its status is 'Available'.
$stmt = $conn->prepare("DELETE FROM food_donation 
                        WHERE DonationID = ? 
                        AND DonorID = ? 
                        AND Status = 'Available'");
$stmt->bind_param("ii", $donation_id, $donor_id);

if ($stmt->execute()) {
    // Successfully deleted (or was already gone)
} else {
    // Handle error (optional)
    error_log("Failed to delete donation: " . $conn->error);
}
$stmt->close();

// Redirect back to the main dashboard (breaks out of iframe)
header("Location: ../donor_dashboard.php");
exit();
?>