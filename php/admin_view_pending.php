<?php
include('db_connect.php');

$sql = "SELECT r.RequestID, r.Status, r.Timestamp, r.RequestedQty,
        u.Name AS ReceiverName, u.Location AS ReceiverLocation, u.Contact AS ReceiverContact, 
        d.Item AS FoodItem, d.Quantity AS DonationQty
        FROM food_request r
        JOIN users u ON r.ReceiverID = u.UserID
        JOIN food_donation d ON r.DonationID = d.DonationID
        WHERE r.Status = 'Pending'
        ORDER BY r.Timestamp ASC";

$result = $conn->query($sql);

echo "<table style='width:95%; margin:15px auto; border-collapse:collapse; text-align:center;'>";
echo "<tr style='background:#f39c12; color:white;'>
        <th>ID</th><th>Receiver (Contact)</th><th>Location</th><th>Item (Qty)</th>
        <th>Requested On</th><th>Action</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reqID = $row['RequestID'];
        $item_qty = htmlspecialchars($row['FoodItem']) . " (" . $row['RequestedQty'] . ")";
        $location_contact = "<strong>" . htmlspecialchars($row['ReceiverName']) . "</strong><br>" . htmlspecialchars($row['ReceiverContact']);

        echo "<tr>
                <td>{$row['RequestID']}</td>
                <td>{$location_contact}</td>
                <td>{$row['ReceiverLocation']}</td>
                <td>{$item_qty}</td>
                <td>" . date("M d, H:i", strtotime($row['Timestamp'])) . "</td>
                <td>
                    <form action='update_request_status.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='request_id' value='{$reqID}'>
                        <button name='status' value='Accepted' class='btn'>Accept</button>
                        <button name='status' value='Declined' class='btn' style='background:#e74c3c;'>Decline</button>
                    </form>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No new pending requests found.</td></tr>";
}

echo "</table>";
$conn->close();
?>