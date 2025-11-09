<?php
include 'db_connect.php';

$sql = "SELECT * FROM volunteer ORDER BY VolunteerID DESC";
$result = $conn->query($sql);

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Assigned Requests</th><th>Pickup Status</th><th>Name</th><th>Email</th><th>Location</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['VolunteerID']."</td>
                <td>".$row['AssignedRequests']."</td>
                <td>".$row['PickupStatus']."</td>
                <td>".$row['Name']."</td>
                <td>".$row['Email']."</td>
                <td>".$row['LOC']."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No volunteers found</td></tr>";
}
echo "</table>";

$conn->close();
?>
