<?php
include('db_connect.php');

$sql = "SELECT r.RequestID, r.Status, r.Timestamp, r.RequestedQty,
        u.Name AS ReceiverName, u.Location AS ReceiverLocation, 
        d.Item AS FoodItem, 
        v.Name AS VolunteerName, v.VolunteerID
        FROM food_request r
        JOIN users u ON r.ReceiverID = u.UserID
        JOIN food_donation d ON r.DonationID = d.DonationID
        LEFT JOIN volunteer v ON r.RequestID = v.AssignedRequests 
        WHERE r.Status IN ('Accepted', 'Assigned', 'Picked Up')
        ORDER BY FIELD(r.Status, 'Accepted', 'Assigned', 'Picked Up'), r.Timestamp ASC";

$result = $conn->query($sql);

echo "<table style='width:95%; margin:15px auto; border-collapse:collapse; text-align:center;'>";
echo "<tr style='background:#2980b9; color:white;'>
        <th>ID</th><th>Receiver</th><th>Item (Qty)</th>
        <th>Current Status</th><th>Volunteer</th><th>Action: Assign</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reqID = $row['RequestID'];
        $status = $row['Status'];

        $status_color = ($status == 'Accepted' ? '#2ecc71' : ($status == 'Picked Up' ? '#e67e22' : '#2980b9'));

        echo "<tr>
                <td>{$row['RequestID']}</td>
                <td>{$row['ReceiverName']} ({$row['ReceiverLocation']})</td>
                <td>" . htmlspecialchars($row['FoodItem']) . " ({$row['RequestedQty']})</td>
                <td style='font-weight:bold; color:{$status_color};'>{$status}</td>
                <td>" . ($row['VolunteerName'] ? htmlspecialchars($row['VolunteerName']) : '-') . "</td>
                <td>";
        
        // Only allow assignment if status is 'Accepted' (meaning accepted but not yet assigned)
        if ($status == 'Accepted') {
            echo "<form action='assign_volunteer.php' method='POST'>
                        <input type='hidden' name='request_id' value='{$reqID}'>
                        <select name='volunteer_id' required style='padding:5px;border-radius:5px;'>
                            <option value=''>Select Volunteer</option>";

            // Fetch volunteers safely
            $vols = $conn->query("SELECT VolunteerID, Name FROM volunteer WHERE AssignedRequests IS NULL OR AssignedRequests = 0");
            while ($v = $vols->fetch_assoc()) {
                echo "<option value='{$v['VolunteerID']}'>{$v['Name']}</option>";
            }

            echo "      </select>
                        <button type='submit' class='btn' style='margin-top:5px;background:#2980b9;'>Assign</button>
                    </form>";
        } else {
            echo "-";
        }

        echo "  </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No requests currently in progress.</td></tr>";
}

echo "</table>";
$conn->close();
?>