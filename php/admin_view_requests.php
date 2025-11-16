<?php
include('db_connect.php');

$sql = "SELECT r.RequestID, r.DonationID, r.ReceiverID, r.Status, r.Timestamp, r.RequestedQty,
        u.Name AS ReceiverName, u.Location AS ReceiverLocation, u.Contact AS ReceiverContact, 
        d.Item AS FoodItem, d.Quantity AS DonationQty, 
        v.Name AS VolunteerName
        FROM food_request r
        JOIN users u ON r.ReceiverID = u.UserID
        JOIN food_donation d ON r.DonationID = d.DonationID
        LEFT JOIN volunteer v ON r.RequestID = v.AssignedRequests 
        ORDER BY r.Timestamp DESC";

$result = $conn->query($sql);

echo "<table style='width:95%; margin:auto; border-collapse:collapse; text-align:center;'>";
echo "<tr style='background:#27ae60; color:white;'>
        <th>ID</th><th>Receiver</th><th>Location</th><th>Item (Qty)</th>
        <th>Status</th><th>Volunteer</th><th>Action</th><th>Assign Volunteer</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reqID = $row['RequestID'];
        $status = $row['Status'];
        $item_qty = htmlspecialchars($row['FoodItem']) . " (" . $row['RequestedQty'] . ")";
        $location_contact = "<strong>Loc:</strong> " . htmlspecialchars($row['ReceiverLocation']) . "<br><strong>C:</strong> " . htmlspecialchars($row['ReceiverContact']);

        echo "<tr>
                <td>{$row['RequestID']}</td>
                <td>{$row['ReceiverName']}</td>
                <td>{$location_contact}</td>
                <td>{$item_qty}</td>
                <td style='font-weight:bold; color: " . 
                    ($status == 'Accepted' ? '#2ecc71' : 
                    ($status == 'Declined' ? '#e74c3c' : 
                    ($status == 'Assigned' ? '#2980b9' : 
                    ($status == 'Picked Up' ? '#e67e22' : 
                    ($status == 'Delivered' ? '#27ae60' : 'gray'))))) . 
                "'>{$status}</td>
                <td>" . ($row['VolunteerName'] ? htmlspecialchars($row['VolunteerName']) : '-') . "</td>
                <td>";
        
        // Show Accept/Decline only if status is Pending
        if ($status == 'Pending') {
            echo "<form action='update_request_status.php' method='POST' style='display:inline;'>
                      <input type='hidden' name='request_id' value='{$reqID}'>
                      <button name='status' value='Accepted' class='btn'>Accept</button>
                      <button name='status' value='Declined' class='btn' style='background:#e74c3c;'>Decline</button>
                  </form>";
        } else {
            echo "-";
        }

        echo "  </td>
                <td>";
        
        // Show Assign Volunteer only if status is Accepted (not already assigned)
        if ($status == 'Accepted') {
            echo "<form action='assign_volunteer.php' method='POST'>
                        <input type='hidden' name='request_id' value='{$reqID}'>
                        <select name='volunteer_id' required style='padding:5px;border-radius:5px;'>
                            <option value=''>Select Volunteer</option>";

            // Note: This query is safe as it doesn't use user input
            $vols = $conn->query("SELECT VolunteerID, Name FROM volunteer");
            while ($v = $vols->fetch_assoc()) {
                echo "<option value='{$v['VolunteerID']}'>{$v['Name']}</option>";
            }

            echo "      </select>
                        <button type='submit' class='btn' style='margin-top:5px;'>Assign</button>
                    </form>";
        } elseif ($status == 'Assigned') {
            echo "Assigned to {$row['VolunteerName']}";
        } else {
            echo "-";
        }

        echo "  </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No requests found.</td></tr>";
}

echo "</table>";
$conn->close();
?>