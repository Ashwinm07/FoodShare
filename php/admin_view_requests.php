<?php
include('db_connect.php');

$sql = "SELECT r.RequestID, r.DonationID, r.ReceiverID, r.Status, r.Timestamp, 
        u.Name AS ReceiverName, d.Item AS FoodItem, d.Quantity
        FROM food_request r
        JOIN users u ON r.ReceiverID = u.UserID
        JOIN food_donation d ON r.DonationID = d.DonationID
        ORDER BY r.Timestamp DESC";

$result = $conn->query($sql);

echo "<table style='width:95%; margin:auto; border-collapse:collapse; text-align:center;'>";
echo "<tr style='background:#27ae60; color:white;'>
        <th>ID</th><th>Receiver</th><th>Item</th><th>Quantity</th>
        <th>Status</th><th>Action</th><th>Assign Volunteer</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reqID = $row['RequestID'];
        $status = $row['Status'];
        echo "<tr>
                <td>{$row['RequestID']}</td>
                <td>{$row['ReceiverName']}</td>
                <td>{$row['FoodItem']}</td>
                <td>{$row['Quantity']}</td>
                <td>{$status}</td>
                <td>
                    <form action='update_request_status.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='request_id' value='{$reqID}'>
                        <button name='status' value='Accepted' class='btn'>Accept</button>
                        <button name='status' value='Declined' class='btn' style='background:#e74c3c;'>Decline</button>
                    </form>
                </td>
                <td>
                    <form action='assign_volunteer.php' method='POST'>
                        <input type='hidden' name='request_id' value='{$reqID}'>
                        <select name='volunteer_id' required style='padding:5px;border-radius:5px;'>
                            <option value=''>Select Volunteer</option>";

        $vols = $conn->query("SELECT VolunteerID, Name FROM volunteer");
        while ($v = $vols->fetch_assoc()) {
            echo "<option value='{$v['VolunteerID']}'>{$v['Name']}</option>";
        }

        echo "      </select>
                        <button type='submit' class='btn' style='margin-top:5px;'>Assign</button>
                    </form>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No requests found.</td></tr>";
}

echo "</table>";
$conn->close();
?>
