<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_id = $_SESSION['UserID'];
    $donation_id = intval($_POST['donation_id']);
    $requested_qty = intval($_POST['requested_qty']);

    // Start a transaction to safely check and update quantities
    $conn->begin_transaction();

    try {
        // Step 1: Get the current quantity and lock the row
        $stmt_check = $conn->prepare("SELECT Quantity, Status FROM food_donation WHERE DonationID = ? FOR UPDATE");
        $stmt_check->bind_param("i", $donation_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        
        if ($result->num_rows == 0) {
            throw new Exception("Donation item not found.");
        }
        
        $row = $result->fetch_assoc();
        $current_quantity = $row['Quantity'];
        $current_status = $row['Status'];

        // Step 2: Check if request is valid
        if ($current_status != 'Available' || $requested_qty > $current_quantity || $requested_qty <= 0) {
            // Not enough quantity, or item not available, or invalid request
            throw new Exception("Not enough quantity available or item is locked.");
        }

        // Step 3: Calculate new quantity and update the donation
        $new_quantity = $current_quantity - $requested_qty;
        
        $stmt_update = $conn->prepare("UPDATE food_donation SET Quantity = ? WHERE DonationID = ?");
        $stmt_update->bind_param("ii", $new_quantity, $donation_id);
        $stmt_update->execute();
        
        // Step 4: If quantity is now 0, mark as "Unavailable"
        if ($new_quantity == 0) {
            $stmt_status = $conn->prepare("UPDATE food_donation SET Status = 'Unavailable' WHERE DonationID = ?");
            $stmt_status->bind_param("i", $donation_id);
            $stmt_status->execute();
        }

        // Step 5: Insert the food request
        $stmt_request = $conn->prepare("INSERT INTO food_request (DonationID, ReceiverID, RequestedQty, Status) VALUES (?, ?, ?, 'Pending')");
        $stmt_request->bind_param("iii", $donation_id, $receiver_id, $requested_qty);
        $stmt_request->execute();

        // If all queries were successful, commit the transaction
        $conn->commit();
        header("Location: ../receiver_dashboard.php?success=requested");
        exit();

    } catch (Exception $e) {
        // Something went wrong, rollback all changes
        $conn->rollback();
        // Send a specific error message back
        if ($e->getMessage() == "Not enough quantity available or item is locked.") {
            header("Location: ../receiver_dashboard.php?error=qty_unavailable");
        } else {
            header("Location: ../receiver_dashboard.php?error=failed");
        }
        exit();
    }
} else {
    header("Location: ../receiver_dashboard.php");
    exit();
}
?>