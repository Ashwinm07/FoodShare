<?php
include('db_connect.php');

$sql = $sql = "SELECT r.RequestID, r.Timestamp, r.RequestedQty,
        u.Name AS ReceiverName, 
        d.Item AS FoodItem,
        v.Name AS VolunteerName
        FROM food_request r
        JOIN users u ON r.ReceiverID = u.UserID
        JOIN food_donation d ON r.DonATIONID = d.DonationID
        LEFT JOIN volunteer v ON r.VolunteerID = v.VolunteerID 
        WHERE r.Status = 'Delivered'
        ORDER BY r.Timestamp DESC";

$result = $conn->query($sql);

echo "<table style='width:95%; margin:15px auto; border-collapse:collapse; text-align:center;'>";
echo "<tr style='background:#555; color:white;'>
        <th>ID</th><th>Receiver</th><th>Item (Qty)</th>
        <th>Delivered By</th><th>Completed On</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['RequestID']}</td>
                <td>{$row['ReceiverName']}</td>
                <td>" . htmlspecialchars($row['FoodItem']) . " ({$row['RequestedQty']})</td>
                <td>" . ($row['VolunteerName'] ? htmlspecialchars($row['VolunteerName']) : 'N/A') . "</td>
                <td>" . date("M d, Y H:i", strtotime($row['Timestamp'])) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No delivered requests found.</td></tr>";
}

echo "</table>";
$conn->close();
?>