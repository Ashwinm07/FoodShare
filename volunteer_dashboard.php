<?php
include('php/db_connect.php');
if(!isset($_SESSION['UserID'])||$_SESSION['Role']!='Volunteer'){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="navbar">
    <div class="logo">🤝 FoodShare</div>
    <nav><a href="logout.php">Logout</a></nav>
</header>

<!-- This section now loads your assigned requests -->
<section class="table-section" style="margin-top: 40px;">
  <h2 style="text-align: center; color: #27ae60;">My Assigned Deliveries</h2>
  <!-- This iframe shows the requests assigned to this volunteer -->
  <iframe src="php/volunteer_view_requests.php" width="100%" height="400" style="border:none; border-radius: 10px;"></iframe>
</section>

</body>
</html>