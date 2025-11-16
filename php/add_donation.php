<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../donor_dashboard.php");
    exit();
}

if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Donor') {
    echo "Access Denied.";
    exit();
}

$donor_id = $_SESSION['UserID']; // Use session ID for security
$item = $_POST['item'];
$quantity = intval($_POST['quantity']);
$expiry_time = $_POST['expiry_time'];

// Secure INSERT with prepared statements
$stmt = $conn->prepare("INSERT INTO food_donation (DonorID, Item, Quantity, ExpiryTime) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $donor_id, $item, $quantity, $expiry_time);

if ($stmt->execute()) {
    // Success
} else {
    // Handle error (optional)
    error_log("Failed to add donation: " . $conn->error);
}
$stmt->close();

// Redirect back to the main dashboard
header("Location: ../donor_dashboard.php");
exit();
?>