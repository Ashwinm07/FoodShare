<?php
include('db_connect.php');
// Ensure session and role checks are performed
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Volunteer') {
    die("Access Denied.");
}

// Get the Volunteer's ID from their UserID in the session.
// This assumes the VolunteerID in the `volunteer` table matches the UserID in the `users` table.
$volunteer_user_id = $_SESSION['UserID'];

// --- (NEW, SIMPLER QUERY) ---
// Select all requests that are assigned to this volunteer
// and are not yet 'Delivered' or 'Declined'.
$sql = "SELECT r.RequestID, r.Status, r.RequestedQty, 
        u.Name AS ReceiverName, u.Location AS ReceiverLocation, u.Contact AS ReceiverContact,
        d.Item AS FoodItem
        FROM food_request r
        JOIN users u ON r.ReceiverID = u.UserID
        JOIN food_donation d ON r.DonationID = d.DonationID
        WHERE r.VolunteerID = ?
        AND r.Status IN ('Assigned', 'Picked Up')
        ORDER BY r.Timestamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $volunteer_user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content='width=device-width, initial-scale=1.0'>
  <link rel="stylesheet" href="../style.css">
  <title>My Deliveries</title>
  <style>
    /* Card specific styles for volunteer view */
    .delivery-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }
    .delivery-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 20px;
        border-left: 5px solid #2980b9;
    }
    .delivery-card h3 {
        color: #27ae60;
        margin-top: 0;
    }
    .delivery-card p {
        margin: 5px 0;
        font-size: 0.95em;
    }
    .status-badge {
        padding: 4px 8px;
        border-radius: 5px;
        font-weight: bold;
        color: white;
        display: inline-block;
        margin-bottom: 10px;
    }
    .status-Assigned { background: #2980b9; }
    .status-Picked-Up { background: #e67e22; }
    .status-Delivered { background: #27ae60; }
    .btn-action {
        background: #2ecc71;
        margin-right: 10px;
        padding: 8px 15px;
        font-size: 14px;
    }
    .btn-action.picked {
        background: #e67e22;
    }
    .btn-action:hover {
        opacity: 0.9;
    }
  </style>
</head>
<body>

<div class="delivery-container">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reqID = $row['RequestID'];
        $status = str_replace(' ', '-', $row['Status']); // For CSS class

        echo "<div class='delivery-card'>
                <h3>Request #{$reqID} - {$row['FoodItem']} (Qty: {$row['RequestedQty']})</h3>
                <p><strong>Receiver:</strong> {$row['ReceiverName']}</p>
                <p><strong>Location:</strong> {$row['ReceiverLocation']}</p>
                <p><strong>Contact:</strong> {$row['ReceiverContact']}</p>
                <span class='status-badge status-{$status}'>{$row['Status']}</span>
                
                <hr style='margin:15px 0;'>

                <form action='update_delivery_status.php' method='POST' target='_top'>
                    <input type='hidden' name='request_id' value='{$reqID}'>";
                    // We no longer need to pass the volunteer ID from here

        if ($row['Status'] == 'Assigned') {
            echo "<button type='submit' name='new_status' value='Picked Up' class='btn btn-action picked'>Picked Up</button>";
        } elseif ($row['Status'] == 'Picked Up') {
            echo "<button type'submit' name='new_status' value='Delivered' class='btn btn-action'>Delivered (Done)</button>";
        } else {
            echo "<p style='color:#27ae60; font-weight:bold;'>Delivery Complete!</p>";
        }

        echo "  </form>
              </div>";
    }
} else {
    echo "<p style='text-align:center;width:100%;padding-top:20px;color:gray;'>No active assigned requests right now. Check back soon!</p>";
}
?>
</div>

</body>
</html>
<?php $stmt->close(); $conn->close(); ?>