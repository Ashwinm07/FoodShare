<?php
include 'db_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$loc = $_POST['loc'];
$assigned_requests = $_POST['assigned_requests'];
$pickup_status = $_POST['pickup_status'];

$sql = "INSERT INTO volunteer (AssignedRequests, PickupStatus, Name, Email, LOC)
        VALUES ('$assigned_requests', '$pickup_status', '$name', '$email', '$loc')";

if ($conn->query($sql) === TRUE) {
    echo "<h3>Volunteer Added Successfully!</h3>";
    echo "<a href='../volunteer_dashboard.php'>Go Back</a>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
