<?php
include('php/db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Receiver') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Receiver Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="navbar">
  <div class="logo">🍲 FoodShare</div>
  <nav>
    <a href="receiver_requests.php">My Requests</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

  <?php if (isset($_GET['success']) && $_GET['success'] == 'requested') { ?>
      <div style="text-align:center; color:green; margin:15px;">✅ Food request sent successfully!</div>
  <?php } elseif (isset($_GET['error']) && $_GET['error'] == 'qty_unavailable') { ?>
      <!-- NEW ERROR MESSAGE -->
      <div style="text-align:center; color:red; margin:15px;">❌ Request failed. Not enough quantity available or the item was just claimed.</div>
  <?php } elseif (isset($_GET['error'])) { ?>
      <div style="text-align:center; color:red; margin:15px;">❌ Failed to send request. Try again.</div>
  <?php } ?>

  <iframe src="php/view_donations.php" width="100%" height="600" style="border:none;"></iframe>
</body>
</html>