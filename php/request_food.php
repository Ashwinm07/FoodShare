<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_id = $_SESSION['UserID'];
    $donation_id = $_POST['donation_id'];
    $requested_qty = isset($_POST['requested_qty']) ? intval($_POST['requested_qty']) : 1;

    $sql = "INSERT INTO food_request (DonationID, ReceiverID, RequestedQty, Status)
            VALUES ('$donation_id', '$receiver_id', '$requested_qty', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        // Update donation status to Requested
        $conn->query("UPDATE food_donation SET Status='Requested' WHERE DonationID='$donation_id'");
        header("Location: ../receiver_dashboard.php?success=requested");
        exit();
    } else {
        header("Location: ../receiver_dashboard.php?error=failed");
        exit();
    }
} else {
    header("Location: ../receiver_dashboard.php");
    exit();
}
?>
