<?php
include('db_connect.php');

$sql = "SELECT * FROM admin_logs ORDER BY LogID DESC";
$result = $conn->query($sql);

echo "<table border='1' style='width:90%; margin:auto; text-align:center; border-collapse:collapse;'>";
echo "<tr style='background-color:#27ae60; color:white;'><th>Log ID</th><th>Name</th><th>Email</th><th>Activity</th><th>Timestamp</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['LogID'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>" . $row['Activity'] . "</td>";
        echo "<td>" . $row['Timestamp'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No admin activity logs found.</td></tr>";
}
echo "</table>";

$conn->close();
?>
