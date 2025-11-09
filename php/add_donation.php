<?php
include 'db_connect.php';
$donor=$_POST['donor_id']; $item=$_POST['item'];
$q=$_POST['quantity']; $exp=$_POST['expiry_time'];
$sql="INSERT INTO food_donation (DonorID,Item,Quantity,ExpiryTime)
VALUES('$donor','$item','$q','$exp')";
echo $conn->query($sql)
? "<h3>Donation Added!</h3><a href='../donor_dashboard.php'>Back</a>"
: "Error: ".$conn->error;
$conn->close();
?>
