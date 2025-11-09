<?php
include('php/db_connect.php');
if(!isset($_SESSION['UserID'])||$_SESSION['Role']!='Volunteer'){header("Location: login.php");exit();}
?>
<!DOCTYPE html>
<html>
<head><title>Volunteer Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body>
<header class="navbar"><div class="logo">🤝 FoodShare</div><nav><a href="logout.php">Logout</a></nav></header>
<div class="form-container">
  <h2>Add Volunteer Record</h2>
  <form action="php/add_volunteer.php" method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="loc" placeholder="Location" required>
    <input type="text" name="assigned_requests" placeholder="Assigned Request ID">
    <input type="text" name="pickup_status" placeholder="Pickup Status" required>
    <button class="btn" type="submit">Add Volunteer</button>
  </form>
</div>
<section class="table-section">
  <h2>Volunteer Records</h2>
  <iframe src="php/view_volunteers.php" width="100%" height="400" style="border:none;"></iframe>
</section>
</body></html>
